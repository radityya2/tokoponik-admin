@extends('layout')

@section('title')
    Create New Product
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('product.index') }}" class="text-green-600 hover:text-green-800">Data Product</a></li>
<li class="breadcrumb-item active">Create New Product</li>
@endsection

@section('content')
    <div class="bg-green-50 rounded-lg shadow-md p-8">
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="border-b border-green-200 mb-6">
            <h1 class="text-gray-800 text-2xl font-bold mb-4">Form Add Product</h1>
        </div>

        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data" id="create-user">
            @csrf
            <div class="mb-6">
                <label class="block text-gray-800 text-sm font-semibold mb-3" for="name">Name</label>
                <input type="text"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 @error('name') border-red-500 @enderror"
                    id="name"
                    name="name"
                    placeholder="Enter product name"
                    value="{{ old('name') }}">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-800 text-sm font-semibold mb-3" for="price">Price</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-600">Rp</span>
                    </div>
                    <input type="number"
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 @error('price') border-red-500 @enderror"
                        id="price"
                        name="price"
                        placeholder="Enter product price"
                        value="{{ old('price') }}">
                </div>
                @error('price')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-800 text-sm font-semibold mb-3" for="description">Description</label>
                <textarea
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 @error('description') border-red-500 @enderror"
                    id="description"
                    name="description"
                    rows="3"
                    placeholder="Enter product description">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-8">
                <label class="block text-gray-800 text-sm font-semibold mb-3" for="type">Type</label>
                <select class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 @error('type') border-red-500 @enderror"
                    id="type"
                    name="type">
                    <option value="" disabled selected>Select product type</option>
                    <option value="vegetable" {{ old('type') == 'vegetable' ? 'selected' : '' }}>vegetable</option>
                    <option value="tool" {{ old('type') == 'tool' ? 'selected' : '' }}>tool</option>
                    <option value="seed" {{ old('type') == 'seed' ? 'selected' : '' }}>seed</option>
                </select>
                @error('type')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit" class="flex items-center px-6 py-2.5 bg-green-800 hover:bg-green-600 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Submit
                </button>
                <a href="{{ route('product.index') }}" class="flex items-center px-6 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back
                </a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $("#create-user").submit(function(event){
            event.preventDefault(); // Mencegah form dari submit default

            // Mengambil data dari form
            var formData = new FormData(this);

            // Mengirim data menggunakan AJAX
            $.ajax({
                url: 'http://127.0.0.1:8000/api/products/store',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {


                    // Pindah ke halaman index setelah sukses
                    window.location.href = "{{ route('product.index') }}"; // Ganti dengan URL index produk
                },
                error: function(xhr) {
                    // Tindakan jika terjadi kesalahan
                    var errors = xhr.responseJSON.errors;
                    var errorMessage = '';
                    for (var key in errors) {
                        errorMessage += errors[key].join(', ') + '\n';
                    }
                    alert('Terjadi kesalahan:\n' + errorMessage);
                }
            });
        });
    });
</script>
