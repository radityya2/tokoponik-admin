<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Admin Dashboard</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-pastel-50">
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full bg-white p-8 rounded-xl shadow-md">
            <!-- Logo dan Judul -->
            <div class="text-center mb-8">
                <div class="flex items-center justify-center gap-3 mb-6">
                    <div class="bg-white p-2 rounded-lg border-2 border-forest-500">
                        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="w-8 h-8">
                    </div>
                    <span class="text-2xl font-bold text-forest-700">Tokoponik</span>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Welcome Back!</h2>
                <p class="text-gray-500 mt-2">Please sign in to your account</p>
            </div>

            <!-- Form Login -->
            <form id="loginForm" class="space-y-4">
                <div>
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-forest-500" required>
                </div>

                <div>
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-forest-500" required>
                </div>

                <div id="errorAlert" class="hidden p-4 text-red-500 bg-red-100 rounded-lg"></div>

                <button type="submit" class="w-full bg-forest-700 text-white py-2 rounded-lg hover:bg-forest-800">
                    Sign in
                </button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    $(document).ready(function() {
        $('#loginForm').on('submit', function(event) {
            event.preventDefault();

            const username = $('#username').val();
            const password = $('#password').val();

            // Reset error state
            $('#errorAlert').addClass('hidden');
            $('input').removeClass('border-red-500');

            // Validasi sederhana
            if (!username || !password) {
                $('#errorAlert').removeClass('hidden').text('Username dan password harus diisi');
                return;
            }

            $.ajax({
                url: 'https://restapi-tokoponik-aqfsagdnfph3cgd8.australiaeast-01.azurewebsites.net/api/login',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    username: username,
                    password: password
                }),
                success: function(response) {
                    if (response.status === 200) {
                        // Simpan token dan user_id ke localStorage
                        localStorage.setItem('token', response.data.token);
                        localStorage.setItem('user_id', response.data.user.id);

                        Swal.fire({
                            icon: 'success',
                            title: 'Login Berhasil!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = '/dashboard';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Login Gagal!',
                            text: response.message,
                            showConfirmButton: true
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    alert('An error occurred while logging in.');
                }
            });
        });
    });
    </script>
</body>
</html>
