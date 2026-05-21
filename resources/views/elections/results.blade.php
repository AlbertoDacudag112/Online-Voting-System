@extends('layouts.app')
@section('title', 'Results — ' . $election->title)

@section('content')

{{-- ── Header ── --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 style="margin:0;"><i class="bi bi-trophy-fill" style="color:#f59e0b;"></i>
            Election Results
        </h3>
        <small style="color:var(--text-dim);">{{ $election->title }}</small>
    </div>
    <a href="{{ route('elections.show', $election->id) }}" class="btn btn-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Back
    </a>
</div>

{{-- ── Election closed banner ── --}}
@if($election->status === 'closed')
<div style="background:rgba(245,158,11,0.10);border:1px solid rgba(245,158,11,0.25);border-radius:10px;padding:14px 20px;margin-bottom:28px;display:flex;align-items:center;gap:12px;">
    <i class="bi bi-megaphone-fill" style="color:#f59e0b;font-size:1.2rem;"></i>
    <div>
        <strong style="color:#fbbf24;">Official Results</strong>
        <div style="color:var(--text-dim);font-size:0.82rem;">
            This election closed on {{ \Carbon\Carbon::parse($election->end_date)->format('F d, Y \a\t h:i A') }}.
            Winners are highlighted below.
        </div>
    </div>
</div>
@else
<div style="background:rgba(99,102,241,0.10);border:1px solid rgba(99,102,241,0.25);border-radius:10px;padding:14px 20px;margin-bottom:28px;display:flex;align-items:center;gap:12px;">
    <i class="bi bi-info-circle-fill" style="color:#818cf8;font-size:1.1rem;"></i>
    <span style="color:#a5b4fc;font-size:0.85rem;">
        This election is still <strong>{{ $election->status }}</strong>. Results shown are live counts and may change.
    </span>
</div>
@endif

{{-- ── Positions, grouped by course ── --}}
@php
    $grouped = $positions->groupBy(function($position) use ($election) {
        if ($election->course) return $election->course;
        $firstCandidate = $position->sorted_candidates->first();
        return $firstCandidate?->course ?? 'General';
    });

    $courseNames = \App\Models\User::COURSES;
@endphp

@foreach($grouped as $courseKey => $coursePositions)
<div class="mb-5">
    {{-- Course/Department heading --}}
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:18px;">
        <div style="height:1px;flex:1;background:var(--border);"></div>
        <span style="background:var(--surface);border:1px solid var(--border-light);border-radius:20px;padding:5px 18px;font-size:0.78rem;font-weight:600;letter-spacing:.05em;color:var(--accent);">
            <i class="bi bi-mortarboard-fill"></i>
            {{ $courseNames[$courseKey] ?? $courseKey }}
        </span>
        <div style="height:1px;flex:1;background:var(--border);"></div>
    </div>

    @foreach($coursePositions as $position)
    <div class="vs-card mb-4">
        {{-- Position header --}}
        <div class="vs-card-header" style="background:rgba(30,35,55,0.6);">
            <div class="vs-card-header-title" style="font-size:0.95rem;">
                <i class="bi bi-person-badge"></i> {{ $position->title }}
            </div>
            <span style="color:var(--text-dim);font-size:0.78rem;">
                {{ $position->sorted_candidates->count() }} candidate(s)
            </span>
        </div>

        {{-- Winner announcement banner --}}
        @if($position->winner && $position->winner->vote_count > 0)
        <div style="background:linear-gradient(90deg,rgba(245,158,11,0.12),rgba(251,191,36,0.06));border-bottom:1px solid rgba(245,158,11,0.2);padding:16px 22px;display:flex;align-items:center;gap:16px;">
            <div style="width:44px;height:44px;border-radius:50%;background:rgba(245,158,11,0.15);border:2px solid rgba(245,158,11,0.4);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="bi bi-trophy-fill" style="color:#f59e0b;font-size:1.1rem;"></i>
            </div>
            <div>
                <div style="font-size:0.72rem;text-transform:uppercase;letter-spacing:.08em;color:#f59e0b;font-weight:600;">
                    {{ $election->status === 'closed' ? '🎉 Winner' : '🏅 Leading' }}
                </div>
                <div style="font-size:1.05rem;font-weight:700;color:#fef3c7;">
                    {{ $position->winner->name }}
                </div>
                @if($position->winner->party)
                <div style="font-size:0.78rem;color:var(--text-dim);">
                    {{ $position->winner->party }}
                    @if($position->winner->course)
                        &bull; {{ $courseNames[$position->winner->course] ?? $position->winner->course }}
                    @endif
                </div>
                @endif
            </div>
            <div style="margin-left:auto;text-align:right;">
                <div style="font-size:1.5rem;font-weight:700;color:#fbbf24;">
                    {{ $position->winner->vote_count }}
                </div>
                <div style="font-size:0.72rem;color:var(--text-dim);">votes</div>
            </div>
        </div>
        @elseif($position->sorted_candidates->count() === 0)
        <div style="padding:14px 22px;color:var(--text-dim);font-size:0.83rem;">
            <i class="bi bi-slash-circle"></i> No candidates for this position.
        </div>
        @else
        <div style="padding:14px 22px;color:var(--text-dim);font-size:0.83rem;">
            <i class="bi bi-hourglass-split"></i> No votes recorded yet.
        </div>
        @endif

        {{-- Full candidate ranking table --}}
        @if($position->sorted_candidates->count() > 0)
        <div style="padding:0;">
            <table class="vs-table" style="margin:0;">
                <thead>
                    <tr>
                        <th style="width:40px;">#</th>
                        <th>Candidate</th>
                        <th>Party</th>
                        <th>Course</th>
                        <th style="text-align:right;">Votes</th>
                        <th style="width:140px;">Share</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalVotesForPos = $position->sorted_candidates->sum('vote_count');
                    @endphp
                    @foreach($position->sorted_candidates as $rank => $candidate)
                    @php
                        $isWinner = $rank === 0 && $candidate->vote_count > 0;
                        $pct = $totalVotesForPos > 0 ? round(($candidate->vote_count / $totalVotesForPos) * 100, 1) : 0;
                    @endphp
                    <tr style="{{ $isWinner ? 'background:rgba(245,158,11,0.06);' : '' }}">
                        <td>
                            @if($isWinner)
                                <i class="bi bi-trophy-fill" style="color:#f59e0b;"></i>
                            @else
                                <span style="color:var(--text-dim);">{{ $rank + 1 }}</span>
                            @endif
                        </td>
                        <td>
                            <strong style="{{ $isWinner ? 'color:#fef3c7;' : '' }}">{{ $candidate->name }}</strong>
                        </td>
                        <td style="color:var(--text-dim);">{{ $candidate->party ?? '—' }}</td>
                        <td style="color:var(--text-dim);">
                            {{ $courseNames[$candidate->course] ?? ($candidate->course ?? '—') }}
                        </td>
                        <td style="text-align:right;font-weight:600;{{ $isWinner ? 'color:#fbbf24;' : '' }}">
                            {{ $candidate->vote_count }}
                        </td>
                        <td>
                            <div style="display:flex;align-items:center;gap:8px;">
                                <div style="flex:1;height:6px;background:var(--bg-3);border-radius:4px;overflow:hidden;">
                                    <div style="width:{{ $pct }}%;height:100%;background:{{ $isWinner ? '#f59e0b' : 'var(--accent)' }};border-radius:4px;transition:width .4s;"></div>
                                </div>
                                <span style="font-size:0.72rem;color:var(--text-dim);width:36px;text-align:right;">{{ $pct }}%</span>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
    @endforeach
</div>
@endforeach

@if($positions->isEmpty())
<div style="text-align:center;color:var(--text-dim);padding:60px 0;">
    <i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:12px;"></i>
    No positions found for this election.
</div>
@endif

@endsection