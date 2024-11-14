@extends('layout')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('title')
    Data User
@endsection

@section('content')
    <div class="flex-1 p-8 bg-pastel-50">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-forest-700">All Users</h1>

            <div class="flex items-center space-x-6">
                <input type="text"
                    id="searchInput"
                    placeholder="Search for users"
                    class="bg-white border border-pastel-200 text-forest-600 px-5 py-2.5 rounded-lg focus:outline-none focus:border-forest-500 focus:ring-2 focus:ring-forest-200 transition-all duration-200">

                <a href="{{ route('user.create') }}">
                    <button class="bg-emerald-600 hover:bg-emerald-500 text-white px-6 py-2.5 rounded-lg transition duration-200 font-medium shadow-sm hover:shadow-md">
                        Add new user
                    </button>
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <table id="userTable" class="w-full">
                <thead>
                    <tr class="bg-forest-500 text-white">
                        <th class="py-4 px-6 text-left font-medium">No</th>
                        <th class="py-4 px-6 text-left font-medium">Name</th>
                        <th class="py-4 px-6 text-left font-medium">Username</th>
                        <th class="py-4 px-6 text-left font-medium">Phone Number</th>
                        <th class="py-4 px-6 text-left font-medium">Role</th>
                        <th class="py-4 px-6 text-left font-medium">Action</th>
                    </tr>
                </thead>
                <tbody id="userTableBody" class="divide-y divide-gray-100">
                    <!-- Data akan diisi melalui AJAX -->
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    function loadUsers() {
        const token = localStorage.getItem('token');

        $.ajax({
            url: 'http://127.0.0.1:8000/api/auth/users',
            method: 'GET',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            success: function(response) {
                var tbody = $('#userTableBody');
                tbody.empty();

                if (response.data && response.data.length > 0) {
                    response.data.forEach(function(user, index) {
                        var row = `
                            <tr class="border-b border-gray-100 hover:bg-gray-50 text-sm">
                                <td class="py-4 px-6">${index + 1}</td>
                                <td class="py-4 px-6">${user.name || '-'}</td>
                                <td class="py-4 px-6">${user.username || '-'}</td>
                                <td class="py-4 px-6">${user.phone_number ? '+62 ' + user.phone_number.replace(/^0+/, '') : '-'}</td>
                                <td class="py-4 px-6">${user.role || '-'}</td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center space-x-3">
                                        <a href="/address/${user.id}" class="text-blue-500 hover:text-blue-800">
                                            <i class="bi bi-house-gear-fill text-xl"></i>
                                        </a>
                                        <a href="/user/${user.id}/edit" class="text-forest-500 hover:text-yellow-500">
                                            <i class="bi bi-pencil-square text-xl"></i>
                                        </a>
                                        <button onclick="deleteUser(${user.id})" class="text-red-500 hover:text-red-700">
                                            <i class="bi bi-trash3-fill text-xl"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        `;
                        tbody.append(row);
                    });
                } else {
                    tbody.html('<tr><td colspan="6" class="text-center py-8 text-gray-500">Tidak ada data</td></tr>');
                }
            },
            error: function(xhr) {
                console.error('Error:', xhr);
                if (xhr.status === 401) {
                    localStorage.removeItem('token');
                    window.location.href = '/login';
                } else {
                    $('#userTableBody').html('<tr><td colspan="6" class="text-center py-8 text-red-500">Error saat memuat data</td></tr>');
                }
            }
        });
    }

    // Fungsi untuk menghapus user
    window.deleteUser = function(id) {
        if (confirm('Yakin ingin menghapus user ini?')) {
            const token = localStorage.getItem('token');

            $.ajax({
                url: `http://127.0.0.1:8000/api/auth/users/${id}/destroy`,
                method: 'DELETE',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    loadUsers();
                    
                },
                error: function(xhr) {
                    console.error('Error:', xhr);
                    if (xhr.status === 401) {
                        localStorage.removeItem('token');
                        window.location.href = '/login';
                    } else {
                        alert('Gagal menghapus user: ' + (xhr.responseJSON?.message || 'Terjadi kesalahan'));
                    }
                }
            });
        }
    }

    // Fungsi pencarian
    $("#searchInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#userTableBody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    // Load data saat halaman dimuat
    loadUsers();
});
</script>
@endpush
