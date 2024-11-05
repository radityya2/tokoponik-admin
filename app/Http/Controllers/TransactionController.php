<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Bank;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::latest()->paginate(10);
        return view('manage-transaction.index', compact('transactions'));
    }

    public function create()
    {
        $banks = Bank::all();
        return view('manage-transaction.create', compact('banks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bank_id' => 'required|exists:banks,id',
            'grand_total' => 'required|numeric|min:0',
            'proof' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        try {
            $proof = $request->file('proof')->store('proofs', 'public');

            $transaction = Transaction::create([
                'user_id' => 1,
                'bank_id' => $validated['bank_id'],
                'grand_total' => $validated['grand_total'],
                'status' => 'pending',
                'proof' => $proof
            ]);

            return redirect()->route('manage-transaction.index')
                ->with('success', 'Transaksi berhasil dibuat');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat membuat transaksi')
                ->withInput();
        }
    }

    public function show(Transaction $transaction)
    {
        return view('manage-transaction.show', compact('transaction'));
    }

    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        $banks = Bank::all();
        return view('manage-transaction.edit', compact('transaction', 'banks'));
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        $validated = $request->validate([
            'bank_id' => 'required|exists:banks,id',
            'grand_total' => 'required|numeric|min:0',
            'status' => 'required|in:pending,success,failed',
            'proof' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        try {
            if ($request->hasFile('proof')) {
                if ($transaction->proof && Storage::disk('public')->exists($transaction->proof)) {
                    Storage::disk('public')->delete($transaction->proof);
                }
                $validated['proof'] = $request->file('proof')->store('proofs', 'public');
            }

            $transaction->update($validated);

            return redirect()->route('manage-transaction.index')
                ->with('success', 'Transaksi berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui transaksi')
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        Storage::disk('public')->delete($transaction->proof);
        $transaction->delete();

        return redirect()->route('manage-transaction.index')
            ->with('success', 'Transaksi berhasil dihapus');
    }
}
