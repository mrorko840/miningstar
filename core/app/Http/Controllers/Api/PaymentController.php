<?php

namespace App\Http\Controllers\Api;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\GatewayCurrency;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function methods()
    {
        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', Status::ENABLE);
        })->with('method')->orderby('method_code')->get();

        $notify[] = 'Payment methods';

        return response()->json([
            'remark' => 'deposit_methods',
            'message' => ['success' => $notify],
            'data' => [
                'methods' => $gatewayCurrency
            ],
        ]);
    }

    public function paymentMethods()
    {
        $user = auth()->user();

        if (!$user->session_data || !$user->session_data->remark == 'payment' || !$user->session_data->trx) {
            $notify[] = 'Time expired, Please try again later';
            return response()->json([
                'remark' => 'validation_error',
                'status' => 'error',
                'message' => ['error' => $notify],
            ]);
        }

        $trx = $user->session_data->trx;
        $order = Order::select('id', 'amount', 'plan_details->title as plan_title')->where('trx', $trx)->first();

        if (!$order) {
            $notify[] = 'Order not found';
            return response()->json([
                'remark' => 'validation_error',
                'status' => 'error',
                'message' => ['error' => $notify],
            ]);
        }

        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', Status::ENABLE);
        })->with('method')->orderby('method_code')->get();

        $notify[] = 'Payment methods';

        return response()->json([
            'remark' => 'payment_methods',
            'message' => ['success' => $notify],
            'data' => [
                'order' => $order,
                'methods' => $gatewayCurrency
            ],
        ]);
    }

    public function depositInsert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|gt:0',
            'method_code' => 'required',
            'currency' => 'required',
            'order' => 'nullable|integer|gt:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'remark' => 'validation_error',
                'status' => 'error',
                'message' => ['error' => $validator->errors()->all()],
            ]);
        }

        $user = auth()->user();
        $amount =  $request->amount;
        $deposit = new Deposit();
        $notification = 'Deposit inserted';
        $remark = 'deposit_inserted';

        if ($request->has('order')) {
            if ($user->session_data->remark = 'payment') {
                $user->session_data = null;
                $user->save();
            }

            $order = Order::find($request->order);
            if (!$order) {
                return response()->json([
                    'remark' => 'validation_error',
                    'status' => 'error',
                    'message' => ['error' => ['Order not found']],
                ]);
            }

            $amount = $order->amount;
            $deposit->order_id = $order->id;
            $notification = 'Payment inserted';
            $remark = 'payment_inserted';
        }

        $gate = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', Status::ENABLE);
        })->where('method_code', $request->method_code)->where('currency', $request->currency)->first();
        if (!$gate) {
            $notify[] = 'Invalid gateway';
            return response()->json([
                'remark'  => 'validation_error',
                'status'  => 'error',
                'message' => ['error' => $notify],
            ]);
        }

        if ($gate->min_amount > $amount || $gate->max_amount < $amount) {
            $notify[] = 'Please follow the limit';
            return response()->json([
                'remark'  => 'validation_error',
                'status'  => 'error',
                'message' => ['error' => $notify],
            ]);
        }

        $charge = $gate->fixed_charge + ($amount * $gate->percent_charge / 100);
        $payable = $amount + $charge;
        $final_amo = $payable * $gate->rate;

        $deposit->user_id = $user->id;
        $deposit->method_code = $gate->method_code;
        $deposit->method_currency = strtoupper($gate->currency);
        $deposit->amount = $amount;
        $deposit->charge = $charge;
        $deposit->rate = $gate->rate;
        $deposit->final_amo = $final_amo;
        $deposit->btc_amo = 0;
        $deposit->btc_wallet = "";
        $deposit->trx = getTrx();
        $deposit->save();

        $notify[] =  $notification;

        return response()->json([
            'remark' => $remark,
            'status' => 'success',
            'message' => ['success' => $notify],
            'data' => [
                'payment' => $deposit,
                'redirect_url' => route('deposit.app.confirm', encrypt($deposit->id))
            ]
        ]);
    }
}
