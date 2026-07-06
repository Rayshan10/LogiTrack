<?php

namespace App\Imports;

use App\Models\Barang;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BarangImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        dd($rows->first());

        $no = Barang::count() + 1;

        foreach ($rows as $row) {

            /*
            |--------------------------------------------------------------------------
            | Konversi Status Dataset
            |--------------------------------------------------------------------------
            */

            $status = match (strtolower(trim($row['delivery_status']))) {

                'pending' => 'Barang Diproses',

                'shipped' => 'Barang Dikirim',

                'complete' => 'Barang Diterima',

                default => 'Barang Diproses',

            };

            /*
            |--------------------------------------------------------------------------
            | Konversi Risiko Keterlambatan
            |--------------------------------------------------------------------------
            */

            $keterlambatan = $row['late_delivery_risk'] == 1
                ? 5
                : 1;

            /*
            |--------------------------------------------------------------------------
            | Hitung Urgensi
            |--------------------------------------------------------------------------
            */

            $lama = (int) $row['days_for_shipping_real'];

            if ($keterlambatan == 5 && $lama <= 2) {

                $urgensi = 5;

            } elseif ($keterlambatan == 5 && $lama <= 4) {

                $urgensi = 4;

            } elseif ($lama <= 2) {

                $urgensi = 3;

            } else {

                $urgensi = 2;

            }

            /*
            |--------------------------------------------------------------------------
            | Simpan Barang
            |--------------------------------------------------------------------------
            */

            Barang::create([

                'kode_barang' => 'BRG' . str_pad($no++, 6, '0', STR_PAD_LEFT),

                'nama_barang' => $row['product_name'],

                'kategori' => $row['category_name'],

                'jumlah' => $row['order_item_quantity'],

                'deskripsi' => $row['shipping_mode'],

                'status' => $status,

                'urgensi' => $urgensi,

                'lama_penyimpanan' => $lama,

                'tingkat_keterlambatan' => $keterlambatan,

            ]);
        }
    }
}