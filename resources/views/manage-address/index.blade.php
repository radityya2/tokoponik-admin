@extends('layout')

@section('title')
    Data Address of {{ $user->name }}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('user.index') }}">Data User</a></li>
<li class="breadcrumb-item active">Data Address of {{ $user->name }}</li>
@endsection

@section('content')
<!-- Main Content -->
<div class="flex-1 p-8 bg-pastel-50">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-forest-600">All Address</h1>
    </div>

    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('address.create', $user_id) }}">
            <button class="bg-forest-600 hover:bg-forest-500 text-white px-4 py-2 rounded-lg">Add Data</button>
        </a>
        <a href="{{ route('user.index') }}">
            <button class="bg-danger-600 hover:bg-forest-500 text-white px-4 py-2 rounded-lg">Back</button>
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-pastel-100 text-forest-600">
                        <th class="px-4 py-3 text-left">#</th>
                        <th class="px-4 py-3 text-left">Receiver Name</th>
                        <th class="px-4 py-3 text-left">Address</th>
                        <th class="px-4 py-3 text-left">Note</th>
                        <th class="px-4 py-3 text-left">Province</th>
                        <th class="px-4 py-3 text-left">District</th>
                        <th class="px-4 py-3 text-left">Subdistrict</th>
                        <th class="px-4 py-3 text-left">Postcode</th>
                        <th class="px-4 py-3 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($addresses->count() != 0)
                        @foreach ($addresses as $a)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3">{{ $a->receiver_name }}</td>
                            <td class="px-4 py-3">{{ $a->address }}</td>
                            <td class="px-4 py-3">{{ $a->note ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $a->province }}</td>
                            <td class="px-4 py-3">{{ $a->district }}</td>
                            <td class="px-4 py-3">{{ $a->subdistrict }}</td>
                            <td class="px-4 py-3">{{ $a->postcode }}</td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <a href="{{ route('address.edit', $a->id) }}">
                                        <button class="bg-yellow-500 hover:bg-yellow-400 text-white px-3 py-1 rounded">Edit</button>
                                    </a>
                                    <a href="{{ route('address.destroy', $a->id) }}">
                                        <button class="bg-red-500 hover:bg-red-400 text-white px-3 py-1 rounded"
                                                onClick="return confirm('Ingin hapus alamat?')">Delete</button>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9" class="px-4 py-3 text-center">Tidak ada data</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
