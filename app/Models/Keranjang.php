<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Keranjang extends Model
{
    use HasFactory;
    protected $table = 'keranjang';
    protected $guarded = ['id'];

    public static function func_data_keranjang_pengguna(){
        if(Auth::check()){
            $data_keranjang_pengguna = Keranjang::with(['relasi_produk', 'relasi_produk_detail'])
                ->where('users_id', Auth::user()->id)
                ->get();
        }
        return $data_keranjang_pengguna;
    }

    public function relasi_produk(){
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }

    public function relasi_produk_detail(){
        return $this->belongsTo(ProdukDetail::class, 'produk_detail_id', 'id');
    }
}
