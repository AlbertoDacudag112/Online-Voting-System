@extends('layouts.app')
@section('title', $election->title)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="bi bi-card-list"></i> {{ $election->title }}</h3>
    <a href="{{ route('elections.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back
    </a>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-dark text-white">Election Details</div>
            <div class="card-body">
                <p><strong>Status:</strong>
                    @if($election->status === 'active')
                        <span class="badge bg-success">Active</span>
                    @elseif($election->status === 'upcoming')
                        <span class="badge bg-warning text-dark">Upcoming</span>
                    @else
                        <span class="badge bg-secondary">Closed</span>
                    @endif
                </p>
                <p><strong>Start:</strong> {{ \Carbon\Carbon::parse($election->start_date)->format('M d, Y h:i A') }}</p>
                <p><strong>End:</strong> {{ \Carbon\Carbon::parse($election->end_date)->format('M d, Y h:i A') }}</p>
                <p><strong>Description:</strong><br>{{ $election->description ?? 'No description.' }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-dark text-white d-flex justify-content-between">
                <span><i class="bi bi-people"></i> Candidates</span>
                @if(Auth::user()->role === 'admin')
                <a href="{{ route('candidates.create') }}" class="btn btn-sm btn-light">
                    <i class="bi bi-plus"></i> Add Candidate
                </a>
                @endif
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Party</th>
                            <th>Votes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($election->candidates as $candidate)
                        <tr>
                            <td>{{ $candidate->name }}</td>
                            <td>{{ $candidate->position->title ?? '-' }}</td>
                            <td>{{ $candidate->party ?? '-' }}</td>
                            <td><span class="badge bg-primary">{{ $candidate->votes->count() }}</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted py-3">No candidates yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
