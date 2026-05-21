@extends('layouts.app')
@section('title', 'Elections')

@section('content')
<div class="page-header">
    <h1 class="page-title"><i class="bi bi-check2-square"></i> Elections</h1>
</div>

{{-- ── Status Filter ── --}}
<div style="display:flex;gap:8px;margin-bottom:24px;flex-wrap:wrap;">
    @foreach(['active' => 'Active', 'upcoming' => 'Upcoming', 'closed' => 'Closed', 'all' => 'All'] as $val => $label)
        @php
            $isActive = $status === $val;
            $filterStyle = $isActive
                ? 'background:var(--accent-dim);color:var(--accent);border-color:var(--accent-border);'
                : 'background:transparent;color:var(--text-dim);border-color:var(--border);';
        @endphp
        <a href="{{ route('vote.index', ['status' => $val]) }}"
           style="padding:6px 16px;border-radius:20px;font-size:0.78rem;font-weight:500;text-decoration:none;border:1px solid;transition:all .15s;{{ $filterStyle }}">
            {{ $label }}
        </a>
    @endforeach
</div>

{{-- ── Election Cards ── --}}
@forelse($elections as $election)
<div class="vs-card mb-3">
    <div class="vs-card-header">
        <div class="vs-card-header-title">
            <i class="bi bi-card-list"></i>
            {{ $election->title }}
        </div>
        <div style="display:flex;align-items:center;gap:10px;">
            @if($election->status === 'active')
                <span class="vs-badge vs-badge-active">Active</span>
            @elseif($election->status === 'upcoming')
                <span class="vs-badge" style="background:var(--yellow-dim);color:var(--yellow);border:1px solid rgba(245,158,11,0.2);">Upcoming</span>
            @else
                <span class="vs-badge vs-badge-closed">Closed</span>
            @endif

            @if($election->user_has_voted)
                <span class="vs-voted"><i class="bi bi-check-circle"></i> Voted</span>
            @elseif($election->status === 'active')
                <span class="vs-not-voted">Not yet voted</span>
            @endif
        </div>
    </div>
    <div class="vs-card-body" style="display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;">
        <div>
            @if($election->description)
            <p style="color:var(--text-dim);font-size:0.83rem;margin:0 0 8px;">{{ $election->description }}</p>
            @endif
            <div style="display:flex;gap:20px;font-size:0.78rem;color:var(--text-dim);">
                <span><i class="bi bi-calendar-event"></i> {{ $election->start_date->format('M d, Y') }}</span>
                <span><i class="bi bi-calendar-x"></i> {{ $election->end_date->format('M d, Y') }}</span>
                <span><i class="bi bi-person-badge"></i> {{ $election->positions->count() }} position(s)</span>
            </div>
        </div>

        @if($election->status === 'active' && !$election->user_has_voted)
        <a href="{{ route('vote.show', $election->id) }}" class="vs-btn vs-btn-success">
            <i class="bi bi-check2-circle"></i> Vote Now
        </a>
        @elseif($election->user_has_voted)
        <span style="font-size:0.8rem;color:var(--text-dim);"><i class="bi bi-check-circle"></i> Vote submitted</span>
        @endif
    </div>
</div>
@empty
<div class="vs-info">
    <i class="bi bi-info-circle"></i>
    No {{ $status !== 'all' ? $status : '' }} elections found.
</div>
@endforelse
@endsection