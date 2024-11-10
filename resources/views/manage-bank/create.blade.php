@extends('layout')

@section('title')
    Tambah Bank
@endsection

@section('content')
    <div class="bg-green-50 rounded-lg shadow-md p-8">
        <div class="border-b border-gray-200 mb-6">
            <p class="text-gray-800 text-2xl font-bold mb-3">Form Add Bank</p>
        </div>

        <form action="{{ route('bank.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-gray-800 text-sm font-semibold mb-2" for="owner_name">Owner Name</label>
                <input type="text"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 @error('owner_name') border-red-500 @enderror"
                    id="owner_name"
                    name="owner_name"
                    placeholder="Masukkan nama pemilik bank"
                    value="{{ old('owner_name') }}">
                @error('owner_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-800 text-sm font-semibold mb-2" for="bank_name">Bank Name</label>
                <input type="text"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 @error('bank_name') border-red-500 @enderror"
                    id="bank_name"
                    name="bank_name"
                    placeholder="Masukkan nama bank"
                    value="{{ old('bank_name') }}">
                @error('bank_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-800 text-sm font-semibold mb-2" for="number">Number</label>
                <input type="text"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 @error('number') border-red-500 @enderror"
                    id="number"
                    name="number"
                    placeholder="Masukkan nomor bank"
                    value="{{ old('number') }}">
                @error('number')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4 mt-8">
                <button type="submit" class="flex items-center px-6 py-2.5 bg-green-800 text-white rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan
                </button>
                <a href="{{ route('bank.index') }}">
                    <button type="button" class="flex items-center px-6 py-2.5 bg-red-700 text-white rounded-lg hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Batal
                    </button>
                </a>
            </div>
        </form>
    </div>
@endsection
