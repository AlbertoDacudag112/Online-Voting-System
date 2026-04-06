@extends('layouts.app')
@section('title', 'Candidates')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="bi bi-people"></i> Candidates</h3>
    @if(Auth::user()->role === 'admin')
    <a href="{{ route('candidates.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Add Candidate
    </a>
    @endif
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Election</th>
                    <th>Position</th>
                    <th>Party</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($candidates as $candidate)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $candidate->name }}</td>
                    <td>{{ $candidate->election->title ?? '-' }}</td>
                    <td>{{ $candidate->position->title ?? '-' }}</td>
                    <td>{{ $candidate->party ?? '-' }}</td>
                    <td>
                        @if(Auth::user()->role === 'admin')
                        <a href="{{ route('candidates.edit', $candidate->id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('candidates.destroy', $candidate->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Delete this candidate?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        @else
                        <span class="text-muted small">View only</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No candidates found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $candidates->links() }}</div>
@endsection
