@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h1 class="page-title"><i class="bi bi-speedometer2"></i> Dashboard</h1>
    <small style="color:var(--text-dim)">Welcome back, {{ Auth::user()->name }}!</small>
</div>

{{-- ── Stat cards ── --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div><div class="stat-label">Total Elections</div><div class="stat-value">{{ $totalElections }}</div></div>
            <div class="stat-icon blue"><i class="bi bi-card-list"></i></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div><div class="stat-label">Active Elections</div><div class="stat-value">{{ $activeElections }}</div></div>
            <div class="stat-icon green"><i class="bi bi-lightning"></i></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div><div class="stat-label">Candidates</div><div class="stat-value">{{ $totalCandidates }}</div></div>
            <div class="stat-icon yellow"><i class="bi bi-people"></i></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div><div class="stat-label">Total Voters</div><div class="stat-value">{{ $totalVoters }}</div></div>
            <div class="stat-icon red"><i class="bi bi-person-badge"></i></div>
        </div>
    </div>
</div>

{{-- ── Pending vote alert for students ── --}}
@if(!Auth::user()->isAdmin() && $pendingElections->count())
<div style="background:rgba(34,197,94,0.08);border:1px solid rgba(34,197,94,0.2);border-radius:10px;padding:14px 18px;margin-bottom:24px;display:flex;align-items:center;gap:12px;">
    <i class="bi bi-bell-fill" style="color:var(--green);font-size:1rem;"></i>
    <span style="font-size:0.85rem;color:#4ade80;">
        You have <strong>{{ $pendingElections->count() }}</strong> active election(s) you haven't voted in yet.
    </span>
    <a href="{{ route('vote.index') }}" class="vs-btn vs-btn-success" style="margin-left:auto;padding:6px 14px;font-size:0.78rem;">
        Vote Now <i class="bi bi-arrow-right"></i>
    </a>
</div>
@endif

<div class="row g-4">
    {{-- ── Recent Elections ── --}}
    <div class="col-md-7">
        <div class="vs-card">
            <div class="vs-card-header">
                <div class="vs-card-header-title"><i class="bi bi-card-list"></i> Recent Elections</div>
                @if(Auth::user()->isAdmin())
                <a href="{{ route('elections.index') }}" class="vs-btn vs-btn-secondary" style="padding:5px 12px;font-size:0.75rem;">View All</a>
                @endif
            </div>
            <table class="vs-table">
                <thead>
                    <tr><th>Title</th><th>Status</th><th>Start</th><th>End</th></tr>
                </thead>
                <tbody>
                    @forelse($recentElections as $e)
                    <tr>
                        <td>{{ $e->title }}</td>
                        <td>
                            @if($e->status === 'active') <span class="vs-badge vs-badge-active">Active</span>
                            @elseif($e->status === 'upcoming') <span class="vs-badge" style="background:var(--yellow-dim);color:var(--yellow);border:1px solid rgba(245,158,11,0.2);">Upcoming</span>
                            @else <span class="vs-badge vs-badge-closed">Closed</span>
                            @endif
                        </td>
                        <td>{{ $e->start_date->format('M d, Y') }}</td>
                        <td>{{ $e->end_date->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" style="text-align:center;color:var(--text-dim);padding:24px;">No elections yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ── Right column ── --}}
    <div class="col-md-5 d-flex flex-column gap-4">

        {{-- Your Account --}}
        <div class="vs-card">
            <div class="vs-card-header">
                <div class="vs-card-header-title"><i class="bi bi-person-circle"></i> Your Account</div>
            </div>
            <div class="vs-card-body">
                <div class="detail-row"><span class="detail-key">Name</span><span class="detail-val">{{ Auth::user()->name }}</span></div>
                <div class="detail-row"><span class="detail-key">Email</span><span class="detail-val">{{ Auth::user()->email }}</span></div>
                <div class="detail-row">
                    <span class="detail-key">Role</span>
                    <span class="vs-badge {{ Auth::user()->isAdmin() ? 'vs-badge-admin' : 'vs-badge-voter' }}">{{ ucfirst(Auth::user()->role) }}</span>
                </div>
                @if(Auth::user()->course)
                <div class="detail-row"><span class="detail-key">Course</span><span class="detail-val">{{ Auth::user()->courseName() }}</span></div>
                @endif
                @if(Auth::user()->year_level)
                <div class="detail-row"><span class="detail-key">Year</span><span class="detail-val">{{ Auth::user()->year_level }}</span></div>
                @endif
                <div class="detail-row">
                    <span class="detail-key">Status</span>
                    <span class="vs-badge {{ Auth::user()->is_active ? 'vs-badge-active' : 'vs-badge-inactive' }}">
                        {{ Auth::user()->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Voters by Course (admin only) --}}
        @if(Auth::user()->isAdmin())
        <div class="vs-card">
            <div class="vs-card-header">
                <div class="vs-card-header-title"><i class="bi bi-pie-chart"></i> Voters by Course</div>
            </div>
            <table class="vs-table">
                <thead><tr><th>Course</th><th>Voters</th></tr></thead>
                <tbody>
                    @forelse($votersByCourse as $row)
                    <tr>
                        <td>{{ \App\Models\User::COURSES[$row->course] ?? ($row->course ?? '—') }}</td>
                        <td><strong>{{ $row->total }}</strong></td>
                    </tr>
                    @empty
                    <tr><td colspan="2" style="text-align:center;color:var(--text-dim);padding:16px;">No data yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Voters by Year Level --}}
        <div class="vs-card">
            <div class="vs-card-header">
                <div class="vs-card-header-title"><i class="bi bi-bar-chart"></i> Voters by Year Level</div>
            </div>
            <table class="vs-table">
                <thead><tr><th>Year Level</th><th>Voters</th></tr></thead>
                <tbody>
                    @forelse($votersByYear as $row)
                    <tr>
                        <td>{{ $row->year_level ?? '—' }}</td>
                        <td><strong>{{ $row->total }}</strong></td>
                    </tr>
                    @empty
                    <tr><td colspan="2" style="text-align:center;color:var(--text-dim);padding:16px;">No data yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @endif

    </div>
</div>
@endsection