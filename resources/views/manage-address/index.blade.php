@extends('layout')

@section('title')
    Data Address
@endsection

@section('content')
<div class="flex-1 p-8 bg-pastel-50">
    <div class="mb-6 flex justify-between items-center">
        <div class="flex items-center gap-4">
            <h1 class="text-3xl font-bold text-forest-700">All Address</h1>
        </div>
        <div class="flex items-center space-x-6">
            <button onclick="window.location.href='{{ route('user.index') }}'" class="bg-gray-500 hover:bg-gray-400 text-white px-6 py-2.5 rounded-lg transition duration-200 flex items-center gap-2">
                Back
            </button>
            <button onclick="window.location.href='{{ route('address.create', ['user_id' => request()->segment(count(request()->segments()))]) }}'" id="addAddressBtn" class="bg-emerald-600 hover:bg-emerald-500 text-white px-6 py-2.5 rounded-lg transition duration-200 font-medium shadow-sm hover:shadow-md">
                Add new address
            </button>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="bg-forest-500 text-white">
                    <th class="px-4 py-3 text-left font-medium">No</th>
                    <th class="px-4 py-3 text-left font-medium">Receiver Name</th>
                    <th class="px-4 py-3 text-left font-medium">Address</th>
                    <th class="px-4 py-3 text-left font-medium">Note</th>
                    <th class="px-4 py-3 text-left font-medium">Province</th>
                    <th class="px-4 py-3 text-left font-medium">District</th>
                    <th class="px-4 py-3 text-left font-medium">Subdistrict</th>
                    <th class="px-4 py-3 text-left font-medium">Postcode</th>
                    <th class="px-4 py-3 text-left font-medium">Action</th>
                </tr>
            </thead>
            <tbody id="addressTableBody">
                <!-- Data akan diisi melalui AJAX -->
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Ambil user_id dari URL
    const pathSegments = window.location.pathname.split('/');
    const userId = pathSegments[pathSegments.length - 1];
    const token = localStorage.getItem('token');

    console.log('User ID from URL:', userId);

    function loadAddresses() {
        const tbody = document.getElementById('addressTableBody');
        tbody.innerHTML = `
            <tr>
                <td colspan="9" class="text-center py-4">Loading...</td>
            </tr>
        `;

        // Ubah endpoint untuk mengambil address berdasarkan user_id dari parameter
        const apiUrl = `http://127.0.0.1:8000/api/auth/addresses/user/${userId}`;

        $.ajax({
            url: apiUrl,
            type: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            },
            success: function(response) {
                console.log('Raw Response:', response);
                const addresses = response.data;

                tbody.innerHTML = '';

                if (addresses && addresses.length > 0) {
                    addresses.forEach((address, index) => {
                        const row = `
                            <tr class="border-b border-gray-100 hover:bg-gray-50 text-sm">
                                <td class="px-4 py-3">${index + 1}</td>
                                <td class="px-4 py-3">${address.receiver_name || '-'}</td>
                                <td class="px-4 py-3">${address.address || '-'}</td>
                                <td class="px-4 py-3">${address.note || '-'}</td>
                                <td class="px-4 py-3">${address.province || '-'}</td>
                                <td class="px-4 py-3">${address.district || '-'}</td>
                                <td class="px-4 py-3">${address.subdistrict || '-'}</td>
                                <td class="px-4 py-3">${address.post_code || '-'}</td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-2">
                                        <button onclick="editAddress(${address.id})"
                                                class="text-forest-500 hover:text-yellow-700">
                                            <i class="bi bi-pencil-square text-xl"></i>
                                        </button>
                                        <button onclick="deleteAddress(${address.id})"
                                                class="text-red-500 hover:text-red-700">
                                            <i class="bi bi-trash3-fill text-xl"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        `;
                        tbody.insertAdjacentHTML('beforeend', row);
                    });
                } else {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="9" class="text-center py-4">Tidak ada data alamat</td>
                        </tr>
                    `;
                }
            },
            error: function(xhr, status, error) {
                console.error('Ajax Error:', {
                    status: xhr.status,
                    statusText: xhr.statusText,
                    responseText: xhr.responseText,
                    error: error
                });
                tbody.innerHTML = `
                    <tr>
                        <td colspan="9" class="text-center py-4 text-red-500">
                            Error saat memuat data: ${error}
                        </td>
                    </tr>
                `;
            }
        });
    }

    // Fungsi untuk delete address
    window.deleteAddress = function(addressId) {
        if (!confirm('Apakah Anda yakin ingin menghapus alamat ini?')) {
            return;
        }

        const token = localStorage.getItem('token');


        $.ajax({
            url: `http://127.0.0.1:8000/api/auth/addresses/${addressId}/destroy`,
            type: 'DELETE',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            },
            success: function(response) {
                console.log('Delete Response:', response);

                // Reload data setelah delete berhasil
                loadAddresses();
            },
            error: function(xhr, status, error) {
                console.error('Delete Error:', {
                    status: xhr.status,
                    statusText: xhr.statusText,
                    responseText: xhr.responseText,
                    error: error
                });
                alert('Gagal menghapus alamat: ' + error);
            }
        });
    }

    // Fungsi untuk edit address
    window.editAddress = function(id) {
        window.location.href = `/address/${id}/edit`;
    }

    // Load data when page loads
    loadAddresses();
});
</script>
@endpush
