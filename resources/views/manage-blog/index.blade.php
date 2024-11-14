@extends('layout')

@section('title')
    Data Blog
@endsection

@section('breadcrumb')
<li class="breadcrumb-item active">Data Blog</li>
@endsection

@section('content')
    <div class="flex-1 p-8 bg-pastel-50">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-forest-700">All Blog Posts</h1>

            <div class="flex items-center space-x-6">
                <input type="text"
                    id="searchInput"
                    placeholder="Search for blog posts"
                    class="bg-white border border-pastel-200 text-forest-600 px-5 py-2.5 rounded-lg focus:outline-none focus:border-forest-500">

                <a href="{{ route('blog.create') }}">
                    <button class="bg-emerald-600 hover:bg-emerald-500 text-white px-6 py-2.5 rounded-lg transition duration-200 font-medium shadow-sm hover:shadow-md">
                        Add new post
                    </button>
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <table id="blogTable" class="w-full">
                <thead>
                    <tr class="bg-forest-500 text-white">
                        <th class="py-4 px-6 text-left font-medium">No</th>
                        <th class="py-4 px-6 text-left font-medium">Title</th>
                        <th class="py-4 px-6 text-left font-medium">Description</th>
                        <th class="py-4 px-6 text-left font-medium">Image</th>
                        <th class="py-4 px-6 text-left font-medium">Link</th>
                        <th class="py-4 px-6 text-left font-medium">Action</th>
                    </tr>
                </thead>
                <tbody id="blogTableBody">
                    <!-- Data akan diisi melalui AJAX -->
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Fungsi untuk memuat data blog
    function loadBlogs() {
        const token = localStorage.getItem('token');

        $.ajax({
            url: 'http://127.0.0.1:8000/api/auth/blogs',
            method: 'GET',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            },
            success: function(response) {
                var tbody = $('#blogTableBody');
                tbody.empty();

                if (response.data && response.data.length > 0) {
                    response.data.forEach(function(blog, index) {
                        var row = `
                            <tr class="border-b border-gray-100 hover:bg-gray-50 text-sm">
                                <td class="py-4 px-6">${index + 1}</td>
                                <td class="py-4 px-6">${blog.title || '-'}</td>
                                <td class="py-4 px-6">${blog.description || '-'}</td>
                                <td class="py-4 px-6">${blog.blog_picture || '-'}</td>
                                <td class="py-4 px-6">${blog.blog_link || '-'}</td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center space-x-3">
                                        <a href="javascript:void(0)" onclick="editBlog(${blog.id})" class="tooltip" title="Edit Blog">
                                            <i class="bi bi-pencil-square text-xl text-forest-500 hover:text-yellow-500 transition duration-200"></i>
                                        </a>
                                        <a href="javascript:void(0)" onclick="deleteBlog(${blog.id})" class="tooltip" title="Delete Blog">
                                            <i class="bi bi-trash3-fill text-xl text-red-500 hover:text-red-700 transition duration-200"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        `;
                        tbody.append(row);
                    });
                } else {
                    tbody.html('<tr><td colspan="6" class="text-center py-8 text-gray-500">Tidak ada data</td></tr>');
                }
            },
            error: function(xhr) {
                console.error('Error:', xhr);
                if (xhr.status === 401) {
                    localStorage.removeItem('token');
                    window.location.href = '/login';
                } else {
                    $('#blogTableBody').html('<tr><td colspan="6" class="text-center py-8 text-red-500">Error saat memuat data</td></tr>');
                }
            }
        });
    }

    // Fungsi untuk menghapus blog
    window.deleteBlog = function(id) {
        if (confirm('Yakin ingin menghapus blog ini?')) {
            const token = localStorage.getItem('token');

            $.ajax({
                url: `http://127.0.0.1:8000/api/auth/blogs/${id}/destroy`,
                method: 'DELETE',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    loadBlogs();
                },
                error: function(xhr) {
                    console.error('Error:', xhr);
                    if (xhr.status === 401) {
                        localStorage.removeItem('token');
                        window.location.href = '/login';
                    } else {
                        alert('Gagal menghapus blog: ' + (xhr.responseJSON?.message || 'Terjadi kesalahan'));
                    }
                }
            });
        }
    }

    // Fungsi untuk edit blog
    window.editBlog = function(id) {
        window.location.href = `/blog/${id}/edit`;
    }

    // Fungsi pencarian
    $("#searchInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#blogTableBody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    // Load data saat halaman dimuat
    loadBlogs();
});
</script>
@endpush
