@extends('layout')

@section('title')
    Create New Blog
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('blog.index') }}" class="text-green-600 hover:text-green-800">Data Blog</a></li>
<li class="breadcrumb-item active">Create New Blog</li>
@endsection

@section('content')
    <div class="bg-green-50 rounded-lg shadow-md p-6">
        <p class="block text-gray-700 text-2xl font-bold mb-2">Form Add Blog</p>
        <form action="{{ route('blog.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="title">Judul Blog :</label>
                <input type="text" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 @error('title') border-red-500 @enderror"
                    id="title" name="title" value="{{ old('title') }}">
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="content">Deskripsi Blog :</label>
                <textarea class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 @error('description') border-red-500 @enderror"
                    id="description" name="description" rows="6">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="image">Gambar Blog :</label>
                <input type="file" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 @error('blog_picture') border-red-500 @enderror"
                    id="image" name="image">
                @error('image')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="blog_link">Link Blog :</label>
                <input type="text" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 @error('blog_link') border-red-500 @enderror"
                    id="blog_link" name="blog_link" value="{{ old('blog_link') }}">
                @error('blog_link')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit" class="px-4 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500">
                    Submit
                </button>
                <a href="{{ route('blog.index') }}">
                    <button type="button" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                        Back
                    </button>
                </a>
            </div>
        </form>
    </div>
@endsection
