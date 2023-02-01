@extends($activeTemplate . 'layouts.app')
@section('panel')

<!-- Begin page content -->
<main class="container-fluid h-100">
    <div class="row h-100 overflow-auto">
        <div class="col-12 text-center mb-auto px-0">
            <header class="header">
                <div class="row">
                    <div class="col-auto">
                        <a href="{{route('user.login')}}" target="_self" class="btn btn-light btn-44"><i class="bi bi-arrow-left"></i></a>
                    </div>
                    <div class="col">
                        <div class="logo-small">
                            <img src="{{ asset($customTemplate . 'img/logo.png') }}" alt="">
                            <h5>{{ $general->site_name }}</h5>
                        </div>
                    </div>
                    <div class="col-auto">
                        <a href=""  target="_self" class="btn btn-light btn-44 invisible"></a>
                    </div>
                </div>
            </header>
        </div>
        <form method="POST" action="{{ route('user.password.email') }}">
            @csrf
            <div class="col-10 col-md-6 col-lg-5 col-xl-3 mx-auto align-self-center text-center py-4">
                <h1 class="mb-4 text-color-theme">Right here you can reset it back</h1>
                <p class="text-muted mb-4">Provide your registered email ID or phone number to reset your password</p>

                <div class="form-floating is-valid mb-3">
                    <input class="form-control" name="value" type="text" value="{{ old('value') }}" id="emails" required autofocus="off">
                    <label for="emails">Email ID or Phone Number</label>
                </div>
                <button class="btn btn-lg btn-default w-100  shadow">Reset Password</button>
            </div>
        </form>
        <div class="col-12 text-center mt-auto">
            <div class="row justify-content-center footer-info">
                <div class="col-auto">
                  
                </div>
            </div>
        </div>
    </div>
</main>







    {{-- <div class="container">
        <div class="row justify-content-center ptb-120">
            <div class="col-md-8 col-lg-7 col-xl-5">
                <div class="card custom--card">
                    <div class="card-body">
                        <div class="mb-4">
                            <p>@lang('To recover your account please provide your email or username to find your account.')</p>
                        </div>
                        <form method="POST" action="{{ route('user.password.email') }}">
                            @csrf
                            <div class="form-group">
                                <label class="form-label">@lang('Email or Username')</label>
                                <input class="form-control form--control" name="value" type="text" value="{{ old('value') }}" required autofocus="off">
                            </div>

                            <div class="form-group">
                                <button class="btn btn--base w-100" type="submit">@lang('Submit')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
