<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('id', 'asc')->get();
        return view("manage-product.index", compact("products"));
    }

    public function create()
    {
        return view("manage-product.create");
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'price' => 'required',
                'description' => 'required',
                'type' => 'required'
            ],
            [
                'name.required' => 'Nama wajib diisi',
                'price.required' => 'Harga wajib diisi',
                'description.required' => 'Deskripsi wajib diisi',
                'type.required' => 'Jenis produk wajib diisi',
            ]
        );

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'type' => $request->type
        ]);

        return redirect()->route('product.index');
    }

    public function edit(String $id)
    {
        $query = Product::where('id', $id)->first();
        return view("manage-product.edit", compact("query"));
    }

    public function update(Request $request, String $id)
    {
        $request->validate(
            [
                'name' => 'required',
                'price' => 'required',
                'description' => 'required',
                'type' => 'required'
            ],
            [
                'name.required' => 'Nama wajib diisi',
                'price.required' => 'Harga wajib diisi',
                'description.required' => 'Deskripsi wajib diisi',
                'type.required' => 'Jenis produk wajib diisi',
            ]
        );

        Product::where('id', $id)->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'type' => $request->type
        ]);

        return redirect()->route('product.index');
    }

    public function destroy(String $id)
    {
        $products = Product::findOrFail($id);
        
        if ($products != null) {
            $products->delete();
        } else {
            return to_route('product.index')->with('error', 'Produk gagal dihapus');
        }

        return to_route('product.index')->with('success', 'Produk berhasil dihapus');
    }
}
