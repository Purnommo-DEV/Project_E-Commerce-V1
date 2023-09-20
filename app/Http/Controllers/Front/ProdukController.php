<?php

namespace App\Http\Controllers\Front;

use App\Models\Produk;
use App\Models\Keranjang;
use App\Models\ProdukDetail;
use App\Models\ProdukGambar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{
    public function halaman_detail_produk($slug){
        $produk = Produk::with('relasi_kategori')->where('slug', $slug)->first();
        $produk_gambar = ProdukGambar::where('produk_id', $produk->id)->get();
        $produk_biasa = ProdukDetail::where('produk_id', $produk->id)->first();
        $produk_variasi = ProdukDetail::where('produk_id', $produk->id)->get();
        return view('Front.produk_detail.produk_detail', compact('produk', 'produk_gambar', 'produk_variasi', 'produk_biasa'));
    }

    public function resp_produk_variasi(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $tampilProdukVariasiStok = ProdukDetail::where([
                'id'=>$data['produk_detail_id']
            ])->select('harga', 'stok')->first();
            return response()->json([
                'resp_produk_variasi' => $tampilProdukVariasiStok,
            ]);
        }
    }

    public function tambah_ke_keranjang(Request $request){
        if(!Auth::user()){
            return response()->json([
                'status_login' => 0,
                'msg' => "Anda Belum Login"
            ]);
        }
        else{
            $validator = Validator::make($request->all(), [
                'produk_detail_id' => 'required',
            ], [
                'produk_detail_id.required' => 'Wajib diisi',
            ]);

            if (!$validator->passes()) {
                return response()->json([
                    'status_tmb_keranjang' => 0,
                    'error' => $validator->errors()->toArray()
                ]);
            } else {
                $data = $request->all();
                $produk_detail = ProdukDetail::where([
                    'produk_id'=>$data['produk_id'],
                    'id'=>$data['produk_detail_id']
                    ])->first()->toArray();

                    if($produk_detail['stok'] < $data['kuantitas']){
                        return response()->json([
                            'status_melebihi_batas' => 0,
                            'msg' => 'Produk Melebihi Stok'
                        ]);
                    }

                $hitungProduk = Keranjang::where([
                    'users_id'=>Auth::user()->id,
                    'produk_id'=>$data['produk_id'],
                    'produk_detail_id'=>$data['produk_detail_id']])->count();
                    if($hitungProduk>0){
                        return response()->json([
                            'status_hitung_produk' => 0,
                            'msg' => 'Produk Telah ada di Keranjang'
                        ]);
                    }else{
                        $tmb_produk_keranjang = Keranjang::create([
                            'users_id' => Auth::user()->id,
                            'produk_id' => $request->produk_id,
                            'produk_detail_id' => $request->produk_detail_id,
                            'kuantitas' => $request->kuantitas,
                            'total_berat' => $produk_detail['berat'] * $request->kuantitas,
                            'total_bayar' => $produk_detail['harga'] * $request->kuantitas,
                        ]);

                        $produk_detail = ProdukDetail::where([
                            'id' => $request->produk_detail_id,
                            'produk_id' => $request->produk_id,
                            ])->first();

                        $produk_detail->update([
                            'stok' => $produk_detail->stok - $request->kuantitas
                        ]);

                        if (!$tmb_produk_keranjang) {
                            return response()->json([
                                'status_tmb_keranjang' => 0,
                                'msg' => 'Terjadi kesalahan, Gagal Menambahkan Produk Ke Keranjang'
                            ]);
                        } else {

                            return response()->json([
                                'status_tmb_keranjang' => 1,
                                'msg' => 'Berhasil Menambahkan Produk Ke Keranjang',
                                'total_produk_keranjang' => help_total_produk_keranjang(),
                                'data_keranjang_terbaru' => help_data_isi_keranjang_baru(),
                                'total_harga_produk_dlm_keranjang' => help_total_harga_produk_keranjang()
                            ]);
                        }
                    }
            }
        }
    }
}
