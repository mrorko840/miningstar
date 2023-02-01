@php
    $policyPages = getContent('policy_pages.element', false, null, true);
    $content = getContent('register.content', true);
@endphp
@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="account section-bg py-100">
        <div class="container">
            <div class="row align-items-center gy-4 flex-wrap-reverse">
                <div class="col-lg-5">
                    <div class="account-content">
                        <div class="account-content__thumb">
                            <img src="{{ getImage('assets/images/frontend/register/' . @$content->data_values->image, '420x410') }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 ps-lg-5">
                    <div class="contact-form">
                        <h3 class="account-title pb-3 text-center"> {{ __(@$content->data_values->title) }} </h3>
                        <form class="verify-gcaptcha" action="{{ route('user.register') }}" method="POST" autocomplete="off">
                            @csrf
                            <div class="row gy-4">
                                @if (session()->get('reference') != null)
                                    <div class="col-sm-12">
                                        <input class="form--control" name="referBy" type="text" value="{{ session()->get('reference') }}" readonly>
                                    </div>
                                @endif

                                <div class="col-sm-6">
                                    <input class="form--control checkUser" name="username" type="text" value="{{ old('username') }}" placeholder="@lang('Enter Username')" required>
                                    <small class="text-danger usernameExist"></small>
                                </div>
                                <div class="col-sm-6">
                                    <input class="form--control checkUser" name="email" type="email" value="{{ old('email') }}" placeholder="@lang('Enter Email')" required>
                                </div>
                                <div class="col-sm-12">
                                    <select class="custom--select form--control" name="country">
                                        @foreach ($countries as $key => $country)
                                            <option data-mobile_code="{{ $country->dial_code }}" data-code="{{ $key }}" value="{{ $country->country }}">{{ __($country->country) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-12">
                                    <div class="input-group">
                                        <span class="input-group-text mobile-code"></span>
                                        <input name="mobile_code" type="hidden">
                                        <input name="country_code" type="hidden">
                                        <input class="form-control form--control checkUser" name="mobile" type="number" value="{{ old('mobile') }}" placeholder="@lang('Enter Mobile Number')" required>
                                    </div>
                                    <small class="text-danger mobileExist"></small>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <input class="form--control" id="your-password" name="password" type="password" placeholder="@lang('Enter Password')" required>

                                        <div class="password-show-hide fas fa-eye toggle-password" id="#your-password"></div>
                                        @if ($general->secure_password)
                                            <div class="input-popup">
                                                <p class="error lower">@lang('1 small letter minimum')</p>
                                                <p class="error capital">@lang('1 capital letter minimum')</p>
                                                <p class="error number">@lang('1 number minimum')</p>
                                                <p class="error special">@lang('1 special character minimum')</p>
                                                <p class="error minimum">@lang('6 character password')</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <input class="form--control" id="res-password" name="password_confirmation" type="password" placeholder="@lang('Confirm Password')" required>
                                        <div class="password-show-hide fas fa-eye toggle-password" id="#res-password"></div>
                                    </div>
                                </div>

                                <x-captcha class="col-sm-12" customCaptchaMarginBottom="col-sm-12" googleMarginBottom="col-sm-12" />

                                @if ($general->agree)
                                    <div class="col-sm-12">
                                        <div class="form-check form--check mb-0">
                                            <input class="form-check-input" id="agree" name="agree" type="checkbox" required>
                                            <label class="form-check-label agree-policy mb-0" for="agree">
                                                @lang('I agree with the')
                                            </label>
                                            @foreach ($policyPages as $policy)
                                                <a class="checkbox__link text--base" href="{{ route('policy.pages', [slug($policy->data_values->title), $policy->id]) }}" target="_blank">@lang($policy->data_values->title) </a>
                                                @if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                <div class="col-sm-12">
                                    <div class="have-account">
                                        <p class="have-account__text">@lang('Already have an account?') <a class="have-account__link text--base" href="{{ route('user.login') }}">@lang('Login')</a></p>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <button class="btn--base w-100" type="submit">{{ __(@$content->data_values->button_text) }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="existModalCenter" role="dialog" aria-labelledby="existModalCenterTitle" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h5>
                    <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6 class="mb-0 text-center">@lang('You already have an account. Please Login. ')</h6>
                </div>
                <div class="modal-footer">
                    <button class="btn btn--danger btn--sm" data-bs-dismiss="modal" type="button">@lang('Close')</button>
                    <a class="btn btn--base btn--sm outline" href="{{ route('user.login') }}">@lang('Login')</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@if ($general->secure_password)
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif
@push('script')
    <script>
        "use strict";
        (function($) {
            @if ($mobileCode)
                $(`option[data-code={{ $mobileCode }}]`).attr('selected', '');
            @endif

            $('select[name=country]').change(function() {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            });
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            @if ($general->secure_password)
                $('input[name=password]').on('input', function() {
                    secure_password($(this));
                });

                $('[name=password]').focus(function() {
                    $(this).closest('.input-group').addClass('hover-input-popup');
                });

                $('[name=password]').focusout(function() {
                    $(this).closest('.input-group').removeClass('hover-input-popup');
                });
            @endif

            $('.checkUser').on('focusout', function(e) {
                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                    var data = {
                        mobile: mobile,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'email') {
                    var data = {
                        email: value,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    }
                }
                $.post(url, data, function(response) {
                    if (response.data != false && response.type == 'email') {
                        $('#existModalCenter').modal('show');
                    } else if (response.data != false) {
                        $(`.${response.type}Exist`).text(`${response.type} already exist`);
                    } else {
                        $(`.${response.type}Exist`).text('');
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
