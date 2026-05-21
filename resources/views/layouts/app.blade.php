<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'VoteSystem')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg:          #6070a7;
            --bg-2:        #252934;
            --bg-3:        #1c2130;
            --surface:     #212840;
            --border:      rgba(255,255,255,0.07);
            --border-light:rgba(255,255,255,0.12);
            --text:        #e8eaf0;
            --text-muted:  #f6f8fd;
            --text-dim:    #bebec0;
            --accent:      #b3c4f9;
            --accent-dim:  rgba(79,124,255,0.12);
            --accent-border:rgba(79,124,255,0.3);
            --green:       #22c55e;
            --green-dim:   rgba(34,197,94,0.12);
            --red:         #ef4444;
            --red-dim:     rgba(239,68,68,0.12);
            --yellow:      #1f9397;
            --yellow-dim:  rgba(245,158,11,0.12);
            --sidebar-w:   220px;
            --topbar-h:    56px;
            --radius:      10px;
        }

        * { box-sizing: border-box; }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.875rem;
            margin: 0;
            min-height: 100vh;
        }

        /* ── TOPBAR ── */
        .topbar {
            position: sticky;
            top: 0;
            z-index: 200;
            height: var(--topbar-h);
            background: var(--bg-2);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            padding: 0 20px;
            gap: 16px;
        }

        .topbar-brand {
            display: flex;
            align-items: center;
            gap: 9px;
            text-decoration: none;
            flex-shrink: 0;
        }

        .topbar-brand-icon {
            width: 30px; height: 30px;
            background: var(--accent-dim);
            border: 1px solid var(--accent-border);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: var(--accent);
            font-size: 0.9rem;
        }

        .topbar-brand-name {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text);
            letter-spacing: 0.01em;
        }

        .topbar-spacer { flex: 1; }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .topbar-avatar {
            width: 30px; height: 30px;
            border-radius: 50%;
            background: var(--accent-dim);
            border: 1px solid var(--accent-border);
            display: flex; align-items: center; justify-content: center;
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--accent);
            text-transform: uppercase;
        }

        .topbar-username {
            font-size: 0.82rem;
            font-weight: 500;
            color: var(--text);
        }

        .topbar-badge {
            font-size: 0.65rem;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 20px;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .badge-admin {
            background: var(--red-dim);
            color: var(--red);
            border: 1px solid rgba(239,68,68,0.25);
        }

        .badge-voter {
            background: var(--accent-dim);
            color: var(--accent);
            border: 1px solid var(--accent-border);
        }

        .topbar-divider {
            width: 1px; height: 20px;
            background: var(--border-light);
        }

        .topbar-logout {
            display: flex; align-items: center; gap: 6px;
            background: none; border: none;
            color: var(--text-muted);
            font-size: 0.82rem;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 6px;
            transition: color 0.15s, background 0.15s;
            text-decoration: none;
        }

        .topbar-logout:hover {
            color: var(--text);
            background: rgba(255,255,255,0.05);
        }

        /* guest links */
        .topbar-link {
            font-size: 0.82rem;
            color: var(--text-muted);
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 6px;
            transition: color 0.15s, background 0.15s;
        }
        .topbar-link:hover { color: var(--text); background: rgba(255,255,255,0.05); }
        .topbar-link.active { color: var(--accent); }

        /* ── BODY LAYOUT ── */
        .app-body {
            display: flex;
            min-height: calc(100vh - var(--topbar-h));
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: var(--sidebar-w);
            flex-shrink: 0;
            background: var(--bg-2);
            border-right: 1px solid var(--border);
            padding: 16px 10px;
            position: sticky;
            top: var(--topbar-h);
            height: calc(100vh - var(--topbar-h));
            overflow-y: auto;
        }

        .sidebar-section-label {
            font-size: 0.62rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--text-dim);
            padding: 10px 10px 4px;
            margin-top: 4px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 8px 10px;
            border-radius: 7px;
            font-size: 0.82rem;
            font-weight: 400;
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.15s, background 0.15s;
            margin-bottom: 1px;
        }

        .sidebar-link i {
            font-size: 0.9rem;
            width: 16px;
            text-align: center;
            flex-shrink: 0;
        }

        .sidebar-link:hover {
            color: var(--text);
            background: rgba(255,255,255,0.05);
        }

        .sidebar-link.active {
            color: var(--accent);
            background: var(--accent-dim);
            font-weight: 500;
        }

        /* ── MAIN CONTENT ── */
        .main-content {
            flex: 1;
            padding: 28px 32px;
            background: var(--bg);
            min-width: 0;
        }

        /* ── FLASH MESSAGES ── */
        .flash-alert {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            border-radius: var(--radius);
            font-size: 0.83rem;
            margin-bottom: 20px;
            border: 1px solid transparent;
        }

        .flash-success {
            background: var(--green-dim);
            border-color: rgba(34,197,94,0.2);
            color: #4ade80;
        }

        .flash-error {
            background: var(--red-dim);
            border-color: rgba(239,68,68,0.2);
            color: #f87171;
        }

        .flash-close {
            margin-left: auto;
            background: none;
            border: none;
            color: inherit;
            opacity: 0.6;
            cursor: pointer;
            font-size: 1rem;
            padding: 0;
            display: flex;
        }
        .flash-close:hover { opacity: 1; }

        /* ── TABLES ── */
        .vs-table {
            width: 100%;
            border-collapse: collapse;
        }

        .vs-table thead tr {
            background: var(--bg-3);
            border-bottom: 1px solid var(--border-light);
        }

        .vs-table th {
            padding: 11px 16px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: var(--text-muted);
            text-align: left;
            white-space: nowrap;
        }

        .vs-table td {
            padding: 12px 16px;
            font-size: 0.83rem;
            color: var(--text);
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        .vs-table tbody tr:last-child td { border-bottom: none; }

        .vs-table tbody tr:hover td { background: rgba(255,255,255,0.02); }

        /* ── CARDS ── */
        .vs-card {
            background: var(--bg-2);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
        }

        .vs-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 18px;
            background: var(--bg-3);
            border-bottom: 1px solid var(--border);
            font-size: 0.83rem;
            font-weight: 600;
            color: var(--text);
            gap: 12px;
        }

        .vs-card-header-title {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .vs-card-body {
            padding: 20px 18px;
        }

        /* ── STAT CARDS ── */
        .stat-card {
            background: var(--bg-2);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 20px 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            transition: border-color 0.2s;
        }

        .stat-card:hover { border-color: var(--border-light); }

        .stat-label {
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 6px;
        }

        .stat-value {
            font-size: 1.9rem;
            font-weight: 700;
            color: var(--text);
            line-height: 1;
        }

        .stat-icon {
            width: 42px; height: 42px;
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .stat-icon.blue   { background: rgba(79,124,255,0.12);  color: #4f7cff; border: 1px solid rgba(79,124,255,0.2); }
        .stat-icon.green  { background: var(--green-dim);        color: var(--green); border: 1px solid rgba(34,197,94,0.2); }
        .stat-icon.yellow { background: var(--yellow-dim);       color: var(--yellow); border: 1px solid rgba(245,158,11,0.2); }
        .stat-icon.red    { background: var(--red-dim);          color: var(--red); border: 1px solid rgba(239,68,68,0.2); }

        /* ── BUTTONS ── */
        .vs-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 16px;
            border-radius: 7px;
            font-size: 0.8rem;
            font-weight: 500;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            text-decoration: none;
            border: 1px solid transparent;
            transition: all 0.15s;
            white-space: nowrap;
        }

        .vs-btn-primary {
            background: var(--accent);
            color: #fff;
            border-color: var(--accent);
        }
        .vs-btn-primary:hover { background: #3d6bff; color: #fff; }

        .vs-btn-secondary {
            background: var(--surface);
            color: var(--text-muted);
            border-color: var(--border-light);
        }
        .vs-btn-secondary:hover { color: var(--text); border-color: rgba(255,255,255,0.2); }

        .vs-btn-success {
            background: rgba(34,197,94,0.15);
            color: var(--green);
            border-color: rgba(34,197,94,0.25);
        }
        .vs-btn-success:hover { background: rgba(34,197,94,0.22); color: var(--green); }

        .vs-btn-icon {
            width: 30px; height: 30px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            font-size: 0.78rem;
        }

        .vs-btn-view  { background: rgba(6,182,212,0.12); color: #06b6d4; border-color: rgba(6,182,212,0.2); }
        .vs-btn-view:hover  { background: rgba(6,182,212,0.2); color: #06b6d4; }
        .vs-btn-edit  { background: var(--yellow-dim); color: var(--yellow); border-color: rgba(245,158,11,0.2); }
        .vs-btn-edit:hover  { background: rgba(245,158,11,0.22); color: var(--yellow); }
        .vs-btn-delete { background: var(--red-dim); color: var(--red); border-color: rgba(239,68,68,0.2); }
        .vs-btn-delete:hover { background: rgba(239,68,68,0.22); color: var(--red); }

        /* ── BADGES / STATUS ── */
        .vs-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.68rem;
            font-weight: 600;
            letter-spacing: 0.03em;
            text-transform: capitalize;
        }

        .vs-badge::before {
            content: '';
            width: 5px; height: 5px;
            border-radius: 50%;
            background: currentColor;
        }

        .vs-badge-active  { background: var(--green-dim); color: var(--green); border: 1px solid rgba(34,197,94,0.2); }
        .vs-badge-open    { background: var(--green-dim); color: var(--green); border: 1px solid rgba(34,197,94,0.2); }
        .vs-badge-closed  { background: rgba(100,116,139,0.12); color: #64748b; border: 1px solid rgba(100,116,139,0.2); }
        .vs-badge-inactive{ background: var(--red-dim); color: var(--red); border: 1px solid rgba(239,68,68,0.2); }
        .vs-badge-admin   { background: var(--red-dim); color: var(--red); border: 1px solid rgba(239,68,68,0.2); }
        .vs-badge-voter   { background: var(--accent-dim); color: var(--accent); border: 1px solid var(--accent-border); }

        /* ── FORMS ── */
        .vs-label {
            display: block;
            font-size: 0.77rem;
            font-weight: 500;
            color: var(--text-muted);
            margin-bottom: 6px;
        }

        .vs-label .required { color: var(--red); margin-left: 2px; }

        .vs-input,
        .vs-select,
        .vs-textarea {
            width: 100%;
            background: var(--bg-3);
            border: 1px solid var(--border-light);
            border-radius: 7px;
            padding: 9px 12px;
            color: var(--text);
            font-size: 0.85rem;
            font-family: 'DM Sans', sans-serif;
            transition: border-color 0.15s, box-shadow 0.15s;
            outline: none;
        }

        .vs-input:focus,
        .vs-select:focus,
        .vs-textarea:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(79,124,255,0.12);
        }

        .vs-input::placeholder,
        .vs-textarea::placeholder { color: var(--text-dim); }

        .vs-textarea { resize: vertical; min-height: 100px; }

        .vs-select option { background: var(--bg-3); }

        /* ── PAGE HEADER ── */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            gap: 16px;
            flex-wrap: wrap;
        }

        .page-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--text);
            margin: 0;
        }

        .page-title i {
            font-size: 1.1rem;
            color: var(--text-muted);
        }

        /* ── INFO BOX ── */
        .vs-info {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 13px 16px;
            background: rgba(79,124,255,0.08);
            border: 1px solid rgba(79,124,255,0.2);
            border-radius: 8px;
            font-size: 0.83rem;
            color: #93c5fd;
        }

        /* ── ACCOUNT DETAIL ITEMS ── */
        .detail-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
            font-size: 0.83rem;
        }
        .detail-row:last-child { margin-bottom: 0; }
        .detail-key { color: var(--text-muted); font-weight: 500; min-width: 52px; }
        .detail-val { color: var(--text); }

        /* ── VOTE SECTION ── */
        .vs-not-voted {
            font-size: 0.68rem;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
            background: var(--yellow-dim);
            color: var(--yellow);
            border: 1px solid rgba(245,158,11,0.25);
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }

        .vs-voted {
            font-size: 0.68rem;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
            background: var(--green-dim);
            color: var(--green);
            border: 1px solid rgba(34,197,94,0.25);
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }

        .position-heading {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--accent);
            margin-bottom: 8px;
        }

        /* ── SCROLLBAR ── */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border-light); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.2); }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            .sidebar { display: none; }
            .main-content { padding: 20px 16px; }
        }
        /* ── PAGINATION ── */
        .pagination { font-size: 0.8rem; gap: 2px; }
        .page-link { padding: 5px 10px; color: #1e2330; border-color: var(--border); font-size: 0.8rem; line-height: 1.4; background: #e8eaf0; }
        .page-link:hover { background: #d0d4e8; color: #1e2330; border-color: var(--border); }
        .page-item.active .page-link { background: #1e2330; border-color: #1e2330; color: #fff; }
        .page-item.disabled .page-link { color: #6b7280; background: #e8eaf0; }
        .page-link svg { width: 12px; height: 12px; }
        .page-link .bi { font-size: 0.75rem; }
    </style>
</head>
<body>

{{-- ── TOP BAR ── --}}
<header class="topbar">
    <a href="{{ route('dashboard') }}" class="topbar-brand">
        <div class="topbar-brand-icon">
            <i class="bi bi-ballot"></i>
        </div>
        <span class="topbar-brand-name">VoteSystem</span>
    </a>

    <div class="topbar-spacer"></div>

    @auth
        <div class="topbar-user">
            <div class="topbar-avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
            <span class="topbar-username">{{ Auth::user()->name }}</span>
            <span class="topbar-badge {{ Auth::user()->role === 'admin' ? 'badge-admin' : 'badge-voter' }}">
                {{ ucfirst(Auth::user()->role) }}
            </span>
        </div>
        <div class="topbar-divider"></div>
        <form method="POST" action="{{ route('logout') }}" style="margin:0">
            @csrf
            <button type="submit" class="topbar-logout">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    @else
        <a href="{{ route('login') }}" class="topbar-link {{ request()->routeIs('login') ? 'active' : '' }}">
            <i class="bi bi-box-arrow-in-right"></i> Login
        </a>
        <a href="{{ route('register') }}" class="topbar-link {{ request()->routeIs('register') ? 'active' : '' }}">
            <i class="bi bi-person-plus"></i> Register
        </a>
    @endauth
</header>

{{-- ── BODY ── --}}
<div class="app-body">

    @auth
    {{-- ── SIDEBAR ── --}}
    <nav class="sidebar">
        <a class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="sidebar-section-label">Elections</div>
        <a class="sidebar-link {{ request()->routeIs('elections.*') ? 'active' : '' }}" href="{{ route('elections.index') }}">
            <i class="bi bi-card-list"></i> Elections
        </a>

        <div class="sidebar-section-label">Candidates</div>
        <a class="sidebar-link {{ request()->routeIs('candidates.*') ? 'active' : '' }}" href="{{ route('candidates.index') }}">
            <i class="bi bi-people"></i> Candidates
        </a>

        @if(!Auth::user()->isAdmin())
        <div class="sidebar-section-label">Voting</div>
        <a class="sidebar-link {{ request()->routeIs('vote.*') ? 'active' : '' }}" href="{{ route('vote.index') }}">
            <i class="bi bi-check2-square"></i> Cast Vote
        </a>
        @endif

        @if(Auth::user()->role === 'admin')
        <div class="sidebar-section-label">Admin</div>
        <a class="sidebar-link {{ request()->routeIs('voters.*') ? 'active' : '' }}" href="{{ route('voters.index') }}">
            <i class="bi bi-person-badge"></i> Voters
        </a>
        @endif
    </nav>
    @endauth

    {{-- ── MAIN ── --}}
    <main class="{{ Auth::check() ? '' : 'w-100' }} main-content">

        @if(session('success'))
        <div class="flash-alert flash-success" role="alert">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
            <button class="flash-close" onclick="this.closest('.flash-alert').remove()" aria-label="Close">
                <i class="bi bi-x"></i>
            </button>
        </div>
        @endif

        @if(session('error'))
        <div class="flash-alert flash-error" role="alert">
            <i class="bi bi-exclamation-circle-fill"></i>
            {{ session('error') }}
            <button class="flash-close" onclick="this.closest('.flash-alert').remove()" aria-label="Close">
                <i class="bi bi-x"></i>
            </button>
        </div>
        @endif

        @yield('content')
    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>