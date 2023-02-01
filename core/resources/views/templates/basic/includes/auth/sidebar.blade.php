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
                            <div class="col-auto">
                                <figure class="avatar avatar-44 rounded-15">
                                    @if (auth()->user()->image != null)
                                        <img src="{{ asset($customImgPath . 'user/profile/' . auth()->user()->image) }}" alt="">
                                    @else
                                        <img src="https://i1.sndcdn.com/artworks-000331665039-ur0qza-t500x500.jpg" alt="">
                                    @endif
                                </figure>
                            </div>
                            <div class="col px-0 align-self-center">
                                <p class="mb-1">{{ auth()->user()->firstname }} <i class="bi bi-patch-check-fill text-info"></i></p> 
                                <p class="text-muted size-12">{{ auth()->user()->address->country.', '.auth()->user()->country_code }}</p>
                            </div>
                            <div class="col-auto">
                                <a href="{{route('user.logout')}}" class="btn btn-44 btn-light">
                                    <i class="bi bi-box-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card bg-opac text-white border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h1 class="display-4">{{ __($general->cur_sym) }} {{ showAmount(auth()->user()->balance) }}</h1>
                                </div>
                                <div class="col-auto">
                                    <p class="text-muted">Wallet Balance</p>
                                </div>
                                <div class="col text-end">
                                    <p class="text-muted"><a href="{{route('user.deposit')}}">+ Top up</a>
                                    </p>
                                </div>
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

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle @if(Route::currentRouteName() == 'user.profile.setting' || Route::currentRouteName() == 'user.home') active @endif" data-bs-toggle="dropdown" href="#" role="button"
                            aria-expanded="false">
                            <div class="avatar avatar-40 rounded icon"><i class="bi bi-person"></i></div>
                            <div class="col">Account</div>
                            <div class="arrow"><i class="bi bi-plus plus"></i> <i class="bi bi-dash minus"></i>
                            </div>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item nav-link @if(Route::currentRouteName() == 'user.home') active @endif" href="{{route('user.home')}}">
                                    <div class="avatar avatar-40 rounded icon"><i class="bi bi-person-badge"></i></div>
                                    <div class="col">Profile</div>
                                    <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                                </a></li>
                            <li><a class="dropdown-item nav-link @if(Route::currentRouteName() == 'user.profile.setting') active @endif" href="{{route('user.profile.setting')}}">
                                    <div class="avatar avatar-40 rounded icon"><i class="bi bi-gear"></i>
                                    </div>
                                    <div class="col">Settings</div>
                                    <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                                </a></li>
                        </ul>
                    </li>

                    {{-- <li class="nav-item">
                        <a class="nav-link" href="chat.html" tabindex="-1">
                            <div class="avatar avatar-40 rounded icon"><i class="bi bi-chat-text"></i></div>
                            <div class="col">Messages</div>
                            <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                        </a>
                    </li> --}}

                    <li class="nav-item">
                        <a class="nav-link @if(Route::currentRouteName() == 'user.referral') active @endif" href="{{route('user.referral')}}" tabindex="-1">
                            <div class="avatar avatar-40 rounded icon"><i class="bi bi-person-plus"></i></div>
                            <div class="col">Refer Friends</div>
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

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle @if(Route::currentRouteName() == 'user.deposit.history' || Route::currentRouteName() == 'user.withdraw.history' || Route::currentRouteName() == 'user.transactions') active @endif " data-bs-toggle="dropdown" href="#" role="button"
                            aria-expanded="false">
                            <div class="avatar avatar-40 rounded icon"><i class="bi bi-clock-history"></i></div>
                            <div class="col">Reports</div>
                            <div class="arrow"><i class="bi bi-plus plus"></i> <i class="bi bi-dash minus"></i>
                            </div>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item nav-link @if(Route::currentRouteName() == 'user.deposit.history') active @endif" href="{{route('user.deposit.history')}}">
                                    <div class="avatar avatar-40 rounded icon"><i class="bi bi-calendar2"></i></div>
                                    <div class="col">Deposit History</div>
                                    <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item nav-link @if(Route::currentRouteName() == 'user.withdraw.history') active @endif" href="{{route('user.withdraw.history')}}">
                                    <div class="avatar avatar-40 rounded icon"><i class="bi bi-calendar-check"></i>
                                    </div>
                                    <div class="col">Witdraw History</div>
                                    <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item nav-link @if(Route::currentRouteName() == 'user.transactions') active @endif" href="{{route('user.transactions')}}">
                                    <div class="avatar avatar-40 rounded icon"><i class="bi bi-calendar-check"></i>
                                    </div>
                                    <div class="col">Transactions</div>
                                    <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                                </a>
                            </li>
                        </ul>
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

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle @if(Route::currentRouteName() == 'ticket.open' || Route::currentRouteName() == 'ticket.index' || Route::currentRouteName() == 'user.transactions') active @endif " data-bs-toggle="dropdown" href="#" role="button"
                            aria-expanded="false">
                            <div class="avatar avatar-40 rounded icon"><i class="bi bi-terminal"></i></div>
                            <div class="col">Support</div>
                            <div class="arrow"><i class="bi bi-plus plus"></i> <i class="bi bi-dash minus"></i>
                            </div>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item nav-link @if(Route::currentRouteName() == 'ticket.open') active @endif" href="{{route('ticket.open')}}">
                                    <div class="avatar avatar-40 rounded icon"><i class="bi bi-calendar2-plus"></i></div>
                                    <div class="col">Create Ticket</div>
                                    <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item nav-link @if(Route::currentRouteName() == 'ticket.index') active @endif" href="{{route('ticket.index')}}">
                                    <div class="avatar avatar-40 rounded icon"><i class="bi bi-calendar-check"></i>
                                    </div>
                                    <div class="col">All Tickets</div>
                                    <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{route('user.logout')}}" tabindex="-1">
                            <div class="avatar avatar-40 rounded icon"><i class="bi bi-box-arrow-right"></i></div>
                            <div class="col">Logout</div>
                            <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Sidebar main menu ends -->
