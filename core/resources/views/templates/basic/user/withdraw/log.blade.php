@extends($activeTemplate . 'layouts.master')

@section('content')

<div class="container">
    <!-- Transactions -->
    <div class="row mb-3">
        <div class="col">
            <h6 class="title">Withdraw History<br><small class="fw-normal text-muted">Today, {{date('d M Y')}}</small>
            </h6>
        </div>
        <div class="col-auto align-self-center">
            {{-- <a href="transactions.html" class="small">View all</a> --}}
            <form action="">
                <div class="input-group">
                    <input class="form-control" name="search" type="text" value="{{ request()->search }}"
                        placeholder="@lang('Search by transactions')">
                    <button class="input-group-text bg-primary text-white">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12 px-0">
            <ul class="list-group list-group-flush bg-none">
                @forelse ($withdraws as $trx)
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-auto">
                                <div class="avatar avatar-50 shadow rounded-10 ">
                                    <img src="https://cdn-icons-png.flaticon.com/512/2535/2535077.png" alt="">
                                </div>
                            </div>
                            <div class="col align-self-center ps-0">
                                <p class="text-color-theme mb-0 small">{{$trx->userCoinBalance?->wallet}}</p>
                                <p class="text-muted size-12 mb-0">{{$trx->trx}}</p>
                                <small>{{ diffForHumans($trx->created_at) }}</small>
                            </div>
                            <div class="col align-self-center text-end">
                                <p class="mb-0" data-bs-toggle="tooltip" title="@lang('Amount with charge')">
                                    {{ __($general->cur_sym) }} {{ showAmount($trx->amount + $trx->charge) }}
                                </p>
                                <p class="text-muted size-12">
                                    @php echo $trx->statusBadge @endphp
                                </p>
                            </div>
                        </div>
                    </li>
                @empty

                @endforelse
            </ul>
            {{ paginateLinks($withdraws) }}
        </div>
    </div>
</div>






    {{-- <div class="d-flex justify-content-end mb-3">
        <form action="">
            <div class="input-group">
                <input class="form-control" name="search" type="text" value="{{ request()->search }}" placeholder="@lang('Trx ID / Wallet')">
                <button class="input-group-text bg-base text-white">
                    <i class="las la-search"></i>
                </button>
            </div>
        </form>
    </div>
    <div class="order-section pd-b-80">
        <div class="row justify-content-center ml-b-30">
            <div class="col-lg-12 mrb-30">
                <div class="order-table-area">
                    <table class="table--responsive--lg table">
                        <thead>
                            <tr>
                                <th>@lang('Time')</th>
                                <th>@lang('Transaction ID')</th>
                                <th>@lang('Wallet')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($withdraws as $withdrawal)
                                <tr>
                                    <td>
                                        {{ showDateTime($withdrawal->created_at) }}
                                    </td>
                                    <td>{{ $withdrawal->trx }}</td>
                                    <td>{{ __($withdrawal->userCoinBalance->wallet) }}</td>
                                    <td>
                                        <strong>{{ showAmount($withdrawal->amount) }} {{ $withdrawal->userCoinBalance->miner->coin_code }}</strong>
                                    </td>

                                    <td>
                                        @php
                                            echo $withdrawal->statusBadge;
                                        @endphp
                                    </td>

                                    <td>
                                        @if ($withdrawal->status == Status::PAYMENT_SUCCESS || $withdrawal->status == Status::PAYMENT_REJECT)
                                            <button class="btn btn-icon btn-sm detailBtn" data-admin_feedback="{{ $withdrawal->admin_feedback }}"><i class="fas fa-desktop"></i></button>
                                        @else
                                            <a class="btn btn-icon btn-sm" href="{{ route('user.withdraw.preview', encrypt($withdrawal->id)) }}"><i class="fas fa-desktop"></i></a>
                                        @endif
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ paginateLinks($withdraws) }}
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Modal -->
    <div class="modal fade" id="detailModal" role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Details')</h5>
                    <span class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <div class="withdraw-detail"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        'use strict';
        (function($) {

            $('.detailBtn').on('click', function() {
                var modal = $('#detailModal');
                var feedback = $(this).data('admin_feedback');

                modal.find('.withdraw-detail').html(`<p> ${feedback} </p>`);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
