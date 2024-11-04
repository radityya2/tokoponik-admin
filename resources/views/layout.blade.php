<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite('resources/css/app.css')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100">
    <!-- Sidebar -->
    <aside id="sidebar" class="fixed left-0 top-0 h-screen w-64 bg-green-600 text-white transition-transform duration-300 z-50">
        <!-- Logo -->
        <div class="flex items-center gap-3 p-5 mb-6">
            <div class="bg-white p-2 rounded-lg">
                <img src="assets/img/logo.png" alt="Logo" class="w-8 h-8">
            </div>
            <span class="text-2xl font-bold text-white">Tokoponik</span>
        </div>

        <!-- Menu Label -->
        <div class="px-5 mb-4">
            <p class="text-xs text-green-100 uppercase">Menu</p>
        </div>

        <!-- Navigation -->
        <nav class="px-3">
            <div class="mb-4">
            <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 p-3 rounded-lg hover:bg-green-700 {{ request()->routeIs('dashboard') ? 'bg-green-700' : '' }}">
                        <i class="bi bi-grid text-xl"></i>
                        <span>Dashboard</span>
                    </a>
            </div>
            <!-- eCommerce Section -->
            <div class="mb-4">
                <p class="px-3 py-2 text-sm text-green-100">eCommerce</p>
                <a href="{{ route('product.index') }}"
                   class="flex items-center gap-3 p-3 rounded-lg hover:bg-green-700 {{ request()->routeIs('product.*') ? 'bg-green-700' : '' }}">
                    <i class="bi bi-box text-xl"></i>
                    <span>Products</span>
                </a>
                <a href="{{ route('user.index') }}"
                   class="flex items-center gap-3 p-3 rounded-lg hover:bg-green-700 {{ request()->routeIs('user.*') ? 'bg-green-700' : '' }}">
                    <i class="bi bi-people text-xl"></i>
                    <span>Users</span>
                </a>
                <a href="{{ route('blog.index') }}"
                   class="flex items-center gap-3 p-3 rounded-lg hover:bg-green-700 {{ request()->routeIs('blog.*') ? 'bg-green-700' : '' }}">
                    <i class="bi bi-file-text text-xl"></i>
                    <span>Blog</span>
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
                <button class="p-2 hover:bg-gray-100 rounded-full">
                    <i class="bi bi-box-arrow-right text-xl"></i>
                </button>
                <div class="flex items-center gap-3">
                    <div class="text-right">
                        <p class="font-medium">Admin User</p>
                        <p class="text-sm text-gray-500">Administrator</p>
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
</body>
</html>
