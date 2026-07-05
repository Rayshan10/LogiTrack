<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use SplFileObject;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
        $path = storage_path(
            'app/private/' .
            session('import_file')
        );

        $csv = new SplFileObject($path);

        $csv->setFlags(
            SplFileObject::READ_CSV |
            SplFileObject::SKIP_EMPTY
        );

        $limit = (int) $request->limit;

        $header = [];
        $imported = 0;

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

            $status = $this->convertStatus(
                $row[$header['Delivery Status']]
            );

            $lama = (int) $row[$header['Days for shipping (real)']];

            $late = (int) $row[$header['Late_delivery_risk']];

            $shipping = $row[$header['Shipping Mode']];

            $urgensi = $this->generateUrgensi(
                $late,
                $lama,
                $shipping
            );

            dd($urgensi);

            // nanti isi proses import di sini

            $imported++;
        }

        dd($imported);
    }

    private function convertStatus(string $status): string
    {
        return match($status){
            'Advance shipping' => 'Barang Diproses',
            'Shipping on time' => 'Barang Dikirim',
            'Late delivery' => 'Barang Sampai Gudang',
            'Shipping canceled' => 'Barang Diproses',
            default => 'Barang Diproses'
        };
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