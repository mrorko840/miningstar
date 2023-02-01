@php
    $content = getContent('transaction.content', true);
@endphp

<section class="order-section pd-t-120 pd-b-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="section-header">
                    <h2 class="section-title">{{ __(@$content->data_values->heading) }}</h2>
                    <span class="title-border"></span>
                    <p>{{ __(@$content->data_values->description) }} </p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center ml-b-30">
            <div class="col-lg-6 mrb-30">
                <div class="order-header float-left">
                    <h3 class="title">@lang('Latest Deposits')</h3>
                </div>
                <div class="order-table-area">
                    <table class="table--responsive--lg table">
                        <thead>
                            <tr>
                                <th>@lang('User')</th>
                                <th>@lang('Amount')</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($deposits as $deposit)
                                <tr>
                                    <td>
                                        <span>{{ $deposit->user->fullname }}</span>
                                    </td>
                                    <td>{{ showAmount($deposit->amount) }} {{ $general->cur_text }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-6 mrb-30">
                <div class="order-header float-right">
                    <h3 class="title">@lang('Latest Withdraws')</h3>
                </div>
                <div class="order-table-area">
                    <table class="table--responsive--lg table">
                        <thead>
                            <tr>
                                <th>@lang('User')</th>
                                <th>@lang('Amount')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($withdraws as $withdraw)
                                <tr>
                                    <td>
                                        <span>{{ $withdraw->user->fullname }}</span>
                                    </td>
                                    <td>{{ showAmount($withdraw->amount, 8) }} {{ @$withdraw->userCoinBalance->miner->coin_code }}</td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
