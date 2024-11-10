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
                <tbody id="bankTableBody" class="divide-y divide-gray-100">
                    @if ($banks->count() != 0)
                        @foreach ($banks as $bank)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 text-sm">
                            <td class="py-4 px-6">{{ $loop->iteration }}</td>
                            <td class="py-4 px-6">{{ $bank->owner_name }}</td>
                            <td class="py-4 px-6">{{ $bank->bank_name }}</td>
                            <td class="py-4 px-6">{{ $bank->number }}</td>
                            <td class="py-4 px-6">
                            <div class="flex items-center space-x-4">
                                    <a href="{{ route('bank.edit', $bank->id) }}"
                                       class="text-forest-500 hover:text-yellow-500 transition duration-200"
                                       title="Edit Bank">
                                        <i class="bi bi-pencil-square text-xl"></i>
                                    </a>

                                    <a href="{{ route('bank.destroy', $bank->id) }}"
                                       onclick="return confirm('Ingin hapus bank?')"
                                       class="text-red-500 hover:text-red-700 transition duration-200"
                                       title="Delete bank">
                                        <i class="bi bi-trash3-fill text-xl"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="text-center py-8 text-gray-500">No data exists</td>
                        </tr>
                    @endif
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
