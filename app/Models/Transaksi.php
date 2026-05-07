<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'pelanggan_id', 
        'paket_id', 
        'berat', 
        'total_harga', 
        'tanggal_masuk', 
        'tanggal_selesai', 
        'status_pembayaran', 
        'status_cucian'
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function paket()
    {
        return $this->belongsTo(Paket::class);
    }
}