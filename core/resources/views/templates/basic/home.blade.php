@extends($activeTemplate . 'layouts.frontend')
@section('content')
@php
    $news = getContent('news.element');
@endphp

    <!-- main page content -->
    <div class="main-container container">
        
        <!-- Welcome -->
        @include($activeTemplate . 'options.welcome')

        <!-- Calculate -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        @include($activeTemplate . 'options.calculate')
                    </div>
                </div>
            </div>
        </div>

        <!-- swiper Plans -->
        <div class="row mb-3">
            <div class="col">
                <h6 class="title">Plans</h6>
            </div>
            <div class="col-auto">
                <a href="{{route('plans')}}" class="small">View all</a>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12 px-0">
                <div class="swiper-container cardswiper">
                    <div class="swiper-wrapper">

                        @forelse ($miners as $item)
                            @foreach ($item->activePlans as $plan)

                                <div class="swiper-slide">
                                    <div class="card theme-radial-gradient border-0">
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <div class="col-auto align-self-center">
                                                    <i class="bi bi-wallet2"></i> {{$plan->title}} - {{$item->coin_code}}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <h4 class="fw-normal mb-2">
                                                        <span class="small text-muted">{{ __($general->cur_sym) }}</span>
                                                        {{showAmount($plan->price)}}
                                                    </h4>
                                                    <p class="mb-0 text-muted size-12">Coin Name</p>
                                                    <p class="text-muted size-12">{{$item->coin_code}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @empty
                            
                        @endforelse

                    </div>
                </div>
            </div>
        </div>

        <!-- Coins -->
        <div class="row mb-3">
            <div class="col">
                <h6 class="title">Coins</h6>
            </div>
            {{-- <div class="col-auto">
                <a href="userlist.html" class="small">View all</a>
            </div> --}}
        </div>
        <div class="row mb-3">
            <div class="col-12 px-0">
                <!-- swiper users connections -->
                <div class="swiper-container connectionwiper">
                    <div class="swiper-wrapper">

                        @forelse ($miners as $coin)
                            <div class="swiper-slide">
                                <a href="profile.html" class="card text-center">
                                    <div class="card-body">
                                        <figure class="avatar avatar-50 shadow-sm mb-1 rounded-10">
                                            <img src="{{ asset($customImgPath . '/miner'.'/'. $coin->coin_image )  }}" alt="">
                                        </figure>
                                        <p class="text-color-theme size-12 small">{{$coin->name}}</p>
                                    </div>
                                </a>
                            </div>
                        @empty
                            
                        @endforelse

                    </div>
                </div>
            </div>
        </div>

        <!-- offers banner -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card theme-bg text-center">
                    <div class="card-body">
                        <div class="row">
                            <div class="col align-self-center">
                                <h1>15% OFF</h1>
                                <p class="size-12 text-muted">
                                    On every bill pay, launch offer get 5% Extra
                                </p>
                                <div class="tag border-dashed border-opac">
                                    BILLPAY15OFF
                                </div>
                            </div>
                            <div class="col-6 align-self-center ps-0">
                                <img src="{{ asset($customTemplate . '/img/offergraphics.png')  }}" alt="" class="mw-100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Saving targets -->
        <div class="row mb-3" hidden>
            <div class="col">
                <h6 class="title">Saving Targets</h6>
            </div>
            <div class="col-auto">

            </div>
        </div>
        <div class="row mb-4" hidden>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-auto">
                                <div class="circle-small">
                                    <div id="circleprogressone"></div>
                                    <div class="avatar avatar-30 alert-primary text-primary rounded-circle">
                                        <i class="bi bi-globe"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto align-self-center ps-0">
                                <p class="small mb-1 text-muted">USA Trip</p>
                                <p>60<span class="small">%</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-auto">
                                <div class="circle-small">
                                    <div id="circleprogresstwo"></div>
                                    <div class="avatar avatar-30 alert-success text-success rounded-circle">
                                        <i class="bi bi-cash-stack"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto align-self-center ps-0">
                                <p class="small mb-1 text-muted">Car loan</p>
                                <p>85<span class="small">%</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- News -->
        @include($activeTemplate . 'options.news')

    </div>
    <!-- main page content ends -->

@endsection


{{-- @section('content')
    @include($activeTemplate . 'sections.banner')
    @include($activeTemplate . 'sections.calculate')

    @if ($sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
@endsection --}}

{{-- @push('script-lib')
    <script src="{{ $activeTemplateTrue . '/js/particle.js' }}"></script>
@endpush  --}}
