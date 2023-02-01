<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Miner;
use App\Models\Deposit;
use App\Models\Frontend;
use App\Models\Language;
use App\Constants\Status;
use App\Models\Withdrawal;
use App\Models\SupportTicket;
use App\Models\AdminNotification;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $general = gs();
        $activeTemplate = activeTemplate();
        $customTemplate = 'assets/templates/custom/';
        $customImgPath = 'assets/images/';
        $viewShare['general'] = $general;
        $viewShare['activeTemplate'] = $activeTemplate;
        $viewShare['customTemplate'] = $customTemplate;
        $viewShare['customImgPath'] = $customImgPath;
        $viewShare['activeTemplateTrue'] = activeTemplate(true);
        $viewShare['language'] = Language::all();
        $viewShare['currentRoute'] = Route::currentRouteName();
        $viewShare['emptyMessage'] = 'Data not found';
        view()->share($viewShare);


        view()->composer('admin.partials.sidenav', function ($view) {
            $view->with([
                'bannedUsersCount'           => User::banned()->count(),
                'emailUnverifiedUsersCount' => User::emailUnverified()->count(),
                'mobileUnverifiedUsersCount'   => User::mobileUnverified()->count(),
                'kycUnverifiedUsersCount'   => User::kycUnverified()->count(),
                'kycPendingUsersCount'   => User::kycPending()->count(),
                'pendingTicketCount'         => SupportTicket::whereIN('status', [Status::TICKET_OPEN, Status::TICKET_REPLY])->count(),
                'pendingDepositsCount'    => Deposit::where('order_id', Status::NOT_ORDER)->pending()->count(),
                'pendingPaymentCount'    => Deposit::where('order_id', '!=', Status::NOT_ORDER)->pending()->count(),
                'pendingWithdrawCount'    => Withdrawal::pending()->count(),
            ]);
        });

        view()->composer('admin.partials.topnav', function ($view) {
            $view->with([
                'adminNotifications' => AdminNotification::where('is_read', Status::NO)->with('user')->orderBy('id', 'desc')->take(10)->get(),
                'adminNotificationCount' => AdminNotification::where('is_read', Status::NO)->count(),
            ]);
        });

        view()->composer('partials.seo', function ($view) {
            $seo = Frontend::where('data_keys', 'seo.data')->first();
            $view->with([
                'seo' => $seo ? $seo->data_values : $seo,
            ]);
        });

        view()->composer($activeTemplate . 'sections.calculate', function ($view) {
            $view->with([
                'miners'    => Miner::with('plans')->whereHas('plans')->orderBy('name', 'ASC')->get(),
            ]);
        });

        view()->composer($activeTemplate . 'sections.transaction', function ($view) {
            $view->with([
                'deposits'  => Deposit::where('status', Status::PAYMENT_SUCCESS)->with('user')->orderBy('id', 'DESC')->take(5)->get(),
                'withdraws' => Withdrawal::whereIn('status', [Status::PAYMENT_SUCCESS, Status::PAYMENT_PENDING])->with('user', 'userCoinBalance.miner')->orderBy('id', 'DESC')->take(5)->get()
            ]);
        });

        view()->composer($activeTemplate . 'sections.plan', function ($view) {
            $view->with([
                'miners'    => Miner::with('activePlans')->whereHas('activePlans')->orderBy('name', 'ASC')->get(),
            ]);
        });

        if ($general->force_ssl) {
            \URL::forceScheme('https');
        }


        Paginator::useBootstrapFour();
    }
}
