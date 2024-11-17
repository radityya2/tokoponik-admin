@extends('layout')

@section('title')
    All Transactions
@endsection

@section('content')
<!-- Main Content -->
<div class="flex-1 p-8 bg-pastel-50">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-forest-700">All Transactions</h1>

        <div class="flex items-center space-x-6">
            <input type="text"
                id="searchInput"
                placeholder="Search by username"
                class="bg-white border border-pastel-200 text-forest-600 px-6 py-2.5 rounded-lg focus:outline-none focus:border-forest-500">
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="bg-forest-500 text-white">
                    <th class="py-4 px-6 text-left font-medium">No</th>
                    <th class="py-4 px-6 text-left font-medium">User</th>
                    <th class="py-4 px-6 text-left font-medium">Bank</th>
                    <th class="py-4 px-6 text-left font-medium">Total</th>
                    <th class="py-4 px-6 text-left font-medium">Status</th>
                    <th class="py-4 px-6 text-left font-medium">Proof</th>
                    <th class="py-4 px-6 text-left font-medium">Action</th>
                </tr>
            </thead>
            <tbody id="transactionTableBody" class="divide-y divide-gray-100">
                <!-- Data akan diisi melalui AJAX -->
            </tbody>
        </table>

    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Tambahkan event listener untuk input pencarian
    $('#searchInput').on('keyup', function() {
        const searchTerm = $(this).val().toLowerCase();
        filterTransactions(searchTerm);
    });

    function filterTransactions(searchTerm) {
        $('#transactionTableBody tr').each(function() {
            const username = $(this).find('td:eq(1)').text().toLowerCase();
            if (username.includes(searchTerm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

    function loadTransactions() {
        const token = localStorage.getItem('token');

        $.ajax({
            url: 'https://restapi-tokoponik-aqfsagdnfph3cgd8.australiaeast-01.azurewebsites.net/api/auth/transactions',
            method: 'GET',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            },
            success: function(response) {
                console.log('Seluruh response:', response);
                var tbody = $('#transactionTableBody');
                tbody.empty();

                if (response.data && response.data.length > 0) {
                    response.data.forEach(function(transaction, index) {
                        const proofPath = transaction.proof
                            ? `/storage/${transaction.proof}`
                            : null;

                        var row = `
                            <tr class="border-b border-gray-100 hover:bg-gray-50 text-sm">
                                <td class="py-4 px-6">${index + 1}</td>
                                <td class="py-4 px-6">${transaction.user ? transaction.user.username : '-'}</td>
                                <td class="py-4 px-6">${transaction.bank?.bank_name || '-'}</td>
                                <td class="py-4 px-6">Rp ${formatNumber(transaction.grand_total)}</td>
                                <td class="py-4 px-6">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium ${getStatusClass(transaction.status)}">
                                        ${transaction.status}
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    <button onclick="showProof('${proofPath}')"
                                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200 text-sm font-medium">
                                        <i class="bi bi-search text-sm" style="margin-right: 0.25rem;"></i>
                                        Proof of Payment
                                    </button>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center space-x-3">
                                        <div class="relative">
                                            <select name="status" onchange="updateStatus(${transaction.id}, this.value)"
                                                class="block w-full px-4 py-2 text-sm text-gray-700 border border-emerald-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 hover:bg-gray-200">
                                                <option value="belum dibayar" ${transaction.status === 'belum dibayar' ? 'selected' : ''}>Belum Dibayar</option>
                                                <option value="menunggu verifikasi" ${transaction.status === 'menunggu verifikasi' ? 'selected' : ''}>Menunggu Verifikasi</option>
                                                <option value="dikemas" ${transaction.status === 'dikemas' ? 'selected' : ''}>Dikemas</option>
                                                <option value="dikirim" ${transaction.status === 'dikirim' ? 'selected' : ''}>Dikirim</option>
                                                <option value="selesai" ${transaction.status === 'selesai' ? 'selected' : ''}>Selesai</option>
                                                <option value="dibatalkan" ${transaction.status === 'dibatalkan' ? 'selected' : ''}>Dibatalkan</option>
                                            </select>
                                        </div>
                                        <a href="javascript:void(0)" onclick="deleteTransaction(${transaction.id})"
                                           class="text-red-500 hover:text-red-700 transition duration-200"
                                           title="Delete Transaction">
                                            <i class="bi bi-trash3-fill text-xl"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        `;
                        tbody.append(row);
                    });
                } else {
                    tbody.html('<tr><td colspan="7" class="text-center py-8 text-gray-500">No data exists</td></tr>');
                }
            },
            error: function(xhr) {
                console.error('Error:', xhr);
                if (xhr.status === 401) {
                    localStorage.removeItem('token');
                    window.location.href = '/login';
                } else {
                    $('#transactionTableBody').html('<tr><td colspan="7" class="text-center py-8 text-red-500">Error loading data</td></tr>');
                }
            }
        });
    }

    // Fungsi format angka
    function formatNumber(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }

    // Fungsi untuk mendapatkan class status
    function getStatusClass(status) {
        const statusClasses = {
            'belum dibayar': 'bg-red-500 text-white',
            'menunggu verifikasi': 'bg-yellow-700 text-white',
            'dikemas': 'bg-yellow-500 text-white',
            'dikirim': 'bg-blue-500 text-white',
            'selesai': 'bg-green-500 text-white',
            'dibatalkan': 'bg-gray-500 text-white'
        };
        return statusClasses[status] || 'bg-gray-500 text-white';
    }

    // Tambahkan fungsi untuk menampilkan proof
    window.showProof = function(proofPath) {
        if (!proofPath) {
            Swal.fire({
                title: 'Info',
                text: 'Proof of Payment not uploaded yet',
                icon: 'info',
                confirmButtonText: 'OK'
            });
            return;
        }

        // Pastikan path lengkap
        const baseUrl = 'https://restapi-tokoponik-aqfsagdnfph3cgd8.australiaeast-01.azurewebsites.net';
        const fullImageUrl = proofPath.startsWith('http') ? proofPath : baseUrl + proofPath;

        // Cek apakah gambar bisa dimuat
        const img = new Image();
        img.onload = function() {
            Swal.fire({
                title: 'Proof of Payment',
                imageUrl: fullImageUrl,
                imageWidth: 400,
                imageHeight: 400,
                imageAlt: 'Proof of Payment Image',
                confirmButtonText: 'Close'
            });
        };

        img.onerror = function() {
            Swal.fire({
                title: 'Error',
                text: 'Failed to load proof of payment image',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        };

        img.src = fullImageUrl;
    };

    // Fungsi untuk update status
    window.updateStatus = function(transactionId, newStatus) {
        const token = localStorage.getItem('token');

        $.ajax({
            url: `https://restapi-tokoponik-aqfsagdnfph3cgd8.australiaeast-01.azurewebsites.net/api/auth/transactions/${transactionId}/update-status`,
            method: 'POST',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            data: JSON.stringify({
                status: newStatus
            }),
            success: function(response) {
                Swal.fire({
                    title: 'Success!',
                    text: 'Transaction status has been successfully updated',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        loadTransactions(); // Reload data setelah update
                    }
                });
            },
            error: function(xhr) {
                console.error('Error:', xhr);
                Swal.fire({
                    title: 'Error!',
                    text: xhr.responseJSON?.message || 'Failed to update transaction status',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    };

    // Fungsi untuk menghapus transaksi
    window.deleteTransaction = function(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this transaction!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                const token = localStorage.getItem('token');

                $.ajax({
                    url: `https://restapi-tokoponik-aqfsagdnfph3cgd8.australiaeast-01.azurewebsites.net/api/auth/transactions/${id}/destroy`,
                    method: 'DELETE',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Transaction has been successfully deleted',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                loadTransactions(); // Reload data setelah hapus
                            }
                        });
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr);
                        Swal.fire({
                            title: 'Error!',
                            text: xhr.responseJSON?.message || 'Failed to delete transaction',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    };

    // Load data transactions saat halaman dimuat
    loadTransactions();
});
</script>
@endpush

