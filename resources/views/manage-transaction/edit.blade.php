@extends('layout')

@section('title')
    Edit Transaksi
@endsection

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Transaksi</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('transaction.update', $transaction->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Bank</label>
                    <select name="bank_id" class="form-control @error('bank_id') is-invalid @enderror">
                        <option value="">Pilih Bank</option>
                        @foreach($banks as $bank)
                            <option value="{{ $bank->id }}" {{ $transaction->bank_id == $bank->id ? 'selected' : '' }}>
                                {{ $bank->owner_name }} - {{ $bank->number }}
                            </option>
                        @endforeach
                    </select>
                    @error('bank_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Total</label>
                    <input type="number" name="grand_total" value="{{ $transaction->grand_total }}" class="form-control @error('grand_total') is-invalid @enderror">
                    @error('grand_total')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                        <option value="pending" {{ $transaction->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="success" {{ $transaction->status == 'success' ? 'selected' : '' }}>Success</option>
                        <option value="failed" {{ $transaction->status == 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Bukti Transfer</label>
                    <input type="file" name="proof" class="form-control @error('proof') is-invalid @enderror">
                    @if($transaction->proof)
                        <img src="{{ Storage::url($transaction->proof) }}" width="200" class="mt-2">
                    @endif
                    @error('proof')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('transaction.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
