@extends('layout')

@section('title')
    Edit Bank
@endsection

@section('content')
    <div class="flex-1 p-8 bg-pastel-50">
        <div class="max-w-2xl mx-auto">
            <h1 class="text-3xl font-bold text-forest-700 mb-8">Edit Data Bank</h1>

            <div class="bg-white rounded-xl shadow-sm p-8">
                <form action="{{ route('manage-bank.update', $bank->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="space-y-6">
                        <div>
                            <label for="owner_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Pemilik</label>
                            <input type="text" name="owner_name" id="owner_name" value="{{ $bank->owner_name }}" required
                                class="w-full bg-white border border-pastel-200 text-forest-600 px-4 py-2.5 rounded-lg focus:outline-none focus:border-forest-500 focus:ring-2 focus:ring-forest-200 transition-all duration-200">
                        </div>

                        <div>
                            <label for="number" class="block text-sm font-medium text-gray-700 mb-2">Nomor Rekening</label>
                            <input type="text" name="number" id="number" value="{{ $bank->number }}" required
                                class="w-full bg-white border border-pastel-200 text-forest-600 px-4 py-2.5 rounded-lg focus:outline-none focus:border-forest-500 focus:ring-2 focus:ring-forest-200 transition-all duration-200">
                        </div>

                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('manage-bank.index') }}">
                                <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2.5 rounded-lg transition duration-200 font-medium">
                                    Batal
                                </button>
                            </a>
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white px-6 py-2.5 rounded-lg transition duration-200 font-medium">
                                Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection 
