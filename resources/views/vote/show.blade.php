@extends('layouts.app')
@section('title', $election->title)

@section('content')
<div class="page-header">
    <div>
        <a href="{{ route('vote.index') }}" class="vs-btn vs-btn-secondary" style="margin-bottom:12px;">
            <i class="bi bi-arrow-left"></i> Back to Elections
        </a>
        <h1 class="page-title"><i class="bi bi-check2-square"></i> {{ $election->title }}</h1>
    </div>
</div>

@if($hasVoted)
    <div class="vs-info" style="background:var(--green-dim);border-color:rgba(34,197,94,0.2);color:#4ade80;">
        <i class="bi bi-check-circle-fill"></i>
        You have already submitted your vote for this election.
    </div>
@else
    <p style="color:var(--text-dim);font-size:0.85rem;margin-bottom:24px;">
        <i class="bi bi-info-circle"></i>
        Select one candidate per position. Your vote cannot be changed after submission.
    </p>

    <form action="{{ route('vote.store') }}" method="POST">
        @csrf
        <input type="hidden" name="election_id" value="{{ $election->id }}">

        @foreach($election->positions as $position)
        <div class="vs-card mb-4">
            <div class="vs-card-header">
                <div class="vs-card-header-title">
                    <i class="bi bi-person-badge"></i> {{ $position->title }}
                </div>
            </div>
            <div class="vs-card-body">
                <div class="row g-3">
                    @foreach($position->candidates as $candidate)
                    <div class="col-md-4 col-sm-6">
                        <label for="candidate_{{ $candidate->id }}"
                               style="display:block;border:1px solid var(--border);border-radius:9px;padding:16px;cursor:pointer;transition:border-color .15s,background .15s;text-align:center;">
                            <input type="radio"
                                   name="votes[{{ $position->id }}]"
                                   value="{{ $candidate->id }}"
                                   id="candidate_{{ $candidate->id }}"
                                   required
                                   style="display:none;"
                                   onchange="highlightCard(this)">
                            <i class="bi bi-person-circle" style="font-size:2rem;color:var(--text-dim);display:block;margin-bottom:8px;"></i>
                            <div style="font-weight:600;color:var(--text);font-size:0.88rem;">{{ $candidate->name }}</div>
                            <div style="font-size:0.75rem;color:var(--text-dim);margin-top:3px;">{{ $candidate->party ?? 'Independent' }}</div>
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach

        @php $totalCandidates = $election->positions->sum(fn($p) => $p->candidates->count()); @endphp
        @if($totalCandidates === 0)
            <div class="vs-info" style="color:orange;">No candidates have been added to this election yet. Voting is unavailable.</div>
        @else
        <button type="submit" class="vs-btn vs-btn-success"
                style="padding:10px 24px;font-size:0.85rem;"
                onclick="return confirm('Submit your vote? This cannot be undone.')">
            <i class="bi bi-check2-circle"></i> Submit Vote
        </button>
    </form>

    <script>
    function highlightCard(radio) {
        // Reset all cards in the same group
        document.querySelectorAll(`input[name="${radio.name}"]`).forEach(r => {
            r.closest('label').style.borderColor = 'var(--border)';
            r.closest('label').style.background  = 'transparent';
        });
        // Highlight selected
        radio.closest('label').style.borderColor = 'var(--accent)';
        radio.closest('label').style.background  = 'var(--accent-dim)';
    }
    </script>
@endif
@endsection