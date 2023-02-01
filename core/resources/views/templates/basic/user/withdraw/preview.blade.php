@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <ul class="list-group">
                            <li style="background-color: #3f3f3f08;" class="list-group-item rounded-0 d-flex justify-content-between">
                                <span class="font-weight-bold">@lang('Requested Amount')</span>
                                <span>{{ showAmount($withdraw->amount) }} {{ $withdraw->userCoinBalance->miner->coin_code }}</span>
                            </li>
                            <li style="background-color: #3f3f3f08;" class="list-group-item rounded-0 d-flex justify-content-between">
                                <span class="font-weight-bold">@lang('Transaction Id')</span>
                                <span>{{ showAmount($withdraw->amount) }} {{ $withdraw->trx }}</span>
                            </li>
                            <li style="background-color: #3f3f3f08;" class="list-group-item rounded-0 d-flex justify-content-between">
                                <span class="font-weight-bold">@lang('Remaining Balance')</span>
                                <span>{{ showAmount($withdraw->userCoinBalance->balance) }} {{ $withdraw->userCoinBalance->miner->coin_code }}</span>
                            </li>
                            <li style="background-color: #3f3f3f08;" class="list-group-item rounded-0 d-flex justify-content-between">
                                <span class="font-weight-bold">@lang('Status')</span>
                                <span>
                                    @php
                                        echo $withdraw->statusBadge;
                                    @endphp
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
