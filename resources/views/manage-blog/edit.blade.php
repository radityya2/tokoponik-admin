@extends('layout')

@section('title')
    Edit Blog
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('blog.index') }}" class="text-green-600 hover:text-green-800">Data Blog</a></li>
<li class="breadcrumb-item active">Edit Blog</li>
@endsection

@section('content')
    <div class="bg-green-50 rounded-lg shadow-md p-8">
        <div class="border-b border-gray-200 mb-6">
            <p class="text-gray-800 text-2xl font-bold mb-3">Form Edit Blog</p>
        </div>

        <form id="editBlogForm" enctype="multipart/form-data">
            @csrf

            <div class="mb-6">
                <label class="block text-gray-800 text-sm font-semibold mb-3" for="title">Title</label>
                <input type="text"
                    class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400"
                    id="title"
                    name="title"
                    placeholder="Enter blog title">
                <p class="text-red-500 text-xs mt-1" id="title-error"></p>
            </div>

            <div class="mb-6">
                <label class="block text-gray-800 text-sm font-semibold mb-3" for="description">Description</label>
                <textarea
                    class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400"
                    id="description"
                    name="description"
                    placeholder="Enter blog description"></textarea>
                <p class="text-red-500 text-xs mt-1" id="description-error"></p>
            </div>

            <div class="mb-6">
                <label class="block text-gray-800 text-sm font-semibold mb-3" for="blog_picture">Image</label>
                <input type="file"
                    class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400"
                    id="blog_picture"
                    name="blog_picture"
                    accept="image/jpeg,image/png,image/jpg">
                <p class="text-red-500 text-xs mt-1" id="blog_picture-error"></p>

                <!-- Container untuk preview gambar -->
                <div class="mt-4">
                    <p class="text-sm font-medium text-gray-700 mb-2">Current Image:</p>
                    <div class="relative">
                        <img id="current_image"
                             src=""
                             alt="Current Blog Image"
                             class="max-w-xs rounded-lg shadow-md"
                             style="display: none;">
                        <p id="image_placeholder"
                           class="text-sm text-gray-500">
                           No image available
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex gap-4 mt-8">
                <button type="submit" id="submitBtn" class="flex items-center px-6 py-2.5 bg-green-800 text-white rounded-lg hover:bg-green-600">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Submit
                </button>
                <a href="/blog" class="flex items-center px-6 py-2.5 bg-red-700 text-white rounded-lg hover:bg-red-800">
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
    // Ambil ID blog dari URL
    const blogId = window.location.pathname.split('/')[2];
    const token = localStorage.getItem('token');

    // Fetch blog data
    $.ajax({
        url: `https://restapi-tokoponik-aqfsagdnfph3cgd8.australiaeast-01.azurewebsites.net/api/auth/blogs/${blogId}`,
        method: 'GET',
        headers: {
            'Authorization': 'Bearer ' + token,
            'Accept': 'application/json'
        },
        success: function(response) {
            console.log('Full response:', response);
            const blog = response.data;

            // Mengisi form dengan data yang ada
            $('#title').val(blog.title);
            $('#description').val(blog.description);

            // Menampilkan gambar dari database
            if (blog.blog_pics && blog.blog_pics.length > 0) {
                const imagePath = blog.blog_pics[0].pic_path;
                console.log('Image path:', imagePath);

                // Pastikan path gambar lengkap
                const baseUrl = 'https://restapi-tokoponik-aqfsagdnfph3cgd8.australiaeast-01.azurewebsites.net';
                const fullImageUrl = imagePath.startsWith('http') ? imagePath : baseUrl + imagePath;
                console.log('Full image URL:', fullImageUrl);

                $('#current_image')
                    .attr('src', fullImageUrl)
                    .on('load', function() {
                        console.log('Image loaded successfully:', fullImageUrl);
                        $(this).show();
                        $('#image_placeholder').hide();
                    })
                    .on('error', function() {
                        console.log('Image failed to load:', fullImageUrl);
                        $(this).hide();
                        $('#image_placeholder').text('Image cannot be loaded').show();
                    });
            } else {
                $('#current_image').hide();
                $('#image_placeholder').text('No image available').show();
            }

        },
        error: function(xhr) {
            console.error('Error response:', xhr);
            if (xhr.status === 401) {
                localStorage.removeItem('token');
                window.location.href = '/login';
            } else {
                alert('Failed to fetch blog data');
            }
        }
    });

    // Modifikasi bagian submit form
    $('#editBlogForm').on('submit', function(e) {
        e.preventDefault();

        // Reset error messages
        $('.text-red-500').text('');
        $('input, textarea').removeClass('border-red-500');

        // Create FormData object
        const formData = new FormData();

        // Tambahkan data ke FormData
        formData.append('title', $('#title').val());
        formData.append('description', $('#description').val());
        formData.append('user_id', localStorage.getItem('user_id'));

        // Tambahkan file gambar jika ada - ubah nama field menjadi 'photo'
        const blogPicture = $('#blog_picture')[0].files[0];
        if (blogPicture) {
            formData.append('photo', blogPicture); // Ubah dari 'blog_picture' menjadi 'photo'
        }

        // Validasi client-side
        let isValid = true;
        const title = $('#title').val().trim();
        const description = $('#description').val().trim();

        if (!title) {
            $('#title-error').text('Judul blog harus diisi');
            $('#title').addClass('border-red-500');
            isValid = false;
        }

        if (!description) {
            $('#description-error').text('Deskripsi blog harus diisi');
            $('#description').addClass('border-red-500');
            isValid = false;
        }

        if (!isValid) return;

        // Disable submit button
        const submitBtn = $('#submitBtn');
        submitBtn.prop('disabled', true)
            .html('<i class="fas fa-spinner fa-spin mr-2"></i>Processing...');

        // Kirim request ke API
        $.ajax({
            url: `https://restapi-tokoponik-aqfsagdnfph3cgd8.australiaeast-01.azurewebsites.net/api/auth/blogs/${blogId}/update`,
            method: 'POST',
            data: formData,
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            },
            processData: false,
            contentType: false,
            success: function(response) {
                console.log('Success response:', response);

                // Simpan data blog yang diperbarui ke localStorage dengan format yang benar
                if (response.data) {
                    const updatedBlogData = {
                        id: response.data.id,
                        blog_pics: response.data.blog_pics,
                        timestamp: new Date().getTime() // Tambahkan timestamp
                    };
                    localStorage.setItem('updatedBlog', JSON.stringify(updatedBlogData));
                }

                Swal.fire({
                    title: 'Success!',
                    text: 'Blog has been successfully updated',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/blog';
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error('Error response:', xhr);
                console.error('Status:', status);
                console.error('Error:', error);

                submitBtn.prop('disabled', false).html('Submit');

                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    Object.keys(errors).forEach(function(key) {
                        $(`#${key}`).addClass('border-red-500');
                        $(`#${key}-error`).text(errors[key][0]);
                    });
                } else if (xhr.status === 401) {
                    localStorage.removeItem('token');
                    window.location.href = '/login';
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat memperbarui blog',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            }
        });
    });

    // Reset error state saat input berubah
    $('input, textarea').on('input', function() {
        $(this).removeClass('border-red-500');
        $(`#${$(this).attr('id')}-error`).text('');
    });
});
</script>
@endpush
