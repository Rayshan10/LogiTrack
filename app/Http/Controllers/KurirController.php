<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KurirController extends Controller
{
    public function index()
    {
        $kurir = User::where(
            'role',
            'kurir'
        )->get();

        return view(
            'kurir-admin.index',
            compact('kurir')
        );
    }

    public function create()
    {
        return view(
            'kurir-admin.create'
        );
    }

    public function store(Request $request)
    {
        $request->validate([

            'name' => 'required',

            'email' => 'required|email|unique:users',

            'password' => 'required|min:6',

        ]);

        User::create([

            'name' => $request->name,

            'email' => $request->email,

            'password' => Hash::make(
                $request->password
            ),

            'role' => 'kurir',

        ]);

        return redirect()
            ->route('kurir.index')
            ->with(
                'success',
                'Kurir berhasil ditambahkan'
            );
    }

    public function edit($id)
    {
        $kurir = User::findOrFail($id);

        return view(
            'kurir-admin.edit',
            compact('kurir')
        );
    }

    public function update(Request $request, $id)
    {
        $kurir = User::findOrFail($id);

        $request->validate([

            'name' => 'required',

            'email' => 'required|email',

        ]);

        $kurir->update([

            'name' => $request->name,

            'email' => $request->email,

        ]);

        return redirect()
            ->route('kurir.index')
            ->with(
                'success',
                'Data kurir berhasil diperbarui'
            );
    }

    public function destroy($id)
    {
        $kurir = User::findOrFail($id);

        $kurir->delete();

        return redirect()
            ->route('kurir.index')
            ->with(
                'success',
                'Kurir berhasil dihapus'
            );
    }
}