<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'asc')->get();
        return view("manage-user.index", compact("users"));
    }

    public function create()
    {
        return view("manage-user.create");
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'username' => 'required',
                'password' => 'required',
                'phone_number' => 'required',
                'role' => 'required',
            ],
            [
                'name.required' => 'Nama wajib diisi',
                'username.required' => 'Username wajib diisi',
                'password.required' => 'Deskripsi wajib diisi',
                'phone_number.required' => 'Nomor Telepon wajib diisi',
                'role.required' => 'Role wajib diisi',
            ]
        );

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'role' => $request->role,
        ]);

        return redirect()->route('user.index');
    }

    public function edit(String $id)
    {
        $query = User::where('id', $id)->first();
        return view("manage-user.edit", compact("query"));
    }

    public function update(Request $request, String $id)
    {
        $request->validate(
            [
                'name' => 'required',
                'username' => 'required',
                'phone_number' => 'required',
                'role' => 'required',
            ],
            [
                'name.required' => 'Nama wajib diisi',
                'username.required' => 'Username wajib diisi',
                'phone_number.required' => 'Nomor Telepon wajib diisi',
                'role.required' => 'Role wajib diisi',
            ]
        );

        User::where('id', $id)->update([
            'name' => $request->name,
            'username' => $request->username,
            'phone_number' => $request->phone_number,
            'role' => $request->role,
        ]);

        return redirect()->route('user.index');
    }

    public function destroy(String $id)
    {
        $user = User::findOrFail($id);
        if ($user != null) {
            $user->delete();
        } else {
            return to_route('user.index')->with('error', 'User gagal dihapus');
        }

        return to_route('user.index')->with('success', 'User berhasil dihapus');
    }
}
