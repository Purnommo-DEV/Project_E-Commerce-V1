<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $table = 'produk';
    protected $guarded = ['id'];

    public function relasi_kategori(){
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }

    public function relasi_tipe(){
        return $this->belongsTo(ProdukTipe::class, 'produk_tipe_id', 'id');
    }
}
