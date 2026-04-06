@extends('layouts.app')
@section('title', isset($election) ? 'Edit Election' : 'Add Election')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="bi bi-{{ isset($election) ? 'pencil' : 'plus-circle' }}"></i>
        {{ isset($election) ? 'Edit Election' : 'Add Election' }}
    </h3>
    <a href="{{ route('elections.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ isset($election) ? route('elections.update', $election->id) : route('elections.store') }}"
              method="POST">
            @csrf
            @if(isset($election)) @method('PUT') @endif

            <div class="mb-3">
                <label for="title" class="form-label fw-semibold">Election Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('title') is-invalid @enderror"
                       id="title" name="title"
                       value="{{ old('title', $election->title ?? '') }}"
                       placeholder="e.g. Student Council Election 2024" required>
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label fw-semibold">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror"
                          id="description" name="description" rows="3"
                          placeholder="Brief description of this election...">{{ old('description', $election->description ?? '') }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="start_date" class="form-label fw-semibold">Start Date & Time <span class="text-danger">*</span></label>
                    <input type="datetime-local" class="form-control @error('start_date') is-invalid @enderror"
                           id="start_date" name="start_date"
                           value="{{ old('start_date', isset($election) ? \Carbon\Carbon::parse($election->start_date)->format('Y-m-d\TH:i') : '') }}"
                           required>
                    @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="end_date" class="form-label fw-semibold">End Date & Time <span class="text-danger">*</span></label>
                    <input type="datetime-local" class="form-control @error('end_date') is-invalid @enderror"
                           id="end_date" name="end_date"
                           value="{{ old('end_date', isset($election) ? \Carbon\Carbon::parse($election->end_date)->format('Y-m-d\TH:i') : '') }}"
                           required>
                    @error('end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="upcoming" {{ old('status', $election->status ?? '') === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                    <option value="active"   {{ old('status', $election->status ?? '') === 'active'   ? 'selected' : '' }}>Active</option>
                    <option value="closed"   {{ old('status', $election->status ?? '') === 'closed'   ? 'selected' : '' }}>Closed</option>
                </select>
                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ isset($election) ? 'Update Election' : 'Save Election' }}
                </button>
                <a href="{{ route('elections.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
