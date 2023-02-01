@extends($activeTemplate . 'layouts.frontend')

@section('content')
    @php
        $content = getContent('contact_us.content', true);
    @endphp

<!-- main page content -->
<div class="main-container container">

    <!-- Contact us form -->
    <div class="row mb-4">
        <form class="register-form verify-gcaptcha" method="POST">
            @csrf
            <div class="col-12 col-md-6 col-lg-4 mx-auto">
                <h3 class="mb-2 text-center text-color-theme">Make your move easy</h3>
                <p class="text-muted mb-4 text-center">Get in touch with us, We give you exact and right
                    information to you!</p>

                
                <div class="form-group form-floating mb-3">
                    <input class="form-control" name="name" id="name" type="text" value="{{ auth()->user() ? auth()->user()->fullname : old('name') }}" @if (auth()->user()) readonly @endif placeholder="@lang('Your Name')" required>
                    
                    <label for="name">Name</label>
                </div>
                <div class="form-group form-floating mb-3">
                    <input class="form-control" id="subject" name="subject" type="text" value="{{ old('subject') }}" placeholder="@lang('Subject')" required>
                    <label for="subject">Subject</label>
                </div>
                <div class="form-group form-floating mb-3">
                    <input class="form-control" id="email" name="email" type="text" value="{{ auth()->user() ? auth()->user()->email : old('email') }}" @if (auth()->user()) readonly @endif placeholder="@lang('Your Email')" required>
                    <label for="email">Email</label>
                </div>
                <div class="form-floating  mb-3">
                    <textarea class="form-control" id="message" name="message" rows="5" placeholder="@lang('Your Message')" required>{{ old('message') }}</textarea>
                    <label for="message">Your Massage</label>
                </div>
                <x-captcha class="col-lg-12" customCaptchaMarginBottom="mrb-20" googleMarginBottom="mrb-20" />

                <button class="submit-btn btn btn-default btn-lg w-100" id="recaptcha" type="submit">@lang('Submit')</button>
            </div>
        </form>
    </div>

</div>
<!-- main page content ends -->


    {{-- <!-- contact-section start -->
    <section class="contact-section register-section pd-t-120">
        <div class="container">

            <div class="row justify-content-center ml-b-30 flex-wrap-reverse">
                <div class="col-lg-5 mrb-30">
                    <div class="contact-thumb">
                        <img src="{{ getImage('assets/images/frontend/contact_us/' . @$content->data_values->image, '618x406') }}" alt="">
                    </div>
                </div>
                <div class="col-lg-7 mrb-30">
                    <div class="register-form-area">
                        <h3 class="title mb-4">{{ __(@$content->data_values->heading) }}</h3>
                        <span class="title-border"></span>
                        <form class="register-form verify-gcaptcha" method="POST">
                            @csrf
                            <div class="row justify-content-center ml-b-20">
                                <div class="col-lg-6 form-group">
                                    <label class="register-icon"><i class="fas fa-pen"></i></label>
                                    <input class="form-control" name="name" type="text" value="{{ auth()->user() ? auth()->user()->fullname : old('name') }}" @if (auth()->user()) readonly @endif placeholder="@lang('Your Name')" required>
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label class="register-icon"><i class="fas fa-envelope"></i></label>
                                    <input class="form-control" name="email" type="text" value="{{ auth()->user() ? auth()->user()->email : old('email') }}" @if (auth()->user()) readonly @endif placeholder="@lang('Your Email')" required>
                                </div>
                                <div class="col-lg-12 form-group">
                                    <label class="register-icon"><i class="fas fa-book"></i></label>
                                    <input class="form-control" name="subject" type="text" value="{{ old('subject') }}" placeholder="@lang('Subject')" required>
                                </div>

                                <div class="col-lg-12 form-group">
                                    <textarea class="form-control" name="message" rows="5" placeholder="@lang('Your Message')" required>{{ old('message') }}</textarea>
                                </div>

                                <x-captcha class="col-lg-12" customCaptchaMarginBottom="mrb-20" googleMarginBottom="mrb-20" />

                                <div class="col-lg-12 form-group text-center">
                                    <button class="submit-btn" id="recaptcha" type="submit">@lang('Submit')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- contact-section end -->

    <!-- contact-info start -->
    <div class="contact-info-area ptb-120">
        <div class="container">
            <div class="contact-info-item-area">
                <div class="row justify-content-center ml-b-30">
                    <div class="col-lg-4 col-md-6 col-sm-8 mrb-30 text-center">
                        <div class="contact-info-item">
                            <i class="fas fa fa-map-marker-alt"></i>
                            <h3 class="title">@lang('Address')</h3>
                            <p>{{ __(@$content->data_values->contact_details) }}</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-8 mrb-30 text-center">
                        <div class="contact-info-item item-one">
                            <i class="fas fa-envelope"></i>
                            <h3 class="title">@lang('Email Address')</h3>
                            <p><a href="mailto:{{ @$content->data_values->email_address }}">{{ @$content->data_values->email_address }}</a></p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-8 mrb-30 text-center">
                        <div class="contact-info-item item-two">
                            <i class="fas fa-phone-alt"></i>
                            <h3 class="title">@lang('Phone Number')</h3>
                            <p><a href="tel:{{ @$content->data_values->contact_number }}">{{ @$content->data_values->contact_number }}</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- contact-info end --> --}}

    {{-- @if ($sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif --}}
@endsection
