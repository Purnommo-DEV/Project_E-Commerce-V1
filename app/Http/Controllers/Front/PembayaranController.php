<?php

namespace App\Http\Controllers\Front;

use Exception;
use Carbon\Carbon;
use App\Models\Alamat;
use App\Models\Pesanan;
use App\Models\Provinsi;
use App\Models\Keranjang;
use App\Models\ProdukDetail;
use App\Models\ProdukGambar;
use Illuminate\Http\Request;
use App\Models\PesananDetail;
use App\Models\PesananStatus;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class PembayaranController extends Controller
{
    public function buat_pesanan(){

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

        if($hitungDataKeranjang > 0){
            return view('Front.buat_pesanan.buat_pesanan', compact('data_keranjang', 'data_alamat_customer', 'gambar_produk',
            'hitungDataKeranjang', 'provinsi', 'total_berat'));
        }else{
            return redirect()->route('customer.HalamanKeranjang');
        }

    }

    public function cek_data_ongkir(Request $request){
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

    public function proses_buat_pesanan(Request $request){
        if($request->ajax()){
            $validator = Validator::make($request->all(), [
                'req_kurir' => 'required',
                'req_layanan' => 'required'
            ], [
                'req_kurir.required' => 'Wajib diisi',
                'req_layanan.required' => 'Wajib diisi'
            ]);

            if (!$validator->passes()) {
                return response()->json([
                    'status_form_kosong' => 1,
                    'error' => $validator->errors()->toArray()
                ]);
            } else {
                $data = $request->all();
                $cost = RajaOngkir::ongkosKirim([
                    'origin'        => 364, // ID kota/kabupaten asal PONTIANAK
                    'destination'   => $data['req_kota_customer'], // ID kota/kabupaten tujuan
                    'weight'        => $data['req_total_berat'], // berat barang dalam gram
                    'courier'       => $data['req_kurir']// kode kurir pengiriman: ['jne', 'tiki', 'pos'] untuk starter
                ])->get();
                $ongkir = $cost[0];

                $alamat_utama_customer = Alamat::where([
                    'users_id' => Auth::user()->id,
                    'alamat_utama' => 1])
                    ->select('id')
                    ->first();

                $simpan_data_pesanan = Pesanan::create([
                    'users_id' => Auth::user()->id,
                    'alamat_pengiriman_id' => $alamat_utama_customer->id,
                    'kode_pesanan' => 'INV_'.Auth::user()->id.Carbon::now()->format('YmdHis'),
                    'total_pembayaran' => $data['req_total_pembayaran'],
                    // 'total_ongkir' => $ongkir['costs'][$data['req_layanan']]['cost'][0]['value'], => Terkadang Berbeda saat dari web lngusng ada service CTY, tetapi jika di cek langsung dari backend hanya ada REG dan OKE
                    'total_ongkir' => $data['req_total_ongkir'],
                    'total_berat' => $data['req_total_berat'],
                    'metode_pembayaran' => $data['req_metode_pembayaran'],
                    'ekspedisi_layanan' => $ongkir['name'].'_'.$ongkir['costs'][$data['req_layanan']]['description'],
                    'kode_pengiriman' => null,
                    'orders_date' => Carbon::now(),
                    'expired_date' => Carbon::now()->addDays(1),
                    'bukti_pembayaran' => null,
                ]);

                PesananStatus::create([
                    'pesanan_id' => $simpan_data_pesanan->id,
                    'status_pesanan_id' => 1 //Belum Bayar
                ]);

                $data_keranjang = Keranjang::where('users_id', Auth::user()->id)->get()->toArray();
                    foreach($data_keranjang as $key => $produk_dalam_keranjang){
                        PesananDetail::create([
                            'pesanan_id' => $simpan_data_pesanan->id,
                            'produk_id' => $produk_dalam_keranjang['produk_id'],
                            'produk_detail_id' => $produk_dalam_keranjang['produk_detail_id'],
                            'kuantitas' => $produk_dalam_keranjang['kuantitas'],
                            'total_harga' => $produk_dalam_keranjang['total_bayar'],
                            'total_berat' => $produk_dalam_keranjang['total_berat'],
                        ]);
                        // $data_detail_produk = ProdukDetail::where([
                        //     'id' => $produk_dalam_keranjang['produk_detail_id']
                        // ])->first();
                        // $data_detail_produk['stok'] = $data_detail_produk['stok'] - $produk_dalam_keranjang['kuantitas'];
                        // $data_detail_produk->update();
                    }
                $data_keranjang_object = Keranjang::where('users_id', Auth::user()->id)->get();
                Keranjang::destroy($data_keranjang_object);

                return response()->json([
                    'status_buat_pesanan' => 1,
                    'route' => route('customer.HalamanBayarPesanan', $simpan_data_pesanan->id),
                    'data_keranjang_terbaru' => help_data_isi_keranjang_baru(),
                    'total_harga_produk_dlm_keranjang' => help_total_harga_produk_keranjang()
                ]);
                // dd($ongkir['costs'][$data['req_layanan']]['cost'][0]['value']);
                // $ongkir = $cost->where([''])
            }
        }
        // Menghabpus String di antara string
        // $string = $data['jenis_kurir'];
        // dd(replace_between($string, '|', '|', ''));
    }

    public function bayar_pesanan($pesanan_id){
        try {
            $pesanan = Pesanan::with('relasi_alamat_pengiriman', 'relasi_user')->where(['id' => $pesanan_id, 'users_id'=> Auth::user()->id])->first();
            $pesanan_detail = PesananDetail::where('pesanan_id', $pesanan->id)->get();
            $pesanan_status = PesananStatus::with('relasi_status_master')->where('pesanan_id', $pesanan->id)->orderBy('created_at', 'desc')->first();
        } catch (Exception $e) {
            return redirect()->back();
        }
        return view('Front.pembayaran.bayar_pesanan', compact('pesanan', 'pesanan_detail', 'pesanan_status'));
    }

    public function upload_bukti_pembayaran(Request $request, $pesanan_id){
        if($request->ajax()){
            $validator = Validator::make($request->all(), [
                'bukti_pembayaran' => 'required',
            ], [
                'bukti_pembayaran.required' => 'Wajib diisi',
            ]);

            if (!$validator->passes()) {
                return response()->json([
                    'status_form_kosong' => 1,
                    'error' => $validator->errors()->toArray()
                ]);
            } else

            if($request->hasFile('bukti_pembayaran')){
                $filenameWithExt = $request->file('bukti_pembayaran')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('bukti_pembayaran')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                $bukti_pembayaran = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
            }
            Pesanan::where([
                'id' => $pesanan_id,
                'users_id' => Auth::user()->id])->update([
                    'bukti_pembayaran' =>  $bukti_pembayaran,
            ]);

            PesananStatus::where([
                'pesanan_id' => $pesanan_id
            ])->update([
                'status_pesanan_id' => 2
            ]);

            return response()->json([
                'status_upload_berhasil' => 1,
                'msg' => 'Upload Bukti Pembayaran Berhasil'
            ]);
        }
    }

}
