<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite('resources/css/app.css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-gray-100">
    <!-- Sidebar -->
    <aside id="sidebar" class="fixed left-0 top-0 h-screen w-64 bg-forest-700 text-white transition-transform duration-300 z-50">
        <!-- Logo -->
        <div class="flex items-center gap-3 p-5 mb-6">
            <div class="bg-white p-2 rounded-lg">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="h-8 w-8">
            </div>
            <span class="text-2xl font-bold text-white">Tokoponik</span>
        </div>

        <!-- Menu Label -->
        <div class="px-5 mb-4">
            <p class="text-xs text-green-100 uppercase">Menu</p>
        </div>

        <!-- Navigation -->
        <nav class="px-3">
            <!-- Dashboard -->
            <div class="mb-4">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-pastel-400 hover:bg-opacity-50 {{ request()->routeIs('dashboard') ? 'bg-pastel-400 bg-opacity-50' : '' }}">
                    <i class="bi bi-grid text-xl"></i>
                    <span>Dashboard</span>
                </a>
            </div>

            <!-- eCommerce Section -->
            <div class="mb-4">
                <p class="px-3 py-2 text-sm text-green-100">eCommerce</p>

                <!-- Products -->
                <a href="{{ route('product.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-pastel-400 hover:bg-opacity-50 {{ request()->routeIs('product.*') ? 'bg-pastel-400 bg-opacity-50' : '' }} mb-2">
                    <i class="bi bi-box-seam text-xl"></i>
                    <span>Products</span>
                </a>

                <!-- Users -->
                <a href="{{ route('user.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-pastel-400 hover:bg-opacity-50 {{ request()->routeIs('user.*') ? 'bg-pastel-400 bg-opacity-50' : '' }} mb-2">
                    <i class="bi bi-people text-xl"></i>
                    <span>Users</span>
                </a>

                <!-- Blog -->
                <a href="{{ route('blog.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-pastel-400 hover:bg-opacity-50 {{ request()->routeIs('blog.*') ? 'bg-pastel-400 bg-opacity-50' : '' }} mb-2">
                    <i class="bi bi-file-earmark-text text-xl"></i>
                    <span>Blog</span>
                </a>

                <a href="{{ route('transaction.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-pastel-400 hover:bg-opacity-50 {{ request()->routeIs('transaction.*') ? 'bg-pastel-400 bg-opacity-50' : '' }} mb-2">
                    <i class="bi bi-receipt-cutoff text-xl"></i>
                    <span>Transaction</span>
                </a>

                <a href="{{ route('bank.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-pastel-400 hover:bg-opacity-50 {{ request()->routeIs('bank.*') ? 'bg-pastel-400 bg-opacity-50' : '' }} mb-2">
                    <i class="bi bi-credit-card text-xl"></i>
                    <span>Bank Account</span>
                </a>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <main id="main-content" class="ml-64 min-h-screen">
        <!-- Top Navigation -->
        <nav class="bg-white shadow-sm px-6 py-3 flex justify-between items-center">
            <!-- Search Bar -->
            <div class="flex-1 max-w-2xl">

            </div>

            <!-- Right Navigation Items -->
            <div class="flex items-center gap-4">
                <button class="p-2 hover:bg-gray-100 rounded-full logout-btn">
                    <i class="bi bi-door-open text-xl"></i>
                </button>
                <div class="flex items-center gap-3">
                    <div class="text-right">
                        <p class="font-medium user-name">Loading...</p>
                        <p class="text-sm text-gray-500 user-role">Loading...</p>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="p-6">
            @yield('content')
        </div>
    </main>

    @stack('scripts')  <!-- Pastikan ini ada -->
    <script>
    $(document).ready(function() {
        // Cek apakah sedang di halaman login
        if (window.location.pathname === '/login') {
            return;
        }

        const token = localStorage.getItem('token');
        const userId = localStorage.getItem('user_id');

        if (!token || !userId) {
            window.location.href = '/login';
            return;
        }

        // Set default headers untuk semua request ajax
        $.ajaxSetup({
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            }
        });

        // Ambil data user untuk header
        $.ajax({
            url: `http://127.0.0.1:8000/api/auth/users/id/info`,
            method: 'GET',
            success: function(response) {
                if (response.status === 200) {
                    $('.user-name').text(response.data.username);
                    $('.user-role').text(response.data.role);
                }
            },
            error: function(xhr) {
                console.error('Error:', xhr);
                if (xhr.status === 401) {
                    localStorage.removeItem('token');
                    localStorage.removeItem('user_id');
                    window.location.href = '/login';
                }
            }
        });

        // Tambahkan ini untuk memastikan nilai userId dan token
        console.log('User ID:', userId);
        console.log('Token:', token);

        // Handle logout
        $('.logout-btn').click(function(e) {
            e.preventDefault();
            localStorage.removeItem('token');
            window.location.href = '/login';
        });
    });




    </script>
</body>
</html>
