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
<a href="{{ route('admin.clinic-settings.index') }}"
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
<a href="{{ route('admin.audit-logs.index') }}"
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
            --secondary-color: #84a98c;
            --danger-color: #bf4040;
            --success-color: #52796f;
            --warning-color: #a07030;
        }

        body {
            background-color: #c8d6c2;
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .admin-sidebar {
            width: 260px;
            background: linear-gradient(135deg, #354f52 0%, #2f3e46 100%);
            color: white;
            padding: 20px 0;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            overflow-y: auto;
            position: sticky;
            top: 0;
            height: 100vh;
        }

        .admin-sidebar .sidebar-brand {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }

        .admin-sidebar .sidebar-brand h5 {
            margin: 0;
            font-weight: 700;
        }

        .admin-sidebar .nav-item {
            margin: 0;
        }

        .admin-sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
        }

        .admin-sidebar .nav-link:hover,
        .admin-sidebar .nav-link.active {
            color: white;
            background-color: rgba(255,255,255,0.1);
            border-left-color: white;
        }

        .admin-sidebar .nav-section {
            margin-top: 20px;
            padding: 0 20px;
        }

        .admin-sidebar .nav-section-title {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            color: rgba(255,255,255,0.5);
            margin-bottom: 10px;
        }

        .admin-main {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .admin-topbar {
            background: white;
            padding: 15px 30px;
            border-bottom: 1px solid #cad2c5;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .admin-topbar-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2f3e46;
        }

        .admin-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }

        .stat-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            border-left: 4px solid var(--primary-color);
            margin-bottom: 20px;
        }

        .stat-card.warning {
            border-left-color: var(--warning-color);
        }

        .stat-card.danger {
            border-left-color: var(--danger-color);
        }

        .stat-card.success {
            border-left-color: var(--success-color);
        }

        .stat-card h6 {
            color: var(--secondary-color);
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-card .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
        }

        .table-responsive {
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        }

        .table {
            margin-bottom: 0;
        }

        .table thead {
            background-color: #cad2c5;
            border-bottom: 2px solid #84a98c;
        }

        .table thead th {
            color: #2f3e46;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn {
            border-radius: 6px;
            font-weight: 600;
            padding: 8px 16px;
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #354f52;
            border-color: #354f52;
        }

        .alert {
            border-radius: 8px;
            border: none;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .admin-sidebar {
                width: 100%;
                height: auto;
            }

            .admin-wrapper {
                flex-direction: column;
            }

            .admin-content {
                padding: 15px;
            }
        }
    </style>
    @yield('css')
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <nav class="admin-sidebar">
            <div class="sidebar-brand">
                <h5><i class="bi bi-shield-check"></i> VaccTrack Admin</h5>
            </div>

            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link @if(request()->routeIs('admin.dashboard')) active @endif" href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
            </ul>

            <div class="nav-section">
                <div class="nav-section-title">Analytics & Operations</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('admin.audit-logs*')) active @endif" href="{{ route('admin.audit-logs') }}">
                            <i class="bi bi-clock-history"></i> Audit Logs
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('admin.financial*')) active @endif" href="{{ route('admin.financial.dashboard') }}">
                            <i class="bi bi-graph-up"></i> Financial
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('admin.vaccine-inventory*')) active @endif" href="{{ route('admin.vaccine-inventory.dashboard') }}">
                            <i class="bi bi-boxes"></i> Inventory
                        </a>
                    </li>
                </ul>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">Management</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('admin.staff*')) active @endif" href="{{ route('admin.staff.index') }}">
                            <i class="bi bi-people"></i> Staff
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('admin.clinic-settings*')) active @endif" href="{{ route('admin.clinic-settings.edit') }}">
                            <i class="bi bi-gear"></i> Clinic Settings
                        </a>
                    </li>
                </ul>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">Insights & Reports</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('admin.vaccination-coverage*')) active @endif" href="{{ route('admin.vaccination-coverage.dashboard') }}">
                            <i class="bi bi-hospital"></i> Vaccination Coverage
                        </a>
                    </li>
                </ul>
            </div>

            <div class="nav-section" style="margin-top: auto;">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link" style="width: 100%; text-align: left; background: none; border: none;">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="admin-main">
            <!-- Top Bar -->
            <div class="admin-topbar">
                <div class="admin-topbar-title">@yield('page-title', 'Dashboard')</div>
                <div>
                    <span class="me-3">Welcome, {{ session('doctor_name', 'User') }}</span>
                    <i class="bi bi-person-circle"></i>
                </div>
            </div>

            <!-- Content Area -->
            <div class="admin-content">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> Please fix the errors below.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    @yield('js')
</body>
</html>
