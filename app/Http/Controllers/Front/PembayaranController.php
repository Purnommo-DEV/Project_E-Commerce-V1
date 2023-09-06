<?php

namespace App\Http\Controllers\Front;

use App\Models\Alamat;
use App\Models\Provinsi;
use App\Models\Keranjang;
use App\Models\ProdukGambar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class PembayaranController extends Controller
{
    public function pembayaran(){
        $data_keranjang = Keranjang::func_data_keranjang_pengguna();
        $provinsi = Provinsi::pluck('name', 'id');
        $data_alamat_customer = Alamat::func_alamat_engguna();
        $gambar_produk = ProdukGambar::get();
        $hitungDataKeranjang = Keranjang::func_data_keranjang_pengguna()->count();

        $id_kota_user = Alamat::where([
            'users_id' => Auth::user()->id,
            'alamat_utama' => 1
            ])->first();

        $total_berat = 0;
        $data_berat = Keranjang::where('users_id', Auth::user()->id)->get();
        foreach($data_berat as $data){
            $total_berat += $data->total_berat * $data->kuantitas;
        }

        return view('Front.pembayaran.pembayaran', compact('data_keranjang', 'data_alamat_customer', 'gambar_produk',
        'hitungDataKeranjang', 'provinsi', 'total_berat'));
    }

    public function cek_ongkir(Request $request){
        if($request->ajax()){
            $data = $request->all();

            $cost = RajaOngkir::ongkosKirim([
                'origin'        => 364, // ID kota/kabupaten asal PONTIANAK
                'destination'   => $data['kota_customer_id'], // ID kota/kabupaten tujuan
                'weight'        => $data['total_berat'], // berat barang dalam gram
                'courier'       => $data['jenis_kurir']// kode kurir pengiriman: ['jne', 'tiki', 'pos'] untuk starter
            ])->get();
            return response()->json($cost);
        }
    }

    public function proses_pembayaran(Request $request){
        // Menghabpus String di antara string
        $string = $data['jenis_kurir'];
        dd(replace_between($string, '|', '|', ''));
    }

}
