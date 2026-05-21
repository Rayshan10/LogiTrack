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

            'status' => 'Barang Diproses',

        ]);

        Tracking::create([

            'barang_id' => $barang->id,

            'status' => 'Barang Diproses',

            'lokasi' => 'Gudang Utama',

        ]);

        /*
        |--------------------------------------------------------------------------
        | Generate QR Code
        |--------------------------------------------------------------------------
        | QR sekarang berisi:
        | http://127.0.0.1:8000/barang/BRG001
        */

        $trackingUrl =
            url('/barang/' . $barang->kode_barang);

        $qr = base64_encode(

            QrCode::format('svg')
                ->size(500)
                ->margin(2)
                ->generate($trackingUrl)

        );

        $barang->update([

            'qr_code' => $qr

        ]);

        return redirect('/barang')
            ->with(
                'success',
                'Data barang berhasil ditambahkan'
            );
    }

    public function show(Barang $barang)
    {
        $barang->load('trackings');

        return view(
            'barang.show',
            compact('barang')
        );
    }

    public function edit(Barang $barang)
    {
        return view(
            'barang.edit',
            compact('barang')
        );
    }

    public function update(
        Request $request,
        Barang $barang
    )
    {
        $barang->update($request->all());

        return redirect('/barang')
            ->with(
                'success',
                'Data barang berhasil diupdate'
            );
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();

        return redirect('/barang')
            ->with(
                'success',
                'Data barang berhasil dihapus'
            );
    }

    public function downloadQr(Barang $barang)
    {
        $qr = base64_decode($barang->qr_code);

        return response($qr)

            ->header(
                'Content-Type',
                'image/svg+xml'
            )

            ->header(
                'Content-Disposition',
                'attachment; filename="qr-' .
                $barang->kode_barang .
                '.svg"'
            );
    }

    public function printQr(Barang $barang)
    {
        return view(
            'barang.print-qr',
            compact('barang')
        );
    }

    public function exportPdfQr()
    {
        $barang = Barang::all();

        $pdf = Pdf::loadView(
            'barang.export-pdf-qr',
            compact('barang')
        );

        return $pdf->download(
            'qr-barang.pdf'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Scan QR → Auto Update Status
    |--------------------------------------------------------------------------
    */

    public function scanUpdateStatus(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Ambil URL dari QR
        |--------------------------------------------------------------------------
        */

        $url = trim($request->kode_barang);

        /*
        |--------------------------------------------------------------------------
        | Ambil path URL
        | contoh:
        | /barang/BRG001
        |--------------------------------------------------------------------------
        */

        $path = parse_url(
            $url,
            PHP_URL_PATH
        );

        /*
        |--------------------------------------------------------------------------
        | Ambil kode barang
        |--------------------------------------------------------------------------
        */

        $kodeBarang = basename($path);

        /*
        |--------------------------------------------------------------------------
        | Cari barang berdasarkan kode_barang
        |--------------------------------------------------------------------------
        */

        $barang = Barang::where(
            'kode_barang',
            $request->kode_barang
        )->first();

        if (!$barang) {

            return response()->json([

                'success' => false

            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Update status barang
        |--------------------------------------------------------------------------
        */

        $barang->update([

            'status' => $request->status

        ]);

        /*
        |--------------------------------------------------------------------------
        | Tambahkan timeline tracking
        |--------------------------------------------------------------------------
        */

        Tracking::create([

            'barang_id' => $barang->id,

            'status' => $request->status,

            'lokasi' => $request->lokasi,

        ]);

        return response()->json([

            'success' => true,

            'barang' => $barang

        ]);
    }
}