<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Tracking extends Model
{
    protected $fillable = [
        'barang_id',
        'user_id',
        'status',
        'lokasi',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function user()
    {
        return $this->belongsTo(
            User::class
        );
    }
}