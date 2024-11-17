@extends('layout')

@section('title')
    Create New Blog
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('blog.index') }}" class="text-green-600 hover:text-green-800">Data Blog</a></li>
<li class="breadcrumb-item active">Create New Blog</li>
@endsection

@section('content')
    <div class="bg-green-50 rounded-lg shadow-md p-8">
        <div class="border-b border-gray-200 mb-6">
            <p class="text-gray-800 text-2xl font-bold mb-3">Form Add Blog</p>
        </div>

        <form id="createBlogForm" enctype="multipart/form-data">
            @csrf
            <div class="mb-6">
                <label class="block text-gray-800 text-sm font-semibold mb-3" for="title">Title</label>
                <input type="text"
                    class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400"
                    id="title"
                    name="title"
                    placeholder="Masukkan judul blog"
                    required>
                <p class="text-red-500 text-xs mt-1 error-message" id="title-error"></p>
            </div>

            <div class="mb-6">
                <label class="block text-gray-800 text-sm font-semibold mb-3" for="description">Description</label>
                <textarea
                    class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400"
                    id="description"
                    name="description"
                    placeholder="Masukkan deskripsi blog"
                    required></textarea>
                <p class="text-red-500 text-xs mt-1 error-message" id="description-error"></p>
            </div>

            <div class="mb-6">
                <label class="block text-gray-800 text-sm font-semibold mb-3" for="photos">Photos</label>
                <input type="file"
                    class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400"
                    id="photos"
                    name="photos"
                    accept="image/jpeg,image/png,image/jpg"
                    required>

                <p class="text-red-500 text-xs mt-1 error-message" id="photos-error"></p>
                <div id="preview" class="mt-2 flex flex-wrap gap-2"></div>
            </div>

            <div class="flex gap-4 mt-8">
                <button type="submit" class="flex items-center px-6 py-2.5 bg-green-800 text-white rounded-lg hover:bg-green-600">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Submit
                </button>
                <a href="{{ route('blog.index') }}" class="flex items-center px-6 py-2.5 bg-red-700 text-white rounded-lg hover:bg-red-800">
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


// Handle preview gambar
$('#photos').on('change', function(e) {
    const files = e.target.files;

    if (!validateFiles(files)) {
        this.value = '';
        $('#preview').empty();
        return;
    }

    const preview = $('#preview');
    preview.empty();

    Array.from(files).forEach(file => {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.append(`
                <div class="relative">
                    <img src="${e.target.result}" class="h-20 w-20 object-cover rounded">
                    <button type="button" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center"
                            onclick="$(this).parent().remove()">×</button>
                </div>
            `);
        }
        reader.readAsDataURL(file);
    });
});

function compressImage(file) {
    return new Promise((resolve) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = new Image();
            img.onload = function() {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');

                // Set ukuran maksimal
                const MAX_WIDTH = 1024;
                const MAX_HEIGHT = 1024;

                let width = img.width;
                let height = img.height;

                if (width > height) {
                    if (width > MAX_WIDTH) {
                        height *= MAX_WIDTH / width;
                        width = MAX_WIDTH;
                    }
                } else {
                    if (height > MAX_HEIGHT) {
                        width *= MAX_HEIGHT / height;
                        height = MAX_HEIGHT;
                    }
                }

                canvas.width = width;
                canvas.height = height;

                ctx.drawImage(img, 0, 0, width, height);

                canvas.toBlob((blob) => {
                    resolve(new File([blob], file.name, {
                        type: 'image/jpeg',
                        lastModified: Date.now()
                    }));
                }, 'image/jpeg', 0.7); // Kompresi dengan quality 0.7
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    });
}

// Handle submit form
$('#createBlogForm').on('submit', async function(e) {
    e.preventDefault();

    // Reset error messages
    $('.error-message').text('');
    $('input, textarea').removeClass('border-red-500');

    // Validasi client-side
    let isValid = true;
    const title = $('#title').val().trim();
    const description = $('#description').val().trim();
    const photo = $('#photos')[0].files[0];

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

    if (!photo) {
        $('#photo-error').text('Foto harus diupload');
        $('#photo').addClass('border-red-500');
        isValid = false;
    }

    if (!isValid) return;

    const formData = new FormData();
    formData.append('title', title);
    formData.append('description', description);

    if (photo) {
        const compressedPhoto = await compressImage(photo);
        formData.append('photo', compressedPhoto);
    }

    formData.append('user_id', localStorage.getItem('user_id'));

    const token = localStorage.getItem('token');

    $.ajax({
        url: 'https://restapi-tokoponik-aqfsagdnfph3cgd8.australiaeast-01.azurewebsites.net/api/auth/blogs/store',
        method: 'POST',
        headers: {
            'Authorization': 'Bearer ' + token,
            'Accept': 'application/json'
        },
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            console.log('Success response:', response);

            // Simpan data blog yang baru dibuat ke localStorage
            const blogData = {
                id: response.data.id,
                blog_pics: response.data.blog_pics,
                timestamp: new Date().getTime()
            };
            localStorage.setItem('newBlog', JSON.stringify(blogData));

            Swal.fire({
                title: 'Success!',
                text: 'Blog has been successfully added',
                icon: 'success'
            }).then(() => {
                window.location.href = '/blog';
            });
        },
        error: function(xhr) {
            console.log('Error Response:', xhr.responseText);

            if (xhr.status === 422 || xhr.status === 400) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    const errors = response.errors || {};

                    Object.keys(errors).forEach(key => {
                        const errorMsg = Array.isArray(errors[key]) ? errors[key][0] : errors[key];
                        $(`#${key}-error`).text(errorMsg);
                        $(`#${key}`).addClass('border-red-500');
                    });
                } catch (e) {
                    console.error('Error parsing response:', e);
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while processing the response',
                        icon: 'error'
                    });
                }
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: 'An error occurred while saving the blog',
                    icon: 'error'
                });
            }
        }
    });
});

// Cek token saat halaman dimuat
$(document).ready(function() {
    const token = localStorage.getItem('token');
    if (!token) {
        window.location.href = '/login';
    }
});
</script>
@endpush
