@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="container">
        <div class="row gy-4 justify-content-center">
            @forelse($withdrawMethod as $data)
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header text-center">
                            <h5 class="card-title">{{ $data->miner->coin_code }} @lang('Wallet')</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="border-bottom d-flex justify-content-between p-3">
                                <span>
                                    @lang('Address')
                                </span>
                                <strong class="word--break fz--14 w-75 d-flex justify-content-end">
                                    @if ($data->wallet)
                                        <span class="small">{{ $data->wallet }}</span>
                                    @else
                                        <span class="text-danger">@lang('Please Update Your Wallet Address')</span>
                                    @endif
                                </strong>
                            </div>
    
                            <div class="border-bottom d-flex justify-content-between p-3">
                                <span>
                                    @lang('Balance')
                                </span>
                                {{ showAmount($data->balance, 8) . ' ' . $data->miner->coin_code }}
                            </div>
    
                            <div class="d-flex border-bottom justify-content-between p-3">
                                <span>
                                    @lang('Min Withdrawal Limit')
                                </span>
                                <span class="text-danger">
                                    {{ showAmount($data->miner->min_withdraw_limit) . ' ' . $data->miner->coin_code }}
                                </span>
                            </div>
    
                            <div class="d-flex justify-content-between p-3">
                                <span>
                                    @lang('Max Withdrawal Limit')
                                </span>
                                <span class="text-danger">
                                    {{ showAmount($data->miner->max_withdraw_limit) . ' ' . $data->miner->coin_code }}
                                </span>
                            </div>
                        </div>
                        <div class="card-footer bg-white text-center">
                            <button class="btn btn-warning w-100 withdrawBtn text-center" data-wallet_address="{{ $data->wallet }}" data-id="{{ $data->id }}" data-resource="{{ $data }}" data-coin_code="{{ __($data->miner->coin_code) }}" type="button">
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
    </div>

    <!-- Modal -->
    <div class="modal fade" id="withdrawModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title method-name" id="exampleModalLabel">@lang('Withdraw')</h5>
                    <span class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <form action="{{ route('user.withdraw.money') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input class="form-control" name="id" type="hidden" value="">
                        </div>
                        <div class="form-group">
                            <label>@lang('Enter Amount')</label>
                            <div class="input-group">
                                <input class="form-control form-control-lg" id="amount" name="amount" type="text" value="{{ old('amount') }}" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" required="">

                                <span class="input-group-text currency-addon"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-warning w-100" type="submit">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
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
