<?php

namespace App\Http\Controllers\Back;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use App\Models\PesananDetail;
use App\Models\PesananStatus;
use App\Models\PesananStatusLog;
use App\Http\Controllers\Controller;
use App\Models\ProdukDetail;
use Illuminate\Support\Facades\Validator;

class AdminPesanan_Controller extends Controller
{
    public function halaman_pesanan(){
        return view('Back.pesanan.pesanan');
    }

    public function data_pesanan(Request $request){
        $data = Pesanan::select([
            'pesanan.*'
        ])->with(['relasi_user', 'relasi_pesanan_status.relasi_status_master'])->orderBy('orders_date', 'desc');

        // if($request->input('jurusan_id')!=null){
        //     $data = $data->where('jurusan_id', $request->jurusan_id);
        // }

        // if($request->input('search.value')!=null){
        //     $data = $data->where(function($q)use($request){
        //             $q->whereRaw('LOWER(muk) like ?',['%'.strtolower($request->input('search.value')).'%']);
        //     });
        //     $data = $data->with('relasi_jurusan')->whereHas('relasi_jurusan', function($q)use($request) {
        //         $q->whereRaw('LOWER(jurusan) like ?',['%'.strtolower($request->input('search.value')).'%']);
        //     });
        // }

        $rekamFilter = $data->get()->count();
        if ($request->input('length') != -1)
            $data = $data->skip($request->input('start'))->take($request->input('length'));
        $rekamTotal = $data->count();
        $data = $data->get();
        return response()->json([
            'draw' => $request->input('draw'),
            'data' => $data,
            'recordsTotal' => $rekamTotal,
            'recordsFiltered' => $rekamFilter
        ]);
    }

    public function detail_pesanan($id){
        $pesanan = Pesanan::with(['relasi_alamat_pengiriman', 'relasi_user'])->where('id', $id)->first();
        $pesanan_detail = PesananDetail::where('pesanan_id', $pesanan->id)->get();
        $pesanan_status = PesananStatus::with('relasi_status_master')->where('pesanan_id', $pesanan->id)->orderBy('created_at', 'desc')->first();
        $pesanan_status_log = PesananStatusLog::where('pesanan_id', $pesanan->id)->get();
        return view('Back.pesanan.detail_pesanan', compact('pesanan', 'pesanan_detail', 'pesanan_status', 'pesanan_status_log'));
    }

    public function verifikasi_pesanan(Request $request){
        if($request->ajax()){

            $data_request = $request->all();

            $data_pesanan = PesananStatus::where([
                'pesanan_id' => $data_request['pesanan_id']
            ])->first();

            $data_pesanan->update([
                'status_pesanan_id' => 3
            ]);

            return response()->json([
                'status_verifikasi_berhasil' => 1,
                'msg' => 'Pesanan Berhasil di Verifikasi'
            ]);
        }
    }

    public function perbarui_status_pesanan(Request $request){
        if($request->ajax()){
            $validator = Validator::make($request->all(), [
                'req_pesanan_status' => 'required',
                'req_resi' => 'required'
            ],
            [
                'req_pesanan_status.required' => 'Wajib diisi',
                'req_resi.required' => 'Wajib diisi'
            ]);

            if (!$validator->passes()) {
                return response()->json([
                    'status_form_kosong' => 1,
                    'error' => $validator->errors()->toArray()
                ]);
            } else {
                $data_request = $request->all();
                $data_pesanan = Pesanan::where([
                    'id' => $data_request['req_pesanan_id']
                ])->first();

                if($data_request['req_resi'] != null){
                    $data_pesanan->update([
                        'kode_pengiriman' => $data_request['req_resi']
                    ]);
                }

                $data_pesanan_status = PesananStatus::where([
                    'pesanan_id' => $data_request['req_pesanan_id']
                ])->first();

                $data_pesanan_status->update([
                    'status_pesanan_id' => $data_request['req_pesanan_status']
                ]);

                PesananStatusLog::create([
                    'pesanan_id' => $data_request['req_pesanan_id'],
                    'status_pesanan_id' => $data_request['req_pesanan_status']
                ]);

                return response()->json([
                    'ubah_status_berhasil' => 1,
                    'msg' => 'Status Pesanan Berhasil di Ubah'
                ]);

            }
        }
    }

    public function batalkan_pesanan_oleh_admin(Request $request){
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

                $data_pesanan_detail = PesananDetail::where('pesanan_id', $data_request['pesanan_id'])->get();

                foreach($data_pesanan_detail as $row){
                    $produk_detail = ProdukDetail::find($row['produk_detail_id']);
                    $produk_detail->stok = $row['kuantitas'] + $produk_detail->stok;
                    $produk_detail->save();
                };

                $data_pesanan_status->update([
                    'status_pesanan_id' => 7
                ]);

                PesananStatusLog::create([
                    'pesanan_id' => $data_request['pesanan_id'],
                    'status_pesanan_id' => 7,
                    'catatan' => $data_request['catatan']
                ]);

                return response()->json([
                    'status_pembatalan_pesanan_oleh_admin' => 1,
                    'msg' => 'Berhasil Membatalkan Pesanan'
                ]);

            }
        }
    }
}
