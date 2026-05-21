<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $fillable = [
    'kode_barang',
    'nama_barang',
    'kategori',
    'jumlah',
    'deskripsi',
    'qr_code',
    'status',
    ];

    public function trackings()
    {
        return $this->hasMany(Tracking::class);
    }

    public function getRouteKeyName()
    {
        return 'kode_barang';
    }
}