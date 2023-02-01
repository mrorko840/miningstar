@php
    $content = getContent('login.content', true);
@endphp
@extends($activeTemplate . 'layouts.app')
@section('panel')

<!-- Begin page content -->
<main class="container-fluid h-100">
    <div class="row h-100 overflow-auto">
        <div class="col-12 text-center mb-auto px-0">
            <header class="header">
                <div class="row">
                    <div class="col-auto"></div>
                    <div class="col">
                        <div class="logo-small">
                            <img src="{{ asset($customTemplate . 'img/logo.png') }}" alt="">
                            <h5>{{ $general->site_name }}</h5>
                        </div>
                    </div>
                    <div class="col-auto"></div>
                </div>
            </header>
        </div>
        <div class="col-10 col-md-6 col-lg-5 col-xl-3 mx-auto align-self-center text-center py-4">
            <h1 class="mb-4 text-color-theme">Sign in</h1>
            <form class="was-validated needs-validation register-form verify-gcaptcha" method="POST" action="{{ route('user.login') }}" novalidate>
                @csrf
                <div class="form-group form-floating mb-3 is-valid">
                    <input class="form-control" name="username" type="text" value="{{ old('username') }}" id="email" placeholder="@lang('Username')" required>
                    <label class="form-control-label" for="email">Username</label>
                </div>

                <div class="form-group form-floating is-invalid mb-3">
                    <input class="form-control" name="password" type="password" placeholder="@lang('Password')" id="password" required autocomplete="new-password">
                    <label class="form-control-label" for="password">Password</label>
                    {{-- <button type="button" class="text-danger tooltip-btn" data-bs-toggle="tooltip"
                        data-bs-placement="left" title="Enter valid Password" id="passworderror">
                        <i class="bi bi-info-circle"></i>
                    </button> --}}
                </div>
                <p class="mb-3 text-center">
                    <a href="{{ route('user.password.request') }}" class="">
                        Forgot your password?
                    </a>
                </p>

                <button type="submit" class="btn btn-lg btn-default w-100 mb-4 shadow">
                    Sign in
                </button>
            </form>
            <p class="mb-2 text-muted">Don't have account?</p>
            <a href="{{ route('user.register') }}" target="_self" class="">
                Sign up <i class="bi bi-arrow-right"></i>
            </a>

        </div>
        {{-- <div class="col-12 text-center mt-auto">
            <div class="row justify-content-center footer-info">
                <div class="col-auto">
                    <p class="text-muted">Or you can continue with </p>
                </div>
                <div class="col-auto ps-0">
                    <a href="#" class="p-1"><i class="bi bi-twitter"></i></a>
                    <a href="#" class="p-1"><i class="bi bi-google"></i></a>
                    <a href="#" class="p-1"><i class="bi bi-facebook"></i></a>
                </div>
            </div>
        </div> --}}
    </div>
</main>





    {{-- <section class="register-section bg-overlay-primary bg_img" data-background="{{ getImage('assets/images/frontend/login/' . $content->data_values->image, '1920x1080') }}">
        <div class="container">
            <div class="row register-area justify-content-center align-items-center">
                <div class="col-lg-5">
                    <div class="register-form-area">
                        <div class="register-logo-area text-center">
                            <a href="{{ route('home') }}"><img src="{{ getImage('assets/images/logoIcon/logo.png') }}" alt="@lang('logo')"></a>
                        </div>
                        @if (Route::has('user.register'))
                            <div class="account-header text-center">
                                <h2 class="title">{{ __(@$content->data_values->title) }}</h2>
                                <p class="sub-title">@lang('Don\'t Have An Account')? <a href="{{ route('user.register') }}">@lang('Create Now')</a></p>
                            </div>
                        @endif
                        <form class="register-form verify-gcaptcha" method="POST" action="{{ route('user.login') }}">
                            @csrf
                            <div class="row justify-content-center">
                                <div class="col-lg-12 form-group">
                                    <label class="register-icon"><i class="fas fa-user"></i></label>
                                    <input class="form-control" name="username" type="text" value="{{ old('username') }}" placeholder="@lang('Username')" required>
                                </div>

                                <div class="col-lg-12 form-group">
                                    <label class="register-icon"><i class="fas fa-key"></i></label>
                                    <input class="form-control" name="password" type="password" placeholder="@lang('Password')" required autocomplete="new-password">
                                </div>

                                <x-captcha customCaptchaMarginBottom="mrb-20" googleMarginBottom="mrb-20" class="col-lg-12" />

                                <div class="col-lg-12 form-group d-flex flex-wrap gap-2 justify-content-between">
                                    <div class="form--check">
                                        <input class="form-check-input" id="rem-me" name="remember" type="checkbox">
                                        <label class="form-check-label mb-0" for="rem-me">@lang('Remember Me')</label>
                                    </div>
                                    <div>
                                        <a href="{{ route('user.password.request') }}" class="text-base">@lang('Forgot Password')?</a>
                                    </div>
                                </div>
                                <div class="col-lg-12 form-group mb-0 text-center">
                                    <button class="submit-btn" id="recaptcha" type="submit">@lang('Login')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

@endsection
