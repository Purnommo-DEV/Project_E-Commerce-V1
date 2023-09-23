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
        $produk = Produk::with('relasi_kategori')->where('kategori_id', $kategori->id)->orderBy('created_at', 'asc')->get();

        return view('Front.kategori_detail.kategori_detail', compact('kategori', 'produk'));
    }

    public function filter_urutkan(Request $request){
        if($request->ajax()) {
            $data=$request->all();
            // echo "<pre>"; print_r($data); die;
        }

        if(isset($data['req_urutan']) && !empty($data['req_urutan'])) {
            if($data['req_urutan']=="produk_terbaru") {
                $produk=Produk::with('relasi_kategori')->whereRelation('relasi_kategori', 'slug', $data['req_kategori_slug'])->orderBy('created_at', 'desc')->get();
            }

            else if($data['req_urutan']=="produk_a_z") {
                $produk=Produk::with('relasi_kategori')->whereRelation('relasi_kategori', 'slug', $data['req_kategori_slug'])->orderBy('nama_produk', 'asc')->get();
            }
        }
        else {
            $produk=Produk::with('relasi_kategori')->whereRelation('relasi_kategori', 'slug', $data['req_kategori_slug'])->orderBy('nama_produk', 'asc')->get();
        }

        $kategori = Kategori::get(['id', 'nama_kategori', 'slug', 'path']);
        return view('Front.kategori_detail.daftar_produk_kategori')->with(compact('produk', 'kategori'));
    }
}
