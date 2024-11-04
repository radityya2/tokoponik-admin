@extends('layout')

@section('title')
    Edit User
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('user.index') }}" class="text-green-600 hover:text-green-800">Data User</a></li>
<li class="breadcrumb-item text-gray-500">Edit User</li>
@endsection

@section('content')
    <div class="bg-green-50 rounded-lg shadow-md p-6">
        <p class="block text-gray-700 text-2xl font-bold mb-2">Form Edit User</p>
        <form action="{{ route('user.update', $query->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Name :</label>
                <input type="text" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 @error('name') border-red-500 @enderror"
                    id="name" name="name" value="{{ $query->name }}">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="username">Username :</label>
                <input type="text" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 @error('username') border-red-500 @enderror"
                    id="username" name="username" value="{{ $query->username }}">
                @error('username')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="phone_number">Phone Number :</label>
                <div class="flex">
                    <span class="inline-flex items-center px-3 py-2 text-gray-600 bg-gray-100 border border-r-0 rounded-l-lg">+62</span>
                    <input type="text" class="flex-1 px-3 py-2 border rounded-r-lg focus:outline-none focus:ring-2 focus:ring-green-400 @error('phone_number') border-red-500 @enderror"
                        id="phone_number" name="phone_number" value="{{ $query->phone_number }}">
                </div>
                @error('phone_number')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="role">Role :</label>
                <select class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 @error('role') border-red-500 @enderror"
                    id="role" name="role">
                    <option value="admin" {{ $query->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="manager" {{ $query->role == 'manager' ? 'selected' : '' }}>Manager</option>
                    <option value="customer_service" {{ $query->role == 'customer_service' ? 'selected' : '' }}>Customer Service</option>
                    <option value="customer" {{ $query->role == 'customer' ? 'selected' : '' }}>Customer</option>
                </select>
                @error('role')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit" class="px-4 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500">
                    Submit
                </button>
                <a href="{{ route('user.index') }}">
                    <button type="button" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                        Back
                    </button>
                </a>
            </div>
        </form>
    </div>
@endsection
