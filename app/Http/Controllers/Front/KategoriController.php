<?php

namespace App\Http\Controllers\Front;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KategoriController extends Controller
{
    public function halaman_kategori_detail($slug){
        $kategori = Kategori::where('slug', $slug)->first();
        $produk = Produk::where('kategori_id', $kategori->id)->get();

        return view('Front.kategori_detail.kategori_detail', compact('kategori', 'produk'));
    }

    public function filter_urutkan(Request $request){
        if($request->ajax()) {
            $data=$request->all();
            // echo "<pre>"; print_r($data); die;
        }

        if(isset($data['urutan']) && !empty($data['urutan'])) {
            if($data['urutan']=="produk_terbaru") {
                $data_produk=Produk::orderBy('created_at', 'desc')->get();

            }

            else if($data['urutan']=="produk_a_z") {
                $data_produk=Produk::orderBy('name', 'asc')->get();

            }

            else if($data['urutan']=="produk_harga_rendah") {
                $data_produk=Produk::orderBy('harga', 'asc')->get();

            }

            else if($data['urutan']=="produk_harga_tinggi") {
                $data_produk=Produk::orderBy('harga', 'desc')->get();
            }
        }
        else {
            $data_produk=Produk::get();
        }

        // $data_produk = Produk::orderBy('id', 'DESC')->get();
        $produk = Produk::with(['relasi_kategori', 'relasi_gambar'])->orderBy('created_at', 'desc')->get();
        $kategori = Kategori::get(['id', 'nama_kategori', 'slug', 'path']);
        return view('Front.kategori_detail.daftar_produk_kategori')->with(compact('produk', 'kategori'));
    }
}
