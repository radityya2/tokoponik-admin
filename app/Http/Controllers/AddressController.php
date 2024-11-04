<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\User;

class AddressController extends Controller
{
    public function index(String $user_id)
    {
        $user = User::where('id', $user_id)->first();
        $addresses = Address::where('user_id', $user_id)->get();
        return view("manage-address.index", compact("addresses", "user", "user_id"));
    }

    public function create(String $user_id)
    {
        $user = User::where('id', $user_id)->first();
        return view("manage-address.create", compact("user", "user_id"));
    }

    public function store(Request $request, String $user_id)
    {
        $request->validate(
            [
                'receiver_name' => 'required',
                'address' => 'required',
                'province' => 'required',
                'district' => 'required',
                'subdistrict' => 'required',
                'postcode' => 'required'
            ],
            [
                'receiver_name.required' => 'Nama penerima wajib diisi',
                'address.required' => 'Alamat wajib diisi',
                'province.required' => 'Provinsi wajib diisi',
                'district.required' => 'Kota/Kabupaten wajib diisi',
                'subdistrict.required' => 'Kecamatan wajib diisi',
                'postcode.required' => 'Kecamatan wajib diisi'
            ]
        );

        Address::create([
            'user_id' => $user_id,
            'receiver_name' => $request->receiver_name,
            'address' => $request->address,
            'note' => $request->note,
            'province' => $request->province,
            'district' => $request->district,
            'subdistrict' => $request->subdistrict,
            'postcode' => $request->postcode
        ]);

        return redirect()->route('address.index', $user_id);
    }

    public function edit(String $id)
    {
        $query = Address::where('id', $id)->first();
        return view("manage-address.edit", compact("query"));
    }

    public function update(Request $request, String $id)
    {
        $request->validate(
            [
                'receiver_name' => 'required',
                'address' => 'required',
                'province' => 'required',
                'district' => 'required',
                'subdistrict' => 'required',
                'postcode' => 'required'
            ],
            [
                'receiver_name.required' => 'Nama penerima wajib diisi',
                'address.required' => 'Alamat wajib diisi',
                'province.required' => 'Provinsi wajib diisi',
                'district.required' => 'Kota/Kabupaten wajib diisi',
                'subdistrict.required' => 'Kecamatan wajib diisi',
                'postcode.required' => 'Kecamatan wajib diisi'
            ]
        );

        Address::where('id', $id)->update([
            'receiver_name' => $request->receiver_name,
            'address' => $request->address,
            'note' => $request->note,
            'province' => $request->province,
            'district' => $request->district,
            'subdistrict' => $request->subdistrict,
            'postcode' => $request->postcode
        ]);

        $address = Address::where('id', $id)->first();
        return redirect()->route('address.index', $address->user_id);
    }

    public function destroy(String $id)
    {
        $address1 = Address::findOrFail($id);
        $address2 = Address::where('id', $id)->first();

        if ($address1 != null) {
            $address1->delete();
        } else {
            return to_route('address.index', $address2->user_id)->with('error', 'Alamat gagal dihapus');
        }

        return to_route('address.index', $address2->user_id)->with('success', 'Alamat berhasil dihapus');
    }
}
