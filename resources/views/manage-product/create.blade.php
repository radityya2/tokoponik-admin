@extends('layout')

@section('title')
    Create New Product
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('product.index') }}" class="text-green-600 hover:text-green-800">Data Product</a></li>
<li class="breadcrumb-item active">Create New Product</li>
@endsection

@section('content')
    <div class="bg-green-50 rounded-lg shadow-md p-6">
        <p class="block text-gray-700 text-2xl font-bold mb-2">Form Add Product</p>
        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Name :</label>
                <input type="text" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 @error('name') border-red-500 @enderror"
                    id="name" name="name" value="{{ old('name') }}">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="price">Price :</label>
                <div class="flex">
                    <span class="inline-flex items-center px-3 py-2 text-sm border border-r-0 rounded-l-lg bg-gray-50">Rp</span>
                    <input type="number" class="flex-1 px-3 py-2 border rounded-r-lg focus:outline-none focus:ring-2 focus:ring-green-400 @error('price') border-red-500 @enderror"
                        id="price" name="price" value="{{ old('price') }}">
                </div>
                @error('price')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Description :</label>
                <input type="text" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 @error('description') border-red-500 @enderror"
                    id="description" name="description" value="{{ old('description') }}">
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="type">Type :</label>
                <select class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 @error('type') border-red-500 @enderror"
                    id="type" name="type">
                    <option value="Vegetable">Vegetable</option>
                    <option value="Tools">Tools</option>
                    <option value="Seeds">Seeds</option>
                </select>
                @error('type')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit" class="px-4 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500">
                    Submit
                </button>
                <a href="{{ route('product.index') }}">
                    <button type="button" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                        Back
                    </button>
                </a>
            </div>
        </form>
    </div>
@endsection
