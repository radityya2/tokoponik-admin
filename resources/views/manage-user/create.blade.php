@extends('layout')

@section('title')
    Create New User
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('user.index') }}" class="text-green-600 hover:text-green-800">Data User</a></li>
<li class="breadcrumb-item active">Create New User</li>
@endsection

@section('content')
    <div class="bg-green-50 rounded-lg shadow-md p-8">
        <div class="border-b border-gray-200 mb-6">
            <p class="text-gray-800 text-2xl font-bold mb-3">Form Add User</p>
        </div>

        <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-6">
                <label class="block text-gray-800 text-sm font-semibold mb-3" for="name">Name</label>
                <input type="text"
                    class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 @error('name') border-red-500 @enderror"
                    id="name"
                    name="name"
                    placeholder="Masukkan nama lengkap"
                    value="{{ old('name') }}">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-800 text-sm font-semibold mb-3" for="username">Username</label>
                <input type="text"
                    class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 @error('username') border-red-500 @enderror"
                    id="username"
                    name="username"
                    placeholder="Masukkan username"
                    value="{{ old('username') }}">
                @error('username')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-800 text-sm font-semibold mb-3" for="password">Password</label>
                <input type="password"
                    class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 @error('password') border-red-500 @enderror"
                    id="password"
                    name="password"
                    placeholder="Masukkan password">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-800 text-sm font-semibold mb-3" for="phone_number">Phone Number</label>
                <div class="flex">
                    <span class="inline-flex items-center px-4 py-2.5 text-gray-700 bg-gray-100 border border-r-0 rounded-l-lg font-medium">+62</span>
                    <input type="text"
                        class="flex-1 px-4 py-2.5 border rounded-r-lg focus:outline-none focus:ring-2 focus:ring-green-400 @error('phone_number') border-red-500 @enderror"
                        id="phone_number"
                        name="phone_number"
                        placeholder="Contoh: 81234567890"
                        value="{{ old('phone_number') }}">
                </div>
                @error('phone_number')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-800 text-sm font-semibold mb-3" for="role">Role</label>
                <select class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 @error('role') border-red-500 @enderror"
                    id="role"
                    name="role">
                    <option value="" disabled selected>Pilih role pengguna</option>
                    <option value="admin">Admin</option>
                    <option value="manager">Manager</option>
                    <option value="customer_service">Customer Service</option>
                    <option value="customer">Customer</option>
                </select>
                @error('role')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4 mt-8">
                <button type="submit" class="flex items-center px-6 py-2.5 bg-green-800 text-white rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Submit
                </button>
                <a href="{{ route('user.index') }}">
                    <button type="button" class="flex items-center px-6 py-2.5 bg-red-700 text-white rounded-lg hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back
                    </button>
                </a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('form').on('submit', function(e) {
        e.preventDefault();

        // Ambil nilai dari form
        const formData = {
            name: $('#name').val(),
            username: $('#username').val(),
            password: $('#password').val(),
            phone_number: $('#phone_number').val().replace(/^0+/, ''), // Hapus angka 0 di depan
            role: $('#role').val()
        };

        // Kirim request ke API
        $.ajax({
            url: 'http://127.0.0.1:8000/api/auth/users/store',
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            data: JSON.stringify(formData),
            success: function(response) {

                window.location.href = "{{ route('user.index') }}";

            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                if (response && response.errors) {
                    // Loop setiap error kecuali username yang sudah ada
                    Object.keys(response.errors).forEach(function(key) {
                        // Skip jika error terkait username yang sudah ada
                        if (key === 'username' && response.errors[key][0].includes('already')) {
                            return;
                        }
                        const errorMessage = response.errors[key][0];
                        $(`#${key}`).addClass('border-red-500');
                        $(`#${key}`).next('.text-red-500').remove();
                        $(`#${key}`).after(`<p class="text-red-500 text-xs mt-1">${errorMessage}</p>`);
                    });
                } else {
                    alert('Terjadi kesalahan saat menyimpan data');
                }
            }
        });
    });

    // Reset error state saat input berubah
    $('input, select').on('change', function() {
        $(this).removeClass('border-red-500');
        $(this).next('.text-red-500').remove();
    });
});
</script>
@endpush
