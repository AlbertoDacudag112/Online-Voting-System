<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Online Voting System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .navbar-brand { font-weight: 700; letter-spacing: 1px; }
        .nav-link.active { font-weight: 600; border-bottom: 2px solid #fff; }
        .sidebar { min-height: calc(100vh - 56px); background-color: #212529; }
        .sidebar .nav-link { color: #adb5bd; padding: 10px 20px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: #fff; background-color: #343a40; border-radius: 6px; }
        .sidebar .nav-link i { margin-right: 8px; }
        .card { border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .table th { background-color: #343a40; color: #fff; }
        .badge-admin { background-color: #dc3545; }
        .badge-voter { background-color: #0d6efd; }
    </style>
</head>
<body>

{{-- Top Navbar --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <i class="bi bi-ballot"></i> VoteSystem
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item">
                        <span class="nav-link text-light">
                            <i class="bi bi-person-circle"></i>
                            {{ Auth::user()->name }}
                            <span class="badge ms-1 {{ Auth::user()->role === 'admin' ? 'bg-danger' : 'bg-primary' }}">
                                {{ ucfirst(Auth::user()->role) }}
                            </span>
                        </span>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link text-light">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}" href="{{ route('register') }}">
                            <i class="bi bi-person-plus"></i> Register
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">

        {{-- Sidebar (only when logged in) --}}
        @auth
        <div class="col-md-2 sidebar py-3">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item mt-2">
                    <small class="text-secondary px-3">ELECTIONS</small>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('elections.*') ? 'active' : '' }}" href="{{ route('elections.index') }}">
                        <i class="bi bi-card-list"></i> Elections
                    </a>
                </li>

                <li class="nav-item mt-2">
                    <small class="text-secondary px-3">CANDIDATES</small>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('candidates.*') ? 'active' : '' }}" href="{{ route('candidates.index') }}">
                        <i class="bi bi-people"></i> Candidates
                    </a>
                </li>

                @if(Auth::user()->role === 'admin')
                <li class="nav-item mt-2">
                    <small class="text-secondary px-3">ADMIN</small>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('voters.*') ? 'active' : '' }}" href="{{ route('voters.index') }}">
                        <i class="bi bi-person-badge"></i> Voters
                    </a>
                </li>
                @endif

                <li class="nav-item mt-2">
                    <small class="text-secondary px-3">VOTING</small>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('vote.*') ? 'active' : '' }}" href="{{ route('vote.index') }}">
                        <i class="bi bi-check2-square"></i> Cast Vote
                    </a>
                </li>
            </ul>
        </div>
        @endauth

        {{-- Main Content --}}
        <div class="{{ Auth::check() ? 'col-md-10' : 'col-md-12' }} py-4 px-4">

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
