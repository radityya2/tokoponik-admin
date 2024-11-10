@extends('layout')

@section('title')
    Data Address of {{ $user->name }}
@endsection

@section('content')
<!-- Main Content -->
<div class="flex-1 p-8 bg-pastel-50">
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-forest-700">All Address</h1>
        <div class="flex items-center space-x-6">
            <input type="text"
                id="searchInput"
                placeholder="Search for addresses"
                onkeyup="searchAddresses()"
                class="bg-white border border-pastel-200 text-forest-600 px-5 py-2.5 rounded-lg focus:outline-none focus:border-forest-500 focus:ring-2 focus:ring-forest-200 transition-all duration-200">
            <a href="{{ route('address.create', $user_id) }}">
                <button class="bg-emerald-600 hover:bg-emerald-500 text-white px-6 py-2.5 rounded-lg transition duration-200 font-medium shadow-sm hover:shadow-md">
                    Add new address
                </button>
            </a>
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
                @if ($addresses->count() != 0)
                    @foreach ($addresses as $a)
                    <tr class="border-b border-gray-100 hover:bg-gray-50 text-sm">
                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3">{{ $a->receiver_name }}</td>
                        <td class="px-4 py-3">{{ $a->address }}</td>
                        <td class="px-4 py-3">{{ $a->note ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $a->province }}</td>
                        <td class="px-4 py-3">{{ $a->district }}</td>
                        <td class="px-4 py-3">{{ $a->subdistrict }}</td>
                        <td class="px-4 py-3">{{ $a->postcode }}</td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('address.edit', $a->id) }}" class="text-forest-500 hover:text-yellow-700 transition duration-200" title="Edit Address">
                                            <i class="bi bi-pencil-square text-xl"></i>
                                        </a>
                                        <a href="{{ route('address.destroy', $a->id) }}" onclick="return confirm('Ingin hapus alamat?')" class="text-red-500 hover:text-red-700 transition duration-200" title="Delete Address">
                                            <i class="bi bi-trash3-fill text-xl"></i>
                                        </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="9" class="px-4 py-3 text-center">No data exists</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection

{{-- Tambahkan script di bagian bawah file --}}
<script>
function searchAddresses() {
    let input = document.getElementById('searchInput');
    let filter = input.value.toLowerCase();
    let tbody = document.getElementById('addressTableBody');
    let tr = tbody.getElementsByTagName('tr');

    for (let i = 0; i < tr.length; i++) {
        let tdName = tr[i].getElementsByTagName('td')[1]; // kolom nama penerima
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
