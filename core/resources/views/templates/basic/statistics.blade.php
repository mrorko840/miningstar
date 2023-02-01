@extends($activeTemplate . 'layouts.frontend')

@section('content')
@php
    $news = getContent('news.element');
@endphp

        <!-- main page content -->
        <div class="main-container container">
            <!-- chart js areachart-->
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="card mb-4">
                        <div class="card-header border-0">
                            <!-- calendar -->
                            <div class="row">
                                <div class="col position-relative align-self-center">
                                    <input type="text" placeholder="Select date range" readonly="readonly" id="daterange"
                                        class="calendar-daterange" />
                                    <h6 class="mb-1">Expense</h6>
                                    <p class="small text-muted textdate">1/8/2024 - 7/8/2024</p>
                                </div>
                                <div class="col-auto align-self-center">
                                    <button class="btn btn-light btn-44 daterange-btn">
                                        <i class="bi bi-calendar-range size-22"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-2">
                            <canvas id="areachart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="row">
                        {{-- <div class="col-6 col-md-12">
                            <div class="card shadow-sm mb-4">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-auto">
                                            <div class="avatar avatar-40 alert-success text-success rounded-circle">
                                                <i class="bi bi-arrow-down-left-circle"></i>
                                            </div>
                                        </div>
                                        <div class="col px-0 align-self-center">
                                            <p class="text-muted size-12 mb-0">Income</p>
                                            <p>1544</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-md-12">
                            <div class="card shadow-sm mb-4">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-auto">
                                            <div class="avatar avatar-40 alert-danger text-danger rounded-circle">
                                                <i class="bi bi-arrow-up-right-circle"></i>
                                            </div>
                                        </div>
                                        <div class="col px-0 align-self-center">
                                            <p class="text-muted size-12 mb-0">Expense</p>
                                            <p>1424</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                        <div class="col-6 col-md-12">
                            <div class="card shadow-sm mb-4">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-auto">
                                            <div class="avatar avatar-40 alert-primary text-primary rounded-circle">
                                                <i class="bi bi-arrow-down-left-circle"></i>
                                            </div>
                                        </div>
                                        <div class="col px-0 align-self-center">
                                            <p class="text-muted size-12 mb-0">Invested</p>
                                            <p>{{$plans->count()}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-md-12">
                            <div class="card shadow-sm mb-4">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-auto">
                                            <div class="avatar avatar-40 alert-warning text-warning rounded-circle">
                                                <i class="bi bi-arrow-up-right-circle"></i>
                                            </div>
                                        </div>
                                        <div class="col px-0 align-self-center">
                                            <p class="text-muted size-12 mb-0">Coins</p>
                                            <p>{{$miners->count()}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Saving targets -->
            <div class="row mb-3">
                <div class="col">
                    <h6 class="title">Top Categories</h6>
                </div>
                <div class="col-auto">

                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 align-self-center">
                    <div class="chartdoughnut mb-4">
                        <div class="datadisplay text-center shadow">
                            <h1 class="fw-normal">15.56k</h1>
                            <p class="text-muted">Expense</p>
                        </div>
                        <canvas id="doughnutchart"></canvas>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="circle-small">
                                        <div id="circleprogressfour"></div>
                                        <div class="avatar avatar-30 alert-warning text-warning rounded-circle">
                                            <i class="bi bi-basket"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto align-self-center ps-0">
                                    <p class="small mb-1 text-muted">Grocery</p>
                                    <p>55<span class="small">%</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="smallchart">
                            <canvas id="smallchart4"></canvas>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="circle-small">
                                        <div id="circleprogressthree"></div>
                                        <div class="avatar avatar-30 alert-danger text-danger rounded-circle">
                                            <i class="bi bi-house"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto align-self-center ps-0">
                                    <p class="small mb-1 text-muted">Rent</p>
                                    <p>10<span class="small">%</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="smallchart">
                            <canvas id="smallchart3"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="circle-small">
                                        <div id="circleprogresstwo"></div>
                                        <div class="avatar avatar-30 alert-success text-success rounded-circle">
                                            <i class="bi bi-truck"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto align-self-center ps-0">
                                    <p class="small mb-1 text-muted">Travel</p>
                                    <p>25<span class="small">%</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="smallchart">
                            <canvas id="smallchart2"></canvas>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="circle-small">
                                        <div id="circleprogressone"></div>
                                        <div class="avatar avatar-30 alert-primary text-primary rounded-circle">
                                            <i class="bi bi-gear"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto align-self-center ps-0">
                                    <p class="small mb-1 text-muted">Other</p>
                                    <p>10<span class="small">%</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="smallchart">
                            <canvas id="smallchart1"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- offers banner-->
            {{-- <div class="row mb-4">
                <div class="col-12">
                    <div class="card bg-danger text-white text-center">
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
                                    <img src="assets/img/offergraphics-red.png" alt="" class="mw-100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            <!-- summary blocks -->
            {{-- <div class="row">
                <div class="col-12 px-0">
                    <div class="swiper-container summayswiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="card shadow-sm mb-4 alert-primary">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-auto">
                                                <div class="avatar avatar-40 bg-primary text-white rounded-circle">
                                                    <i class="bi bi-clock"></i>
                                                </div>
                                            </div>
                                            <div class="col px-0">
                                                <h6 class="mb-0">+155</h6>
                                                <p class="text-muted small">Hours</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="card shadow-sm mb-4 alert-warning">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-auto">
                                                <div class="avatar avatar-40 bg-warning text-white rounded-circle">
                                                    <i class="bi bi-cpu"></i>
                                                </div>
                                            </div>
                                            <div class="col px-0">
                                                <h6 class="mb-0">+365</h6>
                                                <p class="text-muted small">Processing</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="card shadow-sm mb-4 alert-success">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-auto">
                                                <div class="avatar avatar-40 bg-success text-white rounded-circle">
                                                    <i class="bi bi-folder"></i>
                                                </div>
                                            </div>
                                            <div class="col px-0">
                                                <h6 class="mb-0">+658</h6>
                                                <p class="text-muted small">Pojects</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="card shadow-sm mb-4 alert-danger">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-auto">
                                                <div class="avatar avatar-40 bg-danger text-white rounded-circle">
                                                    <i class="bi bi-bar-chart"></i>
                                                </div>
                                            </div>
                                            <div class="col px-0">
                                                <h6 class="mb-0">+248</h6>
                                                <p class="text-muted small">Complete</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            <!-- extra expense  -->
            {{-- <div class="row mb-3">
                <div class="col">
                    <h6 class="title">Extra Expenses</h6>
                </div>
                <div class="col-auto align-self-center">

                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="avatar avatar-40 alert-success text-success rounded-circle">
                                        <i class="bi bi-controller size-20"></i>
                                    </div>
                                </div>
                                <div class="col align-self-center ps-0">
                                    <p class="mb-0">804.91 $</p>
                                    <p class="text-muted size-12">Gaming Console</p>
                                    <p class="small text-muted">Long days lockdown inspires to buy some gaming console
                                        to play.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="avatar avatar-40 alert-danger text-danger rounded-circle">
                                        <i class="bi bi-heart-fill"></i>
                                    </div>
                                </div>
                                <div class="col align-self-center ps-0">
                                    <p class="mb-0">1424.91 $</p>
                                    <p class="text-muted size-12">Medical Treatment</p>
                                    <p class="small text-muted">Due to long illness and food infection medical treatment
                                        undergone 3 days</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}


            <!-- News -->
            @include($activeTemplate . 'options.news')


        </div>
        <!-- main page content ends -->
        
@endsection
