<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Tracking;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = Barang::count();

        $totalKurir = User::where(
            'role',
            'kurir'
        )->count();

        $barangDiproses = Barang::where(
            'status',
            'Barang Diproses'
        )->count();

        $barangDikirim = Barang::where(
            'status',
            'Barang Dikirim'
        )->count();

        $barangDiterima = Barang::where(
            'status',
            'Barang Diterima'
        )->count();

        /*
        |--------------------------------------------------------------------------
        | Aktivitas Distribusi Terbaru
        |--------------------------------------------------------------------------
        */

        $trackingTerbaru = Tracking::with(
            'barang',
            'user'
        );

        if(request('kode_barang'))
        {
            $trackingTerbaru->whereHas(
                'barang',
                function($query)
                {
                    $query->where(
                        'kode_barang',
                        'like',
                        '%' .
                        request('kode_barang') .
                        '%'
                    );
                }
            );
        }

        if(request('status'))
        {
            $trackingTerbaru->where(
                'status',
                request('status')
            );
        }

        if(request('tanggal'))
        {
            $trackingTerbaru->whereDate(
                'created_at',
                request('tanggal')
            );
        }

        $trackingTerbaru = $trackingTerbaru
            ->latest()
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Grafik Distribusi Bulanan
        |--------------------------------------------------------------------------
        */

        $grafikStatus = [
    'Diproses' => $barangDiproses,
    'Dikirim' => $barangDikirim,
    'Diterima' => $barangDiterima,
];

        return view(
            'dashboard',
            compact(
                'totalBarang',
                'totalKurir',
                'barangDiproses',
                'barangDikirim',
                'barangDiterima',
                'trackingTerbaru',
                'grafikStatus'
            )
        );
    }
}