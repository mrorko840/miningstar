@php
    $notifications = getContent('notice.element')
    @endphp
<style>
    .drop-menu-body {
        overflow: scroll;
        height: 360px;
    }
    .drop-menu-footer {
        border-top: 1px solid #dee2e6 !important;
    }
    </style>
<!-- Header -->
<header class="header position-fixed">
    <div class="row">
        <div class="col-auto">
            <a href="javascript:void(0)" target="_self" class="btn btn-light btn-44 menu-btn">
                <i class="bi bi-list"></i>
            </a>
        </div>
        <div class="col align-self-center text-center">
            <div class="logo-small">
                <img src="{{ asset($customTemplate . 'img/logo.png') }}" alt="">
                <a href="{{ route('home') }}">
                    <h5>{{ $general->site_name }}</h5>
                </a>
            </div>
        </div>
        <div class="col-auto px-1">
            <div class="form-check form-switch ps-0">
                <input class="form-check-input" type="checkbox" id="darkmodeswitch" hidden>
                <label class="form-check-label px-2 btn btn-light btn-44" for="darkmodeswitch">
                    <i class="bi bi-moon-stars-fill size-16"></i>
                </label>
            </div>
        </div>

        <div class="col-auto ps-1">
            <div class="dropdown">
                <button type="button" class="btn btn-light btn-44" data-bs-toggle="dropdown" aria-expanded="false"
                    data-bs-auto-close="outside">
                    <i class="bi bi-bell"></i>

                    @if (!Empty($notifications))
                        <span class="count-indicator"></span>
                    @endif
                </button>
                <div style="width: 280px; border-radius: 1.25rem !important;" class="dropdown-menu mt-2">
                    <div class="px-3 border-bottom">
                        <h6 class="my-2 small">@lang('Notification')</h6>
                    </div>
                    <div class="drop-menu-body">
                        <div class="container">
                            @foreach ($notifications as $item)
                                <div class="row align-items-center py-1 border-bottom">
                                    <div class="col-auto">
                                        <img width="40px" src="https://cdn-icons-png.flaticon.com/512/1592/1592461.png" alt="">
                                    </div>
                                    <div class="col ps-0">
                                        <h6 class="small">
                                            {{$item->data_values->title}}
                                        </h6>
                                        <p style="font-size: 0.75em;">
                                            {{-- {{Str::limit($item->data_values->description, 50)}} --}}
                                            {{$item->data_values->description}}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                            
                        </div>
                    </div>

                    <div class="drop-menu-footer py-2">
                        <a href="{{route('notify')}}">
                            <h6 class="small text-center">View All Notification</h6>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</header>
<!-- Header ends -->