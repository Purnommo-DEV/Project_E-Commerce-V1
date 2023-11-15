<?php

namespace App\Http\Controllers\Back;

use App\Models\User;
use App\Models\Alamat;
use App\Models\Pesanan;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use App\Models\PesananStatus;
use App\Http\Controllers\Controller;

class AdminPengguna_Controller extends Controller
{
    public function pengguna(){
        return view('Back.pengguna.pengguna');
    }

    public function data_pengguna(Request $request){
        $data = User::select([
            'users.*'
        ])->with('relasi_role');

        $rekamFilter = $data->get()->count();
        if ($request->input('length') != -1)
            $data = $data->skip($request->input('start'))->take($request->input('length'));
        $rekamTotal = $data->count();
        $data = $data->where('role_id', 2)->get();
        return response()->json([
            'draw' => $request->input('draw'),
            'data' => $data,
            'recordsTotal' => $rekamTotal,
            'recordsFiltered' => $rekamFilter
        ]);
    }

    public function detail_pengguna($kode_pengguna){
        $pengguna = User::where('kode', $kode_pengguna)->first();
        $alamat_pengguna = Alamat::where('users_id', $pengguna->id)->with('relasi_provinsi', 'relasi_kota')->get();
        $jumlah_pesanan = Pesanan::select('id')->where('users_id', $pengguna->id)->count();
        $jumlah_penilaian = Penilaian::select([
            'penilaian.*'
        ])->with('relasi_pesanan_detail.relasi_pesanan.relasi_user', 'relasi_pesanan_detail.relasi_produk_detail.relasi_produk')->whereRelation('relasi_pesanan_detail.relasi_pesanan.relasi_user', 'kode', $kode_pengguna)
        ->count();
        return view('Back.pengguna.detail_pengguna', compact('pengguna', 'alamat_pengguna', 'jumlah_pesanan', 'jumlah_penilaian'));
    }

    public function data_pesanan_pengguna(Request $request, $kode_pengguna){
        $data = Pesanan::select([
            'pesanan.*'
        ])->with('relasi_pesanan_status', 'relasi_pesanan_status.relasi_status_master', 'relasi_user')->whereRelation('relasi_user', 'kode', $kode_pengguna);

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

    public function data_penilaian_pesanan_pengguna(Request $request, $kode_pengguna){
        $data = Penilaian::select([
            'penilaian.*'
        ])->with('relasi_pesanan_detail.relasi_pesanan.relasi_user', 'relasi_pesanan_detail.relasi_produk_detail.relasi_produk')->whereRelation('relasi_pesanan_detail.relasi_pesanan.relasi_user', 'kode', $kode_pengguna);

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

    public function alamat_pengguna($alamat_id){
        $alamat_pengguna = Alamat::where('id', $alamat_id)->first();

        return response()->json([
            'data_alamat' => $alamat_pengguna
        ]);
    }

}
