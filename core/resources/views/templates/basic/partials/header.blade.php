@php
    $contactCaption = getContent('contact_us.content', true);
    $pages = App\Models\Page::where('is_default', Status::NO)
        ->where('tempname', $activeTemplate)
        ->get();
    $socials = getContent('social_icon.element');
@endphp

<header class="header-section">
    <div class="header">
        <div class="header-top-area">
            <div class="container">
                <div class="header-top-content">
                    <div class="header-content d-flex justify-content-between align-items-center flex-wrap">
                        <div class="header-right-info">
                            <span class="first-info"><a href="tel:{{ $contactCaption->data_values->contact_number }}"><i class="fas fa-phone"></i>{{ $contactCaption->data_values->contact_number }}</a></span>
                        </div>
                        <div class="header-right-info">
                            <div class="header-action">
                                @guest
                                    <a class="cmn-btn" href="{{ route('user.register') }}">@lang('Register')</a>
                                    <a class="cmn-btn-active" href="{{ route('user.login') }}">@lang('Login')</a>
                                @else
                                    <a class="cmn-btn-active" href="{{ route('user.home') }}">@lang('Dashboard')</a>
                                    <a class="cmn-btn-danger" href="{{ route('user.logout') }}">@lang('Logout')</a>
                                @endguest
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="header-bottom-area">
            <div class="container">
                <div class="header-menu-content">
                    <nav class="navbar navbar-expand-lg justify-content-between p-0">
                        <a class="site-logo site-title" href="{{ route('home') }}"><img src="{{ getImage('assets/images/logoIcon/logo.png') }}" alt="@lang('site-logo')"></a>

                        <button class="navbar-toggler header-button ml-auto shadow-none" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" type="button" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="fas fa-bars"></span>
                        </button>
                        <div class="collapse navbar-collapse justify-content-lg-center" id="navbarSupportedContent">
                            <ul class="navbar-nav main-menu ml-auto mr-auto">
                                <li><a class="active" href="{{ route('home') }}">@lang('Home')</a></li>
                                @if ($pages->count())
                                    @foreach ($pages as $item)
                                        <li><a href="{{ route('pages', ['slug' => $item->slug]) }}">{{ __($item->name) }}</a></li>
                                    @endforeach
                                @endif
                                <li><a href="{{ route('plans') }}">@lang('Plans')</a></li>
                                <li><a href="{{ route('blog') }}">@lang('Blog')</a></li>
                                <li><a href="{{ route('contact') }}">@lang('Contact')</a></li>
                                <li class="d-flex justify-content-between d-lg-none d-block flex-wrap">
                                    <div class="select-language d-lg-none d-block">
                                        <select class="select-bar nic-select">
                                            @foreach ($language as $lang)
                                                <option value="{{ $lang->code }}">@lang($lang->name)</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @auth
                                        <div class="dashboard-btn d-lg-none d-block">
                                            <a class="cmn-btn" href="{{ route('user.home') }}">@lang('Dashboard')</a>
                                            <a class="cmn-btn-danger" href="{{ route('user.logout') }}">@lang('Logout')</a>
                                        </div>
                                    @else
                                        <div class="dashboard-btn d-lg-none d-block">
                                            <a class="cmn-btn" href="{{ route('user.register') }}">@lang('Register')</a>
                                            <a class="cmn-btn" href="{{ route('user.login') }}">@lang('Login')</a>
                                        </div>
                                    @endauth
                                </li>

                            </ul>
                        </div>
                        <div class="select-language d-lg-block d-none">
                            <select class="select-bar nic-select">
                                @foreach ($language as $lang)
                                    <option value="{{ $lang->code }}">@lang($lang->name)</option>
                                @endforeach
                            </select>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
@if (!request()->routeIs('home'))
    @php
        $breadcrumb = getContent('breadcrumb.content', true);
    @endphp

    <section class="banner-section inner-banner-section bg-overlay-primary bg_img" data-background="{{ getImage('assets/images/frontend/breadcrumb/' . $breadcrumb->data_values->breadcrumb_image, '1950x600') }}">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-10 text-center">
                    <div class="banner-content">
                        <h2 class="title">{{ __($pageTitle) }}</h2>
                        <div class="breadcrumb-area">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('Home')</a></li>
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
@endif
