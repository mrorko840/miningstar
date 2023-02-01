<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Transaction;
use App\Models\UserCoinBalance;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{

    public function withdrawMoney()
    {
        $withdrawMethod = UserCoinBalance::where('user_id', auth()->id())->with('miner')->get();
        $pageTitle = 'Withdraw Money';
        return view($this->activeTemplate . 'user.withdraw.methods', compact('pageTitle', 'withdrawMethod'));
    }

    public function withdrawStore(Request $request)
    {
        $request->validate([
            'id'     => 'required|integer|gt:0',
            'amount' => 'required|numeric'
        ]);

        $wallet   = UserCoinBalance::with('miner')->findOrFail($request->id);

        $minLimit  = getAmount($wallet->miner->min_withdraw_limit, 8);
        $maxLimit  = getAmount($wallet->miner->max_withdraw_limit, 8);

        $this->validate($request, [
            'amount'    => "numeric|min:$minLimit|max:$maxLimit"
        ]);

        if ($wallet->balance < $request->amount) {
            $notify[] = ['error', 'You don\'t have sufficient amount in your wallet'];
            return back()->withNotify($notify);
        }

        if (!$wallet->wallet) {
            $notify[] = ['error', 'You didn\'t provide any wallet address for this coin. Please update your wallet address'];
            return back()->withNotify($notify);
        }

        $user = auth()->user();


        $withdraw                           = new Withdrawal();
        $withdraw->user_coin_balance_id     = $request->id;
        $withdraw->user_id                  = $user->id;
        $withdraw->amount                   = getAmount($request->amount);
        $withdraw->trx                      = getTrx();
        $withdraw->currency                 = $wallet->miner->coin_code;
        $withdraw->final_amount             = getAmount($request->amount);
        $withdraw->after_charge             = getAmount($request->amount);
        $withdraw->status                   = Status::PAYMENT_PENDING;
        $withdraw->save();


        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = $user->id;
        $adminNotification->title     = 'New withdraw request from ' . $user->username;
        $adminNotification->click_url = urlPath('admin.withdraw.details', $withdraw->id);
        $adminNotification->save();

        //Decrease the Balance
        $wallet->decrement('balance', $request->amount);

        $transaction                = new Transaction();
        $transaction->user_id       = $withdraw->user_id;
        $transaction->currency      = $wallet->miner->coin_code;
        $transaction->amount        = getAmount($withdraw->amount);
        $transaction->post_balance  = getAmount($wallet->balance);
        $transaction->trx_type      = '-';
        $transaction->details       = getAmount($withdraw->amount) . ' ' . $wallet->miner->coin_code . ' Withdraw Via Wallet Id: ' . $wallet->wallet;
        $transaction->trx           =  $withdraw->trx;
        $transaction->remark           =  'withdraw';
        $transaction->save();

        notify($user, 'WITHDRAW_REQUEST', [
            'wallet'        => $wallet->wallet,
            'post_balance'  => showAmount($wallet->balance),
            'amount'        => showAmount($withdraw->amount),
            'coin_code'     => $wallet->miner->coin_code,
            'trx'           => $withdraw->trx

        ]);

        $notify[] = ['success', 'Withdrawal request successfully submitted'];

        return redirect()->route('user.withdraw.preview', encrypt($withdraw->id))->withNotify($notify);
    }

    public function withdrawPreview($id)
    {
        try {
            $id = decrypt($id);
        } catch (\Throwable $th) {
            abort('404');
        }
        $withdraw = Withdrawal::with('user')->where('status', Status::PAYMENT_PENDING)->orderBy('id', 'desc')->findOrFail($id);
        $pageTitle = 'Withdraw Preview';
        return view($this->activeTemplate . 'user.withdraw.preview', compact('pageTitle', 'withdraw'));
    }

    public function withdrawLog(Request $request)
    {
        $pageTitle = "Withdraw Log";
        $withdraws = Withdrawal::where('user_id', auth()->id());

        if (request()->has('search')) {
            $withdraws = $withdraws->where(function ($query) {
                $query->where('trx', request()->search);
            })->orWhereHas('userCoinBalance', function ($query) {
                $query->where('wallet', 'like', '%' . request()->search . '%');
            });
        }

        $withdraws = $withdraws->with('userCoinBalance.miner')->orderBy('id', 'desc')->paginate(getPaginate());

        return view($this->activeTemplate . 'user.withdraw.log', compact('pageTitle', 'withdraws'));
    }
}
