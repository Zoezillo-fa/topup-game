<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Store Game</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        /* Sidebar Styling */
        .sidebar {
            width: 260px;
            height: 100vh;
            background: #242733; /* Warna Dark Premium */
            position: fixed;
            top: 0; left: 0;
            color: #a0aaec;
            overflow-y: auto;
            z-index: 1050;
            transition: all 0.3s;
        }
        
        /* Main Content Styling */
        .main-content { 
            margin-left: 260px; 
            padding: 20px; 
            transition: all 0.3s;
        }

        /* Nav Link Styling */
        .sidebar .nav-link {
            color: #a0aaec;
            padding: 12px 20px;
            font-weight: 500;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: all 0.2s;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: rgba(255,255,255,0.05);
            color: #fff;
            border-left: 4px solid #facc15;
        }
        .sidebar .nav-link i { margin-right: 12px; font-size: 1.1rem; width: 20px; text-align: center; }
        
        /* Brand */
        .sidebar-brand {
            padding: 25px 20px;
            font-size: 1.25rem;
            font-weight: 800;
            color: #fff;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            margin-bottom: 15px;
            letter-spacing: 1px;
        }
        
        /* Section Header */
        .section-header {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 20px 20px 8px 20px;
            color: #6c757d;
            font-weight: 700;
        }
        
        /* Dropdown Submenu Level 1 */
        .submenu { background: rgba(0,0,0,0.15); }
        .submenu .nav-link { 
            font-size: 0.9rem; 
            padding: 10px 20px 10px 52px; /* Indentasi Level 1 */
            border-left: none !important;
        }
        .submenu .nav-link:hover, .submenu .nav-link.active {
            color: #facc15;
            background: transparent;
        }

        /* Dropdown Submenu Level 2 (Nested) */
        .submenu-nested { background: rgba(0,0,0,0.2); }
        .submenu-nested .nav-link {
            padding-left: 70px !important; /* Indentasi Level 2 Lebih Dalam */
            font-size: 0.85rem;
        }

        /* Scrollbar Halus */
        .sidebar::-webkit-scrollbar { width: 5px; }
        .sidebar::-webkit-scrollbar-track { background: #242733; }
        .sidebar::-webkit-scrollbar-thumb { background: #3e445b; border-radius: 10px; }

        /* Responsif untuk Mobile */
        @media (max-width: 768px) {
            .sidebar { margin-left: -260px; box-shadow: 5px 0 15px rgba(0,0,0,0.3); }
            .sidebar.show { margin-left: 0; }
            .main-content { margin-left: 0; }
            .sidebar-open-overlay {
                position: fixed;
                top: 0; left: 0; width: 100%; height: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 1040;
                display: none;
            }
            .sidebar-open-overlay.show { display: block; }
        }
    </style>
</head>
<body>

    {{-- Overlay Gelap untuk Mobile --}}
    <div id="mobileOverlay" class="sidebar-open-overlay" onclick="toggleSidebar()"></div>

    <div class="sidebar d-flex flex-column" id="sidebarMenu">
        <a href="#" class="sidebar-brand text-decoration-none d-flex align-items-center justify-content-center">
            <i class="bi bi-shield-lock-fill text-warning me-2 fs-3"></i> 
            <span>ADMIN PANEL</span>
        </a>

        <ul class="nav flex-column mb-auto pb-5">
            
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

            {{-- MENU INTEGRASI --}}
            <div class="section-header">Integrasi API</div>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/integration*') ? '' : 'collapsed' }}" data-bs-toggle="collapse" href="#menuIntegration" aria-expanded="{{ request()->is('admin/integration*') ? 'true' : 'false' }}">
                    <i class="bi bi-hdd-network"></i> Integration 
                    <i class="bi bi-chevron-down ms-auto small"></i>
                </a>
                <div class="collapse {{ request()->is('admin/integration*') ? 'show' : '' }}" id="menuIntegration">
                    <ul class="nav flex-column submenu">
                        
                        {{-- 1. Supplier (Digiflazz) --}}
                        <li class="nav-item">
                            <a href="{{ route('admin.integration.digiflazz') }}" class="nav-link {{ request()->routeIs('admin.integration.digiflazz') ? 'active' : '' }}">
                                <i class="bi bi-box-seam"></i> Supplier (Digiflazz)
                            </a>
                        </li>

                        {{-- 2. API (Apigames) --}}
                        <li class="nav-item">
                            <a href="{{ route('admin.integration.apigames') }}" class="nav-link {{ request()->routeIs('admin.integration.apigames') ? 'active' : '' }}">
                                <i class="bi bi-person-check-fill"></i> API (Apigames)
                            </a>
                        </li>

                        {{-- 3. Payment Gateway (NESTED DROPDOWN) --}}
                        <li class="nav-item">
                            {{-- LOGIC: Tambahkan 'admin/integration/midtrans*' agar menu induk tetap terbuka --}}
                            <a class="nav-link {{ request()->is('admin/integration/tripay*', 'admin/integration/xendit*', 'admin/integration/midtrans*') ? '' : 'collapsed' }}" data-bs-toggle="collapse" href="#menuPaymentGateway" aria-expanded="{{ request()->is('admin/integration/tripay*', 'admin/integration/xendit*', 'admin/integration/midtrans*') ? 'true' : 'false' }}">
                                <i class="bi bi-credit-card-2-front"></i> Payment Gateway
                                <i class="bi bi-chevron-down ms-auto small" style="font-size: 0.8em;"></i>
                            </a>
                            
                            {{-- Sub-Menu Level 2 --}}
                            <div class="collapse {{ request()->is('admin/integration/tripay*', 'admin/integration/xendit*', 'admin/integration/midtrans*') ? 'show' : '' }}" id="menuPaymentGateway">
                                <ul class="nav flex-column submenu-nested">
                                    <li class="nav-item">
                                        <a href="{{ route('admin.integration.tripay') }}" class="nav-link {{ request()->routeIs('admin.integration.tripay') ? 'active' : '' }}">
                                            <i class="bi bi-arrow-return-right small me-2"></i> Tripay
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.integration.xendit') }}" class="nav-link {{ request()->routeIs('admin.integration.xendit') ? 'active' : '' }}">
                                            <i class="bi bi-arrow-return-right small me-2"></i> Xendit
                                        </a>
                                    </li>
                                    {{-- NEW: MIDTRANS MENU --}}
                                    <li class="nav-item">
                                        <a href="{{ route('admin.integration.midtrans') }}" class="nav-link {{ request()->routeIs('admin.integration.midtrans') ? 'active' : '' }}">
                                            <i class="bi bi-arrow-return-right small me-2"></i> Midtrans
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        {{-- 4. Metode Pembayaran --}}
                        <li class="nav-item">
                            <a href="{{ route('admin.integration.payment') }}" class="nav-link {{ request()->routeIs('admin.integration.payment*') ? 'active' : '' }}">
                                <i class="bi bi-wallet2"></i> Metode Pembayaran
                            </a>
                        </li>

                    </ul>
                </div>
            </li>

            <div class="section-header">Produk Game</div>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/games*', 'admin/products*', 'admin/promos*') ? '' : 'collapsed' }}" data-bs-toggle="collapse" href="#menuGame" aria-expanded="{{ request()->is('admin/games*', 'admin/products*', 'admin/promos*') ? 'true' : 'false' }}">
                    <i class="bi bi-controller"></i> Game Features
                    <i class="bi bi-chevron-down ms-auto small"></i>
                </a>
                <div class="collapse {{ request()->is('admin/games*', 'admin/products*', 'admin/promos*') ? 'show' : '' }}" id="menuGame">
                    <ul class="nav flex-column submenu">
                        <li class="nav-item">
                            <a href="{{ route('admin.games.index') }}" class="nav-link {{ request()->routeIs('admin.games.*') ? 'active' : '' }}">
                                <i class="bi bi-joystick"></i> Kelola Game
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                                <i class="bi bi-gem"></i> Kelola Produk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.promos.index') }}" class="nav-link {{ request()->routeIs('admin.promos.*') ? 'active' : '' }}">
                                <i class="bi bi-ticket-perforated-fill"></i> Kode Promo / Voucher
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <div class="section-header">Pengaturan</div>
            <li class="nav-item">
                <a href="{{ route('admin.config.web') }}" class="nav-link {{ request()->routeIs('admin.config.web') ? 'active' : '' }}">
                    <i class="bi bi-globe"></i> Website Config
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.config.server') }}" class="nav-link {{ request()->routeIs('admin.config.server') ? 'active' : '' }}">
                    <i class="bi bi-server"></i> Server Config
                </a>
            </li>
        </ul>

        <div class="p-3 border-top border-secondary border-opacity-25 mt-auto bg-dark">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger w-100 btn-sm fw-bold shadow-sm">
                    <i class="bi bi-box-arrow-left me-2"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <div class="main-content">
        <nav class="navbar navbar-light bg-white shadow-sm mb-4 rounded px-4 py-3 d-flex justify-content-between align-items-center">
            
            <button class="btn btn-outline-secondary d-md-none" type="button" id="sidebarToggle" onclick="toggleSidebar()">
                <i class="bi bi-list"></i>
            </button>

            <div>
                <span class="text-muted small d-block">Selamat Datang,</span>
                <span class="navbar-brand mb-0 h1 fs-5 text-dark">{{ Auth::user()->name ?? 'Administrator' }}</span>
            </div>
            
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                    <i class="bi bi-eye-fill me-1"></i> Lihat Website
                </a>
                <span class="badge bg-success rounded-pill px-3 py-2"><i class="bi bi-wifi me-1"></i> Online</span>
            </div>
        </nav>

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function toggleSidebar() {
            document.getElementById('sidebarMenu').classList.toggle('show');
            document.getElementById('mobileOverlay').classList.toggle('show');
        }

        document.addEventListener('click', function(event) {
            var sidebar = document.getElementById('sidebarMenu');
            var toggleBtn = document.getElementById('sidebarToggle');
            var overlay = document.getElementById('mobileOverlay');

            if (!sidebar.contains(event.target) && !toggleBtn.contains(event.target) && sidebar.classList.contains('show')) {
                if (event.target !== overlay) {
                    toggleSidebar();
                }
            }
        });
    </script>
</body>
</html>