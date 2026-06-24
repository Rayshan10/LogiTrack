<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Tracking;

class KurirController extends Controller
{
    public function index()
{
    $kurir = User::where(
        'role',
        'kurir'
    )
    ->withCount([
        'trackings as total_aktivitas',

        'trackings as barang_dikirim' => function ($q) {
            $q->where(
                'status',
                'Barang Dikirim'
            );
        },

        'trackings as barang_diterima' => function ($q) {
            $q->where(
                'status',
                'Barang Diterima'
            );
        }
    ])
    ->get();

    $topKurir = User::where(
        'role',
        'kurir'
    )
    ->withCount('trackings')
    ->orderByDesc('trackings_count')
    ->take(5)
    ->get();

    return view(
        'kurir-admin.index',
        compact(
            'kurir',
            'topKurir'
        )
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

    public function statistik($id)
    {
        $kurir = User::findOrFail($id);

        $totalAktivitas = Tracking::where(
            'user_id',
            $id
        )->count();

        $barangDikirim = Tracking::where(
            'user_id',
            $id
        )
        ->where(
            'status',
            'Barang Dikirim'
        )
        ->count();

        $barangDiterima = Tracking::where(
            'user_id',
            $id
        )
        ->where(
            'status',
            'Barang Diterima'
        )
        ->count();

        $aktivitasBulanan = Tracking::selectRaw(
                'MONTH(created_at) as bulan,
                COUNT(*) as total'
            )
            ->where(
                'user_id',
                $id
            )
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $riwayat = Tracking::with('barang')
            ->where('user_id', $id)
            ->latest()
            ->get();

        $persentaseKeberhasilan =
            $barangDikirim > 0
                ? round(($barangDiterima / $barangDikirim) * 100, 2)
                : 0;

        return view(
            'kurir-admin.statistik',
            compact(
                'kurir',
                'totalAktivitas',
                'barangDikirim',
                'barangDiterima',
                'aktivitasBulanan',
                'riwayat',
                'persentaseKeberhasilan'
            )
        );
    }
}