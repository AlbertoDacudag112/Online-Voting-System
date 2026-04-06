@extends('layouts.app')
@section('title', isset($candidate) ? 'Edit Candidate' : 'Add Candidate')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="bi bi-{{ isset($candidate) ? 'pencil' : 'plus-circle' }}"></i>
        {{ isset($candidate) ? 'Edit Candidate' : 'Add Candidate' }}
    </h3>
    <a href="{{ route('candidates.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ isset($candidate) ? route('candidates.update', $candidate->id) : route('candidates.store') }}"
              method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($candidate)) @method('PUT') @endif

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                           id="name" name="name"
                           value="{{ old('name', $candidate->name ?? '') }}"
                           placeholder="Candidate full name" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="party" class="form-label fw-semibold">Party / Affiliation</label>
                    <input type="text" class="form-control @error('party') is-invalid @enderror"
                           id="party" name="party"
                           value="{{ old('party', $candidate->party ?? '') }}"
                           placeholder="e.g. Unity Party">
                    @error('party')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="election_id" class="form-label fw-semibold">Election <span class="text-danger">*</span></label>
                    <select class="form-select @error('election_id') is-invalid @enderror"
                            id="election_id" name="election_id" required>
                        <option value="">-- Select Election --</option>
                        @foreach($elections as $election)
                        <option value="{{ $election->id }}"
                            {{ old('election_id', $candidate->election_id ?? '') == $election->id ? 'selected' : '' }}>
                            {{ $election->title }}
                        </option>
                        @endforeach
                    </select>
                    @error('election_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="position_id" class="form-label fw-semibold">Position <span class="text-danger">*</span></label>
                    <select class="form-select @error('position_id') is-invalid @enderror"
                            id="position_id" name="position_id" required>
                        <option value="">-- Select Position --</option>
                        @foreach($positions as $position)
                        <option value="{{ $position->id }}"
                            {{ old('position_id', $candidate->position_id ?? '') == $position->id ? 'selected' : '' }}>
                            {{ $position->title }}
                        </option>
                        @endforeach
                    </select>
                    @error('position_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="bio" class="form-label fw-semibold">Bio / Platform</label>
                <textarea class="form-control @error('bio') is-invalid @enderror"
                          id="bio" name="bio" rows="4"
                          placeholder="Brief description of the candidate...">{{ old('bio', $candidate->bio ?? '') }}</textarea>
                @error('bio')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-4">
                <label for="photo" class="form-label fw-semibold">Photo</label>
                <input type="file" class="form-control @error('photo') is-invalid @enderror"
                       id="photo" name="photo" accept="image/*">
                @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                @if(isset($candidate) && $candidate->photo)
                    <small class="text-muted">Current: {{ $candidate->photo }}</small>
                @endif
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ isset($candidate) ? 'Update Candidate' : 'Save Candidate' }}
                </button>
                <a href="{{ route('candidates.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
