@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="order-section">
        @include($activeTemplate . 'partials.purchased_plan', ['orders' => $orders, 'paginate' => true])
    </div>
@endsection
