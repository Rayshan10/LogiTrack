<?php

namespace App\Http\Controllers;

use App\Models\Tracking;
use Illuminate\Support\Facades\Auth;

class RiwayatPengirimanController extends Controller
{
    public function index()
    {
        $riwayat = Tracking::with(
                'barang',
                'user'
            )
            ->where(
                'user_id',
                Auth::id()
            )
            ->latest()
            ->get();

        $totalPengiriman = Tracking::where(
            'user_id',
            Auth::id()
        )->count();

        $barangDikirim = Tracking::where(
            'user_id',
            Auth::id()
        )
        ->where(
            'status',
            'Barang Dikirim'
        )
        ->count();

        $barangDiterima = Tracking::where(
            'user_id',
            Auth::id()
        )
        ->where(
            'status',
            'Barang Diterima'
        )
        ->count();

        return view(
            'kurir.riwayat',
            compact(
                'riwayat',
                'totalPengiriman',
                'barangDikirim',
                'barangDiterima'
            )
        );
    }
}