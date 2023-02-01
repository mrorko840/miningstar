@extends($activeTemplate . 'layouts.master')
@section('content')
<div class="container">
    <div class="row justify-content-center mt-3">
        <div class="col-md-12">
            <div class="card responsive-filter-card mb-4">
                <div class="card-body">
                    <form action="">
                        <div class="d-flex flex-wrap gap-4">
                            <div class="flex-grow-1">
                                <label>@lang('Transaction Number')</label>
                                <input class="form-control" name="search" type="text" value="{{ request()->search }}">
                            </div>
                            <div class="flex-grow-1">
                                <label>@lang('Coin Code')</label>
                                <select class="form-select" name="coin_code">
                                    <option value="">@lang('Any')</option>
                                    @foreach ($coins as $coin)
                                        <option value="{{ $coin->currency }}" @selected(request()->coin_code == $coin->currency)>{{ __(keyToTitle($coin->currency)) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex-grow-1">
                                <label>@lang('Type')</label>
                                <select class="form-select" name="trx_type">
                                    <option value="">@lang('All')</option>
                                    <option value="+" @selected(request()->trx_type == '+')>@lang('Plus')</option>
                                    <option value="-" @selected(request()->trx_type == '-')>@lang('Minus')</option>
                                </select>
                            </div>
                            <div class="flex-grow-1">
                                <label>@lang('Remark')</label>
                                <select class="form-select" name="remark">
                                    <option value="">@lang('Any')</option>
                                    @foreach ($remarks as $remark)
                                        <option value="{{ $remark->remark }}" @selected(request()->remark == $remark->remark)>{{ __(keyToTitle($remark->remark)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex-grow-1 align-self-end">
                                <button class="btn btn-warning rounded-pill w-100 btn-filter"><i class="las la-filter"></i> @lang('Filter')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12 px-0">
            <ul class="list-group list-group-flush bg-none">
                @forelse ($transactions as $trx)
                    <li class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="avatar avatar-50 shadow rounded-10 ">
                                    <img src="https://png.pngtree.com/element_our/png_detail/20181114/transaction-icon-png_239785.jpg" alt="">
                                </div>
                            </div>
                            <div class="col align-self-center ps-0">
                                <p class="text-color-theme mb-0">{{$trx->details}}</p>
                                <p class="text-muted size-12 mb-0">{{$trx->trx}}</p>
                                <small>{{ diffForHumans($trx->created_at) }}</small>
                            </div>
                            <div class="col align-self-center text-end">
                                <p class="mb-0 @if ($trx->trx_type == '+') text-success @else text-danger @endif" data-bs-toggle="tooltip" title="{{showAmount($trx->amount + $trx->charge, 8)}}">
                                    {{ $trx->trx_type }} {{ showAmount($trx->amount + $trx->charge) }} {{ __($trx->currency) }}
                                </p>
                            </div>
                        </div>
                    </li>
                @empty

                @endforelse
            </ul>
            {{ paginateLinks($transactions) }}
        </div>
    </div>
</div>

    {{-- <div class="row justify-content-center mt-3">
        <div class="col-md-12">
            <div class="show-filter mb-3 text-end">
                <button class="btn btn--base showFilterBtn btn-sm" type="button"><i class="las la-filter"></i> @lang('Filter')</button>
            </div>
            <div class="card responsive-filter-card mb-4">
                <div class="card-body">
                    <form action="">
                        <div class="d-flex flex-wrap gap-4">
                            <div class="flex-grow-1">
                                <label>@lang('Transaction Number')</label>
                                <input class="form-control" name="search" type="text" value="{{ request()->search }}">
                            </div>
                            <div class="flex-grow-1">
                                <label>@lang('Coin Code')</label>
                                <select class="form-control" name="coin_code">
                                    <option value="">@lang('Any')</option>
                                    @foreach ($coins as $coin)
                                        <option value="{{ $coin->currency }}" @selected(request()->coin_code == $coin->currency)>{{ __(keyToTitle($coin->currency)) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex-grow-1">
                                <label>@lang('Type')</label>
                                <select class="form-control" name="trx_type">
                                    <option value="">@lang('All')</option>
                                    <option value="+" @selected(request()->trx_type == '+')>@lang('Plus')</option>
                                    <option value="-" @selected(request()->trx_type == '-')>@lang('Minus')</option>
                                </select>
                            </div>
                            <div class="flex-grow-1">
                                <label>@lang('Remark')</label>
                                <select class="form-control" name="remark">
                                    <option value="">@lang('Any')</option>
                                    @foreach ($remarks as $remark)
                                        <option value="{{ $remark->remark }}" @selected(request()->remark == $remark->remark)>{{ __(keyToTitle($remark->remark)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex-grow-1 align-self-end">
                                <button class="btn btn--base w-100 btn-filter"><i class="las la-filter"></i> @lang('Filter')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="order-section">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="order-table-area">
                    <table class="table--responsive--lg table">
                        <thead>
                            <tr>
                                <th>@lang('Trx')</th>
                                <th>@lang('Transacted')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Post Balance')</th>
                                <th>@lang('Detail')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $trx)
                                <tr>
                                    <td>
                                        <small><strong>{{ $trx->trx }}</strong></small>
                                    </td>

                                    <td>
                                        <small>{{ showDateTime($trx->created_at) }}<br>{{ diffForHumans($trx->created_at) }}</small>
                                    </td>

                                    <td class="budget">
                                        <small class="fw-bold @if ($trx->trx_type == '+') text-success @else text-danger @endif">
                                            {{ $trx->trx_type }} {{ showAmount($trx->amount) }} {{ __($trx->currency) }}
                                        </small>
                                    </td>

                                    <td class="budget">
                                        <small>
                                            {{ showAmount($trx->post_balance) }} {{ __($trx->currency) }}
                                        </small>
                                    </td>

                                    <td>
                                        <small>{{ __($trx->details) }}</small>
                                    </td>
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
    </div> --}}
@endsection

@push('style')
    <style>
        .btn-filter {
            height: 37px;
            line-height: 0.1;
        }
    </style>
@endpush
