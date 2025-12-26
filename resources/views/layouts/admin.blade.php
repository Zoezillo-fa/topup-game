<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Store Game</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f4f6f9; }
        .sidebar {
            width: 260px;
            height: 100vh;
            background: #242733; /* Warna Dark Premium */
            position: fixed;
            top: 0; left: 0;
            color: #a0aaec;
            overflow-y: auto;
        }
        .main-content { margin-left: 260px; padding: 20px; }
        .sidebar .nav-link {
            color: #a0aaec;
            padding: 12px 20px;
            font-weight: 500;
            display: flex;
            align-items: center;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: rgba(255,255,255,0.1);
            color: #fff;
            border-left: 4px solid #facc15;
        }
        .sidebar .nav-link i { margin-right: 10px; font-size: 1.1rem; }
        .sidebar-brand {
            padding: 20px;
            font-size: 1.25rem;
            font-weight: 800;
            color: #fff;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 10px;
        }
        .section-header {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 15px 20px 5px 20px;
            color: #6c757d;
            font-weight: 700;
        }
        /* Dropdown Submenu */
        .submenu { background: rgba(0,0,0,0.2); padding-left: 10px; }
        .submenu .nav-link { font-size: 0.9rem; padding: 8px 20px; }
    </style>
</head>
<body>

    <div class="sidebar d-flex flex-column">
        <a href="#" class="sidebar-brand text-decoration-none text-center">
            <i class="bi bi-shield-lock text-warning me-2"></i> ADMIN PANEL
        </a>

        <ul class="nav flex-column mb-auto">
            
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>

            <div class="section-header">Pengguna</div>
            <li class="nav-item">
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i> Data User & Admin
                </a>
            </li>

            <div class="section-header">Monitoring</div>
            <li class="nav-item">
                <a href="{{ route('admin.transactions.index') }}" class="nav-link {{ request()->routeIs('admin.transactions.*') ? 'active' : '' }}">
                    <i class="bi bi-receipt"></i> Transaksi
                </a>
            </li>

            <div class="section-header">Integrasi API</div>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-toggle="collapse" href="#menuIntegration">
                    <i class="bi bi-hdd-network"></i> Integration 
                    <i class="bi bi-chevron-down ms-auto small"></i>
                </a>
                <div class="collapse" id="menuIntegration">
                    <ul class="nav flex-column submenu">
                        <li class="nav-item">
                            <a href="{{ route('admin.integration.digiflazz') }}" class="nav-link">
                                <i class="bi bi-box-seam"></i> Supplier (Digiflazz)
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.integration.tripay') }}" class="nav-link">
                                <i class="bi bi-credit-card"></i> Payment (Tripay)
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <div class="section-header">Produk Game</div>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-toggle="collapse" href="#menuGame">
                    <i class="bi bi-controller"></i> Game Features
                    <i class="bi bi-chevron-down ms-auto small"></i>
                </a>
                <div class="collapse" id="menuGame">
                    <ul class="nav flex-column submenu">
                        <li class="nav-item">
                            <a href="{{ route('admin.games.index') }}" class="nav-link">
                                <i class="bi bi-joystick"></i> CRUD Services (Game)
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.products.index') }}" class="nav-link">
                                <i class="bi bi-gem"></i> CRUD Products (Item)
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ route('admin.promos.index') }}" class="nav-link {{ request()->is('admin/promos*') ? 'active' : '' }}">
                                <i class="bi bi-ticket-perforated-fill me-2"></i>
                                Kode Promo / Voucher
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <div class="section-header">Pengaturan</div>
            <li class="nav-item">
                <a href="{{ route('admin.config.web') }}" class="nav-link">
                    <i class="bi bi-globe"></i> Website Config
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.config.server') }}" class="nav-link">
                    <i class="bi bi-server"></i> Server Config
                </a>
            </li>
        </ul>

        <div class="p-3 border-top border-secondary border-opacity-25">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger w-100 btn-sm fw-bold">
                    <i class="bi bi-box-arrow-left"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <div class="main-content">
        <nav class="navbar navbar-light bg-white shadow-sm mb-4 rounded px-3">
            <span class="navbar-brand mb-0 h1 fs-6">Halo, <strong class="text-primary">{{ Auth::user()->name ?? 'Admin' }}</strong></span>
            <span class="badge bg-success">Status: Online</span>
        </nav>

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>