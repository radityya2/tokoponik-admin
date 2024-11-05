<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;

class BankController extends Controller
{
    public function index()
    {
        $banks = Bank::all();
        return view('manage-bank.index', compact('banks'));
    }

    public function create()
    {
        return view('manage-bank.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'owner_name' => 'required',
            'number' => 'required'
        ]);

        Bank::create($request->all());
        return redirect()->route('manage-bank.index')->with('success', 'Data bank berhasil ditambahkan');
    }

    public function edit($id)
    {
        $bank = Bank::findOrFail($id);
        return view('manage-bank.edit', compact('bank'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'owner_name' => 'required',
            'number' => 'required'
        ]);

        $bank = Bank::findOrFail($id);
        $bank->update($request->all());
        return redirect()->route('manage-bank.index')->with('success', 'Data bank berhasil diperbarui');
    }

    public function destroy($id)
    {
        $bank = Bank::findOrFail($id);
        $bank->delete();
        return redirect()->route('manage-bank.index')->with('success', 'Data bank berhasil dihapus');
    }
}
