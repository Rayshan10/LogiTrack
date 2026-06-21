<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tracking;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index');
    }

    public function export(Request $request)
    {
        $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
        ]);

        $tracking = Tracking::with([
                'barang',
                'user'
            ])
            ->whereBetween('created_at', [
                $request->tanggal_awal . ' 00:00:00',
                $request->tanggal_akhir . ' 23:59:59'
            ])
            ->latest()
            ->get();

        $pdf = Pdf::loadView(
            'laporan.pdf',
            [
                'tracking' => $tracking,
                'awal' => $request->tanggal_awal,
                'akhir' => $request->tanggal_akhir,
            ]
        );

        $pdf->setPaper('A4', 'landscape');

        return $pdf->download(
            'Laporan-Distribusi-' .
            $request->tanggal_awal .
            '-sampai-' .
            $request->tanggal_akhir .
            '.pdf'
        );
    }
}