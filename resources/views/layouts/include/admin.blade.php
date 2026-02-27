<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Panel | {{ config('app.name', 'Football Fanager') }}</title>
    <link rel="icon" href="{{ asset('assets/images/logo.svg') }}" sizes="32x32" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/admin-style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/admin-responsive.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/dataTables.dataTables.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/select2/select2.min.css') }}" rel="stylesheet">

</head>
@php
    $adminUrl = route('admin.dashboard');
    // if (auth()->check() && auth()->user()->role == 3) {
    // $adminUrl = route('requester.dashboard');
    // }
    // if (auth()->check() && auth()->user()->role == 5) {
    // $adminUrl = route('agent.dashboard');
    // }
@endphp

<body>
    <div class="menu-ovelay"></div>
    <div class="dash">
        {{-- Sidebar --}}
        <div class="dash-nav">
            <div class="navbar-icon"><a href="#!" class="menu-toggle desk-none"><img class="navclose-icon"
                        src="{{ asset('assets/images/close-icon.svg') }}" alt=""></a></div>
            <div class="sidebar d-flex flex-column justify-content-between leftsecpos leftbar-part">
                <!-- Sidebar -->
                <div class="d-flex flex-column flex-shrink-0  text-white ">
                    <a href="{{ $adminUrl }}"
                        class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <div class="header-logo">
                            <img src="{{ asset('assets/images/logo.svg') }}" alt="logo">
                        </div>
                    </a>
                    <hr>
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">

                            <a href="{{ $adminUrl }}"
                                class="nav-link text-white{{ request()->is('admin/dashboard*') ? ' active' : '' }}">
                                <i class="bi bi-grid "></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.countries.index') }}"
                                class="nav-link text-white{{ request()->is('admin/countries') ? ' active' : '' }}">
                                <i class="bi bi-map "></i> Countries
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.languages.index') }}"
                                class="nav-link text-white{{ request()->is('admin/languages') ? ' active' : '' }}">
                                <i class="bi bi-globe "></i> Languages
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.leagues.index') }}"
                                class="nav-link text-white{{ request()->is('admin/leagues') ? ' active' : '' }}">
                                <i class="bi bi-bar-chart "></i> Leagues
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.seasons.index') }}"
                                class="nav-link text-white{{ request()->is('admin/season*') ? ' active' : '' }}">
                                <i class="bi bi-bar-chart "></i> Seasons
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.teams.index') }}"
                                class="nav-link text-white{{ request()->is('admin/team*') ? ' active' : '' }}">
                                <i class="bi bi-bar-chart "></i> Teams
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.rounds.index') }}"
                                class="nav-link text-white{{ request()->is('admin/rounds*') ? ' active' : '' }}">
                                <i class="bi bi-bar-chart "></i> Rounds
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.matches.index') }}"
                                class="nav-link text-white{{ request()->is('admin/matches*') ? ' active' : '' }}">
                                <i class="bi bi-bar-chart "></i> Matches
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.league-list.index') }}"
                                class="nav-link text-white{{ request()->is('admin/league-list*') ? ' active' : '' }}">
                                <i class="bi bi-bar-chart "></i> All League List 
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.all-players.index') }}"
                                class="nav-link text-white{{ request()->is('admin/all-players*') ? ' active' : '' }}">
                                <i class="bi bi-bar-chart "></i> All Players 
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.stat-type.index') }}"
                                class="nav-link text-white{{ request()->is('admin/stat-type*') ? ' active' : '' }}">
                                <i class="bi bi-bar-chart "></i> Stat Type 
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.all-team-player.index') }}"
                                class="nav-link text-white{{ request()->is('admin/all-team-player*') ? ' active' : '' }}">
                                <i class="bi bi-bar-chart "></i> All Team Player 
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.all-referee.index') }}"
                                class="nav-link text-white{{ request()->is('admin/all-referee*') ? ' active' : '' }}">
                                <i class="bi bi-bar-chart "></i> All Referee 
                            </a>
                        </li>
                    </ul>

                </div>

            </div>
        </div>
        {{-- Main Content --}}
        <div class="main-container">
            <div class="main-content d-flex flex-column">
                {{-- Header --}}
                <header class=" py-3 px-4 d-flex justify-content-between align-items-center mob-box-padd">
                    <div class="mob-navbar"><a href="#!" class="menu-toggle desk-none"><img class="nav-bar-icon"
                                src="{{ asset('assets/images/logo.svg') }}" alt="logo"></a></div>
                    <h4 class="mb-0">{{ $pageTitle }}</h4>
                    <!-- <input type="text" placeholder="Search..." class="form-control w-25"> -->
                    <div class="header-cls-wraps">
                        <div class="hed-right-sec">
                            <div class="header-noti h-notification"><a href="javascript:void(0);"
                                    class="icon-btn grayborderbtn"><i class="ti ti-bell"></i>
                                    <span id="notification-count"
                                        class="position-absolute translate-middle-cls badge rounded-pill bg-danger">00
                                    </span></a></div>
                            <div class="notification-box">
                                <div class="noti-bottomborder">
                                    <div class="noti-head flex-center-between">
                                        <h5>Notificaciones</h5>
                                        <a href="javascript:void(0)"
                                            class="cursor_pointer text-link-unline markasread">Mark all as read</a>
                                    </div>
                                </div>
                                <div class="notification-tabs-sec">
                                    <div class="noti-list-block">
                                        <div class="noti-listing">
                                            <ul class="notification-list">
                                                <li>
                                                    <div class="notification-loader"><img
                                                            src="{{ asset('assets/images/ajax-loader.gif') }}"></div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="noti-heads flex-center-between view-all-noti">
                                </div>
                            </div>
                        </div>
                        <div class="header-profile">
                            <!-- Toggle control -->
                            <input type="checkbox" id="profile-toggle" />
                            <label for="profile-toggle" class="header-pro-photo">
                                <img src="{{ asset('assets/images/avatar.png') }}" alt="avatar">

                            </label>

                            <!-- Dropdown -->
                            <div class="header-pro-log">
                                @php
                                    $userid = 1;
                                    if (auth()->check()) {
                                        $userid = auth()->user()->id;
                                    }
                                @endphp
                                <ul>
                                    <li>
                                        <a href="#">
                                            <i class="bi bi-person"></i> Profile
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                            <i class="bi bi-box-arrow-right"></i> {{ __('Logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </header>

                {{-- Page Content --}}
                <main class="flex-grow-1 p-4 mob-box-padd">
                    @yield('content')
                </main>

                {{-- Footer --}}
                <footer class="bg-white py-2 text-center border-top">
                    <small>&copy; {{ date('Y') }} Football Fanager</small>
                </footer>
            </div>
        </div>
    </div>
    <!-- jQuery (must be first) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap (after jQuery) -->
    <script src="{{ asset('assets/js/bootstrap.js') }}"></script>
    <!-- DataTables JS (after jQuery) -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.responsive.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}"></script>
    <!-- Chart.js (optional but load before any charts are drawn) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Select2 (after jQuery) -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <!-- Your main JS (last) -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    @yield('scripts')
</body>

</html>
