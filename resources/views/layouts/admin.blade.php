@extends('layouts.app')

@section('sidebar-role', 'Admin Portal')
@section('page-title', 'Admin Dashboard')
@section('user-initials', substr(session('user_name', 'AD'), 0, 1) . substr(strrchr(session('user_name', 'AD') . ' ', ' '), 1, 1))
@section('user-name', session('user_name', 'Admin'))
@section('user-role', 'Administrator')

@section('sidebar-nav')
@php $cur = request()->route()->getName(); @endphp

{{-- Dashboard --}}
<a href="{{ route('admin.dashboard') }}"
   class="nav-item {{ str_starts_with($cur, 'admin.dashboard') ? 'active' : '' }}">
  <span class="icon">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
      <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
      <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
    </svg>
  </span>
  <span class="nav-label">Dashboard</span>
</a>

<div class="sidebar-section-label">Financial</div>

{{-- Financial Analytics --}}
<a href="{{ route('admin.financial.dashboard') }}"
   class="nav-item {{ str_starts_with($cur, 'admin.financial') ? 'active' : '' }}">
  <span class="icon">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
      <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/>
      <line x1="6" y1="20" x2="6" y2="14"/>
    </svg>
  </span>
  <span class="nav-label">Financial</span>
</a>

<div class="sidebar-section-label">Inventory</div>

{{-- Vaccine Inventory --}}
<a href="{{ route('admin.vaccine-inventory.dashboard') }}"
   class="nav-item {{ str_starts_with($cur, 'admin.vaccine-inventory') ? 'active' : '' }}">
  <span class="icon">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
      <path d="M11 11 9.26 13.74a2.31 2.31 0 0 0 3.27 3.27L15 15"/>
      <path d="m14 3-3.5 3.5"/><path d="M15 2l-1.5 1.5L17 7l1.5-1.5a2.12 2.12 0 0 0-3-3Z"/>
      <path d="m3 21 6.5-6.5"/><path d="m7 7 10 10"/>
    </svg>
  </span>
  <span class="nav-label">Inventory</span>
</a>

<div class="sidebar-section-label">Analytics</div>

{{-- Analytics --}}
<a href="{{ route('admin.analytics.dashboard') }}"
   class="nav-item {{ str_starts_with($cur, 'admin.analytics') ? 'active' : '' }}">
  <span class="icon">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
      <line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/>
      <line x1="3" y1="18" x2="21" y2="18"/><line x1="1" y1="12" x2="1" y2="13"/>
      <line x1="1" y1="6" x2="1" y2="7"/><line x1="1" y1="18" x2="1" y2="19"/>
    </svg>
  </span>
  <span class="nav-label">Analytics</span>
</a>

{{-- Vaccination Coverage --}}
<a href="{{ route('admin.vaccination-coverage.dashboard') }}"
   class="nav-item {{ str_starts_with($cur, 'admin.vaccination-coverage') ? 'active' : '' }}">
  <span class="icon">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
      <path d="M22 11.08V5a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14.02"/><circle cx="18.5" cy="17.5" r="3.5"/>
      <line x1="21" y1="20" x2="16" y2="15"/>
    </svg>
  </span>
  <span class="nav-label">Coverage</span>
</a>

<div class="sidebar-section-label">Management</div>

{{-- Staff --}}
<a href="{{ route('admin.staff.index') }}"
   class="nav-item {{ str_starts_with($cur, 'admin.staff') ? 'active' : '' }}">
  <span class="icon">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
      <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
      <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
    </svg>
  </span>
  <span class="nav-label">Staff</span>
</a>

{{-- Settings --}}
<a href="{{ route('admin.clinic-settings.edit') }}"
   class="nav-item {{ str_starts_with($cur, 'admin.clinic-settings') ? 'active' : '' }}">
  <span class="icon">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
      <circle cx="12" cy="12" r="3"/><path d="M12 1v6m0 6v6"/><path d="M4.22 4.22l4.24 4.24m0 5.08l-4.24 4.24"/>
      <path d="M1 12h6m6 0h6"/><path d="M4.22 19.78l4.24-4.24m5.08 0l4.24 4.24"/><path d="M12 23v-6"/>
      <path d="M19.78 19.78l-4.24-4.24m0-5.08l4.24-4.24"/><path d="M23 12h-6m-6 0h-6"/><path d="M19.78 4.22l-4.24 4.24m-5.08 0l4.24-4.24"/>
    </svg>
  </span>
  <span class="nav-label">Settings</span>
</a>

<div class="sidebar-section-label">Monitoring</div>

{{-- Audit Logs --}}
<a href="{{ route('admin.audit-logs') }}"
   class="nav-item {{ str_starts_with($cur, 'admin.audit-logs') ? 'active' : '' }}">
  <span class="icon">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
      <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>
      <line x1="12" y1="11" x2="12" y2="17"/><line x1="9" y1="14" x2="15" y2="14"/>
    </svg>
  </span>
  <span class="nav-label">Audit Logs</span>
</a>

{{-- Reports --}}
<a href="{{ route('admin.scheduled-reports.index') }}"
   class="nav-item {{ str_starts_with($cur, 'admin.scheduled-reports') ? 'active' : '' }}">
  <span class="icon">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
      <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
    </svg>
  </span>
  <span class="nav-label">Reports</span>
</a>

@endsection
