@extends('layout')

@section('title')
    Edit Product
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('product.index') }}" class="text-green-600 hover:text-green-800">Data Product</a></li>
<li class="breadcrumb-item active">Edit Product</li>
@endsection

@section('content')
    <div class="bg-green-50 rounded-lg shadow-md p-8">
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="border-b border-green-200 mb-6">
            <h1 class="text-gray-800 text-2xl font-bold mb-4">Form Edit Product</h1>
        </div>

        <form id="editProductForm">
            <div class="mb-6">
                <label class="block text-gray-800 text-sm font-semibold mb-3" for="name">Name</label>
                <input type="text"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400"
                    id="name"
                    name="name"
                    placeholder="Enter product name">
                <span id="nameError" class="text-red-500 text-xs mt-1"></span>
            </div>

            <div class="mb-6">
                <label class="block text-gray-800 text-sm font-semibold mb-3" for="price">Price</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-600">Rp</span>
                    </div>
                    <input type="number"
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400"
                        id="price"
                        name="price"
                        placeholder="Enter product price">
                </div>
                <span id="priceError" class="text-red-500 text-xs mt-1"></span>
            </div>

            <div class="mb-6">
                <label class="block text-gray-800 text-sm font-semibold mb-3" for="description">Description</label>
                <textarea
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400"
                    id="description"
                    name="description"
                    rows="3"
                    placeholder="Enter product description"></textarea>
                <span id="descriptionError" class="text-red-500 text-xs mt-1"></span>
            </div>

            <div class="mb-6">
                <label class="block text-gray-800 text-sm font-semibold mb-3" for="photos">Product Photos</label>
                <input type="file"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400"
                    id="photos"
                    name="photos[]"
                    accept="image/jpeg,png,jpg"
                    multiple>

                <div class="mt-4">
                    <p class="text-sm font-medium text-gray-700 mb-2">Current Image:</p>
                    <div id="existingImages" class="flex flex-wrap gap-2">
                        <!-- Gambar akan dimuat melalui JavaScript -->
                    </div>
                </div>

                <div id="preview" class="mt-2 flex flex-wrap gap-2"></div>
                <span id="photosError" class="text-red-500 text-xs mt-1"></span>
            </div>

            <div class="mb-8">
                <label class="block text-gray-800 text-sm font-semibold mb-3" for="type">Type</label>
                <select class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400"
                    id="type"
                    name="type">
                    <option value="" disabled selected>Select product type</option>
                    <option value="vegetable">Vegetable</option>
                    <option value="tool">Tool</option>
                    <option value="seed">Seed</option>
                </select>
                <span id="typeError" class="text-red-500 text-xs mt-1"></span>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="flex items-center px-6 py-2.5 bg-green-800 hover:bg-green-600 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Update
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    const productId = window.location.pathname.split('/')[2];

    // Ambil data produk dari API
    $.ajax({
        url: `http://127.0.0.1:8000/api/products/${productId}`,
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        success: function(response) {
            if (response.data) {
                $('#name').val(response.data.name || '');
                $('#price').val(response.data.price || '');
                $('#description').val(response.data.description || '');
                $('#type').val(response.data.type || '');

                // Tampilkan gambar yang ada
                const existingImages = document.getElementById('existingImages');
                existingImages.innerHTML = ''; // Bersihkan container

                if (response.data.product_pics && response.data.product_pics.length > 0) {
                    response.data.product_pics.forEach(pic => {
                        const baseUrl = 'http://127.0.0.1:8000';
                        const fullImageUrl = pic.path.startsWith('http') ? pic.path : baseUrl + pic.path;

                        const div = document.createElement('div');
                        div.className = 'relative';
                        div.innerHTML = `
                            <img src="${fullImageUrl}"
                                 alt="Product Image"
                                 class="h-20 w-20 object-cover rounded-lg shadow-md"
                                 onerror="this.onerror=null; this.src='/storage/photos/default.jpg'; this.parentElement.innerHTML='<div class=\'h-20 w-20 flex items-center justify-center text-gray-400 text-xs bg-gray-100 rounded-lg\'>Tidak ada gambar</div>';">
                        `;
                        existingImages.appendChild(div);
                    });
                } else {
                    existingImages.innerHTML = '<div class="text-sm text-gray-500">Tidak ada gambar tersedia</div>';
                }
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            alert('Gagal mengambil data produk');
            window.location.href = '{{ route("product.index") }}';
        }
    });

    $('#editProductForm').on('submit', function(e) {
        e.preventDefault();

        const formData = new FormData();
        formData.append('name', $('#name').val());
        formData.append('price', $('#price').val());
        formData.append('description', $('#description').val());
        formData.append('type', $('#type').val());

        // Tambahkan file foto jika ada
        if ($('#photos')[0].files[0]) {
            formData.append('photo', $('#photos')[0].files[0]);
        }

        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.text();
        submitBtn.prop('disabled', true).text('Processing...');

        $.ajax({
            url: `http://127.0.0.1:8000/api/products/${productId}/update`,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            },
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log('Success:', response);

                // Simpan data produk yang diperbarui ke localStorage
                if (response.data) {
                    const updatedProductData = {
                        id: response.data.id,
                        product_pics: response.data.product_pics,
                        timestamp: new Date().getTime()
                    };
                    localStorage.setItem('updatedProduct', JSON.stringify(updatedProductData));
                }

                Swal.fire({
                    title: 'Success!',
                    text: 'Product has been successfully updated',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('product.index') }}";
                    }
                });
            },
            error: function(xhr, status, error) {
                submitBtn.prop('disabled', false).text(originalText);
                console.error('Error Response:', xhr.responseText);
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    alert(xhr.responseJSON.message);
                } else {
                    alert('Gagal memperbarui produk. Silakan coba lagi.');
                }
            }
        });
    });
});
</script>
@endpush
