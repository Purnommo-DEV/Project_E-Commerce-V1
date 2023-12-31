<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukGambar extends Model
{
    use HasFactory;
    protected $table = 'produk_gambar';
    protected $guarded = ['id'];

    public function relasi_produk(){
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }
}
