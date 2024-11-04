@extends('layout')

@section('title')
    Create New Address for {{ $user->name }}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('user.index') }}" class="text-green-600 hover:text-green-800">Data User</a></li>
<li class="breadcrumb-item"><a href="{{ route('address.index', $user_id) }}" class="text-green-600 hover:text-green-800">Data Address of {{ $user->name }}</a></li>
<li class="breadcrumb-item active">Create New Address</li>
@endsection

@section('content')
    <div class="bg-green-50 rounded-lg shadow-md p-6">
        <p class="block text-gray-700 text-2xl font-bold mb-2">Form Add Address</p>
        <form action="{{ route('address.store', $user_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="receiver_name">Receiver Name :</label>
                <input type="text" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 @error('receiver_name') border-red-500 @enderror"
                    id="receiver_name" name="receiver_name" value="{{ old('receiver_name') }}">
                @error('receiver_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="address">Address :</label>
                <input type="text" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 @error('address') border-red-500 @enderror"
                    id="address" name="address" value="{{ old('address') }}">
                @error('address')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="note">Note :</label>
                <input type="text" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 @error('note') border-red-500 @enderror"
                    id="note" name="note" value="{{ old('note') }}">
                @error('note')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="province">Province :</label>
                <input type="text" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 @error('province') border-red-500 @enderror"
                    id="province" name="province" value="{{ old('province') }}">
                @error('province')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="district">District :</label>
                <input type="text" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 @error('district') border-red-500 @enderror"
                    id="district" name="district" value="{{ old('district') }}">
                @error('district')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="subdistrict">Subdistrict :</label>
                <input type="text" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 @error('subdistrict') border-red-500 @enderror"
                    id="subdistrict" name="subdistrict" value="{{ old('subdistrict') }}">
                @error('subdistrict')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="postcode">Postcode :</label>
                <input type="number" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 @error('postcode') border-red-500 @enderror"
                    id="postcode" name="postcode" value="{{ old('postcode') }}">
                @error('postcode')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit" class="px-4 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    Submit
                </button>
                <a href="{{ route('address.index', $user_id) }}">
                    <button type="button" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                        Back
                    </button>
                </a>
            </div>
        </form>
    </div>
@endsection
