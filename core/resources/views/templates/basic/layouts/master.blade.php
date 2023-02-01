@extends($activeTemplate . 'layouts.app')
@section('panel')
    
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

    {{-- @include($activeTemplate . 'partials.user_header') --}}
    <!-- header-section end -->
    {{-- <section class="dashboard-section ptb-80">
        <div class="container">
            @yield('content')
        </div>
    </section> --}}
    {{-- @include($activeTemplate . 'partials.footer') --}}
    
@endsection
