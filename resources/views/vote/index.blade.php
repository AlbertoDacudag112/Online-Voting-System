@extends('layouts.app')
@section('title', 'Cast Your Vote')

@section('content')
<div class="mb-4">
    <h3><i class="bi bi-check2-square"></i> Cast Your Vote</h3>
    <p class="text-muted">Select one candidate per position. You can only vote once per election.</p>
</div>

@forelse($elections as $election)
<div class="card mb-4">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
        <span><i class="bi bi-card-list"></i> {{ $election->title }}</span>
        @if($election->ballots->where('user_id', Auth::id())->where('has_voted', true)->count())
            <span class="badge bg-success"><i class="bi bi-check-circle"></i> Already Voted</span>
        @else
            <span class="badge bg-warning text-dark">Not yet voted</span>
        @endif
    </div>
    <div class="card-body">
        @if($election->ballots->where('user_id', Auth::id())->where('has_voted', true)->count())
            <div class="alert alert-success">
                <i class="bi bi-check-circle"></i> You have already cast your vote for this election.
            </div>
        @else
            <form action="{{ route('vote.store') }}" method="POST">
                @csrf
                <input type="hidden" name="election_id" value="{{ $election->id }}">

                @foreach($election->positions as $position)
                <div class="mb-4">
                    <h5 class="fw-bold text-primary"><i class="bi bi-person-badge"></i> {{ $position->title }}</h5>
                    <div class="row g-3">
                        @foreach($position->candidates as $candidate)
                        <div class="col-md-4">
                            <div class="card border-2 candidate-card" style="cursor:pointer;">
                                <div class="card-body text-center">
                                    <div class="mb-2">
                                        <i class="bi bi-person-circle fs-1 text-secondary"></i>
                                    </div>
                                    <h6 class="fw-bold mb-1">{{ $candidate->name }}</h6>
                                    <small class="text-muted">{{ $candidate->party ?? 'Independent' }}</small>
                                    <div class="mt-2">
                                        <input class="form-check-input" type="radio"
                                               name="votes[{{ $position->id }}]"
                                               value="{{ $candidate->id }}"
                                               id="candidate_{{ $candidate->id }}" required>
                                        <label class="form-check-label ms-1" for="candidate_{{ $candidate->id }}">
                                            Select
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach

                <button type="submit" class="btn btn-success btn-lg"
                        onclick="return confirm('Are you sure? You cannot change your vote after submitting.')">
                    <i class="bi bi-check2-circle"></i> Submit Vote
                </button>
            </form>
        @endif
    </div>
</div>
@empty
<div class="alert alert-info">
    <i class="bi bi-info-circle"></i> No active elections at the moment.
</div>
@endforelse
@endsection
