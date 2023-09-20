<?php

namespace App\Http\Controllers\Front;

use App\Models\Banner;
use App\Models\Produk;
use App\Models\Slider;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BerandaController extends Controller
{
    public function halaman_beranda(){
        $slider = Slider::get(['judul', 'gambar']);
        $banner = Banner::get(['judul', 'gambar']);
        $produk = Produk::with(['relasi_kategori', 'relasi_gambar'])->orderBy('created_at', 'desc')->get();
        $kategori = Kategori::get(['id', 'nama_kategori', 'slug', 'path']);
        return view('Front.beranda.beranda', compact('banner', 'produk', 'kategori', 'slider'));
    }
}
