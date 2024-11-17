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
        const baseUrl = 'https://restapi-tokoponik-aqfsagdnfph3cgd8.australiaeast-01.azurewebsites.net';

        $.ajax({
            url: `${baseUrl}/api/auth/blogs`,
            method: 'GET',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            },
            success: function(response) {
                console.log('API Response:', response);
                var tbody = $('#blogTableBody');
                tbody.empty();

                if (response.data && response.data.length > 0) {
                    response.data.forEach(function(blog, index) {
                        console.log('Blog data:', blog);
                        console.log('Blog pics:', blog.blog_pics);

                        // Perbaikan cara mengambil path gambar
                        let imagePath;
                        if (blog.blog_pics && blog.blog_pics.length > 0) {
                            imagePath = blog.blog_pics[0].pic_path;
                            // Pastikan path lengkap
                            if (!imagePath.startsWith('http')) {
                                imagePath = `${baseUrl}/${imagePath}`;
                            }
                        } else {
                            imagePath = `${baseUrl}/storage/photos/default.jpg`;
                        }

                        var row = `
                            <tr class="border-b border-gray-100 hover:bg-gray-50 text-sm">
                                <td class="py-4 px-6">${index + 1}</td>
                                <td class="py-4 px-6">${blog.title || '-'}</td>
                                <td class="py-4 px-6">${blog.description || '-'}</td>
                                <td class="py-4 px-6">
                                    <div class="h-16 w-16 bg-gray-100 rounded overflow-hidden">
                                        <img src="${imagePath}"
                                             alt="${blog.title}"
                                             class="h-full w-full object-cover blog-image"
                                             data-blog-id="${blog.id}"
                                             onerror="this.onerror=null; this.src='${baseUrl}/storage/photos/default.jpg'">
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex gap-2">
                                        <a href="javascript:void(0)" onclick="editBlog(${blog.id})"
                                           class="text-forest-500 hover:text-yellow-700 transition duration-200">
                                            <i class="bi bi-pencil-square text-xl"></i>
                                        </a>
                                        <a href="javascript:void(0)" onclick="deleteBlog(${blog.id})"
                                           class="text-red-500 hover:text-red-700 transition duration-200">
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
                    $('#blogTableBody').html('<tr><td colspan="5" class="text-center py-8 text-red-500">Error loading data</td></tr>');
                }
            }
        });
    }

    // Fungsi untuk menghapus blog
    window.deleteBlog = function(id) {
        if (confirm('Are you sure you want to delete this blog?')) {
            const token = localStorage.getItem('token');

            $.ajax({
                url: `https://restapi-tokoponik-aqfsagdnfph3cgd8.australiaeast-01.azurewebsites.net/api/auth/blogs/${id}/destroy`,
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
                        alert('Failed to delete blog: ' + (xhr.responseJSON?.message || 'An error occurred'));
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

    // Cek apakah ada data blog yang baru diupdate
    const updatedBlogStr = localStorage.getItem('updatedBlog');
    if (updatedBlogStr) {
        try {
            const updatedBlog = JSON.parse(updatedBlogStr);

            // Pastikan data masih fresh (kurang dari 5 detik)
            const now = new Date().getTime();
            if (now - updatedBlog.timestamp < 5000) { // 5 detik

                // Update gambar di index jika ada
                if (updatedBlog.blog_pics && updatedBlog.blog_pics.length > 0) {
                    const blogId = updatedBlog.id;
                    const newImagePath = updatedBlog.blog_pics[0].pic_path;

                    // Pastikan path gambar lengkap
                    const baseUrl = 'https://restapi-tokoponik-aqfsagdnfph3cgd8.australiaeast-01.azurewebsites.net';
                    const fullImageUrl = newImagePath.startsWith('http') ?
                        newImagePath :
                        baseUrl + '/' + newImagePath;

                    console.log('Updating image for blog:', blogId);
                    console.log('New image URL:', fullImageUrl);

                    // Update semua instance gambar untuk blog ini
                    $(`.blog-image[data-blog-id="${blogId}"]`).each(function() {
                        $(this)
                            .attr('src', fullImageUrl)
                            .on('load', function() {
                                console.log('Image loaded successfully');
                            })
                            .on('error', function() {
                                console.log('Failed to load image:', fullImageUrl);
                            });
                    });
                }
            }
        } catch (e) {
            console.error('Error parsing updatedBlog:', e);
        }

        // Hapus data dari localStorage
        localStorage.removeItem('updatedBlog');
    }

    // Cek apakah ada blog baru yang ditambahkan
    const newBlogStr = localStorage.getItem('newBlog');
    if (newBlogStr) {
        try {
            const newBlog = JSON.parse(newBlogStr);
            // Pastikan data masih fresh (kurang dari 5 detik)
            const now = new Date().getTime();
            if (now - newBlog.timestamp < 5000) {
                // Reload data untuk menampilkan blog baru
                loadBlogs();
            }
        } catch (e) {
            console.error('Error parsing newBlog:', e);
        }
        // Hapus data dari localStorage
        localStorage.removeItem('newBlog');
    }
});
</script>
@endpush
