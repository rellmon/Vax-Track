@extends('layouts.parent')
@section('page-title', 'My Schedules')
@section('content')
<div class="card">
  <div class="table-wrapper">
    <table>
      <thead><tr><th>Child</th><th>Vaccine</th><th>Category</th><th>Date</th><th>Time</th><th>Status</th></tr></thead>
      <tbody>
        @forelse($schedules as $s)
          <tr>
            <td><strong>{{ $s->child?->full_name }}</strong></td>
            <td>{{ $s->vaccine?->name }}</td>
            <td><span class="badge badge-blue">{{ $s->vaccine?->type }}</span></td>
            <td>{{ \Carbon\Carbon::parse($s->appointment_date)->format('F j, Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($s->appointment_time)->format('g:i A') }}</td>
            <td><span class="badge {{ $s->status==='Completed'?'badge-green':($s->status==='Cancelled'?'badge-red':'badge-amber') }}">{{ $s->status }}</span></td>
          </tr>
        @empty
          <tr><td colspan="6">
            <div class="empty-state">
              <div class="empty-icon"><svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" style="opacity:.4"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div>
              <p>No schedules found.</p>
            </div>
          </td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection