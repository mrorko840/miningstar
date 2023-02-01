@extends($activeTemplate . 'layouts.app')
@section('panel')
    <!-- Topbar Header -->
    {{-- @include($activeTemplate . 'includes.guest.header') --}}

    @if (!request()->routeIs('home'))
    @endif
    <!-- Begin page -->

    <main class="h-100">
        <!-- Topbar Header -->
        @guest
            @include($activeTemplate . 'includes.guest.header')
        @endguest
        @auth
            @include($activeTemplate . 'includes.auth.header')
        @endauth
        @yield('content')
    </main>

    <!-- Topbar Bottom -->
    @guest
        @include($activeTemplate . 'includes.guest.bottom_nav')
    @endguest
    @auth
        @include($activeTemplate . 'includes.auth.bottom_nav')
    @endauth

    @php
        $cookie = App\Models\Frontend::where('data_keys', 'cookie.data')->first();
    @endphp

@endsection

@push('script')
    <script>
        (function($) {
            $('.policy').on('click', function() {
                $.get('{{ route('cookie.accept') }}', function(response) {
                    $('.cookies-card').addClass('d-none');
                });
            });
            setTimeout(function() {
                $('.cookies-card').removeClass('hide')
            }, 2000);
        })(jQuery)
    </script>
@endpush
