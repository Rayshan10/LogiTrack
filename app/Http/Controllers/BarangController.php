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

            // =========================
            // FIELD SAW
            // =========================

            'urgensi' => $request->urgensi,

            'lama_penyimpanan' => $request->lama_penyimpanan,

            'tingkat_keterlambatan' => $request->tingkat_keterlambatan,

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

        $this->prosesSAW();

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

        $this->prosesSAW();

        return redirect('/barang')
            ->with(
                'success',
                'Data barang berhasil diupdate'
            );
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();

        $this->prosesSAW();

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
        $url = trim($request->kode_barang);

        $path = parse_url($url, PHP_URL_PATH);
        $kodeBarang = basename($path);

        $barang = Barang::whereRaw(
            'TRIM(LOWER(kode_barang)) = ?',
            [trim(strtolower($kodeBarang))]
        )->first();

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Barang tidak ditemukan'
            ]);
        }

        // update status barang utama
        $barang->status = $request->status;
        $barang->save();

        // tambah timeline tracking
        Tracking::create([
            'barang_id' => $barang->id,
            'status'    => $request->status,
            'lokasi'    => $request->lokasi,
        ]);

        // reload relasi terbaru
        $barang->load('trackings');

        return response()->json([
            'success' => true,
            'barang' => $barang
        ]);
    }

    private function prosesSAW()
    {
        $barang = Barang::all();

        /*
        |--------------------------------------------------------------------------
        | Cari nilai maksimum
        |--------------------------------------------------------------------------
        */

        $maxUrgensi =
            Barang::max('urgensi');

        $maxLamaPenyimpanan =
            Barang::max('lama_penyimpanan');

        $maxKeterlambatan =
            Barang::max('tingkat_keterlambatan');

        /*
        |--------------------------------------------------------------------------
        | Bobot SAW
        |--------------------------------------------------------------------------
        */

        $bobotUrgensi = 0.40;

        $bobotLamaPenyimpanan = 0.35;

        $bobotKeterlambatan = 0.25;

        /*
        |--------------------------------------------------------------------------
        | Perhitungan SAW
        |--------------------------------------------------------------------------
        */

        foreach($barang as $b)
        {
            $rUrgensi =
                $b->urgensi /
                $maxUrgensi;

            $rLamaPenyimpanan =
                $b->lama_penyimpanan /
                $maxLamaPenyimpanan;

            $rKeterlambatan =
                $b->tingkat_keterlambatan /
                $maxKeterlambatan;

            $nilaiSAW =

                ($rUrgensi *
                    $bobotUrgensi)

                +

                ($rLamaPenyimpanan *
                    $bobotLamaPenyimpanan)

                +

                ($rKeterlambatan *
                    $bobotKeterlambatan);

            $b->update([

                'nilai_saw' =>
                    round($nilaiSAW, 3)

            ]);
        }
    }

    public function hitungSAW()
    {
        $this->prosesSAW();

        return redirect('/dashboard')
            ->with(
                'success',
                'Perhitungan SAW berhasil'
            );
    }

    public function exportSAWPDF()
    {
        /*
        |--------------------------------------------------------------------------
        | Ambil ranking SAW
        |--------------------------------------------------------------------------
        */

        $rankingSAW = Barang::query();

        /*
        |--------------------------------------------------------------------------
        | Filter prioritas SAW
        |--------------------------------------------------------------------------
        */

        if(request('prioritas'))
        {
            if(request('prioritas')
                == 'sangat_prioritas')
            {
                $rankingSAW->where(
                    'nilai_saw',
                    '>=',
                    0.80
                );
            }

            elseif(request('prioritas')
                == 'prioritas')
            {
                $rankingSAW
                    ->whereBetween(
                        'nilai_saw',
                        [0.60, 0.79]
                    );
            }

            elseif(request('prioritas')
                == 'normal')
            {
                $rankingSAW->where(
                    'nilai_saw',
                    '<',
                    0.60
                );
            }
        }

        $rankingSAW =
            $rankingSAW
                ->orderByDesc('nilai_saw')
                ->get();

        /*
        |--------------------------------------------------------------------------
        | Generate PDF
        |--------------------------------------------------------------------------
        */

        $pdf = Pdf::loadView(

            'barang.export-saw-pdf',

            compact('rankingSAW')

        );

        /*
        |--------------------------------------------------------------------------
        | Download PDF
        |--------------------------------------------------------------------------
        */

        return $pdf->download(
            'laporan-saw-distribusi.pdf'
        );
    }
}