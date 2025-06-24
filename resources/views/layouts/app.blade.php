<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SPK CPI - PAUDQU QURROTA A\'YUN')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 260px;
            --navbar-height: 64px;
            --primary-color: #3b82f6;
            --primary-dark: #1d4ed8;
            --secondary-color: #64748b;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-500: #64748b;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --gray-900: #0f172a;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--gray-50);
            color: var(--gray-800);
            font-size: 14px;
            line-height: 1.5;
            margin: 0;
            overflow-x: hidden;
        }

        /* ===== NAVBAR ===== */
        .navbar-custom {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: var(--navbar-height);
            background: white;
            border-bottom: 1px solid var(--gray-200);
            z-index: 1030;
            padding: 0 24px;
            display: flex;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: 600;
            font-size: 16px;
            color: var(--gray-800) !important;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .navbar-brand i {
            color: var(--primary-color);
            margin-right: 8px;
            font-size: 18px;
        }

        .navbar-toggle {
            background: none;
            border: none;
            color: var(--gray-500);
            font-size: 16px;
            padding: 8px;
            border-radius: 6px;
            margin-right: 16px;
            transition: all 0.2s ease;
        }

        .navbar-toggle:hover {
            background: var(--gray-100);
            color: var(--gray-700);
        }

        .navbar-right {
            margin-left: auto;
            display: flex;
            align-items: center;
        }

        .user-dropdown {
            position: relative;
        }

        .user-dropdown-toggle {
            display: flex;
            align-items: center;
            padding: 6px 12px;
            border-radius: 8px;
            text-decoration: none;
            color: var(--gray-700);
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }

        .user-dropdown-toggle:hover {
            background: var(--gray-100);
            color: var(--gray-800);
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            margin-right: 8px;
            object-fit: cover;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            margin-right: 8px;
        }

        .user-name {
            font-size: 13px;
            font-weight: 500;
            line-height: 1.2;
        }

        .user-role {
            font-size: 11px;
            color: var(--gray-500);
            line-height: 1.2;
        }

        .dropdown-menu {
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 8px;
            min-width: 180px;
        }

        .dropdown-item {
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 13px;
            display: flex;
            align-items: center;
            color: var(--gray-700);
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background: var(--gray-100);
            color: var(--gray-800);
        }

        .dropdown-item i {
            margin-right: 8px;
            width: 16px;
            text-align: center;
            font-size: 12px;
        }

        .dropdown-divider {
            margin: 8px 0;
            border-color: var(--gray-200);
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            position: fixed;
            top: var(--navbar-height);
            left: 0;
            width: var(--sidebar-width);
            height: calc(100vh - var(--navbar-height));
            background: white;
            border-right: 1px solid var(--gray-200);
            overflow-y: auto;
            z-index: 1020;
            transition: transform 0.3s ease;
        }

        .sidebar.collapsed {
            transform: translateX(-100%);
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid var(--gray-200);
            background: var(--gray-50);
        }

        .sidebar-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--primary-color);
            margin: 0 0 4px 0;
        }

        .sidebar-subtitle {
            font-size: 12px;
            color: var(--gray-500);
            margin: 0;
        }

        .sidebar-menu {
            padding: 16px 0;
            list-style: none;
            margin: 0;
        }

        .sidebar-menu li {
            margin-bottom: 4px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            color: var(--gray-600);
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s ease;
            border-radius: 0;
            position: relative;
        }

        .sidebar-menu a:hover {
            background: var(--gray-100);
            color: var(--gray-800);
        }

        .sidebar-menu a.active {
            background: var(--primary-color);
            color: white;
        }

        .sidebar-menu a.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: var(--primary-dark);
        }

        .sidebar-menu i {
            width: 18px;
            text-align: center;
            margin-right: 12px;
            font-size: 14px;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--navbar-height);
            padding: 24px;
            min-height: calc(100vh - var(--navbar-height));
            transition: margin-left 0.3s ease;
        }

        .main-content.expanded {
            margin-left: 0;
        }

        /* ===== CARDS ===== */
        .card {
            border: 1px solid var(--gray-200);
            border-radius: 12px;
            box-shadow: none;
            transition: all 0.2s ease;
            background: white;
        }

        .card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            background: white;
            border-bottom: 1px solid var(--gray-200);
            font-weight: 600;
            font-size: 14px;
            padding: 16px 20px;
            border-radius: 12px 12px 0 0;
        }

        .card-body {
            padding: 20px;
        }

        /* ===== STATS CARDS ===== */
        .stats-card {
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: 12px;
            padding: 20px;
            position: relative;
            transition: all 0.2s ease;
        }

        .stats-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transform: translateY(-1px);
        }

        .stats-card.primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            border: none;
        }

        .stats-card.success {
            background: linear-gradient(135deg, var(--success-color), #059669);
            color: white;
            border: none;
        }

        .stats-card.warning {
            background: linear-gradient(135deg, var(--warning-color), #d97706);
            color: white;
            border: none;
        }

        .stats-card.danger {
            background: linear-gradient(135deg, var(--danger-color), #dc2626);
            color: white;
            border: none;
        }

        /* ===== BUTTONS ===== */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            font-size: 13px;
            padding: 8px 16px;
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-primary {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        /* ===== TABLES ===== */
        .table {
            border-radius: 8px;
            overflow: hidden;
            font-size: 13px;
        }

        .table thead th {
            background: var(--gray-50);
            border: none;
            font-weight: 600;
            color: var(--gray-700);
            padding: 12px 16px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table tbody td {
            padding: 12px 16px;
            border-color: var(--gray-200);
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background: var(--gray-50);
        }

        /* ===== ALERTS ===== */
        .alert {
            border-radius: 8px;
            border: 1px solid;
            padding: 12px 16px;
            font-size: 13px;
            margin-bottom: 16px;
        }

        .alert-success {
            background: #f0fdf4;
            border-color: #bbf7d0;
            color: #166534;
        }

        .alert-danger {
            background: #fef2f2;
            border-color: #fecaca;
            color: #dc2626;
        }

        .alert-warning {
            background: #fffbeb;
            border-color: #fed7aa;
            color: #d97706;
        }

        .alert-info {
            background: #eff6ff;
            border-color: #bfdbfe;
            color: #1d4ed8;
        }

        /* ===== BADGES ===== */
        .badge {
            font-size: 11px;
            font-weight: 500;
            padding: 4px 8px;
            border-radius: 6px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 16px;
            }

            .navbar-custom {
                padding: 0 16px;
            }

            .user-info {
                display: none;
            }
        }

        /* ===== ANIMATIONS ===== */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.4s ease-out;
        }

        /* ===== LOADING STATES ===== */
        .loading {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* ===== SCROLLBAR ===== */
        .sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: var(--gray-100);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: var(--gray-300);
            border-radius: 2px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: var(--gray-400);
        }
    </style>
</head>

<body>
    <!-- Fixed Navbar -->
    <nav class="navbar-custom">
        <!-- Mobile Toggle -->
        <button class="navbar-toggle d-lg-none" type="button" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Brand -->
        <a class="navbar-brand"
            href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('guru.dashboard') }}">
            <i class="fas fa-graduation-cap"></i>
            SPK CPI - PAUDQU
        </a>

        <!-- Right Side -->
        <div class="navbar-right">
            <div class="user-dropdown dropdown">
                <a class="user-dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <img src="{{ auth()->user()->foto ? asset('uploads/users/' . auth()->user()->foto) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=3b82f6&color=ffffff&size=64' }}"
                        class="user-avatar" alt="Profile">
                    <div class="user-info d-none d-md-block">
                        <div class="user-name">{{ auth()->user()->name }}</div>
                        <div class="user-role">{{ auth()->user()->role == 'admin' ? 'Administrator' : 'Guru' }}</div>
                    </div>
                    <i class="fas fa-chevron-down" style="font-size: 10px; color: var(--gray-500);"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    @if (auth()->user()->isGuru())
                        <li>
                            <a class="dropdown-item" href="{{ route('guru.profil.index') }}">
                                <i class="fas fa-user"></i>Profil Saya
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                    @endif
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline w-100">
                            @csrf
                            <button type="submit"
                                class="dropdown-item text-danger border-0 bg-transparent w-100 text-start">
                                <i class="fas fa-sign-out-alt"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Fixed Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h6 class="sidebar-title">{{ auth()->user()->isAdmin() ? 'Panel Admin' : 'Panel Guru' }}</h6>
            <p class="sidebar-subtitle">{{ auth()->user()->role == 'admin' ? 'Administrator' : 'Guru PAUD' }}</p>
        </div>

        <ul class="sidebar-menu">
            @if (auth()->user()->isAdmin())
                <!-- Admin Menu -->
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users.index') }}"
                        class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>Kelola User
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.siswa.index') }}"
                        class="{{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
                        <i class="fas fa-child"></i>Data Siswa
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.kriteria.index') }}"
                        class="{{ request()->routeIs('admin.kriteria.*') ? 'active' : '' }}">
                        <i class="fas fa-list-check"></i>Data Kriteria
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.penilaian.index') }}"
                        class="{{ request()->routeIs('admin.penilaian.*') ? 'active' : '' }}">
                        <i class="fas fa-edit"></i>Data Penilaian
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.hasil-cpi.index') }}"
                        class="{{ request()->routeIs('admin.hasil-cpi.*') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i>Hasil CPI
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.cetak-hasil') }}" target="_blank">
                        <i class="fas fa-print"></i>Cetak Laporan
                    </a>
                </li>
            @else
                <!-- Guru Menu -->
                <li>
                    <a href="{{ route('guru.dashboard') }}"
                        class="{{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('guru.hasil-cpi.index') }}"
                        class="{{ request()->routeIs('guru.hasil-cpi.*') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i>Hasil Penilaian CPI
                    </a>
                </li>
                <li>
                    <a href="{{ route('guru.cetak-hasil') }}" target="_blank">
                        <i class="fas fa-print"></i>Cetak Laporan
                    </a>
                </li>
                <li>
                    <a href="{{ route('guru.profil.index') }}"
                        class="{{ request()->routeIs('guru.profil.*') ? 'active' : '' }}">
                        <i class="fas fa-user-circle"></i>Profil Saya
                    </a>
                </li>
            @endif
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Alerts -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Page Content -->
        <div class="fade-in-up">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script>
        // Sidebar toggle functionality
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');

            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('show');
            } else {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
            }
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.getElementById('sidebarToggle');

            if (window.innerWidth <= 768 &&
                !sidebar.contains(e.target) &&
                !toggle?.contains(e.target) &&
                sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
            }
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
            alerts.forEach(function(alert) {
                if (alert.querySelector('.btn-close')) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            });
        }, 5000);

        // Loading state for forms
        document.querySelectorAll('form').forEach(function(form) {
            form.addEventListener('submit', function() {
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn && !submitBtn.disabled) {
                    const originalHTML = submitBtn.innerHTML;
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="loading me-2"></span>Memproses...';

                    // Re-enable after 10 seconds as fallback
                    setTimeout(function() {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalHTML;
                    }, 10000);
                }
            });
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    </script>

    @stack('scripts')
</body>

</html>
