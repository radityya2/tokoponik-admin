@extends('layout')

@section('title')
    Edit Bank
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('bank.index') }}" class="text-green-600 hover:text-green-800">Data Bank</a></li>
<li class="breadcrumb-item active">Edit Bank</li>
@endsection

@section('content')
    <div class="bg-green-50 rounded-lg shadow-md p-8">
        <div class="border-b border-green-200 mb-6">
            <h1 class="text-gray-800 text-2xl font-bold mb-4">Form Edit Bank</h1>
        </div>

        <form action="{{ route('bank.update', $bank->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <div>
                    <label for="owner_name" class="block text-gray-800 text-sm font-semibold mb-3">Owner Name</label>
                    <input type="text" name="owner_name" id="owner_name" value="{{ $bank->owner_name }}" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 @error('owner_name') border-red-500 @enderror">
                    @error('owner_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="bank_name" class="block text-gray-800 text-sm font-semibold mb-3">Bank Name</label>
                    <input type="text" name="bank_name" id="bank_name" value="{{ $bank->bank_name }}" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 @error('bank_name') border-red-500 @enderror">
                    @error('bank_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="number" class="block text-gray-800 text-sm font-semibold mb-3">Number</label>
                    <input type="text" name="number" id="number" value="{{ $bank->number }}" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 @error('number') border-red-500 @enderror">
                    @error('number')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="flex items-center px-6 py-2.5 bg-green-800 hover:bg-green-600 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan
                    </button>
                    <a href="{{ route('bank.index') }}" class="flex items-center px-6 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
