@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="main-container container">
        <div class="row justify-content-center mt-4">
            <div class="col-xl-6 col-md-8 col-sm-8">
                <div class="profile-area">
                    <form action="" method="post">
                        @csrf
                        <div class="form-group form-floating mb-3 is-valid">
                            <input class="form-control" id="current_password" name="current_password" type="password" required
                                autocomplete="current-password">
                            <label for="current_password" class="form-label">@lang('Current Password')</label>
                        </div>
                        <div class="form-group form-floating mb-3 is-valid">
                            <input class="form-control" name="password" type="password" required
                                autocomplete="current-password">
                            <label class="form-label">@lang('Password')</label>
                            {{-- @if ($general->secure_password)
                            <div class="input-popup">
                                <p class="error lower">@lang('1 small letter minimum')</p>
                                <p class="error capital">@lang('1 capital letter minimum')</p>
                                <p class="error number">@lang('1 number minimum')</p>
                                <p class="error special">@lang('1 special character minimum')</p>
                                <p class="error minimum">@lang('6 character password')</p>
                            </div>
                        @endif --}}
                        </div>
                        <div class="form-group form-floating mb-3 is-valid">
                            <input class="form-control" name="password_confirmation" type="password" required
                                autocomplete="current-password">
                            <label class="form-label">@lang('Confirm Password')</label>
                        </div>
                        <button class="submit-btn btn btn-lg btn-default w-100 mb-4 shadow"
                            type="submit">@lang('Submit')</button>
                    </form>
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
