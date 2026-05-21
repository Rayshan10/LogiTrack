<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    protected $fillable = [
        'barang_id',
        'status',
        'lokasi',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}