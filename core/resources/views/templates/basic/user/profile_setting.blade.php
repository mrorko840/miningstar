@extends($activeTemplate . 'layouts.master')
@section('content')
    <!-- main page content -->
    <div class="main-container container">

        <!-- user information -->
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <div class="row">
                    <div class="col-auto">
                        <figure class="avatar avatar-60 rounded-10">
                            @if ($user->image != null)
                                <img src="{{ asset($customImgPath . 'user/profile/' . $user->image) }}" alt="">
                            @else
                                <img src="https://i1.sndcdn.com/artworks-000331665039-ur0qza-t500x500.jpg" alt="">
                            @endif
                        </figure>
                    </div>
                    <div class="col px-0 align-self-center">
                        <h3 class="mb-0 text-color-theme">{{ $user->firstname . ' ' . $user->lastname }}</h3>
                        <p class="text-muted ">{{ @$user->address->address }}, {{ $user->country_code }}</p>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="text-end">
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#editbio" class="small"> <i
                            class="bi bi-pencil-square"></i> Bio</a>
                </div>
                <p class="text-muted ">
                    {{@$user->bio}}
                </p>
            </div>
        </div>

        <form class="profile-form" action="" method="post" enctype="multipart/form-data">
            @csrf

            <!-- profile information -->
            <div class="row mb-3">
                <div class="col">
                    <h6>Basic Information</h6>
                </div>
            </div>
            <div class="row h-100 mb-4">
                <div class="col-6 col-md-6 col-lg-4">
                    <div class="form-group form-floating  mb-3">
                        <input class="form-control" id="InputFirstname" name="firstname" type="text"
                            value="{{ $user->firstname }}" placeholder="@lang('First Name')" required>
                        <label for="firstname">First Name</label>
                    </div>
                </div>
                <div class="col-6 col-md-6 col-lg-4">
                    <div class="form-group form-floating  mb-3">
                        <input class="form-control" id="lastname" name="lastname" type="text"
                            value="{{ $user->lastname }}" placeholder="@lang('Last Name')" required>
                        <label for="lastname">Last Name</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating mb-3">
                        <input class="form-control" id="email" name="email" type="email" value="{{ $user->email }}"
                            placeholder="@lang('E-mail Address')" readonly>
                        <label for="email">E-mail Address</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating mb-3">
                        <input class="form-control" id="phone" name="mobile" type="tel" value="{{ $user->mobile }}"
                            placeholder="@lang('Your Contact Number')" readonly>
                        <label for="phone">Phone Number</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating mb-3">
                        <input class="form-control" id="country" type="text" value="{{ @$user->address->country }}"
                            readonly>
                        <label for="country">Country</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating">
                        <input type="file" name="image" class="form-control" id="fileupload">
                        <label for="fileupload">Uplaod File</label>
                    </div>
                </div>
            </div>

            <!-- add edit address form -->
            <div class="row mb-3">
                <div class="col">
                    <h6>Address Change</h6>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <div class="form-group form-floating">
                        <input class="form-control" id="address" name="address" type="text"
                            value="{{ @$user->address->address }}" placeholder="@lang('Address')" required="">
                        <label class="form-control-label" for="address2">Address</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <div class="form-group form-floating">
                        <input class="form-control" id="state" name="state" type="text"
                            value="{{ @$user->address->state }}" placeholder="@lang('state')" required="">
                        <label class="form-control-label" for="address5">State</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <div class="form-group form-floating">
                        <input class="form-control" id="city" name="city" type="text"
                            value="{{ @$user->address->city }}" placeholder="@lang('City')" required="">
                        <label class="form-control-label" for="address6">City</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="form-group form-floating">
                        <input class="form-control" id="zip" name="zip" type="text"
                            value="{{ @$user->address->zip }}" placeholder="@lang('Zip Code')" required="">
                        <label class="form-control-label" for="address7">Zip Code</label>
                    </div>
                </div>
            </div>

            <div class="row h-100 ">
                <div class="col-12 mb-4">
                    <button class="submit-btn btn btn-default btn-lg w-100" type="submit">@lang('Update')</button>
                </div>
            </div>

        </form>

    </div>
    <!-- main page content ends -->
    
    <!-- Modal -->
    <div class="modal fade" id="editbio" tabindex="-1" aria-labelledby="editbioLabel" aria-hidden="true">
        <form action="{{route('user.bio.submit')}}" method="POST">
            @csrf
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editbioLabel">Edit Your Bio</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <textarea name="bio"  class="form-control" id="" cols="30" rows="5">{{@$user->bio}}</textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection





{{-- @section('content')
    <div class="row justify-content-center mt-4">
        <div class="col-lg-12">
            <div class="profile-area">
                <form class="profile-form" action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="form-group col-lg-6">
                            <label for="InputFirstname">@lang('First Name')</label>
                            <input class="form-control" id="InputFirstname" name="firstname" type="text" value="{{ $user->firstname }}" placeholder="@lang('First Name')" required>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="lastname">@lang('Last Name')</label>
                            <input class="form-control" id="lastname" name="lastname" type="text" value="{{ $user->lastname }}" placeholder="@lang('Last Name')" required>
                        </div>

                        <div class="col-lg-6 form-group">
                            <label>@lang('Username')</label>
                            <input class="form-control" type="text" value="{{ $user->username }}" placeholder="Username" readonly>
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="email">@lang('E-mail Address')</label>
                            <input class="form-control" id="email" name="email" type="email" value="{{ $user->email }}" placeholder="@lang('E-mail Address')" readonly>
                        </div>
                        <div class="form-group col-lg-6">
                            <input id="track" name="country_code" type="hidden">
                            <label for="phone">@lang('Mobile Number')</label>
                            <input class="form-control" id="phone" name="mobile" type="tel" value="{{ $user->mobile }}" placeholder="@lang('Your Contact Number')" readonly>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="country">@lang('Country')</label>
                            <input class="form-control" id="country" type="text" value="{{ @$user->address->country }}" readonly>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="address">@lang('Address')</label>
                            <input class="form-control" id="address" name="address" type="text" value="{{ @$user->address->address }}" placeholder="@lang('Address')" required="">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="state">@lang('State')</label>
                            <input class="form-control" id="state" name="state" type="text" value="{{ @$user->address->state }}" placeholder="@lang('state')" required="">
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="zip">@lang('Zip Code')</label>
                            <input class="form-control" id="zip" name="zip" type="text" value="{{ @$user->address->zip }}" placeholder="@lang('Zip Code')" required="">
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="city">@lang('City')</label>
                            <input class="form-control" id="city" name="city" type="text" value="{{ @$user->address->city }}" placeholder="@lang('City')" required="">
                        </div>

                        <button class="submit-btn" type="submit">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection --}}
