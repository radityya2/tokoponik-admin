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
                    name="photos[]"
                    accept="image/jpeg,image/png,image/jpg"
                    multiple>
                <p class="text-red-500 text-xs mt-1 error-message" id="photos-error"></p>
                <div id="preview" class="mt-2 flex flex-wrap gap-2"></div>
            </div>

            <div id="linkContainer">
                <div class="mb-6">
                    <label class="block text-gray-800 text-sm font-semibold mb-3">Links</label>
                    <div class="flex gap-2">
                        <input type="url"
                            class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400"
                            name="links[]"
                            placeholder="Masukkan link blog">
                        <button type="button" onclick="addLinkField()" class="px-4 py-2 bg-green-500 text-white rounded-lg">
                            +
                        </button>
                    </div>
                    <p class="text-red-500 text-xs mt-1 error-message" id="links-error"></p>
                </div>
            </div>

            <div class="flex gap-4 mt-8">
                <button type="submit" id="submitBtn" class="flex items-center px-6 py-2.5 bg-green-800 text-white rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Submit
                </button>
                <a href="{{ route('blog.index') }}" class="flex items-center px-6 py-2.5 bg-red-700 text-white rounded-lg hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
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
// Fungsi untuk menambah field link
function addLinkField() {
    const container = document.createElement('div');
    container.className = 'mb-6';
    container.innerHTML = `
        <div class="flex gap-2">
            <input type="url"
                class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400"
                name="links[]"
                placeholder="Masukkan link blog">
            <button type="button" onclick="this.parentElement.remove()" class="px-4 py-2 bg-red-500 text-white rounded-lg">
                -
            </button>
        </div>
    `;
    document.getElementById('linkContainer').appendChild(container);
}

// Preview gambar sebelum upload
function previewImages(event) {
    const preview = document.getElementById('preview');
    preview.innerHTML = '';

    const files = event.target.files;

    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        if (!file.type.startsWith('image/')) continue;

        const reader = new FileReader();
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'relative';
            div.innerHTML = `
                <img src="${e.target.result}" class="h-20 w-20 object-cover rounded">
                <button type="button" onclick="this.parentElement.remove()"
                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center">
                    ×
                </button>
            `;
            preview.appendChild(div);
        }
        reader.readAsDataURL(file);
    }
}

// Event listener untuk preview gambar
document.getElementById('photos').addEventListener('change', previewImages);

$(document).ready(function() {
    // Cek token saat halaman dimuat
    const token = localStorage.getItem('token');
    if (!token) {
        window.location.href = '/login';
        return;
    }

    $('#createBlogForm').on('submit', function(e) {
        e.preventDefault();
        console.log('Form submitted'); // Debug

        const token = localStorage.getItem('token');
        const formData = new FormData(this);

        // Debug form data
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        // Client-side validation
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

        if (!isValid) return false;

        // Kirim request ke API
        $.ajax({
            url: 'http://127.0.0.1:8000/api/auth/blogs/store',
            method: 'POST',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log('Success:', response);
                Swal.fire({
                    title: 'Success!',
                    text: 'Blog has been successfully added',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/blog';
                    }
                });
            },
            error: function(xhr, status, error) {
                console.log('Error Status:', xhr.status);
                console.log('Error Response:', xhr.responseText);

                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    Object.keys(errors).forEach(function(key) {
                        $(`#${key}-error`).text(errors[key][0]);
                        $(`#${key}`).addClass('border-red-500');
                    });
                } else {
                    alert('Terjadi kesalahan saat menyimpan blog');
                }
            }
        });
    });

    // Reset error state saat input berubah
    $('input, textarea').on('input', function() {
        $(this).removeClass('border-red-500');
        const name = $(this).attr('name');
        const baseKey = name.replace('[]', '');
        $(`#${baseKey}-error`).text('');
    });
});
</script>
@endpush
