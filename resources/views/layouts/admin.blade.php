<!doctype html>
<html lang="id" data-bs-theme="dark"> <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel - MariBaca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        body { min-height: 100vh; overflow-x: hidden; background-color: #1a1d20; color: #e0e0e0; }
        .sidebar {
            width: 260px;
            background: #0f1113;
            min-height: 100vh;
            position: fixed;
            border-right: 1px solid #2d3238;
        }
        .main-content { margin-left: 260px; padding: 2rem; }
        .nav-link { color: #a0a0a0; padding: 12px 20px; font-weight: 500; }
        .nav-link:hover, .nav-link.active {
            background-color: #212529; color: #ffc107; border-left: 4px solid #ffc107;
        }
        .admin-card { background-color: #212529; border: 1px solid #2d3238; border-radius: 8px; }
        .admin-table th { background-color: #2c3036; color: white; border-bottom: 2px solid #495057; }
        .admin-table td { background-color: #212529; color: #ddd; border-bottom: 1px solid #343a40; }
        @media (max-width: 768px) {
            .sidebar {
                left: -260px;
                transition: 0.3s;
                z-index: 1050;
            }
            .sidebar.active {
                left: 0;
            }
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }
            .sidebar-overlay {
                display: none;
                position: fixed; top: 0; left: 0; right: 0; bottom: 0;
                background: rgba(0,0,0,0.5); z-index: 1040;
            }
            .sidebar-overlay.active { display: block; }
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <div class="sidebar-overlay" onclick="toggleSidebar()"></div>
    
        <div class="sidebar d-flex flex-column p-3" id="adminSidebar">
            <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center mb-4 text-white text-decoration-none border-bottom pb-3 border-secondary">
                <i class="bi bi-shield-lock-fill fs-3 text-warning me-2"></i>
                <span class="fs-5 fw-bold">Admin Panel</span>
            </a>
            
            <ul class="nav flex-column mb-auto">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                        <i class="bi bi-people-fill me-2"></i> Kelola User
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.stories') }}" class="nav-link {{ request()->routeIs('admin.stories') ? 'active' : '' }}">
                        <i class="bi bi-book-half me-2"></i> Kelola Cerita
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.comments') }}" class="nav-link {{ request()->routeIs('admin.comments') ? 'active' : '' }}">
                        <i class="bi bi-chat-left-text-fill me-2"></i> Komentar Live
                    </a>
                </li>
            </ul>
            
            <div class="mt-auto border-top pt-3 border-secondary">
                <div class="d-flex align-items-center text-white small mb-3">
                    <div class="bg-warning rounded-circle me-2" style="width: 30px; height: 30px; display:flex; align-items:center; justify-content:center; color:black; font-weight:bold;">A</div>
                    <div>{{ Auth::user()->name }}</div>
                </div>
                <a href="{{ url('/') }}" class="btn btn-outline-secondary w-100 btn-sm mb-2"><i class="bi bi-globe me-2"></i>Lihat Website</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-danger w-100 btn-sm fw-bold">Keluar</button>
                </form>
            </div>
        </div>

        <div class="main-content w-100">
            <button class="btn btn-dark d-md-none mb-3 border border-secondary" onclick="toggleSidebar()">
                <i class="bi bi-list fs-4"></i> Menu
            </button>
        
            @yield('content')
        </div>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('adminSidebar').classList.toggle('active');
            document.querySelector('.sidebar-overlay').classList.toggle('active');
        }
    </script>
</body>
</html>