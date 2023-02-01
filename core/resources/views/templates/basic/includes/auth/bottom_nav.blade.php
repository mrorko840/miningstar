<!-- Footer -->
<footer class="footer">
    <div class="container">
        <ul class="nav nav-pills nav-justified">
            <li class="nav-item">
                <a class="nav-link @if(Route::currentRouteName() == 'home') active @endif" href="{{route('home')}}">
                    <span>
                        <i class="nav-icon bi bi-house"></i>
                        <span class="nav-text">Home</span>
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if(Route::currentRouteName() == 'statistics') active @endif" href="{{route('statistics')}}">
                    <span>
                        <i class="nav-icon bi bi-laptop"></i>
                        <span class="nav-text">Statistics</span>
                    </span>
                </a>
            </li>
            <li class="nav-item centerbutton">
                <div class="nav-link">
                    <span class="theme-radial-gradient">
                        <i class="close bi bi-x"></i>
                        <img src="{{ asset($customTemplate . 'img/capslock-fill.svg') }}" class="text-white nav-icon" alt="" />
                    </span>
                    <div class="nav-menu-popover justify-content-between">
                        <button type="button" class="btn btn-lg btn-icon-text"
                            onclick="window.location.replace('{{route('user.deposit')}}');">
                            <i class="bi bi-credit-card size-32"></i><span>Add Money</span>
                        </button>

                        {{-- <button type="button" class="btn btn-lg btn-icon-text"
                            onclick="window.location.replace('{{route('plans')}}');">
                            <i class="bi bi-award-fill size-32"></i><span>Plans</span>
                        </button> --}}

                        <button type="button" class="btn btn-lg btn-icon-text"
                            onclick="window.location.replace('{{route('user.withdraw')}}');">
                            <i class="bi bi-wallet2 size-32"></i><span>Withdraw</span>
                        </button>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link @if(Route::currentRouteName() == 'plans') active @endif" href="{{route('plans')}}">
                    <span>
                        <i style="font-size: 21px" class="bi bi-award-fill"></i>
                        <span class="nav-text">Plans</span>
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if(Route::currentRouteName() == 'user.home') active @endif" href="{{route('user.home')}}">
                    <span>
                        <i style="font-size: 21px" class="nav-icon bi bi-person"></i>
                        <span class="nav-text">Profile</span>
                    </span>
                </a>
            </li>
        </ul>
    </div>
</footer>
<!-- Footer ends-->
