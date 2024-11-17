@extends('layout')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('title')
    Product Data
@endsection

@section('breadcrumb')
<li class="breadcrumb-item active">Product Data</li>
@endsection

@section('content')
    <div class="flex-1 p-8 bg-pastel-50">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-forest-700">All Products</h1>
            <div class="flex items-center space-x-6">
                <input type="text" id="searchInput" placeholder="Search for products" class="bg-white border border-pastel-200 text-forest-600 px-5 py-2.5 rounded-lg focus:outline-none focus:border-forest-500 focus:ring-2 focus:ring-forest-200 transition-all duration-200">
                <select id="typeFilter" class="bg-white border border-pastel-200 text-forest-600 px-5 py-2.5 rounded-lg focus:outline-none focus:border-forest-500 focus:ring-2 focus:ring-forest-200 transition-all duration-200">
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

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <table id="productTable" class="w-full">
                <thead>
                    <tr class="bg-forest-500 text-white text-sm">
                        <th class="py-4 px-6 text-left font-medium">No</th>
                        <th class="py-4 px-6 text-left font-medium">Image</th>
                        <th class="py-4 px-6 text-left font-medium">Name</th>
                        <th class="py-4 px-6 text-left font-medium">Price</th>
                        <th class="py-4 px-6 text-left font-medium">Description</th>
                        <th class="py-4 px-6 text-left font-medium">Type</th>
                        <th class="py-4 px-6 text-left font-medium">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Tambahkan fungsi filter table
        function filterTable() {
            var searchText = $("#searchInput").val().toLowerCase();
            var typeFilter = $("#typeFilter").val().toLowerCase();

            $("#productTable tbody tr").each(function() {
                var name = $(this).find("td:eq(2)").text().toLowerCase();
                var type = $(this).find("td:eq(5)").text().toLowerCase();

                var matchSearch = name.includes(searchText);
                var matchType = typeFilter === "" || type.includes(typeFilter);

                if (matchSearch && matchType) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }

        // Tambahkan fungsi format number
        function formatNumber(num) {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
        }

        // Function to load products
        function loadProducts() {
            $.ajax({
                url: 'http://127.0.0.1:8000/api/products',
                method: 'GET',
                success: function(response) {
                    console.log('API Response:', response);
                    var tbody = $('#productTable tbody');
                    tbody.empty();

                    if (response.data && response.data.length > 0) {
                        response.data.forEach(function(product, index) {
                            // Cek apakah product_pics ada dan memiliki data
                            let imageUrl = '/storage/photos/default.jpg';
                            if (product.product_pics && product.product_pics.length > 0) {
                                imageUrl = product.product_pics[0].path || '/storage/photos/default.jpg';
                            }

                            var row = `
                                <tr class="border-b border-gray-100 hover:bg-gray-50 text-sm">
                                    <td class="py-4 px-6">${index + 1}</td>
                                    <td class="py-4 px-6">
                                        <div class="h-16 w-16 bg-gray-100 rounded overflow-hidden">
                                            <img src="${imageUrl}"
                                                 alt="${product.name}"
                                                 class="h-full w-full object-cover"
                                                 onerror="this.onerror=null; this.src='/storage/photos/default.jpg';">
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">${product.name || '-'}</td>
                                    <td class="py-4 px-6">Rp ${formatNumber(product.price || 0)}</td>
                                    <td class="py-4 px-6">${product.description || '-'}</td>
                                    <td class="py-4 px-6">
                                        <span class="px-3 py-1 rounded-full text-xs font-medium ${getTypeColor(product.type)}">
                                            ${product.type || '-'}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center space-x-3">
                                            <button onclick="editProduct(${product.id})" class="text-forest-500 hover:text-yellow-500   ">
                                                <i class="bi bi-pencil-square text-xl"></i>
                                            </button>
                                            <button onclick="deleteProduct(${product.id})" class="text-red-500 hover:text-red-700">
                                                <i class="bi bi-trash3-fill text-xl"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            `;
                            tbody.append(row);
                        });
                    } else {
                        tbody.html('<tr><td colspan="7" class="text-center py-4">No product data available</td></tr>');
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr);
                    $('#productTable tbody').html('<tr><td colspan="7" class="text-center py-4 text-red-500">Error loading data</td></tr>');
                }
            });
        }

        // Delete product function
        window.deleteProduct = function(id) {
            if (confirm('Are you sure you want to delete this product?')) {
                $.ajax({
                    url: `http://127.0.0.1:8000/api/products/${id}/destroy`,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json'
                    },
                    success: function(response) {
                        loadProducts();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        alert('Failed to delete product');
                    }
                });
            }
        };

        // Edit product function
        window.editProduct = function(id) {
            $.ajax({
                url: `http://127.0.0.1:8000/api/products/${id}`,
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.data) {
                        localStorage.setItem('editProduct', JSON.stringify(response.data));
                        window.location.href = `/product/${id}/edit`;
                    } else {
                        alert('Product data not found');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    alert('Failed to fetch product data');
                }
            });
        };

        // Event listeners for filter
        $("#searchInput").on("keyup", filterTable);
        $("#typeFilter").on("change", filterTable);

        // Load data when the page loads
        loadProducts();

        // Cek apakah ada produk yang baru diupdate
        const updatedProductStr = localStorage.getItem('updatedProduct');
        if (updatedProductStr) {
            try {
                const updatedProduct = JSON.parse(updatedProductStr);

                // Pastikan data masih fresh (kurang dari 5 detik)
                const now = new Date().getTime();
                if (now - updatedProduct.timestamp < 5000) { // 5 detik

                    // Update gambar di index jika ada
                    if (updatedProduct.product_pics && updatedProduct.product_pics.length > 0) {
                        const productId = updatedProduct.id;
                        const newImagePath = updatedProduct.product_pics[0].path;

                        // Pastikan path gambar lengkap
                        const baseUrl = 'http://127.0.0.1:8000';
                        const fullImageUrl = newImagePath.startsWith('http') ?
                            newImagePath :
                            baseUrl + '/' + newImagePath;

                        // Update gambar untuk produk ini
                        $(`#productTable tbody tr`).each(function() {
                            const row = $(this);
                            const editButton = row.find('button[onclick^="editProduct"]');
                            if (editButton.length && editButton.attr('onclick').includes(productId)) {
                                row.find('img').attr('src', fullImageUrl);
                            }
                        });
                    }
                }
            } catch (e) {
                console.error('Error parsing updatedProduct:', e);
            }

            // Hapus data dari localStorage
            localStorage.removeItem('updatedProduct');
        }
    });

    function getTypeColor(type) {
        type = type.toLowerCase();
        switch(type) {
            case 'vegetable':
                return 'bg-green-100 text-green-700';
            case 'tool':
                return 'bg-blue-100 text-blue-700';
            case 'seed':
                return 'bg-yellow-100 text-yellow-700';
            default:
                return 'bg-gray-100 text-gray-700';
        }
    }
</script>
@endpush
