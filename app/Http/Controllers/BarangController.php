<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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

    $qr = base64_encode(
        QrCode::format('svg')
            ->size(200)
            ->generate($request->kode_barang)
    );

    Barang::create([
        'kode_barang' => $request->kode_barang,
        'nama_barang' => $request->nama_barang,
        'kategori' => $request->kategori,
        'jumlah' => $request->jumlah,
        'deskripsi' => $request->deskripsi,
        'qr_code' => $qr,
    ]);

    return redirect('/barang')
        ->with('success', 'Data barang berhasil ditambahkan');
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
}