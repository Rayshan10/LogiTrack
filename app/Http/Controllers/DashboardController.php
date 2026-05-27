<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Tracking;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang =
            Barang::count();

        $barangDiproses =
            Barang::where(
                'status',
                'Barang Diproses'
            )->count();

        $barangDikirim =
            Barang::where(
                'status',
                'Barang Dikirim'
            )->count();

        $barangSampaiGudang =
            Barang::where(
                'status',
                'Barang Sampai Gudang'
            )->count();

        $barangDiterima =
            Barang::where(
                'status',
                'Barang Diterima'
            )->count();

        $trackingTerbaru =
            Tracking::with('barang')
                    ->latest()
                    ->take(5)
                    ->get();
        
        $rankingSAW = 
            Barang::orderByDesc(
                'nilai_saw'
            )->get();

        return view('dashboard', compact(

            'totalBarang',

            'barangDiproses',

            'barangDikirim',

            'barangSampaiGudang',

            'barangDiterima',

            'trackingTerbaru',

            'rankingSAW'

        ));
    }
}