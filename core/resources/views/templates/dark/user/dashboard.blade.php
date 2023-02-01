@extends($activeTemplate . 'layouts.master')
@section('content')
    @if ($general->kv && auth()->user()->kv != Status::KYC_VERIFIED)
        @php
            $kycInstruction = getContent('kyc_instruction.content', true);
        @endphp
        <div class="row mb-3">
            <div class="container">
                <div class="row">
                    @if (auth()->user()->kv == Status::KYC_UNVERIFIED)
                        <div class="col-12">
                            <div class="alert alert-info mb-0" role="alert">
                                <h5 class="alert-heading m-0">@lang('KYC Verification Required')</h5>
                                <hr>
                                <p class="mb-0"> {{ __($kycInstruction->data_values->verification_instruction) }} <a class="text--base" href="{{ route('user.kyc.form') }}">@lang('Click Here to Verify')</a></p>
                            </div>
                        </div>
                    @elseif(auth()->user()->kv == Status::KYC_PENDING)
                        <div class="col-12">
                            <div class="alert alert-warning mb-0" role="alert">
                                <h5 class="alert-heading m-0">@lang('KYC Verification pending')</h5>
                                <hr>
                                <p class="mb-0"> {{ __($kycInstruction->data_values->pending_instruction) }} <a class="text--base" href="{{ route('user.kyc.data') }}">@lang('See KYC Data')</a></p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- dashboard-section start -->
    <div class="row gy-4 justify-content-center dashboard-card-wrapper">
        <div class="col-xl-4 col-sm-6">
            <div class="dashboard-card border-bottom-info">
                <div class="dashboard-card__thumb-title">
                    <div class="dashboard-card__thumb rounded-0 border-0">
                        <i class="las la-money-bill fa-4x"></i>
                    </div>
                    <h5 class="dashboard-card__title"> @lang('Balance')</h5>
                </div>
                <div class="dashboard-card__content">
                    <h4 class="dashboard-card__Status">{{ showAmount(auth()->user()->balance) }} {{ __($general->cur_text) }}</h4>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-sm-6">
            <div class="dashboard-card border-bottom-success">
                <div class="dashboard-card__thumb-title">
                    <div class="dashboard-card__thumb rounded-0 border-0">
                        <i class="las la-wallet fa-4x"></i>
                    </div>
                    <h5 class="dashboard-card__title"> @lang('Deposit')</h5>
                </div>
                <div class="dashboard-card__content">
                    <h4 class="dashboard-card__Status">{{ showAmount($widget['deposit']) }} {{ __($general->cur_text) }}</h4>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-sm-6">
            <div class="dashboard-card border-bottom-violet">
                <div class="dashboard-card__thumb-title">
                    <div class="dashboard-card__thumb rounded-0 border-0">
                        <i class="las la-wallet fa-4x"></i>
                    </div>
                    <h5 class="dashboard-card__title"> @lang('Referral Bonus')</h5>
                </div>
                <div class="dashboard-card__content">
                    <h4 class="dashboard-card__Status">{{ showAmount($widget['referral_bonus']) }} {{ __($general->cur_text) }}</h4>
                </div>
            </div>
        </div>

        @foreach ($miners as $item)
            <div class="col-xl-4 col-sm-6">
                <div class="dashboard-card border-bottom-violet">
                    <div class="dashboard-card__thumb-title">
                        <div class="dashboard-card__thumb">

                            <img src="{{ getImage(getFilePath('miner') . '/' . $item->coin_image, getFileSize('miner')) }}" alt="@lang('Image')">
                        </div>
                        <h5 class="dashboard-card__title"> <span>{{ $item->coin_code }}</span> @lang('Wallet')</h5>
                    </div>
                    <div class="dashboard-card__content">
                        <h4 class="dashboard-card__Status">{{ showAmount($item->userCoinBalances->balance, 8) }} {{ $item->coin_code }}</h4>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <!-- dashboard-section end -->

    <div class="latest-plan">
        <h5>@lang('Latest Purchased Plans')</h5>
        @include($activeTemplate . 'partials.purchased_plan', ['orders', $orders, 'paginate' => false])
    </div>

    <div class="card custom--card mt-4">
        <div class="card-header">
            <h5 class="card-title">@lang('Monthly Deposit')</h5>
        </div>
        <div class="card-body">
            <div class="chart-scroll">
                <div class="chart-wrapper m-0">
                    <canvas id="depositChart" width="400" height="180"></canvas>
                </div>
            </div>
        </div>
    </div>
    <!-- chart-section start -->
@endsection

@push('style')
    <style>
        .latest-plan {
            padding-top: 20px;
        }
    </style>
@endpush

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
