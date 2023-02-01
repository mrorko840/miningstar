@php
    $contactCaption = getContent('contact_us.content', true);
    $pages = App\Models\Page::where('is_default', Status::NO)
        ->where('tempname', $activeTemplate)
        ->get();
    $socials = getContent('social_icon.element');
    $breadcrumb = getContent('breadcrumb.content', true);
@endphp

<header class="header-section dashboard-header">
    <div class="header">
        <div class="header-bottom-area">
            <div class="container">
                <div class="header-menu-content">
                    <nav class="navbar navbar-expand-xl justify-content-between p-0">
                        <a class="site-logo site-title" href="{{ route('home') }}"><img src="{{ getImage('assets/images/logoIcon/logo.png') }}" alt="@lang('site-logo')"></a>

                        <button class="navbar-toggler header-button ml-auto shadow-none" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" type="button" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="fas fa-bars"></span>
                        </button>

                        <div class="collapse navbar-collapse justify-content-xl-center" id="navbarSupportedContent">
                            <div class="header-nav-menu">
                                <ul class="navbar-nav main-menu ml-auto mr-auto">
                                    <li><a href="{{ route('user.home') }}">@lang('Dashboard')</a></li>
                                    <li class="menu_has_children"><a href="#0">@lang('Deposit')</a>
                                        <ul class="sub-menu">
                                            <li><a href="{{ route('user.deposit') }}">@lang('Deposit Now')</a></li>
                                            <li><a href="{{ route('user.deposit.history') }}">@lang('Deposit Log')</a></li>
                                        </ul>
                                    </li>

                                    <li class="menu_has_children"><a href="#0">@lang('Withdraw')</a>
                                        <ul class="sub-menu">
                                            <li><a href="{{ route('user.withdraw') }}">@lang('Withdraw Now')</a></li>
                                            <li><a href="{{ route('user.withdraw.history') }}">@lang('Withdraw Log')</a></li>
                                        </ul>
                                    </li>

                                    <li class="menu_has_children"><a href="#0">@lang('Plan')</a>
                                        <ul class="sub-menu">
                                            <li><a href="{{ route('user.plans') }}">@lang('Buy Plan')</a></li>
                                            <li><a href="{{ route('user.plans.purchased') }}">@lang('Purchased Plans')</a></li>
                                            <li><a href="{{ route('user.plans.active') }}">@lang('Active Plans')</a></li>
                                        </ul>
                                    </li>

                                    @if ($general->referral_system)
                                        <li class="menu_has_children"><a href="#0">@lang('Referral')</a>
                                            <ul class="sub-menu">
                                                <li><a href="{{ route('user.referral') }}">@lang('My Referral')</a></li>
                                                <li><a href="{{ route('user.referral.log') }}">@lang('Referral Bonus Logs')</a></li>
                                            </ul>
                                        </li>
                                    @endif

                                    <li class="menu_has_children"><a href="#0">@lang('Support Ticket')</a>
                                        <ul class="sub-menu">
                                            <li><a href="{{ route('ticket.index') }}">@lang('All Tickets')</a></li>
                                            <li><a href="{{ route('ticket.open') }}">@lang('Create Ticket')</a></li>
                                        </ul>
                                    </li>

                                    <li class="menu_has_children"><a href="#0">@lang('My Account')</a>
                                        <ul class="sub-menu">
                                            <li><a href="{{ route('user.profile.setting') }}">@lang('Profile')</a></li>
                                            <li><a href="{{ route('user.wallets') }}">@lang('Wallets')</a></li>
                                            <li><a href="{{ route('user.transactions') }}">@lang('Transactions')</a></li>
                                            <li><a href="{{ route('user.twofactor') }}">@lang('2FA Security')</a></li>
                                            <li><a href="{{ route('user.change.password') }}">@lang('Change Password')</a></li>
                                        </ul>
                                    </li>
                                    <li class="d-flex justify-content-between d-xl-none d-block mt-3 flex-wrap">
                                        <div class="select-language">
                                            <select class="select-bar nic-select">
                                                @foreach ($language as $lang)
                                                    <option value="{{ $lang->code }}">@lang($lang->name)</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="dashboard-btn d-xl-none d-block">
                                            <a class="cmn-btn" href="{{ route('user.logout') }}">@lang('Logout')</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="select-language d-xl-block d-none">
                            <select class="select-bar nic-select">
                                @foreach ($language as $lang)
                                    <option value="{{ $lang->code }}">@lang($lang->name)</option>
                                @endforeach
                            </select>
                        </div>
                        <a class="cmn-btn-danger d-xl-block d-none ms-2" href="{{ route('user.logout') }}">@lang('Logout')</a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
<section class="banner-section inner-banner-section dashboard-inner-banner bg-overlay-primary bg_img" data-background="{{ getImage('assets/images/frontend/breadcrumb/' . $breadcrumb->data_values->breadcrumb_image, '1950x600') }}">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-10 text-center">
                <div class="banner-content">
                    <h2 class="title">{{ __($pageTitle) }}</h2>
                    <div class="breadcrumb-area">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('Dashboard')</a></li>
                                @stack('breadcrumb-plugins')
                                <li class="breadcrumb-item active" aria-current="page">{{ __($pageTitle) }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
