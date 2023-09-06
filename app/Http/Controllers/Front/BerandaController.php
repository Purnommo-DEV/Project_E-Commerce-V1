<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function halaman_beranda(){
        $produk = Produk::with('relasi_kategori')->get();
        return view('Front.beranda.beranda', compact('produk'));
    }
}
