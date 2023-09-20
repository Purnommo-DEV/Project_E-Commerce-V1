<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesananDetail extends Model
{
    use HasFactory;
    protected $table = 'pesanan_detail';
    protected $guarded = ['id'];

    public function relasi_pesanan(){
        return $this->belongsTo(Pesanan::class, 'pesanan_id', 'id');
    }

    public function relasi_produk(){
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }

    public function relasi_produk_detail(){
        return $this->belongsTo(ProdukDetail::class, 'produk_detail_id', 'id');
    }
}
