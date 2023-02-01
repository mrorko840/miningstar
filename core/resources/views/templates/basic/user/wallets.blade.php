@extends($activeTemplate . 'layouts.master')

@section('content')

    <div class="main-container container">
        <div class="row justify-content-center mt-5">
            <div class="col-lg-12">
                <div class="profile-area">
    
                    @if ($user->coinBalances->count())
                        <form class="register" action="" method="post">
                            @csrf
                            @foreach ($user->coinBalances as $item)
                                <div class="form-group">
                                    <label class="d-flex justify-content-between" for="walletAddress{{ $loop->index }}">
                                        <strong>@lang('Balance'): {{ showAmount($item->balance, 8) }} {{ $item->miner->coin_code }}</strong></label>
                                        <div class="form-group form-floating mb-3 is-valid">
                                            <input class="form-control" id="walletAddress{{ $loop->index }}" name="address[{{ $item->miner_id }}]" type="text" value="{{ $item->wallet }}" placeholder="Wallet Address">
                                            <label for="walletAddress{{ $loop->index }}">{{ $item->miner->coin_code }} @lang('Wallet')</label>
                                        </div>
                                </div>
                            @endforeach
                            <input class="submit-btn btn btn-lg btn-default w-100 mb-4 shadow" type="submit" value="@lang('Submit')">
                        </form>
                    @else
                        <h5 class="text-danger text-center">@lang('You have no wallet yet, please buy some plan first')</h5>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
