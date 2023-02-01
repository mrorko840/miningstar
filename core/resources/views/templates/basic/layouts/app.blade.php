<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> {{ $general->siteName(__($pageTitle)) }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    @include('partials.seo')

    <!-- All Css -->
    @include($activeTemplate . 'includes.css')
    <!-- Custom All Css -->
    @include($activeTemplate . 'includes.custom_css')

    <!-- Custom Css -->
    @auth
    @include($activeTemplate . 'custom_css.auth_css')
    @endauth
    @guest
    @include($activeTemplate . 'custom_css.home_css')
    @endguest

    @stack('style-lib')
    @stack('style')
</head>

<body class="body-scroll" data-page="{{ @$data_page ? $data_page : 'index'}}">

    <!-- loader section -->
    <div class="container-fluid loader-wrap">
        <div class="row h-100">
            <div class="col-10 col-md-6 col-lg-5 col-xl-3 mx-auto text-center align-self-center">
                <div class="loader-cube-wrap loader-cube-animate mx-auto">
                    <img src="{{ asset($customTemplate . 'img/logo.png') }}" alt="Logo">
                </div>
                <p class="mt-4">It's time for track budget<br><strong>Please wait...</strong></p>
            </div>
        </div>
    </div>
    <!-- loader section ends -->

    @guest
        <!-- Side Bar -->
        @include($activeTemplate . 'includes.guest.sidebar')
    @endguest
    @auth
        <!-- Side Bar -->
        @include($activeTemplate . 'includes.auth.sidebar')
    @endauth

    {{-- <div class="sidebar-overlay"></div>
    <div class="body-overlay"></div> --}}
    {{-- @include($activeTemplate . 'partials.preloader') --}}
    @yield('panel')
    {{-- <a class="scrollToTop" href="#"><i class="fa fa-angle-double-up"></i></a> --}}

    <!-- PWA app install toast message -->
    {{-- <div class="position-fixed bottom-0 start-50 translate-middle-x  z-index-10">
        <div class="toast mb-3" role="alert" aria-live="assertive" aria-atomic="true" id="toastinstall"
            data-bs-animation="true">
            <div class="toast-header">
                <img width="30px" src="{{ asset($customTemplate . 'img/favicon32.png') }}" class="rounded me-2" alt="...">
                <strong class="me-auto">Install {{$general->site_name}}</strong>
                <small>now</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <div class="row">
                    <div class="col">
                        Click "Install" to install {{$general->site_name}} & experience indepedent.
                    </div>
                    <div class="col-auto align-self-center ps-0">
                        <button class="btn-default btn btn-sm" id="addtohome">Install</button>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- All Js -->
    @include($activeTemplate . 'includes.js')

    @stack('script-lib')

    @include('partials.notify')

    @include('partials.plugins')

    @stack('script')

    <script>
        'use strict';
        (function($) {
            $(document).on("change", ".select-bar", function() {
                window.location.href = "{{ url('/') }}/change/" + $(this).val();
            });

            $('.select-bar').val('{{ session('lang') }}');
        })(jQuery)
    </script>

</body>

</html>
