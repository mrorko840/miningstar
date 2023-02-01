@extends($activeTemplate . 'layouts.master')
@section('content')
    
    <div class="container">
        <!-- Transactions -->
        <div class="row mb-3">
            <div class="col">
                <h6 class="title">Deposit History<br><small class="fw-normal text-muted">Today, {{date('d M Y')}}</small>
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
                    @forelse ($deposits as $trx)
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="avatar avatar-50 shadow rounded-10 ">
                                        <img src="https://cdn-icons-png.flaticon.com/512/2266/2266216.png" alt="">
                                    </div>
                                </div>
                                <div class="col align-self-center ps-0">
                                    <p class="text-color-theme mb-0">{{$trx->gateway?->name}}</p>
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
                {{ paginateLinks($deposits) }}
            </div>
        </div>
    </div>

    {{-- <div class="d-flex justify-content-end mb-3">
        <form action="">
            <div class="input-group">
                <input class="form-control" name="search" type="text" value="{{ request()->search }}"
                    placeholder="@lang('Search by transactions')">
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
                                <th>@lang('Gateway | Transaction')</th>
                                <th class="text-center">@lang('Initiated')</th>
                                <th class="text-center">@lang('Amount')</th>
                                <th class="text-center">@lang('Conversion')</th>
                                <th class="text-center">@lang('Status')</th>
                                <th>@lang('Details')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($deposits as $deposit)
                                <tr>
                                    <td>
                                        <div class="d-flex flex-column flex-wrap">
                                            <span class="fw-bold"> <span
                                                    class="text-primary">{{ __($deposit->gateway?->name) }}</span> </span>
                                            <small> {{ $deposit->trx }} </small>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex flex-column flex-wrap">
                                            <small>{{ showDateTime($deposit->created_at) }}</small>
                                            <small>{{ diffForHumans($deposit->created_at) }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column flex-wrap">
                                            <small>{{ __($general->cur_sym) }}{{ showAmount($deposit->amount) }} + <span
                                                    data-bs-toggle="tooltip" data-bs-placement="right" class="text-danger"
                                                    title="@lang('charge')">{{ showAmount($deposit->charge) }}
                                                </span></small>
                                            <small data-bs-toggle="tooltip" title="@lang('Amount with charge')">
                                                <strong>{{ showAmount($deposit->amount + $deposit->charge) }}
                                                    {{ __($general->cur_text) }}</strong>
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column flex-wrap">
                                            <small> 1 {{ __($general->cur_text) }} = {{ showAmount($deposit->rate) }}
                                                {{ __($deposit->method_currency) }}
                                                <strong>{{ showAmount($deposit->final_amo) }}
                                                    {{ __($deposit->method_currency) }}</strong></small>
                                        </div>
                                    </td>
                                    <td>
                                        @php echo $deposit->statusBadge @endphp
                                    </td>
                                    @php
                                        $details = $deposit->detail != null ? json_encode($deposit->detail) : null;
                                    @endphp

                                    <td>
                                        <button
                                            class="btn btn-icon btn-sm @if ($deposit->method_code >= 1000) detailBtn @else disabled @endif"
                                            type="button"
                                            @if ($deposit->method_code >= 1000) data-info="{{ $details }}" @endif
                                            @if ($deposit->status == Status::PAYMENT_REJECT) data-admin_feedback="{{ $deposit->admin_feedback }}" @endif
                                            @if ($deposit->method_code < 1000) disabled @endif>
                                            <i class="las la-desktop"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ paginateLinks($deposits) }}
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
                    <ul class="list-group userData mb-2">
                    </ul>
                    <div class="feedback"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.detailBtn').on('click', function() {
                var modal = $('#detailModal');

                var userData = $(this).data('info');
                var html = '';
                if (userData) {
                    userData.forEach(element => {
                        if (element.type != 'file') {
                            html += `
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>${element.name}</span>
                                <span">${element.value}</span>
                            </li>`;
                        }
                    });
                }

                modal.find('.userData').html(html);

                if ($(this).data('admin_feedback') != undefined) {
                    var adminFeedback = `
                        <div class="my-3">
                            <strong>@lang('Admin Feedback')</strong>
                            <p>${$(this).data('admin_feedback')}</p>
                        </div>
                    `;
                } else {
                    var adminFeedback = '';
                }

                modal.find('.feedback').html(adminFeedback);


                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
