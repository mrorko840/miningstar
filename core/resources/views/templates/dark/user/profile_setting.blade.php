@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="card custom--card">
        <h5 class="card-header">
            {{ __($pageTitle) }}
        </h5>

        <div class="card-body">
            <form class="profile-form" action="" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row gy-4">
                    <div class="col-sm-6">
                        <label class="form-label" for="InputFirstname">@lang('First Name')</label>
                        <input class="form--control" id="InputFirstname" name="firstname" type="text" value="{{ old('firstname', $user->firstname) }}" placeholder="@lang('First Name')" required />
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="lastname">@lang('Last Name')</label>
                        <input class="form--control" id="lastname" name="lastname" type="text" value="{{ $user->lastname }}" placeholder="@lang('Last Name')" required>
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label">@lang('Username')</label>
                        <input class="form--control" type="text" value="{{ $user->username }}" placeholder="Username" readonly>
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="email">@lang('E-mail Address')</label>
                        <input class="form--control" id="email" name="email" type="email" value="{{ $user->email }}" placeholder="@lang('E-mail Address')" readonly>
                    </div>
                    <div class="col-sm-6">
                        <input id="track" name="country_code" type="hidden">
                        <label class="form-label" for="phone">@lang('Mobile Number')</label>
                        <input class="form--control" id="phone" name="mobile" type="tel" value="{{ $user->mobile }}" placeholder="@lang('Your Contact Number')" readonly>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="country">@lang('Country')</label>
                        <input class="form--control" id="country" type="text" value="{{ @$user->address->country }}" readonly>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="address">@lang('Address')</label>
                        <input class="form--control" id="address" name="address" type="text" value="{{ @$user->address->address }}" placeholder="@lang('Address')">
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="state">@lang('State')</label>
                        <input class="form--control" id="state" name="state" type="text" value="{{ @$user->address->state }}" placeholder="@lang('state')">
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="zip">@lang('Zip Code')</label>
                        <input class="form--control" id="zip" name="zip" type="text" value="{{ @$user->address->zip }}" placeholder="@lang('Zip Code')">
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="city">@lang('City')</label>
                        <input class="form--control" id="city" name="city" type="text" value="{{ @$user->address->city }}" placeholder="@lang('City')">
                    </div>
                    <div class="col-lg-12">
                        <button class="btn--base w-100" type="submit">@lang('Submit')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
