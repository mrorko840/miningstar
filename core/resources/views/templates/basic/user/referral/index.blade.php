@extends($activeTemplate . 'layouts.master')

@section('content')
    <!-- main page content -->
    <div class="main-container container">
        <!-- banner -->
        <div class="row mb-4">
            <div class="col-12 text-center">
                <img src="{{ asset($customTemplate . 'img/infographic-scan.png') }}" alt="">
            </div>
        </div>

        <div class="row">
            <div class="col-12 text-center mb-4">
                <h1 class="mb-3 text-color-theme">Share QR Code to Refer</h1>
                <div class="form-group">
                    
                    <div class="card">
                        <label class="d-flex justify-content-between">
                            <span class="pt-2 ps-2 text-center">@lang('Referral Link')</span>
                            @if (auth()->user()->referrer)
                                <span class="text-info">@lang('You are referred by') {{ auth()->user()->referrer->fullname }}</span>
                            @endif
                        </label>
                        <div class="card-body">
                            <div class="input-group">
                                <input class="form-control form--control referralURL" name="text" type="text"
                                    value="{{ route('home') }}?ref={{ auth()->user()->username }}" readonly="">
                                <button class="input-group-text btn btn-primary copyBoard border-0" id="copyBoard"> 
                                    <i class="bi bi-clipboard"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="order-section pd-t-30 pd-b-80">
            <div class="row justify-content-center ml-b-30">
                <div class="col-lg-12 mrb-30">
                    @if ($user->allReferrals->count() > 0 && $maxLevel > 0)
                        <label>@lang('My Referrals')</label>
                        <div class="treeview-container">
                            <ul class="treeview">
                                <li class="items-expanded"> {{ $user->fullname }} ( {{ $user->username }} )
                                    @include($activeTemplate . 'partials.under_tree', [
                                        'user' => $user,
                                        'layer' => 0,
                                        'isFirst' => true,
                                    ])
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- main page content ends -->

    
@endsection

{{-- @section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <label class="d-flex justify-content-between">
                    <span>@lang('Referral Link')</span>
                    @if (auth()->user()->referrer)
                        <span class="text-info">@lang('You are referred by') {{ auth()->user()->referrer->fullname }}</span>
                    @endif
                </label>
                <div class="input-group">
                    <input class="form-control form--control referralURL" name="text" type="text" value="{{ route('home') }}?ref={{ auth()->user()->username }}" readonly="">
                    <button class="input-group-text btn-icon copyBoard border-0" id="copyBoard"> <i class="fa fa-copy"></i> </button>
                </div>
            </div>
        </div>
    </div>

    <div class="order-section pd-t-30 pd-b-80">
        <div class="row justify-content-center ml-b-30">
            <div class="col-lg-12 mrb-30">
                @if ($user->allReferrals->count() > 0 && $maxLevel > 0)
                    <label>@lang('My Referrals')</label>
                    <div class="treeview-container">
                        <ul class="treeview">
                            <li class="items-expanded"> {{ $user->fullname }} ( {{ $user->username }} )
                                @include($activeTemplate . 'partials.under_tree', ['user' => $user, 'layer' => 0, 'isFirst' => true])
                            </li>
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection --}}

@push('style-lib')
    <link type="text/css" href="{{ asset('assets/global/css/jquery.treeView.css') }}" rel="stylesheet">
@endpush
@push('script')
    <script src="{{ asset('assets/global/js/jquery.treeView.js') }}"></script>
    <script>
        (function($) {
            "use strict";

            $('.treeview').treeView();
            $('.copyBoard').click(function() {
                var copyText = document.getElementsByClassName("referralURL");
                copyText = copyText[0];
                copyText.select();
                copyText.setSelectionRange(0, 99999);

                /*For mobile devices*/
                document.execCommand("copy");
                notify('success', "Copied: " + copyText.value);
            });
        })(jQuery);
    </script>
@endpush
