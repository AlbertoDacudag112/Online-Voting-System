@extends('layouts.app')
@section('title', 'Elections')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="bi bi-card-list"></i> Elections</h3>
    @if(Auth::user()->role === 'admin')
    <a href="{{ route('elections.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Add Election
    </a>
    @endif
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($elections as $election)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $election->title }}</td>
                    <td>
                        @if($election->status === 'active')
                            <span class="badge bg-success">Active</span>
                        @elseif($election->status === 'upcoming')
                            <span class="badge bg-warning text-dark">Upcoming</span>
                        @else
                            <span class="badge bg-secondary">Closed</span>
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($election->start_date)->format('M d, Y h:i A') }}</td>
                    <td>{{ \Carbon\Carbon::parse($election->end_date)->format('M d, Y h:i A') }}</td>
                    <td>
                        <a href="{{ route('elections.show', $election->id) }}" class="btn btn-sm btn-info text-white">
                            <i class="bi bi-eye"></i>
                        </a>
                        @if(Auth::user()->role === 'admin')
                        <a href="{{ route('elections.edit', $election->id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('elections.destroy', $election->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Are you sure you want to delete this election?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No elections found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $elections->links() }}</div>
@endsection
