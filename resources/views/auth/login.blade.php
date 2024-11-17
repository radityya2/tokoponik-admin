<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Admin Dashboard</title>
    @vite('resources/css/app.css')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-pastel-50">
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full bg-white p-8 rounded-xl shadow-md">
            <!-- Logo dan Judul -->
            <div class="text-center mb-8">
                <div class="flex items-center justify-center gap-3 mb-6">
                    <div class="bg-forest-700 p-2 rounded-lg">
                        <img src="assets/img/logo.png" alt="Logo" class="w-8 h-8">
                    </div>
                    <span class="text-2xl font-bold text-forest-700">Tokoponik</span>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Welcome Back!</h2>
                <p class="text-gray-500 mt-2">Please sign in to your account</p>
            </div>

            <!-- Form Login -->
            <form id="loginForm" class="space-y-6">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                    <input type="text" id="username" name="username" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-forest-500 focus:border-forest-500"
                        placeholder="Enter your username">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-forest-500 focus:border-forest-500"
                        placeholder="Enter your password">
                </div>

                <div>
                    <button type="submit"
                        class="w-full bg-forest-700 text-white py-2.5 rounded-lg hover:bg-forest-800 focus:outline-none focus:ring-2 focus:ring-forest-500 focus:ring-offset-2 transition-colors duration-200">
                        Sign in
                    </button>
                </div>
            </form>

            <!-- Alert untuk error -->
            <div id="errorAlert" class="hidden mt-4 p-4 rounded-lg bg-red-100 text-red-700 text-sm"></div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();

            const username = $('#username').val();
            const password = $('#password').val();

            // Reset error message
            $('#errorAlert').addClass('hidden').text('');

            // Tambahkan header CSRF
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: 'http://127.0.0.1:8000/api/login',
                method: 'POST',
                data: {
                    username: username,
                    password: password
                },
                success: function(response) {
                    if (response.status === 200) {
                        // Simpan token dan data user
                        localStorage.setItem('token', response.data.token);
                        localStorage.setItem('user_id', response.data.user.id);
                        localStorage.setItem('user_role', response.data.user.role);

                        // Redirect ke dashboard
                        window.location.href = '/dashboard';
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr);
                    const response = xhr.responseJSON;
                    $('#errorAlert')
                        .removeClass('hidden')
                        .text(response?.message || 'Login gagal. Silakan cek kredensial Anda.');
                }
            });
        });
    });
    </script>
</body>
</html>
