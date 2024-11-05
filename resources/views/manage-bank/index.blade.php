@extends('layout')

@section('title')
    Data Bank
@endsection

@section('content')
    <div class="flex-1 p-8 bg-pastel-50">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-forest-700">Data Bank</h1>

            <div class="flex items-center space-x-6">
                <input type="text"
                    id="searchInput"
                    placeholder="Cari data bank"
                    onkeyup="searchBanks()"
                    class="bg-white border border-pastel-200 text-forest-600 px-5 py-2.5 rounded-lg focus:outline-none focus:border-forest-500 focus:ring-2 focus:ring-forest-200 transition-all duration-200">

                <a href="{{ route('bank.create') }}">
                    <button class="bg-emerald-600 hover:bg-emerald-500 text-white px-6 py-2.5 rounded-lg transition duration-200 font-medium shadow-sm hover:shadow-md">
                        Tambah Bank
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
                        <th class="py-4 px-6 text-left font-medium">Nama Pemilik</th>
                        <th class="py-4 px-6 text-left font-medium">Nomor Rekening</th>
                        <th class="py-4 px-6 text-left font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody id="bankTableBody" class="divide-y divide-gray-100">
                    @if ($banks->count() != 0)
                        @foreach ($banks as $bank)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 text-sm">
                            <td class="py-4 px-6">{{ $loop->iteration }}</td>
                            <td class="py-4 px-6">{{ $bank->owner_name }}</td>
                            <td class="py-4 px-6">{{ $bank->number }}</td>
                            <td class="py-4 px-6">
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('bank.edit', $bank->id) }}" class="tooltip" title="Edit Bank">
                                        <button class="bg-forest-500 hover:bg-forest-600 text-white px-4 py-2 rounded-lg transition duration-200 text-sm font-medium">
                                            Update
                                        </button>
                                    </a>
                                    <form action="{{ route('bank.destroy', $bank->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition duration-200 text-sm font-medium"
                                                onclick="return confirm('Yakin ingin menghapus data bank ini?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="text-center py-8 text-gray-500">Tidak ada data</td>
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
