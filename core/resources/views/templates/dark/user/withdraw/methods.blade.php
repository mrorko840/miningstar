@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="row gy-4">
        @forelse($withdrawMethod as $data)
            <div class="col-lg-6">
                <div class="card custom--card">
                    <h5 class="card-header text-center">{{ $data->miner->coin_code }} @lang('Wallet')</h5>
                    <div class="card-body p-0">
                        <div class="border-bottom d-flex flex-wrap justify-content-between p-3">
                            <span>
                                @lang('Address')
                            </span>
                            <strong class="word--break fz--14 d-flex justify-content-end">
                                @if ($data->wallet)
                                    {{ $data->wallet }}
                                @else
                                    <span class="text-danger">@lang('Please update your wallet address')</span>
                                @endif
                            </strong>
                        </div>

                        <div class="border-bottom flex-wrap gap-2 d-flex justify-content-between p-3">
                            <span>
                                @lang('Balance')
                            </span>
                            {{ showAmount($data->balance, 8) . ' ' . $data->miner->coin_code }}
                        </div>

                        <div class="d-flex flex-wrap gap-2 border-bottom justify-content-between p-3">
                            <span>
                                @lang('Min Withdrawal Limit')
                            </span>
                            <span class="text-danger">
                                {{ showAmount($data->miner->min_withdraw_limit) . ' ' . $data->miner->coin_code }}
                            </span>
                        </div>

                        <div class="d-flex flex-wrap gap-2 justify-content-between p-3">
                            <span>
                                @lang('Max Withdrawal Limit')
                            </span>
                            <span class="text-danger">
                                {{ showAmount($data->miner->max_withdraw_limit) . ' ' . $data->miner->coin_code }}
                            </span>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn--base withdrawBtn btn-sm w-100" data-wallet_address="{{ $data->wallet }}" data-id="{{ $data->id }}" data-resource="{{ $data }}" data-coin_code="{{ __($data->miner->coin_code) }}" type="button">
                            @lang('Withdraw Now')
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-lg-12">
                <div class="alert alert-warning" role="alert">
                    <strong>@lang('You did\'t have any wallet yet.')</strong>
                </div>
            </div>
        @endforelse
    </div>
    <!-- Modal -->
    <div class="modal custom--modal fade" id="withdrawModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title method-name" id="exampleModalLabel">@lang('Withdraw')</h5>
                    <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('user.withdraw.money') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="col-12">
                            <div class="form-group">
                                <input class="form-control" name="id" type="hidden" value="">
                            </div>
                        </div>
                        <div class="col-12">
                            <label>@lang('Amount')</label>
                            <div class="input-group">
                                <input class="form-control form--control" id="amount" name="amount" type="text" value="{{ old('amount') }}" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" required="">

                                <span class="input-group-text currency-addon"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn--base w-100" type="submit">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <style>
        .custom--modal .modal-content {
            text-align: left !important;
        }
    </style>
@endpush
@push('script')
    <script>
        'use strict';
        (function($) {
            $('.withdrawBtn').on('click', function() {
                let walletAddress = $(this).data('wallet_address');
                if (!walletAddress) {
                    notify('error', 'Please update your wallet address');
                    return;
                }
                var modal = $('#withdrawModal');
                modal.find('.currency-addon').text($(this).data('coin_code'));
                modal.find('input[name=id]').val($(this).data('id'))
                modal.modal('show');
            });

        })(jQuery)
    </script>
@endpush
