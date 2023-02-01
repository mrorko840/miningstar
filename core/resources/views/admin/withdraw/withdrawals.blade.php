@extends('admin.layouts.app')

@section('panel')
    <div class="row justify-content-center">
        @if (request()->routeIs('admin.withdraw.log') || request()->routeIs('admin.withdraw.method') || request()->routeIs('admin.users.withdrawals') || request()->routeIs('admin.users.withdrawals.method'))
            <div class="col-xl-4 col-sm-6 mb-30">
                <div class="widget-two box--shadow2 has-link b-radius--5 bg--success">
                    <a href="{{ route('admin.withdraw.approved') }}" class="item-link"></a>
                    <div class="widget-two__content">
                        <h2 class="text-white">{{ __($general->cur_sym) }}{{ showAmount($successful) }}</h2>
                        <p class="text-white">@lang('Approved Withdrawals')</p>
                    </div>
                </div><!-- widget-two end -->
            </div>
            <div class="col-xl-4 col-sm-6 mb-30">
                <div class="widget-two box--shadow2 has-link b-radius--5 bg--6">
                    <a href="{{ route('admin.withdraw.pending') }}" class="item-link"></a>
                    <div class="widget-two__content">
                        <h2 class="text-white">{{ __($general->cur_sym) }}{{ showAmount($pending) }}</h2>
                        <p class="text-white">@lang('Pending Withdrawals')</p>
                    </div>
                </div><!-- widget-two end -->
            </div>
            <div class="col-xl-4 col-sm-6 mb-30">
                <div class="widget-two box--shadow2 b-radius--5 has-link bg--pink">
                    <a href="{{ route('admin.withdraw.rejected') }}" class="item-link"></a>
                    <div class="widget-two__content">
                        <h2 class="text-white">{{ __($general->cur_sym) }}{{ showAmount($rejected) }}</h2>
                        <p class="text-white">@lang('Rejected Withdrawals')</p>
                    </div>
                </div><!-- widget-two end -->
            </div>
        @endif
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">

                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Date')</th>
                                    <th>@lang('Transaction Number')</th>
                                    @if (!request()->routeIs('admin.users.withdrawals'))
                                        <th>@lang('Username')</th>
                                    @endif
                                    <th>@lang('Wallet')</th>
                                    <th>@lang('Amount')</th>
                                    @if (request()->routeIs('admin.withdraw.log'))
                                        <th>@lang('Status')</th>
                                    @endif
                                    <th>@lang('Action')</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse($withdrawals as $withdraw)
                                    <tr>
                                        <td>
                                            {{ showDateTime($withdraw->created_at) }}
                                        </td>
                                        <td class="fw-bold">
                                            {{ $withdraw->trx }}
                                        </td>

                                        @if (!request()->routeIs('admin.users.withdrawals'))
                                            <td>
                                                <a href="{{ route('admin.users.detail', $withdraw->user_id) }}">{{ @$withdraw->user->username }}</a>
                                            </td>
                                        @endif

                                        <td>
                                            {{ __(@$withdraw->userCoinBalance->wallet) }}
                                        </td>

                                        <td>
                                            <strong>{{ showAmount($withdraw->amount) }} {{ __($withdraw->userCoinBalance->miner->coin_code) }}</strong>

                                        </td>

                                        @if (request()->routeIs('admin.withdraw.log'))
                                            <td>
                                                @php echo $withdraw->statusBadge @endphp
                                            </td>
                                        @endif

                                        <td>
                                            <a href="{{ route('admin.withdraw.details', $withdraw->id) }}" class="btn btn-sm btn-outline--primary ms-1">
                                                <i class="la la-desktop"></i> @lang('Details')
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($withdrawals->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($withdrawals) }}
                    </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>
@endsection


@push('breadcrumb-plugins')
    <x-search-form dateSearch='yes' />
@endpush
