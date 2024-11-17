@extends('layout')

@section('title')
    Data Bank
@endsection

@section('content')
    <div class="flex-1 p-8 bg-pastel-50">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-forest-700">All Bank Account</h1>

            <div class="flex items-center space-x-6">
                <input type="text"
                    id="searchInput"
                    placeholder="Search for owner"
                    onkeyup="searchBanks()"
                    class="bg-white border border-pastel-200 text-forest-600 px-5 py-2.5 rounded-lg focus:outline-none focus:border-forest-500 focus:ring-2 focus:ring-forest-200 transition-all duration-200">

                <a href="{{ route('bank.create') }}">
                    <button class="bg-emerald-600 hover:bg-emerald-500 text-white px-6 py-2.5 rounded-lg transition duration-200 font-medium shadow-sm hover:shadow-md">
                        Add new bank
                    </button>
                </a>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <table id="bankTable" class="w-full">
            <thead>
                    <tr class="bg-forest-500 text-white">
                        <th class="py-4 px-6 text-left font-medium">No</th>
                        <th class="py-4 px-6 text-left font-medium">Owner Name</th>
                        <th class="py-4 px-6 text-left font-medium">Bank Name</th>
                        <th class="py-4 px-6 text-left font-medium">Number</th>
                        <th class="py-4 px-6 text-left font-medium">Action</th>
                    </tr>
                </thead>
                <tbody id="bankTableBody">
                    <!-- Data akan diisi melalui AJAX -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
    function searchBanks() {
        let input = document.getElementById('searchInput');
        let filter = input.value.toLowerCase();
        let tbody = document.getElementById('bankTableBody');
        let tr = tbody.getElementsByTagName('tr');

        for (let i = 0; i < tr.length; i++) {
            let tdName = tr[i].getElementsByTagName('td')[1]; // kolom nama pemilik
            if (tdName) {
                let txtValue = tdName.textContent || tdName.innerText;
                if (txtValue.toLowerCase().indexOf(filter) > -1) {
                    tr[i].style.display = '';
                } else {
                    tr[i].style.display = 'none';
                }
            }
        }
    }
    </script>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Fungsi untuk memuat data bank
        function loadBanks() {
            const token = localStorage.getItem('token');

            $.ajax({
                url: 'https://restapi-tokoponik-aqfsagdnfph3cgd8.australiaeast-01.azurewebsites.net/api/auth/banks',
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                },
                success: function(response) {
                    var tbody = $('#bankTableBody');
                    tbody.empty();

                    if (response.data && response.data.length > 0) {
                        response.data.forEach(function(bank, index) {
                            var row = `
                                <tr class="border-b border-gray-100 hover:bg-gray-50 text-sm">
                                    <td class="py-4 px-6">${index + 1}</td>
                                    <td class="py-4 px-6">${bank.owner_name || '-'}</td>
                                    <td class="py-4 px-6">${bank.bank_name || '-'}</td>
                                    <td class="py-4 px-6">${bank.number || '-'}</td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center space-x-4">
                                            <a href="javascript:void(0)" onclick="editBank(${bank.id})"
                                               class="text-forest-500 hover:text-yellow-500 transition duration-200"
                                               title="Edit Bank">
                                                <i class="bi bi-pencil-square text-xl"></i>
                                            </a>
                                            <a href="javascript:void(0)" onclick="deleteBank(${bank.id})"
                                               class="text-red-500 hover:text-red-700 transition duration-200"
                                               title="Delete Bank">
                                                <i class="bi bi-trash3-fill text-xl"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            `;
                            tbody.append(row);
                        });
                    } else {
                        tbody.html('<tr><td colspan="5" class="text-center py-8 text-gray-500">No data exists</td></tr>');
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr);
                    if (xhr.status === 401) {
                        localStorage.removeItem('token');
                        window.location.href = '/login';
                    } else {
                        $('#bankTableBody').html('<tr><td colspan="5" class="text-center py-8 text-red-500">Error when loading data</td></tr>');
                    }
                }
            });
        }

        // Fungsi untuk menghapus bank
        window.deleteBank = function(id) {
            if (confirm('Yakin ingin menghapus bank ini?')) {
                const token = localStorage.getItem('token');

                $.ajax({
                    url: `https://restapi-tokoponik-aqfsagdnfph3cgd8.australiaeast-01.azurewebsites.net/api/auth/banks/${id}/destroy`,
                    method: 'DELETE',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        loadBanks();
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr);
                        if (xhr.status === 401) {
                            localStorage.removeItem('token');
                            window.location.href = '/login';
                        } else {
                            alert('Gagal menghapus bank: ' + (xhr.responseJSON?.message || 'Terjadi kesalahan'));
                        }
                    }
                });
            }
        }

        // Fungsi untuk edit bank
        window.editBank = function(id) {
            const token = localStorage.getItem('token');
            console.log('Token saat edit:', token); // Debugging

            if (!token) {
                console.log('Token tidak ditemukan'); // Debugging
                window.location.href = '/login';
                return;
            }

            $.ajax({
                url: `https://restapi-tokoponik-aqfsagdnfph3cgd8.australiaeast-01.azurewebsites.net/api/auth/banks/${id}`,
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                },
                success: function(response) {
                    console.log('Edit berhasil:', response); // Debugging
                    window.location.href = `/bank/${id}/edit`;
                },
                error: function(xhr) {
                    console.error('Edit error:', xhr); // Debugging
                    if (xhr.status === 401) {
                        localStorage.removeItem('token');
                        window.location.href = '/login';
                    } else {
                        alert('Terjadi kesalahan saat mengakses data bank');
                    }
                }
            });
        }

        // Fungsi pencarian (menggunakan fungsi yang sudah ada)
        $("#searchInput").on("keyup", searchBanks);

        // Load data saat halaman dimuat
        loadBanks();
    });
</script>
@endpush

