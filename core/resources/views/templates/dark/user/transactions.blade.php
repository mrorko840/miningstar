@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row justify-content-center">

        <div class="col-12">
            <h5>{{ __($pageTitle) }}</h5>
        </div>
        <div class="col-md-12">
            <div class="show-filter mb-3 text-end">
                <button class="btn--base showFilterBtn" type="button"><i class="las la-filter"></i> @lang('Filter')</button>
            </div>
            <div class="card custom--card responsive-filter-card mb-4">
                <div class="card-body">
                    <form action="">
                        <div class="d-flex flex-wrap gap-4">
                            <div class="flex-grow-1">
                                <label>@lang('Transaction Number')</label>
                                <input class="form-control form--control" name="search" type="text" value="{{ request()->search }}">
                            </div>
                            <div class="flex-grow-1">
                                <label>@lang('Type')</label>
                                <select class="custom--select form-control form--control" name="trx_type">
                                    <option value="">@lang('All')</option>
                                    <option value="+" @selected(request()->trx_type == '+')>@lang('Plus')</option>
                                    <option value="-" @selected(request()->trx_type == '-')>@lang('Minus')</option>
                                </select>
                            </div>
                            <div class="flex-grow-1">
                                <label>@lang('Coin Code')</label>
                                <select class="custom--select form-control form--control" name="coin_code">
                                    <option value="">@lang('Any')</option>
                                    @foreach ($coins as $coin)
                                        <option value="{{ $coin->currency }}" @selected(request()->coin_code == $coin->currency)>{{ __(keyToTitle($coin->currency)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex-grow-1">
                                <label>@lang('Remark')</label>
                                <select class="custom--select form-control form--control" name="remark">
                                    <option value="">@lang('Any')</option>
                                    @foreach ($remarks as $remark)
                                        <option value="{{ $remark->remark }}" @selected(request()->remark == $remark->remark)>{{ __(keyToTitle($remark->remark)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex-grow-1 align-self-end">
                                <button class="btn--base w-100 btn-sm"><i class="las la-filter"></i> @lang('Filter')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="dashboard-table">
                <table class="table--responsive--lg table">
                    <thead>
                        <tr>
                            <th scope="col">@lang('Transaction No.')</th>
                            <th scope="col">@lang('Transacted')</th>
                            <th scope="col">@lang('Amount')</th>
                            <th scope="col">@lang('Post Balance')</th>
                            <th scope="col">@lang('Detail')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $trx)
                            <tr>
                                <td>
                                    <strong>{{ $trx->trx }}</strong>
                                </td>

                                <td>
                                    {{ showDateTime($trx->created_at) }}<br>{{ diffForHumans($trx->created_at) }}
                                </td>

                                <td class="budget">
                                    <span class="fw-bold @if ($trx->trx_type == '+') text-success @else text-danger @endif">
                                        {{ $trx->trx_type }} {{ showAmount($trx->amount) }} {{ $trx->currency }}
                                    </span>
                                </td>

                                <td class="budget">
                                    {{ showAmount($trx->post_balance) }} {{ __($trx->currency) }}
                                </td>

                                <td>{{ __($trx->details) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ paginateLinks($transactions) }}
            </div>
        </div>
    </div>
@endsection
