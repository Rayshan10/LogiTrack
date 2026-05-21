<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Tracking;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::all();
        return view('barang.index', compact('barang'));
    }

    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|unique:barangs',
            'nama_barang' => 'required',
            'kategori' => 'required',
            'jumlah' => 'required|integer',
        ]);

        $barang = Barang::create([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'kategori' => $request->kategori,
            'jumlah' => $request->jumlah,
            'deskripsi' => $request->deskripsi,
        ]);

        Tracking::create([
            'barang_id' => $barang->id,
            'status' => 'Barang Diproses',
            'lokasi' => 'Gudang Utama',
        ]);

        $qr = base64_encode(
            QrCode::format('svg')
                ->size(500)
                ->margin(2)
                ->generate(url('/barang/' . $barang->id))
        );

        $barang->update([
        'qr_code' => $qr
        ]);

        return redirect('/barang')->with('success', 'Data barang berhasil ditambahkan');
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);
        $barang->update($request->all());

        return redirect('/barang')
            ->with('success', 'Data barang berhasil diupdate');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect('/barang')
            ->with('success', 'Data barang berhasil dihapus');
    }

    public function show(Barang $barang)
    {
        $barang->load('trackings');

        return view('barang.show', compact('barang'));
    }

    public function downloadQr($id)
    {
        $barang = Barang::findOrFail($id);

        $qr = base64_decode($barang->qr_code);

        return response($qr)
            ->header('Content-Type', 'image/svg+xml')
            ->header(
                'Content-Disposition',
                'attachment; filename="qr-'.$barang->kode_barang.'.svg"'
            );
    }

    public function printQr($id)
    {
        $barang = Barang::findOrFail($id);

        return view('barang.print-qr', compact('barang'));
    }

    public function exportPdfQr()
    {
        $barang = Barang::all();

        $pdf = Pdf::loadView(
            'barang.export-pdf-qr',
            compact('barang')
        );

        return $pdf->download('qr-barang.pdf');
    }
}