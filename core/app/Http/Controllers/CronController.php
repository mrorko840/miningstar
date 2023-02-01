<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\UserCoinBalance;

class CronController extends Controller
{
    public function returnAmount()
    {
        $general            = gs();
        $general->last_cron = Carbon::now()->toDateTimeString();
        $general->save();

        $orders = Order::approved()
            ->with('user', 'miner')
            ->whereHas('user')
            ->where('last_paid', '<=', Carbon::now()->subHours(24)->toDateTimeString())
            ->get();

        foreach ($orders as $order) {

            $return_amount   = rand($order->min_return_per_day * 100000000, $order->max_return_per_day * 100000000) / 100000000;
            $ucb             = UserCoinBalance::where('user_id', $order->user_id)->where('miner_id', $order->miner_id)->first();
            if (!$ucb) {
                continue;
            }
            $ucb->balance += $return_amount;
            $ucb->save();

            $order->period_remain   -= 1;
            $order->last_paid       = Carbon::now();
            $order->save();

            $transaction                = new Transaction();
            $transaction->user_id       = $order->user_id;
            $transaction->amount        = $return_amount;
            $transaction->post_balance  = getAmount($ucb->balance);
            $transaction->charge        = 0;
            $transaction->trx_type      = '+';
            $transaction->details       = 'Daily return amount for the plan ' . $order->plan_details->title;
            $transaction->trx           = getTrx();
            $transaction->currency      = $order->miner->coin_code;
            $transaction->remark = 'return_amount';
            $transaction->save();

            if ($order->period_remain == 0) {
                $order->status  = Status::ORDER_PENDING;
                $order->save();
            }
        }

        $notify[] = ['success', 'Cron executed successfully!'];


        return back()->withNotify($notify);
    }
}
