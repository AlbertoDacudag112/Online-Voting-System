@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="bi bi-speedometer2"></i> Dashboard</h3>
    <small class="text-muted">Welcome back, {{ Auth::user()->name }}!</small>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="card-title">Total Elections</h6>
                    <h2 class="mb-0">{{ $totalElections }}</h2>
                </div>
                <i class="bi bi-card-list fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="card-title">Active Elections</h6>
                    <h2 class="mb-0">{{ $activeElections }}</h2>
                </div>
                <i class="bi bi-lightning fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="card-title">Total Candidates</h6>
                    <h2 class="mb-0">{{ $totalCandidates }}</h2>
                </div>
                <i class="bi bi-people fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-danger">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="card-title">Total Voters</h6>
                    <h2 class="mb-0">{{ $totalVoters }}</h2>
                </div>
                <i class="bi bi-person-badge fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <i class="bi bi-card-list"></i> Recent Elections
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentElections as $election)
                        <tr>
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
                            <td>{{ \Carbon\Carbon::parse($election->start_date)->format('M d, Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($election->end_date)->format('M d, Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted">No elections yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <i class="bi bi-person-circle"></i> Your Account
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ Auth::user()->name }}</p>
                <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                <p><strong>Role:</strong>
                    <span class="badge {{ Auth::user()->role === 'admin' ? 'bg-danger' : 'bg-primary' }}">
                        {{ ucfirst(Auth::user()->role) }}
                    </span>
                </p>
                @if(Auth::user()->voter_id)
                <p><strong>Voter ID:</strong> {{ Auth::user()->voter_id }}</p>
                @endif
                <p><strong>Status:</strong>
                    <span class="badge {{ Auth::user()->is_active ? 'bg-success' : 'bg-danger' }}">
                        {{ Auth::user()->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
