@extends('layouts.doctor')
@section('page-title', 'Edit Vaccine')
@section('content')
<div style="max-width:600px;">
  <a href="{{ route('doctor.vaccines') }}" class="btn btn-secondary mb-4" style="display:inline-flex;align-items:center;gap:7px;">
    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
    Back to Vaccines
  </a>
  <div class="card">
    <div class="card-header">
      <span class="card-title" style="display:flex;align-items:center;gap:8px;">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4Z"/></svg>
        Edit Vaccine — {{ $vaccine->name }}
      </span>
    </div>
    <div class="card-body">
      <form action="{{ route('doctor.vaccines.update', $vaccine) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-row">
          <div class="form-group">
            <label>Vaccine Name</label>
            <input type="text" name="name" class="form-control" value="{{ $vaccine->name }}" maxlength="100" required>
          </div>
          <div class="form-group">
            <label>Category / Type</label>
            <select name="type" class="form-control" required>
              @foreach(['Birth','6 weeks','10 weeks','14 weeks','9 months','12 months'] as $t)
                <option {{ $vaccine->type === $t ? 'selected' : '' }}>{{ $t }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Stock Quantity</label>
            <input type="number" name="stock" class="form-control" value="{{ $vaccine->stock }}" min="0" max="99999" required>
          </div>
          <div class="form-group">
            <label>Price (₱)</label>
            <input type="number" name="price" class="form-control" value="{{ $vaccine->price }}" min="0" step="0.01" max="999999.99" required>
          </div>
        </div>
        <div class="form-group">
          <label>Manufacturer</label>
          <input type="text" name="manufacturer" class="form-control" value="{{ $vaccine->manufacturer }}" maxlength="100" required>
        </div>
        <div class="form-group">
          <label>Description</label>
          <textarea name="description" class="form-control" rows="3" maxlength="500">{{ $vaccine->description }}</textarea>
        </div>
        <div class="toggle-wrap" style="margin-bottom:20px;">
          <input type="checkbox" name="active" id="toggle-active" class="toggle-input" {{ $vaccine->active ? 'checked' : '' }}>
          <label for="toggle-active" class="toggle-label-ui"></label>
          <span style="font-size:13px;font-weight:500;color:var(--text2);">Active (Available for use)</span>
        </div>
        <div class="flex gap-2">
          <a href="{{ route('doctor.vaccines') }}" class="btn btn-secondary">Cancel</a>
          <button type="submit" class="btn btn-primary" style="display:inline-flex;align-items:center;gap:7px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
            Update Vaccine
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection