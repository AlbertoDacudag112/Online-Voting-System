@extends('layouts.app')
@section('title', 'Manage Voters')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="bi bi-person-badge"></i> Manage Voters</h3>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Voter ID</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($voters as $voter)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $voter->name }}</td>
                    <td>{{ $voter->email }}</td>
                    <td>{{ $voter->voter_id ?? '-' }}</td>
                    <td>
                        <span class="badge {{ $voter->role === 'admin' ? 'bg-danger' : 'bg-primary' }}">
                            {{ ucfirst($voter->role) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge {{ $voter->is_active ? 'bg-success' : 'bg-secondary' }}">
                            {{ $voter->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('voters.edit', $voter->id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        @if($voter->id !== Auth::id())
                        <form action="{{ route('voters.destroy', $voter->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Delete this voter?')">
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
                <tr><td colspan="7" class="text-center text-muted py-4">No voters found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $voters->links() }}</div>
@endsection
