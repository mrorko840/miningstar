<?php

namespace App\Http\Controllers\Api;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Miner;
use App\Models\Order;
use App\Models\Plan;
use App\Models\Transaction;
use App\Models\UserCoinBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderPlanController extends Controller
{
    public function plans()
    {
        $miners     = Miner::select('id', 'name')->with('activePlans:id,miner_id,title,price,features')->whereHas('activePlans')->get();

        $notify[] = 'Active plans';

        return response()->json([
            'remark'     => 'active_plans',
            'status'     => 'success',
            'message'    => ['success', $notify],
            'data'       => [
                'miners' => $miners
            ]
        ]);
    }

    public function purchasedPlan()
    {
        $user     = auth()->user();
        $notify[] = 'Purchased plans';
        $orders   = Order::select('id', 'plan_details->title as plan_title', 'plan_details->miner as miner', 'plan_details->speed as speed', 'coin_code', 'period', 'period_remain', 'min_return_per_day', 'max_return_per_day', 'status', 'amount')->where('user_id', $user->id)->orderBy('id', 'desc')->paginate(getPaginate());


        return response()->json([
            'remark'     => 'purchased_plans',
            'status'     => 'success',
            'message'    => ['success', $notify],
            'data'       => [
                'orders' => $orders
            ]
        ]);
    }

    public function activePlan()
    {
        $user      = auth()->user();
        $notify[] = 'Purchased plans';
        $orders    = Order::approved()->where('user_id', $user->id)->where('period_remain', '>', 0)->with('miner')->orderBy('id', 'desc')->paginate(getPaginate());

        return response()->json([
            'remark'     => 'active_plans',
            'status'     => 'success',
            'message'    => ['success', $notify],
            'data'       => [
                'orders' => $orders
            ]
        ]);
    }


    public function orderPlan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plan_id'           => 'required',
            'payment_method'    => 'required|integer|between:1,2',
        ], [
            'payment_method.required' => 'Please Select a Payment System'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'remark' => 'validation_error',
                'status' => 'error',
                'message' => ['error' => $validator->errors()->all()]
            ]);
        }

        $plan = Plan::where('id', $request->plan_id)->active()->with('miner')->first();

        if (!$plan) {
            $notify[] = 'Plan doesn\'t exist';

            return response()->json([
                'remark' => 'validation_error',
                'status' => 'error',
                'message' => ['error' => $notify]
            ]);
        }

        $planDetails = [
            'title'         => $plan->title,
            'miner'         => $plan->miner->name,
            'speed'         => $plan->speed . ' ' . $plan->speedUnitText,
            'period'        => $plan->period . ' ' . $plan->periodUnitText,
            'period_value'  => $plan->period,
            'period_unit'   => $plan->period_unit
        ];

        $user                       = auth()->user();
        $order                      = new Order();
        $order->trx                 = getTrx();
        $order->user_id             = $user->id;
        $order->plan_details         = $planDetails;
        $order->amount              = $plan->price;
        $order->min_return_per_day  = $plan->min_return_per_day;
        $order->max_return_per_day  = $plan->max_return_per_day ?? $plan->min_return_per_day;
        $order->miner_id           = $plan->miner_id;

        $general = gs();

        if ($request->payment_method == 1) {
            if ($user->balance < $plan->price) {
                $notify[] = 'Sorry! you don\'t have sufficient balance to buy this plan';

                return response()->json([
                    'remark' => 'validation_error',
                    'status' => 'error',
                    'message' => ['error' => $notify]
                ]);
            }

            $period                 = totalPeriodInDay($plan->period, $plan->period_unit);
            $order->period          = $period;
            $order->period_remain   = $period;
            $order->status          = Status::ORDER_APPROVED;

            $order->save();


            //Check If Exists
            $ucb = UserCoinBalance::where('user_id', $user->id)->where('miner_id', $order->miner_id)->firstOrCreate([
                'user_id'       => $user->id,
                'miner_id'     => $order->miner_id
            ]);

            if ($order) {
                $user->balance -= $order->amount;
                $user->save();

                $referrer = $user->referrer;
                if ($general->referral_system && $referrer) {
                    levelCommission($user, $order->amount, $order->trx);
                }

                $transaction                    = new Transaction();
                $transaction->user_id           = $order->user_id;
                $transaction->amount            = getAmount($order->amount);
                $transaction->charge            = 0;
                $transaction->post_balance      = $user->balance;
                $transaction->currency          = $ucb->miner->coin_code;
                $transaction->trx_type          = '-';
                $transaction->details           = 'Payment to Buy a Plan';
                $transaction->trx               =  $order->trx;
                $transaction->save();

                notify($user, 'PAYMENT_VIA_USER_BALANCE', [
                    'plan_title'        => $plan->title,
                    'amount'            => getAmount($order->amount),
                    'method_currency'   => $general->cur_text,
                    'post_balance'      => getAmount($user->balance),
                    'method_name'       => $general->cur_text . ' Balance',
                    'order_id'          => $order->trx,
                ]);


                $notify[] = 'Plan purchased successfully';
                return response()->json([
                    'remark' => 'plan_purchased',
                    'status' => 'success',
                    'message' => ['success' => $notify],
                    'data' => [
                        'redirect_url' => route('api.plan.purchased')
                    ]
                ]);
            } else {
                $notify[] = 'Sorry something went wrong! We could\'nt complete your order. Please try again';

                return response()->json([
                    'remark' => 'validation_error',
                    'status' => 'error',
                    'message' => ['error' => $notify]
                ]);
            }
        } else {
            $order->status         = Status::ORDER_UNPAID;
            $order->save();

            $sessionData = [
                'remark' => 'payment',
                'trx' => $order->trx
            ];

            $user->session_data = $sessionData;
            $user->save();

            $notify[] = 'Payment methods';

            return response()->json([
                'remark' => 'payment_methods',
                'status' => 'success',
                'message' => ['success' => $notify],
                'data' => [
                    'redirect_url' => route('api.payment.methods')
                ]
            ]);
        }
    }
}
