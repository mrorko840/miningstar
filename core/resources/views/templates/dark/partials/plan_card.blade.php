@php
    if (!@$class) {
        $class = 'col-xl-3 col-md-6 col-sm-8';
    }
@endphp
<div class="plan-tab">
    <ul class="nav custom--tab nav-pills mb-3" id="pills-tab" role="tablist">
        @foreach ($miners as $item)
            <li class="nav-item" role="presentation">
                <button class="nav-link @if ($loop->first) active @endif" id="tabName{{ $loop->iteration }}" data-bs-toggle="pill" data-bs-target="#pills-{{ $loop->iteration }}" type="button" role="tab" aria-controls="pills-{{ $loop->iteration }}" aria-selected="@if ($loop->first) true @else false @endif">{{ $item->name }}</button>
            </li>
        @endforeach
    </ul>
    <div class="tab-content" id="pills-tabContent">
        @foreach ($miners as $item)
            <div class="tab-pane fade @if ($loop->first) show active @endif" id="pills-{{ $loop->iteration }}" role="tabpanel" aria-labelledby="tabName{{ $loop->iteration }}">
                <div class="row gy-4 justify-content-center">
                    @foreach ($item->activePlans as $plan)
                        <div class="{{ $class }}">
                            <div class="price-item">
                                <div class="price-item__header">
                                    <h5 class="price-item__title">{{ __($plan->title) }}</h5>
                                    <h2 class="price-item__price"> {{ $general->cur_sym }}{{ showAmount($plan->price) }}<span class="price-item__price-month"> / {{ $plan->period . ' ' . $plan->periodUnitText }}</span> </h2>
                                </div>
                                <div class="price-item__content">
                                    <div class="price-item__body">
                                        <ul class="text-list">
                                            @foreach ($plan->features ?? [] as $feature)
                                                <li class="text-list__item">{{ $feature }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="price-item__button">
                                        @guest
                                            <a class="btn--base" href="{{ route('user.login') }}">@lang('Buy Now')</a>
                                        @else
                                            <button class="btn--base buy-plan" data-id="{{ $plan->id }}" data-title="{{ $plan->title }}" data-price="{{ showAmount($plan->price) }}" type="button">@lang('Buy Now')</button>
                                        @endguest
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>

@auth
    @include($activeTemplate . 'partials.buy_plan_modal')
@endauth
