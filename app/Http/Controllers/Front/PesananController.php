<?php

namespace App\Http\Controllers\Front;

use App\Models\Penilaian;
use App\Models\ProdukDetail;
use Illuminate\Http\Request;
use App\Models\PesananDetail;
use App\Models\PesananStatus;
use App\Models\PesananStatusLog;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PesananController extends Controller
{
    public function konfirmasi_pesanan(Request $request){
        if($request->ajax()){
            $data_request = $request->all();

            $data_pesanan_status = PesananStatus::where([
                'pesanan_id' => $data_request['req_pesanan_id']
            ])->first();

            $data_pesanan_status->update([
                'status_pesanan_id' => $data_request['req_status_pesanan_id']
            ]);

            PesananStatusLog::create([
                'pesanan_id' => $data_request['req_pesanan_id'],
                'status_pesanan_id' => $data_request['req_status_pesanan_id']
            ]);

            return response()->json([
                'konfirmasi_pesanan_berhasil' => 1,
                'msg' => 'Berhasol Konfirmasi Pesanan Diterima'
            ]);
        }
    }

    public function beri_peninlaian_produk_pesanan(Request $request){
        if($request->ajax()){
            $validator = Validator::make($request->all(), [
                'rating' => 'required',
                'path' => 'required',
                'komentar' => 'required'
            ],
            [
                'rating.required' => 'Wajib diisi',
                'path.required' => 'Wajib diisi',
                'komentar.required' => 'Wajib diisi'
            ]);

            if (!$validator->passes()) {
                return response()->json([
                    'status_form_kosong' => 1,
                    'error' => $validator->errors()->toArray()
                ]);
            } else {
                $data_request = $request->all();
                if($request->hasFile('path')){
                    $filenameWithExt = $request->file('path')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $request->file('path')->getClientOriginalExtension();
                    $filenameSimpan = $filename.'_'.time().'.'.$extension;
                    $path = $request->file('path')->store('gambar_produk_penilaian', 'public');
                }

                Penilaian::create([
                    'pesanan_detail_id' => $data_request['pesanan_detail_id'],
                    'rating' => $data_request['rating'],
                    'path' => $path,
                    'komentar' => $data_request['komentar'],
                ]);

                return response()->json([
                    'beri_penilaian_berhasil' => 1,
                    'msg' => 'Produk Berhasil di Berikan Nilai'
                ]);

            }
        }
    }

    public function batalkan_pesanan_oleh_pelanggan(Request $request){
        if($request->ajax()){
            $validator = Validator::make($request->all(), [
                'catatan' => 'required',
            ],
            [
                'catatan.required' => 'Wajib diisi'
            ]);

            if (!$validator->passes()) {
                return response()->json([
                    'status_form_kosong' => 1,
                    'error' => $validator->errors()->toArray()
                ]);
            } else {
                $data_request = $request->all();
                $data_pesanan_status = PesananStatus::where([
                    'pesanan_id' => $data_request['pesanan_id']
                ])->first();

                $data_pesanan_detail = PesananDetail::where('pesanan_id', $data_request['pesanan_id'])->get()->toArray();

                foreach($data_pesanan_detail as $row){
                    $produk_detail = ProdukDetail::find($row['produk_detail_id']);
                    $produk_detail->stok = $row['kuantitas'] + $produk_detail->stok;
                    $produk_detail->save();
                };

                $data_pesanan_status->update([
                    'status_pesanan_id' => 8
                ]);

                PesananStatusLog::create([
                    'pesanan_id' => $data_request['pesanan_id'],
                    'status_pesanan_id' => 8,
                    'catatan' => $data_request['catatan']
                ]);

                return response()->json([
                    'pembatalan_pesanan_oleh_pengguna' => 1,
                    'msg' => 'Berhasil Membatalkan Pesanan'
                ]);

            }
        }
    }
}
