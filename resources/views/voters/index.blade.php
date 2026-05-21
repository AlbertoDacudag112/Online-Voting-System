@extends('layouts.app')
@section('title', 'Manage Voters')

@section('content')
<div class="page-header">
    <h1 class="page-title"><i class="bi bi-person-badge"></i> Manage Voters</h1>
</div>

{{-- ── Filters ── --}}
<form method="GET" action="{{ route('voters.index') }}" class="vs-card mb-4">
    <div class="vs-card-body" style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
        <div style="flex:1;min-width:160px;">
            <label class="vs-label">Search</label>
            <input type="text" name="search" class="vs-input" placeholder="Name or email…" value="{{ request('search') }}">
        </div>
        <div style="min-width:140px;">
            <label class="vs-label">Course</label>
            <select name="course" class="vs-select">
                <option value="">All Courses</option>
                @foreach(\App\Models\User::COURSES as $key => $label)
                <option value="{{ $key }}" {{ request('course') === $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div style="min-width:130px;">
            <label class="vs-label">Year Level</label>
            <select name="year_level" class="vs-select">
                <option value="">All Years</option>
                @foreach(\App\Models\User::YEAR_LEVELS as $key => $label)
                <option value="{{ $key }}" {{ request('year_level') === $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div style="min-width:110px;">
            <label class="vs-label">Role</label>
            <select name="role" class="vs-select">
                <option value="">All Roles</option>
                <option value="voter"  {{ request('role') === 'voter'  ? 'selected' : '' }}>Voter</option>
                <option value="admin"  {{ request('role') === 'admin'  ? 'selected' : '' }}>Admin</option>
            </select>
        </div>
        <div style="min-width:110px;">
            <label class="vs-label">Status</label>
            <select name="status" class="vs-select">
                <option value="">All</option>
                <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <button type="submit" class="vs-btn vs-btn-primary">
            <i class="bi bi-search"></i> Filter
        </button>
        <a href="{{ route('voters.index') }}" class="vs-btn vs-btn-secondary">Reset</a>
    </div>
</form>

{{-- ── Table ── --}}
<div class="vs-card">
    <table class="vs-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Course</th>
                <th>Year</th>
                <th>Role</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($voters as $voter)
            <tr>
                <td style="color:var(--text-dim);">{{ $loop->iteration }}</td>
                <td>{{ $voter->name }}</td>
                <td style="color:var(--text-dim);">{{ $voter->email }}</td>
                <td>{{ \App\Models\User::COURSES[$voter->course] ?? '—' }}</td>
                <td>{{ $voter->year_level ?? '—' }}</td>
                <td><span class="vs-badge {{ $voter->role === 'admin' ? 'vs-badge-admin' : 'vs-badge-voter' }}">{{ ucfirst($voter->role) }}</span></td>
                <td><span class="vs-badge {{ $voter->is_active ? 'vs-badge-active' : 'vs-badge-inactive' }}">{{ $voter->is_active ? 'Active' : 'Inactive' }}</span></td>
                <td style="display:flex;gap:6px;">
                    <a href="{{ route('voters.edit', $voter->id) }}" class="vs-btn vs-btn-icon vs-btn-edit"><i class="bi bi-pencil"></i></a>
                    @if($voter->id !== Auth::id())
                    <form action="{{ route('voters.destroy', $voter->id) }}" method="POST" onsubmit="return confirm('Delete this voter?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="vs-btn vs-btn-icon vs-btn-delete"><i class="bi bi-trash"></i></button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;color:var(--text-dim);padding:32px;">No voters found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-3">{{ $voters->links() }}</div>
@endsection