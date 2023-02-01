@php
    $contactCaption = getContent('contact_us.content', true);
    $pages = App\Models\Page::where('is_default', Status::NO)
        ->where('tempname', $activeTemplate)
        ->get();
    $socials = getContent('social_icon.element');
@endphp
<!-- Sidebar main menu -->
<div class="sidebar-wrap  sidebar-pushcontent">
    <!-- Add overlay or fullmenu instead overlay -->
    <div class="closemenu text-muted">Close Menu</div>
    <div class="sidebar dark-bg">
        <!-- user information -->
        <div class="row my-3">
            <div class="col-12 ">
                <div class="card shadow-sm bg-opac text-white border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col align-self-center text-center">
                                <div class="logo-small">
                                    <img src="{{ asset($customTemplate . 'img/logo.png') }}" alt="">
                                    <a href="{{ route('home') }}">
                                        <h5>{{ $general->site_name }}</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mx-1 mb-2">
                        <div class="col pe-2">
                            <div class="card shadow-sm bg-opac text-white border-0">
                                <a href="{{route('user.login')}}">
                                    <div class="card-body">
                                        <h6 class="text-center">Sign In</h6>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col ps-2">
                            <div class="card shadow-sm bg-opac text-white border-0">
                                <a href="{{route('user.register')}}">
                                    <div class="card-body">
                                        <h6 class="text-center">Sign Up</h6>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- user emnu navigation -->
        <div class="row">
            <div class="col-12">
                <ul class="nav nav-pills">

                    <li class="nav-item">
                        <a class="nav-link @if(Route::currentRouteName() == 'home') active @endif" aria-current="page" href="{{route('home')}}">
                            <div class="avatar avatar-40 rounded icon"><i class="bi bi-house-door"></i></div>
                            <div class="col">Dashboard</div>
                            <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link @if(Route::currentRouteName() == 'notify') active @endif" href="{{route('notify')}}" tabindex="-1">
                            <div class="avatar avatar-40 rounded icon"><i class="bi bi-bell"></i></div>
                            <div class="col">Notification</div>
                            <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link @if(Route::currentRouteName() == 'plans') active @endif" href="{{route('blog')}}" tabindex="-1">
                            <div class="avatar avatar-40 rounded icon"><i class="bi bi-newspaper"></i></div>
                            <div class="col">Blogs</div>
                            <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link @if(Route::currentRouteName() == 'plans') active @endif" href="{{route('plans')}}" tabindex="-1">
                            <div class="avatar avatar-40 rounded icon"><i class="bi bi-award-fill"></i></div>
                            <div class="col">Plans</div>
                            <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link @if(Route::currentRouteName() == 'style') active @endif" href="{{route('style')}}" tabindex="-1">
                            <div class="avatar avatar-40 rounded icon"><i class="bi bi-palette"></i></div>
                            <div class="col">Style <i class="bi bi-star-fill text-warning small"></i></div>
                            <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                        </a>
                    </li>

                    {{-- @if ($pages->count())
                        @foreach ($pages as $item)
                            <li class="nav-item">
                                <a class="nav-link @if(URL::current() == route('pages', ['slug' => $item->slug]) ) active @endif" href="{{ route('pages', ['slug' => $item->slug]) }}" tabindex="-1">
                                    <div class="avatar avatar-40 rounded icon"><i class="bi bi-app-indicator"></i></div>
                                    <div class="col">{{ __($item->name) }}</div>
                                    <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                                </a>
                            </li>
                        @endforeach
                    @endif --}}

                    <li class="nav-item">
                        <a class="nav-link @if(Route::currentRouteName() == 'contact') active @endif" href="{{route('contact')}}" tabindex="-1">
                            <div class="avatar avatar-40 rounded icon"><i class="bi bi-person-lines-fill"></i></div>
                            <div class="col">Contact Us</div>
                            <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Sidebar main menu ends -->
