@extends('layout')

@section('title')
    Data Product
@endsection

@section('breadcrumb')
<li class="breadcrumb-item active">Data Product</li>
@endsection

@section('content')
    <!-- Main Content -->
    <div class="flex-1 p-8 bg-pastel-50">
        <!-- Header dengan styling yang diperbarui -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-forest-700">All Products</h1>

            <div class="flex items-center space-x-6">
                <input type="text"
                    id="searchInput"
                    placeholder="Search for products"
                    class="bg-white border border-pastel-200 text-forest-600 px-5 py-2.5 rounded-lg focus:outline-none focus:border-forest-500 focus:ring-2 focus:ring-forest-200 transition-all duration-200">

                <select id="typeFilter"
                    class="bg-white border border-pastel-200 text-forest-600 px-5 py-2.5 rounded-lg focus:outline-none focus:border-forest-500 focus:ring-2 focus:ring-forest-200 transition-all duration-200 appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%22%3E%3Cpath%20d%3D%22M5.293%207.293a1%201%200%20011.414%200L10%2010.586l3.293-3.293a1%201%200%2011.414%201.414l-4%204a1%201%200%2001-1.414%200l-4-4a1%201%200%20010-1.414z%22%20fill%3D%22%236b7280%22%2F%3E%3C%2Fsvg%3E')] bg-no-repeat bg-[position:right_1rem_center] bg-[length:1.5em_1.5em] pr-12">
                    <option value="">All Types</option>
                    <option value="vegetable">Vegetable</option>
                    <option value="seed">Seed</option>
                    <option value="tool">Tool</option>
                </select>

                <a href="{{ route('product.create') }}">
                    <button class="bg-emerald-600 hover:bg-emerald-500 text-white px-6 py-2.5 rounded-lg transition duration-200 font-medium shadow-sm hover:shadow-md">
                        Add new product
                    </button>
                </a>
            </div>
        </div>

        <!-- Tabel dengan styling yang diperbarui -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <table id="productTable" class="w-full">
                <thead>
                    <tr class="bg-forest-500 text-white text-sm">
                        <th class="py-4 px-6 text-left font-medium">No</th>
                        <th class="py-4 px-6 text-left font-medium">Name</th>
                        <th class="py-4 px-6 text-left font-medium">Price</th>
                        <th class="py-4 px-6 text-left font-medium">Description</th>
                        <th class="py-4 px-6 text-left font-medium">Type</th>
                        <th class="py-4 px-6 text-left font-medium">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @if ($products->count() != 0)
                        @foreach ($products as $p)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="py-4 px-6 text-sm">{{ $loop->iteration }}</td>
                            <td class="py-4 px-6 text-sm">{{ $p->name }}</td>
                            <td class="py-4 px-6 text-sm">
                                <div class="flex items-center">
                                    <span>Rp</span>
                                    <span class="ml-1">{{ number_format($p->price, 2, ',', '.') }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-sm">{{ $p->description }}</td>
                            <td class="py-4 px-6 text-sm">
                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                    {{ $p->type === 'vegetable' ? 'bg-emerald-100 text-emerald-700' :
                                       ($p->type === 'seed' ? 'bg-blue-100 text-blue-700' :
                                       'bg-amber-100 text-amber-700') }}">
                                    {{ $p->type }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center space-x-4">
                                    <a href="{{ route('product.edit', $p->id) }}"
                                       class="text-forest-500 hover:text-forest-500 transition duration-200"
                                       title="Edit Product">
                                        <i class="bi bi-pencil-square text-xl"></i>
                                    </a>

                                    <a href="{{ route('product.destroy', $p->id) }}"
                                       onclick="return confirm('Ingin hapus produk?')"
                                       class="text-red-500 hover:text-red-700 transition duration-200"
                                       title="Delete Product">
                                        <i class="bi bi-trash3-fill text-xl"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center py-8 text-gray-500 bg-gray-50">Tidak ada data</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<!-- Pastikan jQuery dimuat terlebih dahulu -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        function filterTable() {
            var searchValue = $("#searchInput").val().toLowerCase();
            var typeValue = $("#typeFilter").val().toLowerCase().trim();

            $("#productTable tbody tr").each(function() {
                var row = $(this);
                // Skip baris "Tidak ada data"
                if (row.find('td[colspan]').length > 0) return;

                var rowText = row.text().toLowerCase();
                var typeCell = row.find("td:eq(4)").text().toLowerCase().trim();

                var matchesSearch = rowText.indexOf(searchValue) > -1;
                var matchesType = typeValue === "" || typeCell.includes(typeValue);

                row.toggle(matchesSearch && matchesType);
            });
        }

        $("#searchInput").on("keyup", filterTable);
        $("#typeFilter").on("change", filterTable);
    });
</script>
@endpush
