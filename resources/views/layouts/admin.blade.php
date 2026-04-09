<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - VaccTrack Admin Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #52796f;
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
