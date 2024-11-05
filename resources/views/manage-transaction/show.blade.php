@extends('layout')

@section('title')
    Detail Transaksi
@endsection

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detail Transaksi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">User</th>
                        <td>{{ $transaction->user->name }}</td>
                    </tr>
                    <tr>
                        <th>Bank</th>
                        <td>{{ $transaction->bank->owner_name }} - {{ $transaction->bank->number }}</td>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <td>Rp {{ number_format($transaction->grand_total) }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge badge-{{ $transaction->status == 'success' ? 'success' : ($transaction->status == 'pending' ? 'warning' : 'danger') }}">
                                {{ $transaction->status }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Bukti Transfer</th>
                        <td><img src="{{ Storage::url($transaction->proof) }}" width="200"></td>
                    </tr>
                </table>
                <a href="{{ route('transaction.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
