@extends('layout')

@section('title')
    Data Transaksi
@endsection


@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Transaksi</h6>
            <a href="{{ route('transaction.create') }}" class="btn btn-primary">Tambah Transaksi</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>User</th>
                            <th>Bank</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Bukti</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $transaction->user->name }}</td>
                            <td>{{ $transaction->bank->owner_name }}</td>
                            <td>Rp {{ number_format($transaction->grand_total) }}</td>
                            <td>
                                <span class="badge badge-{{ $transaction->status == 'success' ? 'success' : ($transaction->status == 'pending' ? 'warning' : 'danger') }}">
                                    {{ $transaction->status }}
                                </span>
                            </td>
                            <td>
                                <img src="{{ Storage::url($transaction->proof) }}" width="50">
                            </td>
                            <td>
                                <a href="{{ route('transaction.edit', $transaction->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <a href="{{ route('transaction.destroy', $transaction->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
