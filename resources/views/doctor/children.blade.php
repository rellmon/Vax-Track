@extends('layouts.doctor')
@section('page-title', 'Children')
@section('content')
<div class="page-toolbar">
  <div class="page-toolbar-left">
    <form method="GET" action="{{ route('doctor.children') }}" style="display:flex;align-items:center;gap:8px;">
      <div class="search-bar" style="width:280px;">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" name="search" placeholder="Search children..." value="{{ request('search') }}">
      </div>
      <button type="submit" class="btn btn-secondary btn-sm">Search</button>
    </form>
  </div>
  <div class="flex gap-2">
    <a href="{{ route('doctor.children.create-existing') }}" class="btn btn-secondary" style="display:flex;align-items:center;gap:7px;">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
      Existing Parent
    </a>
    <a href="{{ route('doctor.children.create') }}" class="btn btn-primary">+ Register New Child</a>
  </div>
</div>

<div class="card">
  <div class="table-wrapper">
    <table>
      <thead><tr>
        <th>Child Name</th><th>Date of Birth</th><th>Age</th><th>Gender</th>
        <th>Blood Type</th><th>Parent / Guardian</th><th>Actions</th>
      </tr></thead>
      <tbody>
        @forelse($children as $c)
          <tr>
            <td><strong>{{ $c->full_name }}</strong></td>
            <td>{{ \Carbon\Carbon::parse($c->dob)->format('M j, Y') }}</td>
            <td><span class="badge badge-blue">{{ $c->age }}</span></td>
            <td>{{ $c->gender }}</td>
            <td>{{ $c->blood_type ?: '—' }}</td>
            <td>{{ $c->parent ? $c->parent->full_name : '—' }}</td>
            <td>
              <div class="flex gap-2">
                <a href="{{ route('doctor.children.show', $c) }}" class="btn btn-sm btn-secondary" style="display:inline-flex;align-items:center;gap:5px;">
                  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"/><circle cx="12" cy="12" r="3"/></svg>
                  View
                </a>
                <a href="{{ route('doctor.children.edit', $c) }}" class="btn btn-sm btn-secondary" style="display:inline-flex;align-items:center;gap:5px;">
                  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4Z"/></svg>
                  Edit
                </a>
              </div>
            </td>
          </tr>
        @empty
          <tr><td colspan="7">
            <div class="empty-state">
              <div class="empty-icon"><svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" style="opacity:.4"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
              <p>No children registered yet.</p>
            </div>
          </td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection