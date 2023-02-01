@extends($activeTemplate . 'layouts.master')
@section('content')
<style>
    .coverPhoto{
        background-image: url('https://cdn.pixabay.com/photo/2016/05/05/02/37/sunset-1373171__480.jpg');
        background-position: center;
        background-size: cover;
        position: relative;
        z-index: 0;
    }
    .pofilePhoto{
        margin-top: -120px;
        position: relative;
        z-index: 0;
        margin-left: 25px;
    }
</style>

@php
    $app = getContent('app.content', true);
@endphp
    <!-- main page content -->
    <div class="main-container container pt-0">
        <div class="card shadow-sm mb-4 coverPhoto">
            <div style="height: 150px" class="card-body">

            </div>
        </div>
        <div class="pofilePhoto mb-3">
            @if ($user->image != null)
                <img class="img-thumbnail rounded-circle mb-2" width="140px" src="{{ asset($customImgPath . 'user/profile/' . $user->image) }}" alt="">  
            @else
                <img class="img-thumbnail rounded-circle mb-2" width="140px" src="https://i1.sndcdn.com/artworks-000331665039-ur0qza-t500x500.jpg" alt="">  
            @endif
            <h3 class="mb-0 text-color-theme">{{ $user->firstname . ' ' . $user->lastname }}</h3>
            <p class="text-muted mb-0"><b>{{ @$user->address->address }}, {{ $user->country_code }}</b></p>
            <p class="text-muted small"><b>Bio:</b> {{$user->bio}}</p>
        </div>

        <!-- followers and connections -->
        {{-- <div class="row mb-4 text-center py-4 bg-theme-light">
            <div class="col">
                <h6 class="mb-0">+254</h6>
                <p class="text-muted small">Followers</p>
            </div>
            <div class="col">
                <h6 class="mb-0">+124</h6>
                <p class="text-muted small">Connections</p>
            </div>
            <div class="col">
                <h6 class="mb-0">+1456</h6>
                <p class="text-muted small">Friends</p>
            </div>
        </div> --}}

        <!-- summary -->
        <div class="row mb-3">
            <div class="col-6 col-md-6">
                <div class="card shadow-sm mb-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-auto px-0">
                                <div class="avatar avatar-40 bg-primary text-white shadow-sm rounded-10-end">
                                    <i class="bi bi-currency-dollar"></i>
                                </div>
                            </div>
                            <div class="col">
                                <p class="text-muted size-12 mb-0">Main Balance</p>
                                <p>{{ __($general->cur_sym) }} {{ showAmount(auth()->user()->balance) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-6">
                <div class="card shadow-sm mb-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-auto px-0">
                                <div class="avatar avatar-40 bg-info text-white shadow-sm rounded-10-end">
                                    <i class="bi bi-person-plus-fill"></i>
                                </div>
                            </div>
                            <div class="col">
                                <p class="text-muted size-12 mb-0">Referral Bonus</p>
                                <p>{{ __($general->cur_sym) }} {{ showAmount($widget['referral_bonus']) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-6">
                <div class="card shadow-sm mb-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-auto px-0">
                                <div class="avatar avatar-40 bg-warning text-white shadow-sm rounded-10-end">
                                    <i class="bi bi-wallet-fill"></i>
                                </div>
                            </div>
                            <div class="col">
                                <p class="text-muted size-12 mb-0">Total Deposit</p>
                                <p>{{ __($general->cur_sym) }} {{ showAmount($widget['deposit']) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-6">
                <div class="card shadow-sm mb-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-auto px-0">
                                <div class="avatar avatar-40 bg-success text-white shadow-sm rounded-10-end">
                                    <i class="bi bi-cash-coin"></i>
                                </div>
                            </div>
                            <div class="col">
                                <p class="text-muted size-12 mb-0">Total Withdraw</p>
                                <p>{{ __($general->cur_sym) }} {{ showAmount($widget['withdraw']) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @foreach ($miners as $item)
                <div class="col-12 col-md-6">
                    <div class="card shadow-sm mb-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-auto px-0">
                                    <div class="avatar avatar-40 text-white shadow-sm rounded-10-end">
                                        <img src="{{ asset($customImgPath . '/miner'.'/'. $item->coin_image )  }}" alt="">
                                    </div>
                                </div>
                                <div class="col">
                                    <p class="text-muted size-12 mb-0">{{ $item->coin_code }} Wallet</p>
                                    <p>{{ showAmount($item->userCoinBalances->balance, 8) }} {{ $item->coin_code }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

        <!-- Accounts-->
        <div class="card mb-4">
            <div class="card-header py-2 ps-0 ">
                <div class="row">
                    <div class="col-auto">
                        <h6 class="py-1 px-2 bg-primary-light text-primary shadow-sm rounded-10-end w-100">
                            Account
                        </h6>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pt-0">
                <div class="list-group list-group-flush border-top border-color">
                    
                    <a href="{{route('user.profile.setting')}}" class="list-group-item list-group-item-action border-color py-2">
                        <div class="row align-items-center">
                            <div class="col-auto px-0">
                                <div class="avatar avatar-50 bg-primary-light text-primary shadow-sm rounded-10-end">
                                    <i class="material-icons">manage_accounts</i>
                                </div>
                            </div>
                            <div class="col align-self-center pl-0">
                                <h6 class="mb-1 small">Profile Settings</h6>
                                <p class="text-secondary small">Update account informations</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('user.change.password') }}" class="list-group-item list-group-item-action border-color py-2">
                        <div class="row">
                            <div class="col-auto px-0">
                                <div class="avatar avatar-50 bg-primary-light text-primary shadow-sm rounded-10-end">
                                    <i class="material-icons">lock_open</i>
                                </div>
                            </div>
                            <div class="col align-self-center pl-0">
                                <h6 class="mb-1 small">Security Settings</h6>
                                <p class="text-secondary small">Change Password</p>
                            </div>
                        </div>
                    </a>
                    
                    <a href="{{ route('user.wallets') }}" class="list-group-item list-group-item-action border-color py-2">
                        <div class="row">
                            <div class="col-auto px-0">
                                <div class="avatar avatar-50 bg-primary-light text-primary shadow-sm rounded-10-end">
                                    <i class="material-icons">account_balance_wallet</i>
                                </div>
                            </div>
                            <div class="col align-self-center pl-0">
                                <h6 class="mb-1 small">Wallet</h6>
                                <p class="text-secondary small">Add your Wallet Address here.</p>
                            </div>
                        </div>
                    </a>

                </div>
            </div>
        </div>

        <!-- Reports -->
        <div class="card mb-4">
            <div class="card-header py-2 ps-0 ">
                <div class="row">
                    <div class="col-auto">
                        <h6 class="py-1 px-2 bg-success-light text-success shadow-sm rounded-10-end w-100">
                            Reports
                        </h6>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pt-0">
                <div class="list-group list-group-flush border-top border-color">
                    
                    {{-- <a href="" class="list-group-item list-group-item-action border-color py-2">
                        <div class="row align-items-center">
                            <div class="col-auto px-0">
                                <div class="avatar avatar-50 bg-success-light text-success shadow-sm rounded-10-end">
                                    <i class="material-icons">bubble_chart</i>
                                </div>
                            </div>
                            <div class="col align-self-center pl-0">
                                <h6 class="mb-1 small">Commissions</h6>
                                <p class="text-secondary small">Commissions from myTeam</p>
                            </div>
                        </div>
                    </a> --}}

                    <a href="{{ route('user.transactions') }}" class="list-group-item list-group-item-action border-color py-2">
                        <div class="row">
                            <div class="col-auto px-0">
                                <div class="avatar avatar-50 bg-success-light text-success shadow-sm rounded-10-end">
                                    <i class="material-icons">bar_chart</i>
                                </div>
                            </div>
                            <div class="col align-self-center pl-0">
                                <h6 class="mb-1 small">Transactions</h6>
                                <p class="text-secondary small">All Transactions Here</p>
                            </div>
                        </div>
                    </a>
                    
                    <a href="{{ route('user.deposit.history') }}" class="list-group-item list-group-item-action border-color py-2">
                        <div class="row">
                            <div class="col-auto px-0">
                                <div class="avatar avatar-50 bg-success-light text-success shadow-sm rounded-10-end">
                                    <i class="material-icons">history_toggle_off</i>
                                </div>
                            </div>
                            <div class="col align-self-center pl-0">
                                <h6 class="mb-1 small">Deposit History</h6>
                                <p class="text-secondary small">All deposit records here.</p>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('user.withdraw.history') }}" class="list-group-item list-group-item-action border-color py-2">
                        <div class="row">
                            <div class="col-auto px-0">
                                <div class="avatar avatar-50 bg-success-light text-success shadow-sm rounded-10-end">
                                    <i class="material-icons">history_toggle_off</i>
                                </div>
                            </div>
                            <div class="col align-self-center pl-0">
                                <h6 class="mb-1 small">Withdraw History</h6>
                                <p class="text-secondary small">All withdraw records here.</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Exit -->
        <div class="card mb-4">
            <div class="card-header py-2 ps-0 ">
                <div class="row">
                    <div class="col-auto">
                        <h6 class="py-1 px-2 bg-warning-light text-warning shadow-sm rounded-10-end w-100">
                            Others
                        </h6>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pt-0">
                <div class="list-group list-group-flush border-top border-color">
                    
                    <a href="{{$app->data_values->app_link}}" class="list-group-item list-group-item-action border-color py-2">
                        <div class="row align-items-center">
                            <div class="col-auto px-0">
                                <div class="avatar avatar-50 bg-warning-light text-warning shadow-sm rounded-10-end">
                                    <i class="material-icons">android</i>
                                </div>
                            </div>
                            <div class="col align-self-center pl-0">
                                <h6 class="mb-1 small">App</h6>
                                <p class="text-secondary small">Download Our official application</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <!-- Exit -->
        <div class="card mb-4">
            <div class="card-header py-2 ps-0 ">
                <div class="row">
                    <div class="col-auto">
                        <h6 class="py-1 px-2 bg-danger-light text-danger shadow-sm rounded-10-end w-100">
                            Exit
                        </h6>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pt-0">
                <div class="list-group list-group-flush border-top border-color">
                    
                    <a href="{{route('user.logout')}}" class="list-group-item list-group-item-action border-color py-2">
                        <div class="row align-items-center">
                            <div class="col-auto px-0">
                                <div class="avatar avatar-50 bg-danger-light text-danger shadow-sm rounded-10-end">
                                    <i class="material-icons">power_settings_new</i>
                                </div>
                            </div>
                            <div class="col align-self-center pl-0">
                                <h6 class="mb-1 small">Logout</h6>
                                <p class="text-secondary small">Logout from the application</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        
    </div>
    <!-- main page content ends -->
@endsection

{{-- @section('content')
    <!-- dashboard-section start -->
    @if ($general->kv && auth()->user()->kv != Status::KYC_VERIFIED)
        @php
            $kycInstruction = getContent('kyc_instruction.content', true);
        @endphp
        <div class="row mrb-60">
            <div class="container">
                <div class="row">
                    @if (auth()->user()->kv == Status::KYC_UNVERIFIED)
                        <div class="col-12">
                            <div class="alert alert-info mb-0" role="alert">
                                <h5 class="alert-heading m-0">@lang('KYC Verification Required')</h5>
                                <hr>
                                <p class="mb-0"> {{ __($kycInstruction->data_values->verification_instruction) }} <a class="text-base" href="{{ route('user.kyc.form') }}">@lang('Click Here to Verify')</a></p>
                            </div>
                        </div>
                    @elseif(auth()->user()->kv == Status::KYC_PENDING)
                        <div class="col-12">
                            <div class="alert alert-warning mb-0" role="alert">
                                <h5 class="alert-heading m-0">@lang('KYC Verification pending')</h5>
                                <hr>
                                <p class="mb-0"> {{ __($kycInstruction->data_values->pending_instruction) }} <a class="text-base" href="{{ route('user.kyc.data') }}">@lang('See KYC Data')</a></p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <div class="row justify-content-center ml-b-30">
        <div class="col-lg-4 col-md-6 col-sm-8 mrb-30">
            <div class="dash-item d-flex flex-wrap">
                <div class="dash-icon">
                    <i class="las la-money-bill fa-4x"></i>
                </div>
                <div class="dash-content">
                    <h3 class="sub-title">@lang('Balance')</h3>
                    <h4 class="title"> <span>{{ showAmount(auth()->user()->balance) }} {{ __($general->cur_text) }}</span></h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-8 mrb-30">
            <div class="dash-item d-flex flex-wrap">
                <div class="dash-icon">
                    <i class="las la-wallet fa-4x"></i>
                </div>
                <div class="dash-content">
                    <h3 class="sub-title">@lang('Deposit')</h3>
                    <h4 class="title"> <span>{{ showAmount($widget['deposit']) }} {{ __($general->cur_text) }}</span></h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-8 mrb-30">
            <div class="dash-item d-flex flex-wrap">
                <div class="dash-icon">
                    <i class="las la-wallet fa-4x"></i>
                </div>
                <div class="dash-content">
                    <h3 class="sub-title">@lang('Referral Bonus')</h3>
                    <h4 class="title"> <span>{{ showAmount($widget['referral_bonus']) }} {{ __($general->cur_text) }}</span></h4>
                </div>
            </div>
        </div>
        @foreach ($miners as $item)
            <div class="col-lg-4 col-md-6 col-sm-8 mrb-30">
                <div class="dash-item d-flex flex-wrap">
                    <div class="dash-icon">
                        <img src="{{ getImage(getFilePath('miner') . '/' . $item->coin_image, getFileSize('miner')) }}" alt="@lang('Image')">
                    </div>
                    <div class="dash-content">
                        <h3 class="sub-title"><span>{{ $item->coin_code }}</span> @lang('Wallet')</h3>
                        <h4 class="title">{{ showAmount($item->userCoinBalances->balance, 8) }} {{ $item->coin_code }}</h4>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <!-- dashboard-section end -->

    <section class="ptb-80">
        <div class="order-section">
            <h2 class="section-title">@lang('Latest Purchased') <span>@lang('Plans')</span></h2>
            @include($activeTemplate . 'partials.purchased_plan', ['orders' => $orders, 'paginate' => false])
        </div>
    </section>
    <!-- chart-section start -->
    <section class="chart-section pb-80">
        <div class="container">
            <h2 class="section-title">@lang('Monthly') <span>@lang('Deposits')</span></h2>
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="chart-scroll">
                        <div class="chart-wrapper m-0">
                            <canvas id="depositChart" width="400" height="180"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- chart-section start -->
@endsection --}}

@push('script')
    <script>
        'use strict';
        var ctx = document.getElementById('depositChart');
        var depositChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($report['months']->flatten()),
                datasets: [{
                    label: '# Deposits',
                    data: @json($report['deposit_month_amount']->flatten()),
                    backgroundColor: [
                        'rgba(255, 255, 255, 0.1)'
                    ],
                    borderColor: [
                        '#{{ $general->base_color }}'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }

        });
    </script>
@endpush
