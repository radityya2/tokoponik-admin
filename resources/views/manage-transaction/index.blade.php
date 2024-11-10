@extends('layout')

@section('title')
    All Transactions
@endsection

@section('content')
<!-- Main Content -->
<div class="flex-1 p-8 bg-pastel-50">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-forest-700">All Transactions</h1>

        <div class="flex items-center space-x-6">
            <input type="text"
                id="searchInput"
                placeholder="Search for transactions"
                class="bg-white border border-pastel-200 text-forest-600 px-5 py-2.5 rounded-lg focus:outline-none focus:border-forest-500">


        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="bg-forest-500 text-white">
                    <th class="py-4 px-6 text-left font-medium">No</th>
                    <th class="py-4 px-6 text-left font-medium">User</th>
                    <th class="py-4 px-6 text-left font-medium">Bank</th>
                    <th class="py-4 px-6 text-left font-medium">Total</th>
                    <th class="py-4 px-6 text-left font-medium">Status</th>
                    <th class="py-4 px-6 text-left font-medium">Proof</th>
                    <th class="py-4 px-6 text-left font-medium">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @if($transactions->count() != 0)
                    @foreach($transactions as $transaction)
                    <tr class="border-b border-gray-100 hover:bg-gray-50 text-sm">
                        <td class="py-4 px-6">{{ $loop->iteration }}</td>
                        <td class="py-4 px-6">{{ $transaction->user->name }}</td>
                        <td class="py-4 px-6">{{ $transaction->bank->owner_name }}</td>
                        <td class="py-4 px-6">Rp {{ number_format($transaction->grand_total) }}</td>
                        <td class="py-4 px-6">
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                {{ strtolower($transaction->status) === 'belum dibayar' ? 'bg-gray-500 text-white' :
                                   (strtolower($transaction->status) === 'dikemas' ? 'bg-yellow-500 text-white' :
                                   (strtolower($transaction->status) === 'dikirim' ? 'bg-blue-500 text-white' :
                                   (strtolower($transaction->status) === 'selesai' ? 'bg-emerald-500 text-white' :
                                   (strtolower($transaction->status) === 'dibatalkan' ? 'bg-red-500 text-white' : 'bg-primary-500 text-white')))) }}">
                                {{ str_replace('_', ' ', $transaction->status) }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <button onclick="showProof('{{ Storage::url($transaction->proof) }}')" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200 text-sm font-medium">
                                <i class="bi bi-search text-sm" style="margin-right: 0.25rem;"></i>
                                Proof of Payment
                            </button>
                        </td>

<!-- Tambahkan div untuk menampilkan gambar bukti pembayaran -->
<div id="proofModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
    <img id="proofImage" class="max-w-full max-h-full" src="" alt="Proof of Payment">
    <i onclick="closeProof()" class=" bi bi-x absolute top-4 right-4 bg-red-500 text-white px-2 py-1 rounded"></i>
</div>

<script>
    function showProof(imageUrl) {
        const proofModal = document.getElementById('proofModal');
        const proofImage = document.getElementById('proofImage');
        proofImage.src = imageUrl;
        proofModal.classList.remove('hidden');
    }

    function closeProof() {
        const proofModal = document.getElementById('proofModal');
        proofModal.classList.add('hidden');
    }
</script>
                        <td class="py-4 px-6">
                            <div class="flex items-center space-x-3">
                            <button onclick="toggleDropdown('{{ $transaction->id }}')" class="bg-{{ strtolower($transaction->status) }} hover:bg-forest-600 text-white px-4 py-2 rounded-lg transition duration-200 text-sm font-medium">
                                    {{ str_replace('_', ' ', $transaction->status) }}
                                </button>
                                <div id="dropdown-{{ $transaction->id }}" class="hidden absolute left-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-10">
                                    <form action="{{ route('transaction.updateStatus', $transaction->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" name="status" value="belum dibayar" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Belum Dibayar</button>
                                        <button type="submit" name="status" value="dikemas" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dikemas</button>
                                        <button type="submit" name="status" value="dikirim" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dikirim</button>
                                        <button type="submit" name="status" value="selesai" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Selesai</button>
                                        <button type="submit" name="status" value="dibatalkan" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dibatalkan</button>
                                    </form>
                                </div>
                                <a href="{{ route('transaction.destroy', $transaction->id) }}"
                                   onclick="return confirm('Yakin ingin menghapus?')"
                                   class="text-red-500 hover:text-red-700 transition duration-200"
                                   title="Delete Transaction">
                                    <i class="bi bi-trash3-fill text-xl" ></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="text-center py-8 text-gray-500">No data exists</td>
                    </tr>
                @endif
            </tbody>
        </table>
        {{ $transactions->links() }}
    </div>
</div>
@endsection
