@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="card custom--card">
        <h5 class="card-header">
            {{ __($pageTitle) }}
        </h5>
        <div class="card-body">
            @if ($user->coinBalances->count())
                <form class="register" action="" method="post">
                    <div class="row gy-4">
                        @csrf
                        @foreach ($user->coinBalances as $item)
                            <div class="col-sm-12">
                                <label class="form-label d-flex justify-content-between" for="walletAddress{{ $loop->index }}">
                                    {{ $item->miner->coin_code }} @lang('Wallet')
                                    <span class="text--info">@lang('Balance') : <strong>{{ showAmount($item->balance, 8) }}</strong> {{ $item->miner->coin_code }}</span>
                                </label>
                                <input class="form--control" id="walletAddress{{ $loop->index }}" name="address[{{ $item->miner_id }}]" type="text" value="{{ $item->wallet }}" placeholder="@lang('Wallet Address')">
                            </div>
                        @endforeach
                        <div class="col-sm-12">
                            <input class="btn--base w-100" type="submit" value="@lang('Submit')">
                        </div>
                    </div>
                </form>
            @else
                <p class="text-danger text-center">@lang('You have no wallet yet, please buy some plan first')</p>
            @endif
        </div>
    </div>
@endsection
