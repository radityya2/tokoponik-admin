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
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-forest-600">All Products</h1>

                <div class="flex items-center gap-4">
                    <input type="text"
                        id="searchInput"
                        placeholder="Search for products"
                        class="bg-white border border-pastel-200 text-forest-600 px-4 py-2 rounded-lg focus:outline-none focus:border-forest-500">

                    <select id="typeFilter" class="bg-white border border-pastel-200 text-forest-600 px-4 pr-8 py-2 rounded-lg focus:outline-none focus:border-forest-500 appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%22%3E%3Cpath%20d%3D%22M5.293%207.293a1%201%200%20011.414%200L10%2010.586l3.293-3.293a1%201%200%20111.414%201.414l-4%204a1%201%200%2001-1.414%200l-4-4a1%201%200%20010-1.414z%22%20fill%3D%22%236b7280%22%2F%3E%3C%2Fsvg%3E')] bg-no-repeat bg-[position:right_0.5rem_center] bg-[length:1.5em_1.5em]">
                        <option value="">All Types</option>
                        <option value="vegetable">Vegetable</option>
                        <option value="seed">Seed</option>
                        <option value="tool">Tool</option>
                    </select>

                    <a href="{{ route('product.create') }}">
                        <button class="bg-forest-600 hover:bg-forest-500 text-white px-4 py-2 rounded-lg">
                            Add new product
                        </button>
                    </a>
                </div>
            </div>


            <div class="overflow-x-auto">
                <table id="productTable" class="w-full">
                    <thead class="bg-green-200/50">
                    <tr class="bg-pastel-100 text-forest-600">
                            <th class="py-3 px-6 text-left">No</th>
                            <th class="py-3 px-6 text-left">Name</th>
                            <th class="py-3 px-6 text-left">Price</th>
                            <th class="py-3 px-6 text-left">Description</th>
                            <th class="py-3 px-6 text-left">Type</th>
                            <th class="py-3 px-6 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @if ($products->count() != 0)
                            @foreach ($products as $p)
                            <tr class="border-b border-gray-100">
                                <td class="py-3 px-6">{{ $loop->iteration }}</td>
                                <td class="py-3 px-6">{{ $p->name }}</td>
                                <td class="py-3 px-6">
                                    <div class="flex items-center">
                                        <span>Rp</span>
                                        <span class="ml-1">{{ number_format($p->price, 2, ',', '.') }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6">{{ $p->description }}</td>
                                <td class="py-3 px-6">{{ $p->type }}</td>
                                <td class="py-3 px-6 ">
                                    <div class="flex gap-2">
                                        <a href="{{ route('product.edit', $p->id) }}">
                                            <button class="w-24 bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg transition duration-200">
                                                Update
                                            </button>
                                        </a>
                                        <a href="{{ route('product.destroy', $p->id) }}">
                                            <button class="w-24 bg-action-danger hover:bg-red-600 text-white px-4 py-2 rounded-lg transition duration-200"
                                                    onClick="return confirm('Ingin hapus produk?')">
                                                Delete
                                            </button>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center p-4 bg-green-50">Tidak ada data</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
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
            var typeValue = $("#typeFilter").val().toLowerCase();

            $("#productTable tbody tr").each(function() {
                var rowText = $(this).text().toLowerCase();
                var rowType = $(this).find("td:eq(4)").text().toLowerCase(); // kolom type

                var matchesSearch = rowText.indexOf(searchValue) > -1;
                var matchesType = typeValue === "" || rowType === typeValue;

                $(this).toggle(matchesSearch && matchesType);
            });
        }

        $("#searchInput").on("keyup", filterTable);
        $("#typeFilter").on("change", filterTable);
    });
</script>
@endpush
