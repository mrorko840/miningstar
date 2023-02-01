@extends($activeTemplate . 'layouts.frontend')

@section('content')
    <div class="main-container container">
        <div class="row justify-content-center ptb-120">
            <div class="col-md-8 col-lg-7 col-xl-6">
                <div class="card custom--card">
                    <div class="card-body">
                        <form class="was-validated needs-validation register-form verify-gcaptcha" method="POST" action="{{ route('user.data.submit') }}">
                            @csrf
                            <div class="form-group form-floating mb-3 is-valid">
                                <input class="form-control form--control" name="firstname" type="text" value="{{ old('firstname') }}" required>
                                <label class="form-label">@lang('First Name')</label>
                            </div>

                            <div class="form-group form-floating mb-3 is-valid">
                                <input class="form-control form--control" name="lastname" type="text" value="{{ old('lastname') }}" required>
                                <label class="form-label">@lang('Last Name')</label>
                            </div>
                            <div class="form-group form-floating mb-3 is-valid">
                                <input class="form-control form--control" name="address" type="text" value="{{ old('address') }}">
                                <label class="form-label">@lang('Address')</label>
                            </div>
                            <div class="form-group form-floating mb-3 is-valid">
                                <input class="form-control form--control" name="state" type="text" value="{{ old('state') }}">
                                <label class="form-label">@lang('State')</label>
                            </div>
                            <div class="form-group form-floating mb-3 is-valid">
                                <input class="form-control form--control" name="zip" type="text" value="{{ old('zip') }}">
                                <label class="form-label">@lang('Zip Code')</label>
                            </div>

                            <div class="form-group form-floating mb-3 is-valid">
                                <input class="form-control form--control" name="city" type="text" value="{{ old('city') }}">
                                <label class="form-label">@lang('City')</label>
                            </div>
                            
                            <div class="form-group">
                                <button class="btn btn-lg btn-default w-100 mb-4 shadow" type="submit">
                                    @lang('Submit')
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
