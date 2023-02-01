@extends($activeTemplate . 'layouts.frontend')


@section('content')
    <!-- main page content -->
    <div class="main-container container">

        <!-- tabs structure -->
        <ul class="nav nav-pills nav-justified tabs mb-3" id="assetstabs" role="tablist">
            @foreach ($miners as $item)
                <li class="nav-item" role="presentation">
                    <button class="nav-link @if ($loop->first) active @endif" id="home-tab"
                        data-bs-toggle="tab" data-bs-target="#{{ $item->name }}" type="button" role="tab"
                        aria-controls="{{ $item->name }}" aria-selected="true">
                        {{ $item->name }}
                    </button>
                </li>
            @endforeach
        </ul>

        <div class="tab-content" id="assetstabsContent">
            @foreach ($miners as $item)
                <div class="tab-pane fade @if ($loop->first) show active @endif" id="{{ $item->name }}"
                    role="tabpanel">
                    @foreach ($item->activePlans as $plan)
                        {{-- {{$plan->title}} - {{$item->name}} --}}
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h5 class="text-color-theme">
                                                    {{$plan->title}} - {{$item->name}}
                                                </h5>
                                                <h6 class="pt-3">
                                                    Price: {{showAmount($plan->price)}}
                                                </h6>
                                                @guest
                                                    <a class="btn btn-info" href="{{ route('user.login') }}">@lang('Buy Now')</a>
                                                @else
                                                    <a class="buy-plan btn btn-outline-success btn-sm mt-3" data-id="{{ $plan->id }}" data-title="{{ $plan->title }}" data-price="{{ showAmount($plan->price) }}" href="javascript:void(0)">@lang('Buy Now')</a>
                                                @endguest
                                            </div>
                                            <div class="col-auto">
                                                <figure class="avatar avatar-70 shadow-sm mb-1 rounded-10">
                                                    <img src="{{ asset($customImgPath . 'miner/'. $item->coin_image )  }}" alt="">
                                                </figure>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

    </div>
    <!-- main page content ends -->

    @auth
        @include($activeTemplate . 'partials.buy_plan_modal')
    @endauth
    
@endsection
