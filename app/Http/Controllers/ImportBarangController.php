<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Tracking;
use SplFileObject;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ImportBarangController extends Controller
{
    public function index()
    {
        return view('barang.import');
    }

    public function store(Request $request)
    {
        $request->validate([
        'file' => 'required|mimes:csv,txt|max:204800'
        ]);

        // Simpan file ke storage/app/imports
        $path = $request->file('file')->store('imports');

        // Simpan path ke session
        session([
            'import_file' => $path
        ]);

        $csv = new SplFileObject(
            storage_path('app/private/' . $path)
        );

        $csv->setFlags(
            SplFileObject::READ_CSV |
            SplFileObject::SKIP_EMPTY
        );

        $header = [];
        $preview = [];
        $totalRows = 0;

        foreach ($csv as $index => $row) {

            if ($row == [null]) {
                continue;
            }

            if ($index == 0) {
                $header = $row;
                continue;
            }

            $totalRows++;

            if (count($preview) < 20) {
                $preview[] = $row;
            }
        }

        return view(
            'barang.preview',
            compact(
                'header',
                'preview',
                'totalRows'
            )
        );
    }

    public function process(Request $request)
    {

        DB::beginTransaction();

        try {

            $path = storage_path(
                'app/private/' . session('import_file')
            );

            $csv = new SplFileObject($path);

            $csv->setFlags(
                SplFileObject::READ_CSV |
                SplFileObject::SKIP_EMPTY
            );

            $limit = (int) $request->limit;

            $header = [];

            $imported = 0;

            $lastBarang = Barang::orderBy('id', 'desc')->first();

            $nomor = 1;

            if ($lastBarang) {

                $nomor = (int) substr(
                    $lastBarang->kode_barang,
                    3
                ) + 1;
            }

            foreach ($csv as $index => $row) {

                if ($row == [null]) {
                    continue;
                }

                if ($index == 0) {

                    $header = array_flip($row);

                    continue;
                }

                if ($limit != 0 && $imported >= $limit) {
                    break;
                }

                // Pastikan kolom wajib ada
                if (
                    !isset($header['Product Name']) ||
                    !isset($header['Category Name']) ||
                    !isset($header['Order Item Quantity']) ||
                    !isset($header['Days for shipping (real)']) ||
                    !isset($header['Late_delivery_risk']) ||
                    !isset($header['Shipping Mode'])
                ) {
                    continue;
                }

                $namaBarang = trim(
                    $row[$header['Product Name']]
                );

                $kategori = trim(
                    $row[$header['Category Name']]
                );

                // Lewati jika barang sudah ada
                if (
                    Barang::where('nama_barang', $namaBarang)
                        ->where('kategori', $kategori)
                        ->exists()
                ) {
                    continue;
                }

                $status = 'Barang Diproses';

                $lama = (int) $row[$header['Days for shipping (real)']];

                $late = (int) $row[$header['Late_delivery_risk']];

                $shipping = $row[$header['Shipping Mode']];

                $urgensi = $this->generateUrgensi(
                    $late,
                    $lama,
                    $shipping
                );

                $kodeBarang = 'BRG' . str_pad(
                    $nomor,
                    6,
                    '0',
                    STR_PAD_LEFT
                );

                $barang = Barang::create([

                    'kode_barang' => $kodeBarang,

                    'nama_barang' => $namaBarang,

                    'kategori' => $kategori,

                    'jumlah' => (int) $row[$header['Order Item Quantity']],

                    'deskripsi' => $shipping,

                    'status' => $status,

                    'urgensi' => $urgensi,

                    'lama_penyimpanan' => $lama,

                    'tingkat_keterlambatan' => $late,

                    'nilai_saw' => null

                ]);

                // Generate QR Code
                $qr = base64_encode(

                    QrCode::format('svg')
                        ->size(250)
                        ->generate($barang->kode_barang)

                );

                $barang->update([

                    'qr_code' => $qr

                ]);

                // Tracking pertama
                Tracking::create([

                    'barang_id' => $barang->id,

                    'user_id' => Auth::id() ?? 1,

                    'status' => 'Barang Diproses',

                    'lokasi' => 'Gudang Utama',

                    'keterangan' => 'Barang berhasil diimport dari Dataset Kaggle'

                ]);

                $nomor++;

                $imported++;
            }

            DB::commit();

            return redirect()
                ->route('barang.index')
                ->with(
                    'success',
                    $imported . ' data berhasil diimport.'
                );

        } catch (\Exception $e) {

    DB::rollBack();

    dd($e->getMessage(), $e->getLine(), $e->getFile());
}
    }

    private function generateUrgensi(
        int $lateRisk,
        int $lamaPengiriman,
        string $shippingMode
    ): int {

        if ($lateRisk == 1) {
            return 5;
        }

        if ($shippingMode == 'Same Day') {
            return 5;
        }

        if ($shippingMode == 'First Class') {
            return 4;
        }

        if ($lamaPengiriman >= 5) {
            return 4;
        }

        if ($shippingMode == 'Second Class') {
            return 3;
        }

        return 2;
    }
}