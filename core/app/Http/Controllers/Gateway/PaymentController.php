<?php

namespace App\Http\Controllers\Gateway;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\FormProcessor;
use App\Models\AdminNotification;
use App\Models\Deposit;
use App\Models\GatewayCurrency;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserCoinBalance;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function payment($id)
    {
        try {
            $orderId = decrypt($id);
        } catch (\Throwable $th) {
            abort(404);
        }

        $order = Order::unpaid()->findOrFail($orderId);

        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', Status::ENABLE);
        })->with('method')->orderby('method_code')->get();

        $pageTitle = 'Payment Methods';

        return view($this->activeTemplate . 'user.payment.deposit', compact('gatewayCurrency', 'pageTitle', 'order'));
    }

    public function deposit()
    {
        $order = null;
        session()->forget('payment');
        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', Status::ENABLE);
        })->with('method')->orderby('method_code')->get();
        $pageTitle = 'Deposit Methods';
        return view($this->activeTemplate . 'user.payment.deposit', compact('gatewayCurrency', 'pageTitle', 'order'));
    }

    public function depositInsert(Request $request)
    {
        $request->validate([
            'amount'      => 'required|numeric|gt:0',
            'method_code' => 'required',
            'currency'    => 'required',
            'order'       => 'nullable|integer|gt:0'
        ]);

        $order = null;
        $amount = $request->amount;
        $notification =  'Please follow deposit limit';

        if ($request->has('order')) {
            $order = Order::unpaid()->find($request->order);
            if (!$order) {
                $notify[] = ['error', 'Order not found!'];
                return back()->withNotify($notify);
            }
            $amount = $order->amount;
            $notification = 'Please follow payment limit';
        }

        $user   = auth()->user();

        $gate = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', Status::ENABLE);
        })->where('method_code', $request->method_code)->where('currency', $request->currency)->first();
        if (!$gate) {
            $notify[] = ['error', 'Invalid gateway'];
            return back()->withNotify($notify);
        }

        if ($gate->min_amount > $amount || $gate->max_amount < $amount) {
            $notify[] = ['error', $notification];
            return back()->withNotify($notify);
        }

        $charge    = $gate->fixed_charge + ($amount * $gate->percent_charge / 100);
        $payable   = $amount + $charge;
        $final_amo = $payable * $gate->rate;

        $data                  = new Deposit();
        $data->user_id         = $user->id;
        $data->order_id        = $order ? $order->id : 0;
        $data->method_code     = $gate->method_code;
        $data->method_currency = strtoupper($gate->currency);
        $data->amount          = $amount;
        $data->charge          = $charge;
        $data->rate            = $gate->rate;
        $data->final_amo       = $final_amo;
        $data->btc_amo         = 0;
        $data->btc_wallet      = "";
        $data->trx             = getTrx();
        $data->save();
        session()->put('Track', $data->trx);
        return to_route('user.deposit.confirm');
    }


    public function appDepositConfirm($hash)
    {
        try {
            $id = decrypt($hash);
        } catch (\Exception $ex) {
            return "Sorry, invalid URL.";
        }

        $data = Deposit::where('status', Status::PAYMENT_INITIATE)->orderBy('id', 'DESC')->firstOrFail($id);
        $user = User::findOrFail($data->user_id);
        auth()->login($user);
        session()->put('Track', $data->trx);
        return to_route('user.deposit.confirm');
    }


    public function depositConfirm()
    {
        $track = session()->get('Track');
        $deposit = Deposit::where('trx', $track)->where('status', Status::PAYMENT_INITIATE)->orderBy('id', 'DESC')->with('gateway')->firstOrFail();

        if ($deposit->method_code >= 1000) {
            return to_route('user.deposit.manual.confirm');
        }


        $dirName = $deposit->gateway->alias;
        $new     = __NAMESPACE__ . '\\' . $dirName . '\\ProcessController';

        $data = $new::process($deposit);
        $data = json_decode($data);


        if (isset($data->error)) {
            $notify[] = ['error', $data->message];
            return to_route(gatewayRedirectUrl())->withNotify($notify);
        }
        if (isset($data->redirect)) {
            return redirect($data->redirect_url);
        }

        // for Stripe V3
        if (@$data->session) {
            $deposit->btc_wallet = $data->session->id;
            $deposit->save();
        }

        $pageTitle = 'Deposit Confirm';
        if ($deposit->order_id) {
            $pageTitle = 'Payment Confirm';
        }

        return view($this->activeTemplate . $data->view, compact('data', 'pageTitle', 'deposit'));
    }


    public static function userDataUpdate($deposit, $isManual = null)
    {
        $general  = gs();
        $order = null;
        if ($deposit->order_id) {
            $order = Order::unpaid()->whereIn('status', [Status::ORDER_UNPAID, Status::ORDER_PENDING])->find($deposit->order_id);
            if (!$order) {
                return;
            }
        }

        if ($deposit->status == Status::PAYMENT_INITIATE || $deposit->status == Status::PAYMENT_PENDING) {
            $deposit->status = Status::PAYMENT_SUCCESS;
            $deposit->save();

            $user = User::find($deposit->user_id);
            $detail = 'Deposit for payment via';
            if (!$order) {
                $user->balance += $deposit->amount;
                $user->save();
                $detail = 'Deposit via';
            }

            $transaction               = new Transaction();
            $transaction->user_id      = $deposit->user_id;
            $transaction->amount       = $deposit->amount;
            $transaction->post_balance = $user->balance;
            $transaction->charge       = $deposit->charge;
            $transaction->trx_type     = '-';
            $transaction->details      = $detail . $deposit->gatewayCurrency()->name;
            $transaction->trx          = $deposit->trx;
            $transaction->currency     = $general->cur_text;
            $transaction->remark       = 'deposit';
            $transaction->save();

            if (!$order) {
                if (!$isManual) {
                    $adminNotification = new AdminNotification();
                    $adminNotification->user_id = $user->id;
                    $adminNotification->title = 'Deposit successful via ' . $deposit->gatewayCurrency()->name;
                    $adminNotification->click_url = urlPath('admin.deposit.successful');
                    $adminNotification->save();
                }

                notify($user, $isManual ? 'DEPOSIT_APPROVE' : 'DEPOSIT_COMPLETE', [
                    'method_name' => $deposit->gatewayCurrency()->name,
                    'method_currency' => $deposit->method_currency,
                    'method_amount' => showAmount($deposit->final_amo),
                    'amount' => showAmount($deposit->amount),
                    'charge' => showAmount($deposit->charge),
                    'rate' => showAmount($deposit->rate),
                    'trx' => $deposit->trx,
                    'post_balance' => showAmount($user->balance)
                ]);
            } else {
                $period                 = totalPeriodInDay($order->plan_details->period_value, $order->plan_details->period_unit);
                $order->status          = Status::ORDER_APPROVED;
                $order->period          = $period;
                $order->period_remain   = $period;
                $order->save();

                $transaction               = new Transaction();
                $transaction->user_id      = $deposit->user_id;
                $transaction->amount       = $deposit->amount;
                $transaction->post_balance = $user->balance;
                $transaction->charge       = $deposit->charge;
                $transaction->trx_type     = '-';
                $transaction->details      = 'Payment via' . $deposit->gatewayCurrency()->name;
                $transaction->trx          = $deposit->trx;
                $transaction->currency     = $general->cur_text;
                $transaction->remark       = 'payment';
                $transaction->save();

                session()->put('payment', true);

                //Check If Exists
                UserCoinBalance::where('user_id', $user->id)->where('miner_id', $order->miner_id)->firstOrCreate([
                    'user_id'       => $user->id,
                    'miner_id'     => $order->miner_id
                ]);

                $referrer = $user->referrer;

                if ($general->referral_system && $referrer) {
                    levelCommission($user, $order->amount, $order->trx);
                }

                notify($user, $isManual ? 'PAYMENT_APPROVE' : 'PAYMENT_COMPLETE', [
                    'plan_title'        => $order->plan_details->title,
                    'method_name'       => $deposit->gatewayCurrency()->name,
                    'method_currency'   => $deposit->method_currency,
                    'method_amount'     => showAmount($deposit->final_amo),
                    'amount'            => showAmount($deposit->amount),
                    'charge'            => showAmount($deposit->charge),
                    'rate'              => showAmount($deposit->rate),
                    'order_id'          => $deposit->trx
                ]);
            }
        }
    }

    public function manualDepositConfirm()
    {
        $track = session()->get('Track');
        $data = Deposit::with('gateway')->where('status', Status::PAYMENT_INITIATE)->where('trx', $track)->first();
        if (!$data) {
            return to_route(gatewayRedirectUrl());
        }
        if ($data->method_code > 999) {

            $pageTitle = 'Deposit Confirm';
            $method = $data->gatewayCurrency();
            $gateway = $method->method;
            return view($this->activeTemplate . 'user.payment.manual', compact('data', 'pageTitle', 'method', 'gateway'));
        }
        abort(404);
    }

    public function manualDepositUpdate(Request $request)
    {
        $track = session()->get('Track');
        $deposit  = Deposit::with('gateway')->where('status', Status::PAYMENT_INITIATE)->where('trx', $track)->first();
        if (!$deposit) {
            return to_route(gatewayRedirectUrl());
        }
        $order = null;
        $notification = 'Deposit request form ';
        $clickUrl = urlPath('admin.deposit.details', $deposit->id);
        if ($deposit->order_id) {
            $order = Order::unpaid()->find($deposit->order_id);

            if (!$order) {
                $notify[] = ['error', 'Order not found'];
                return to_route('user.home')->withNotify('error', $notify);
            }

            $notification = 'Payment request form ';
            $clickUrl = urlPath('admin.payment.details', $deposit->id);
        }

        $gatewayCurrency = $deposit->gatewayCurrency();
        $gateway         = $gatewayCurrency->method;
        $formData        = $gateway->form->form_data;

        $formProcessor  = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);
        $request->validate($validationRule);
        $userData       = $formProcessor->processFormData($request, $formData);


        $deposit->detail = $userData;
        $deposit->status = Status::PAYMENT_PENDING; // pending
        $deposit->save();


        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = $deposit->user->id;
        $adminNotification->title     = $notification . $deposit->user->username;
        $adminNotification->click_url = $clickUrl;
        $adminNotification->save();

        if ($order) {
            $order->status = Status::ORDER_PENDING; //pending
            $order->save();

            $short_code = [
                'method_name'     => $deposit->gatewayCurrency()->name,
                'method_currency' => $deposit->method_currency,
                'method_amount'   => getAmount($deposit->final_amo),
                'amount'          => getAmount($deposit->amount),
                'charge'          => getAmount($deposit->charge),
                'rate'            => getAmount($deposit->rate),
                'trx'             => $deposit->trx
            ];

            notify($deposit->user, 'PAYMENT_REQUEST', $short_code);

            $notification = 'Your payment request has been taken';
            $redirectUrl  = 'user.plans.purchased';
        } else {
            $notification = 'Your deposit request has been taken';
            $redirectUrl  = 'user.deposit.history';
            notify($deposit->user, 'DEPOSIT_REQUEST', [
                'method_name'     => $deposit->gatewayCurrency()->name,
                'method_currency' => $deposit->method_currency,
                'method_amount'   => showAmount($deposit->final_amo),
                'amount'          => showAmount($deposit->amount),
                'charge'          => showAmount($deposit->charge),
                'rate'            => showAmount($deposit->rate),
                'trx'             => $deposit->trx
            ]);
        }

        $notify[] = ['success', $notification];
        return to_route($redirectUrl)->withNotify($notify);
    }
}
