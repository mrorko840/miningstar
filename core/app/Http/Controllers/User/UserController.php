<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\FormProcessor;
use App\Lib\GoogleAuthenticator;
use App\Models\Deposit;
use App\Models\Form;
use App\Models\Miner;
use App\Models\Order;
use App\Models\Referral;
use App\Models\ReferralLog;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserCoinBalance;
use App\Models\Withdrawal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function home()
    {
        $pageTitle = 'Profile';
        $data_page = 'profile';
        $user = auth()->user();
        $widget['deposit'] = Deposit::where('user_id', $user->id)->where('status', Status::PAYMENT_SUCCESS)->sum('amount');
        $widget['withdraw'] = Withdrawal::where('user_id', $user->id)->where('status', Status::PAYMENT_SUCCESS)->sum('amount');
        $widget['referral_bonus'] = ReferralLog::where('user_id', $user->id)->sum('amount');

        $miners     = Miner::with(['userCoinBalances' => function ($q) {
            return $q->where('user_id', auth()->id());
        }])->whereHas('userCoinBalances', function ($q) {
            return $q->where('user_id', auth()->id());
        })->get();

        $report['months'] = collect([]);
        $report['deposit_month_amount'] = collect([]);

        $depositsMonth = Deposit::where('user_id', auth()->id())->where('order_id', 0)->whereYear('created_at', '>=', Carbon::now()->subYear())
            ->selectRaw("SUM( CASE WHEN status = " . Status::PAYMENT_SUCCESS . " THEN amount END) as depositAmount")
            ->selectRaw("DATE_FORMAT(created_at,'%M') as months")
            ->orderBy('created_at')
            ->groupBy(DB::Raw("MONTH(created_at)"))->get();

        $depositsMonth->map(function ($aaa) use ($report) {
            $report['months']->push($aaa->months);
            $report['deposit_month_amount']->push(getAmount($aaa->depositAmount));
        });

        $orders = Order::where('user_id', $user->id)->approved()->with('miner')->orderBy('id', 'desc')->limit(10)->get();

        return view($this->activeTemplate . 'user.dashboard', compact('pageTitle', 'miners', 'report', 'depositsMonth', 'widget', 'orders', 'data_page', 'user'));
    }

    public function depositHistory(Request $request)
    {
        $pageTitle = 'Deposit History';
        $deposits = auth()->user()->deposits()->searchable(['trx'])->with(['gateway'])->orderBy('id', 'desc')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.deposit_history', compact('pageTitle', 'deposits'));
    }

    public function show2faForm()
    {
        $general   = gs();
        $ga        = new GoogleAuthenticator();
        $user      = auth()->user();
        $secret    = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . $general->site_name, $secret);
        $pageTitle = '2FA Setting';
        return view($this->activeTemplate . 'user.twofactor', compact('pageTitle', 'secret', 'qrCodeUrl'));
    }

    public function create2fa(Request $request)
    {
        $user = auth()->user();
        $this->validate($request, [
            'key' => 'required',
            'code' => 'required',
        ]);
        $response = verifyG2fa($user, $request->code, $request->key);
        if ($response) {
            $user->tsc = $request->key;
            $user->ts = 1;
            $user->save();
            $notify[] = ['success', 'Google authenticator activated successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong verification code'];
            return back()->withNotify($notify);
        }
    }

    public function disable2fa(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
        ]);

        $user = auth()->user();
        $response = verifyG2fa($user, $request->code);
        if ($response) {
            $user->tsc = null;
            $user->ts = Status::DISABLE;
            $user->save();
            $notify[] = ['success', 'Two factor authenticator deactivated successfully'];
        } else {
            $notify[] = ['error', 'Wrong verification code'];
        }
        return back()->withNotify($notify);
    }

    public function transactions(Request $request)
    {
        $pageTitle = 'Transactions';
        $remarks = Transaction::distinct('remark')->orderBy('remark')->get('remark');
        $coins = Transaction::distinct('currency')->orderBy('currency')->get('currency');
        $transactions = Transaction::where('user_id', auth()->id());

        if ($request->search) {
            $transactions = $transactions->where('trx', $request->search);
        }

        if ($request->type) {
            $transactions = $transactions->where('trx_type', $request->type);
        }

        if ($request->remark) {
            $transactions = $transactions->where('remark', $request->remark);
        }

        if ($request->coin_code) {
            $transactions = $transactions->where('currency', $request->coin_code);
        }

        $transactions = $transactions->orderBy('id', 'desc')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.transactions', compact('pageTitle', 'transactions', 'remarks', 'coins'));
    }

    public function kycForm()
    {
        if (auth()->user()->kv == Status::KYC_PENDING) {
            $notify[] = ['error', 'Your KYC is under review'];
            return to_route('user.home')->withNotify($notify);
        }
        if (auth()->user()->kv == Status::KYC_VERIFIED) {
            $notify[] = ['error', 'You are already KYC verified'];
            return to_route('user.home')->withNotify($notify);
        }
        $pageTitle = 'KYC Form';
        $form = Form::where('act', 'kyc')->first();
        return view($this->activeTemplate . 'user.kyc.form', compact('pageTitle', 'form'));
    }

    public function kycData()
    {
        $user = auth()->user();
        $pageTitle = 'KYC Data';
        return view($this->activeTemplate . 'user.kyc.info', compact('pageTitle', 'user'));
    }

    public function kycSubmit(Request $request)
    {
        $form = Form::where('act', 'kyc')->first();
        $formData = $form->form_data;
        $formProcessor = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);
        $request->validate($validationRule);
        $userData = $formProcessor->processFormData($request, $formData);
        $user = auth()->user();
        $user->kyc_data = $userData;
        $user->kv = Status::KYC_PENDING;
        $user->save();

        $notify[] = ['success', 'KYC data submitted successfully'];
        return to_route('user.home')->withNotify($notify);
    }

    public function attachmentDownload($fileHash)
    {
        $filePath = decrypt($fileHash);
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $general = gs();
        $title = slug($general->site_name) . '- attachments.' . $extension;
        $mimetype = mime_content_type($filePath);
        header('Content-Disposition: attachment; filename="' . $title);
        header("Content-Type: " . $mimetype);
        return readfile($filePath);
    }

    public function userData()
    {
        $user = auth()->user();
        if ($user->profile_complete == Status::YES) {
            return to_route('user.home');
        }
        $pageTitle = 'User Data';
        return view($this->activeTemplate . 'user.user_data', compact('pageTitle', 'user'));
    }

    public function userDataSubmit(Request $request)
    {
        $user = auth()->user();
        if ($user->profile_complete == Status::YES) {
            return to_route('user.home');
        }
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
        ]);
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->address = [
            'country' => @$user->address->country,
            'address' => $request->address,
            'state' => $request->state,
            'zip' => $request->zip,
            'city' => $request->city,
        ];
        $user->profile_complete = Status::YES;
        $user->save();

        $notify[] = ['success', 'Registration process completed successfully'];
        return to_route('user.home')->withNotify($notify);
    }

    public function referral()
    {
        $general = gs();

        if (!$general->referral_system) {
            $notify[] = ['error', 'Sorry, the referral system is currently unavailable'];
            return back()->withNotify($notify);
        }

        $pageTitle = "Referrals";
        $maxLevel = Referral::max('level');
        $relations = [];
        for ($label = 1; $label <= $maxLevel; $label++) {
            $relations[$label] = (@$relations[$label - 1] ? $relations[$label - 1] . '.allReferrals' : 'allReferrals');
        }
        $user = auth()->user()->load($relations);
        return view($this->activeTemplate . 'user.referral.index', compact('pageTitle', 'user', 'maxLevel'));
    }


    public function referralLog()
    {

        if (!gs()->referral_system) {
            $notify[] = ['error', 'Sorry, the referral system is currently unavailable'];
            return back()->withNotify($notify);
        }

        $pageTitle = "Referral Bonus Logs";
        $logs = ReferralLog::where('user_id', auth()->id())->with('referee')->orderBy('id', 'desc')->paginate(getPaginate());

        return view($this->activeTemplate . 'user.referral.logs', compact('pageTitle', 'logs'));
    }

    public function wallets()
    {
        $pageTitle = "User Coin Wallets";
        $user      = User::where('id', auth()->id())->with('coinBalances.miner')->first();
        return view($this->activeTemplate . 'user.wallets', compact('pageTitle', 'user'));
    }

    public function walletUpdate(Request $request)
    {
        $request->validate([
            "address" => 'required|array'
        ]);

        foreach ($request->address as $key => $value) {
            UserCoinBalance::where('miner_id', $key)->where('user_id', auth()->id())->update(['wallet' => $value]);
        }

        $notify[] = ['success', 'Wallet Address Updated Successfully'];
        return back()->withNotify($notify);
    }
}
