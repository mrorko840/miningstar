<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Miner;
use App\Models\Plan;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\UserCoinBalance;


class OrderPlanController extends Controller
{
    public function plans()
    {
        $pageTitle = "Plans";
        $miners    = Miner::with('activePlans')->whereHas('activePlans')->get();
        return view($this->activeTemplate . 'user.plans.index', compact('pageTitle', 'miners'));
    }
    public function orderPlan(Request $request)
    {
        $request->validate([
            'plan_id'        => 'required|exists:plans,id',
            'payment_method' => 'required|integer|between:1,2',
        ], [
            'payment_method.required' => 'Please Select a Payment System'
        ]);

        $plan = Plan::active()->with('miner')->findOrFail($request->plan_id);
        $user = auth()->user();

        if ($request->payment_method == 1 && $user->balance < $plan->price) {
            $notify[] = ['error', 'Sorry! You Don\'t Have Sufficient Balance To Buy This Plan'];
            return back()->withNotify($notify);
        }

        $planDetails = [
            'title'        => $plan->title,
            'miner'        => $plan->miner->name,
            'speed'        => $plan->speed . ' ' . $plan->speedUnitText,
            'period'       => $plan->period . ' ' . $plan->periodUnitText,
            'period_value' => $plan->period,
            'period_unit'  => $plan->period_unit
        ];

        $order                     = new Order();
        $order->trx                = getTrx();
        $order->user_id            = $user->id;
        $order->plan_details       = $planDetails;
        $order->amount             = $plan->price;
        $order->min_return_per_day = $plan->min_return_per_day;
        $order->max_return_per_day = $plan->max_return_per_day ?? $plan->min_return_per_day;
        $order->miner_id          = $plan->miner->id;

        if ($request->payment_method == 1) {
            $period               = totalPeriodInDay($plan->period, $plan->period_unit);
            $order->period        = $period;
            $order->period_remain = $period;
            $order->status        = Status::ORDER_APPROVED;
            $order->save();

            //Check If Exists
            $ucb = UserCoinBalance::where('user_id', $user->id)->where('miner_id', $order->miner_id)->firstOrCreate([
                'user_id'       => $user->id,
                'miner_id'     => $order->miner_id
            ]);

            $user->balance -= $order->amount;
            $user->save();

            $general = gs();
            $referrer = $user->referrer;
            if ($general->referral_system && $referrer) {
                levelCommission($user, $order->amount, $order->trx);
            }

            $transaction               = new Transaction();
            $transaction->user_id      = $order->user_id;
            $transaction->amount       = getAmount($order->amount);
            $transaction->charge       = 0;
            $transaction->currency     = $general->cur_text;
            $transaction->post_balance = $user->balance;
            $transaction->trx_type     = '-';
            $transaction->details      = 'Paid to buy a plan';
            $transaction->remark       = 'payment';
            $transaction->trx          = $order->trx;
            $transaction->save();

            notify($user, 'PAYMENT_VIA_USER_BALANCE', [
                'plan_title'      => $plan->title,
                'amount'          => showAmount($order->amount),
                'method_currency' => $general->cur_text,
                'post_balance'    => showAmount($user->balance),
                'method_name'     => $general->cur_text . ' Balance',
                'order_id'        => $order->trx,
            ]);


            $notify[] = ['success', 'Plan purchased successfully.'];

            return redirect()->route('user.plans.purchased')->withNotify($notify);
        } else {
            $order->status = Status::ORDER_UNPAID;
            $order->save();
            return redirect()->route('user.payment', encrypt($order->id));
        }
    }
    public function purchasedPlan()
    {
        $user      = auth()->user();
        $pageTitle = "Purchased Plans";
        $orders    = Order::where('user_id', $user->id)->with('miner')->orderBy('id', 'desc')->paginate(getPaginate());

        return view($this->activeTemplate . 'user.plans.purchased', compact('pageTitle', 'orders'));
    }

    public function activePlan()
    {
        $user      = auth()->user();
        $pageTitle = "Active Plans";
        $orders    = Order::approved()->where('user_id', $user->id)->where('period_remain', '>', 0)->with('miner')->orderBy('id', 'desc')->paginate(getPaginate());

        return view($this->activeTemplate . 'user.plans.purchased', compact('pageTitle', 'orders'));
    }
}
