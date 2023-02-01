@php
    $content = getContent('login.content', true);
@endphp
@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="account section-bg py-100">
        <div class="container">
            <div class="row align-items-center gy-4 flex-wrap-reverse">
                <div class="col-lg-5">
                    <div class="account-content">
                        <div class="account-content__thumb">
                            <img src="{{ getImage('assets/images/frontend/login/' . @$content->data_values->image, '420x410') }}" alt="@lang('Login')">
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 ps-lg-5">
                    <div class="contact-form">
                        <h3 class="account-title pb-3 text-center"> {{ __(@$content->data_values->title) }} </h3>
                        <form class="verify-gcaptcha" method="POST" action="{{ route('user.login') }}" autocomplete="off">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-sm-12">
                                    <input class="form--control" name="username" type="text" value="{{ old('username') }}" placeholder="@lang('Username')" required>
                                </div>
                                <div class="col-sm-12">
                                    <div class="input-group">
                                        <input class="form--control" id="your-password" name="password" type="password" placeholder="@lang('Password')" required>
                                        <div class="password-show-hide fas fa-eye toggle-password" id="#your-password"></div>
                                    </div>
                                </div>

                                <x-captcha customCaptchaMarginBottom="col-sm-12" googleMarginBottom="col-sm-12" class="col-sm-12" />

                                <div class="col-sm-12">
                                    <div class="checkbox d-flex justify-content-between align-items-center align-items-center flex-wrap text-start">
                                        <div class="form-check form--check mb-0">
                                            <input class="form-check-input" id="rem-me" name="remember" type="checkbox">
                                            <label class="form-check-label mb-0" for="rem-me">@lang('Remember Me')</label>
                                        </div>
                                        <div>
                                            <a class="checkbox__forgot-pass text--base" href="{{ route('user.password.request') }}">@lang('Forget Password')</a>
                                        </div>
                                    </div>
                                </div>

                                @if ($general->registration)
                                    <div class="col-sm-12">
                                        <div class="have-account">
                                            <p class="have-account__text">@lang('Don\'t Have An Account?') <a class="have-account__link text--base" href="{{ route('user.register') }}">@lang('Register')</a></p>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-sm-12">
                                    <button class="btn--base w-100" type="submit"> @lang('Login') </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        "use strict";

        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML = '<span style="color:red;">@lang('Captcha field is required.')</span>';
                return false;
            }

            return true;
        }

        function verifyCaptcha() {
            document.getElementById('g-recaptcha-error').innerHTML = '';
        }
    </script>
@endpush
