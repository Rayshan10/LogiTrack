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

        $trackingTerbaru = Tracking::with(
            'barang',
            'user'
            );

        /*
        |--------------------------------------------------------------------------
        | Search kode barang
        |--------------------------------------------------------------------------
        */

        if(request('kode_barang'))
        {
            $trackingTerbaru->whereHas('barang',
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

        /*
        |--------------------------------------------------------------------------
        | Filter status
        |--------------------------------------------------------------------------
        */

        if(request('status'))
        {
            $trackingTerbaru->where(
                'status',
            request('status')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Filter tanggal
        |--------------------------------------------------------------------------
        */

        if(request('tanggal'))
        {
            $trackingTerbaru->whereDate(
                'created_at',
                request('tanggal')
            );
        }

        $trackingTerbaru =
            $trackingTerbaru
                ->latest()
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