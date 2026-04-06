@extends('layouts.app')
@section('title', 'Edit Voter')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="bi bi-pencil"></i> Edit Voter</h3>
    <a href="{{ route('voters.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('voters.update', $voter->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                           id="name" name="name" value="{{ old('name', $voter->name) }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                           id="email" name="email" value="{{ old('email', $voter->email) }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="voter_id" class="form-label fw-semibold">Voter ID</label>
                    <input type="text" class="form-control @error('voter_id') is-invalid @enderror"
                           id="voter_id" name="voter_id" value="{{ old('voter_id', $voter->voter_id) }}"
                           placeholder="e.g. VTR-2024-001">
                    @error('voter_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label for="role" class="form-label fw-semibold">Role <span class="text-danger">*</span></label>
                    <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                        <option value="voter" {{ old('role', $voter->role) === 'voter' ? 'selected' : '' }}>Voter</option>
                        <option value="admin" {{ old('role', $voter->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label for="is_active" class="form-label fw-semibold">Status</label>
                    <select class="form-select" id="is_active" name="is_active">
                        <option value="1" {{ old('is_active', $voter->is_active) == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('is_active', $voter->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Update Voter
                </button>
                <a href="{{ route('voters.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
