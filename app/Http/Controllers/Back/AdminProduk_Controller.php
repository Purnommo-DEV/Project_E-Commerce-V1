<?php

namespace App\Http\Controllers\Back;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProdukBiasa;
use App\Models\ProdukGambar;
use App\Models\ProdukTipe;
use App\Models\ProdukVariasi;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Alert;
use App\Models\ProdukDetail;

class AdminProduk_Controller extends Controller
{
    public function produk(){
        $tipe = ProdukTipe::get(['id', 'produk_tipe']);
        $kategori = Kategori::get(['id', 'nama_kategori']);
        return view('Back.produk.produk', compact('kategori', 'tipe'));
    }

    public function data_produk(Request $request){
        $data = Produk::select([
            'produk.*'
        ])->with('relasi_kategori', 'relasi_tipe')->orderBy('created_at', 'desc');

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

    public function produk_detail($slug){


    }

    public function tambah_data_produk(Request $request){
        $validator = Validator::make($request->all(), [
            'nama_produk' => 'required',
            'kategori_id' => 'required',
            'produk_tipe_id' => 'required',
            'deskripsi_singkat' => 'required',
            'deskripsi_lengkap' => 'required',
        ], [
            'nama_produk.required' => 'Wajib diisi',
            'kategori_id.required' => 'Wajib diisi',
            'produk_tipe_id.required' => 'Wajib diisi',
            'deskripsi_singkat.required' => 'Wajib diisi',
            'deskripsi_lengkap.required' => 'Wajib diisi',
        ]);

         if (!$validator->passes()) {
            return response()->json([
                'status' => 0,
                'error' => $validator->errors()->toArray()
            ]);
        } else {
            $tambah_produk = Produk::create([
                'nama_produk' => $request->nama_produk,
                'kategori_id' =>$request->kategori_id,
                'produk_tipe_id' =>$request->produk_tipe_id,
                'slug' => Str::slug($request->nama_produk),
                'deskripsi_singkat' => $request->deskripsi_singkat,
                'deskripsi_lengkap' => $request->deskripsi_lengkap
            ]);
            $files = $request->file('path');
            foreach($files as $file_gambar){
                ProdukGambar::create([
                    'produk_id' => $tambah_produk->id,
                    'judul' => $file_gambar->getClientOriginalName(),
                    'path' => $file_gambar->store('gambar_produk', 'public')
                ]);
            }

            $produk_variasi = $request->input('produk_variasi');
            $harga_produk_variasi = str_replace(['Rp. ', '.', '.'], ['', '', ''], $request->input('harga_p_variasi'));
            $berat_produk_variasi = $request->input('berat_p_variasi');
            $stok_produk_variasi = $request->input('stok_p_variasi');

            if($request->produk_tipe_id == 1){
                ProdukDetail::create([
                    'produk_id' => $tambah_produk->id,
                    'produk_variasi' => $request->nama_produk,
                    'harga' => $request->harga_produk_biasa,
                    'berat' => $request->berat_produk_biasa,
                    'stok'  => $request->stok_produk_biasa
                ]);
            }
            else if($request->produk_tipe_id == 2){
                for ($x = 0; $x < count($produk_variasi); $x++) {
                    $tampung_produk_variasi = $produk_variasi[$x];
                    $tampung_harga_produk_variasi = $harga_produk_variasi[$x];
                    $tampung_berat_produk_variasi = $berat_produk_variasi[$x];
                    $tampung_stok_produk_variasi = $stok_produk_variasi[$x];

                    if (trim($tampung_produk_variasi) == "" || is_null($tampung_produk_variasi))
                        continue;
                        ProdukDetail::create([
                            'produk_id' => $tambah_produk->id,
                            'produk_variasi' => $tampung_produk_variasi,
                            'harga' => $tampung_harga_produk_variasi,
                            'berat' => $tampung_berat_produk_variasi,
                            'stok'  => $tampung_stok_produk_variasi
                    ]);
                }
            }

            if (!$tambah_produk) {
                return response()->json([
                    'status' => 0,
                    'msg' => 'Terjadi kesalahan, Gagal Menambahkan Produk'
                ]);
            } else {
                return response()->json([
                    'status' => 1,
                    'msg' => 'Berhasil Menambahkan Produk'
                ]);
            }
        }
    }

    public function edit_data_produk($id){
        $produk_tipe = ProdukTipe::get(['id','produk_tipe']);
        $produk_kategori = Kategori::get(['id', 'nama_kategori']);
        $produk = Produk::with('relasi_kategori', 'relasi_tipe')->where('id', $id)->first();
        $produk_gambar = ProdukGambar::where('produk_id', $produk->id)->get();
        return view('Back.produk.edit.produk_edit', compact('produk_kategori', 'produk_tipe', 'produk', 'produk_gambar'));
    }

    public function ubah_data_produk(Request $request){
        $validator = Validator::make($request->all(), [
            'nama_produk' => 'required',
            'kategori_id' => 'required',
            // 'harga_produk_biasa' => 'required',
            // 'berat_produk_biasa' => 'required',
            // 'stok_produk_biasa' => 'required',
            'deskripsi_singkat' => 'required',
            'deskripsi_lengkap' => 'required',
        ], [
            'nama_produk.required' => 'Wajib diisi',
            'kategori_id.required' => 'Wajib diisi',
            // 'harga_produk_biasa.required' => 'Wajib diisi',
            // 'berat_produk_biasa.required' => 'Wajib diisi',
            // 'stok_produk_biasa.required' => 'Wajib diisi',
            'deskripsi_singkat.required' => 'Wajib diisi',
            'deskripsi_lengkap.required' => 'Wajib diisi',
        ]);

         if (!$validator->passes()) {
            return response()->json([
                'status' => 0,
                'error' => $validator->errors()->toArray()
            ]);
        } else {
            $data_produk = Produk::where('id', $request->produk_id)->first();

            if($data_produk->produk_tipe_id == 1){
                Produk::where('id', $request->produk_id)->update([
                    'nama_produk' => $request->nama_produk,
                    'kategori_id' => $request->kategori_id,
                    'slug' => Str::slug($request->nama_produk),
                    'deskripsi_singkat' => $request->deskripsi_singkat,
                    'deskripsi_lengkap' => $request->deskripsi_lengkap,
                ]);

                $data_detail_produk = ProdukDetail::where('produk_id', $data_produk->id)->first();

                if($data_detail_produk == null){
                    ProdukDetail::create([
                        'produk_id' => $data_produk->id,
                        'produk_variasi' =>$request->nama_produk,
                        'harga' => $request->harga_produk_biasa,
                        'stok'  => $request->stok_produk_biasa,
                        'berat' => $request->berat_produk_biasa,
                    ]);
                }else{
                    ProdukDetail::where('produk_id', $data_produk->id)->update([
                        'harga' => $request->harga_produk_biasa,
                        'stok'  => $request->stok_produk_biasa,
                        'berat' => $request->berat_produk_biasa,
                    ]);
                }
            }else if($data_produk->produk_tipe_id == 2){
                Produk::where('id', $request->produk_id)->update([
                    'nama_produk' => $request->nama_produk,
                    'kategori_id' => $request->kategori_id,
                    'slug' => Str::slug($request->nama_produk),
                    'deskripsi_singkat' => $request->deskripsi_singkat,
                    'deskripsi_lengkap' => $request->deskripsi_lengkap,
                ]);
            }
            return response()->json([
                'status' => 1,
                'msg' => 'Berhasil Mengubah Data Produk'
            ]);
        }
    }

    public function hapus_data_produk($produk_id){
        $data_produk = Produk::find($produk_id);
        $data_gbr_produk = ProdukGambar::where('produk_id', $produk_id)->get()->toArray();
        foreach($data_gbr_produk as $key => $gbr_produk){
            $path = 'storage/'.$gbr_produk['path'];
            if (File::exists($path)) {
                File::delete($path);
            }
        }
        $data_produk->delete();
        return response()->json([
            'status' => 1,
            'msg'   => 'Berhasil Menghapus Data',
        ]);
    }

    public function update_data_produk_variasi(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            foreach($data['produk_variasi_id'] as $key => $variasi){
                if(!empty($variasi)){
                    $ubah_produk_variasi = ProdukDetail::where(['id' => $data['produk_variasi_id'][$key]])->update([
                        'produk_variasi' => $data['produk_variasi'][$key],
                        'harga' => $data['harga'][$key],
                        'berat' => $data['berat'][$key],
                        'stok'  => $data['stok'][$key]
                    ]);
                }
            }
            if (!$ubah_produk_variasi) {
                return response()->json([
                    'status' => 0,
                    'msg' => 'Terjadi kesalahan, Gagal Mengubah Variasi Produk'
                ]);
            } else {
                return response()->json([
                    'status' => 1,
                    'msg' => 'Berhasil Mengubah Variasi Produk'
                ]);
            }
        }
    }

    public function tambah_data_produk_variasi(Request $request, $produk_id){
        $produk_variasi = $request->input('produk_variasi');
        // $harga_produk_variasi = str_replace(['Rp. ', '.', '.'], ['', '', ''], $request->input('harga_p_variasi'));
        $harga_produk_variasi = $request->input('harga_p_variasi');
        $berat_produk_variasi = $request->input('berat_p_variasi');
        $stok_produk_variasi = $request->input('stok_p_variasi');

        for ($x = 0; $x < count($produk_variasi); $x++) {
            $tampung_produk_variasi = $produk_variasi[$x];
            $tampung_harga_produk_variasi = $harga_produk_variasi[$x];
            $tampung_berat_produk_variasi = $berat_produk_variasi[$x];
            $tampung_stok_produk_variasi = $stok_produk_variasi[$x];

            if (trim($tampung_produk_variasi) == "" || is_null($tampung_produk_variasi))
                continue;
                $tambah_variasi_produk = ProdukDetail::create([
                    'produk_id' => $produk_id,
                    'produk_variasi' => $tampung_produk_variasi,
                    'harga' => $tampung_harga_produk_variasi,
                    'berat' => $tampung_berat_produk_variasi,
                    'stok'  => $tampung_stok_produk_variasi
            ]);
        }
        if (!$tambah_variasi_produk) {
            return response()->json([
                'status' => 0,
                'msg' => 'Terjadi kesalahan, Gagal Menambahkan Variasi Produk'
            ]);
        } else {
            return response()->json([
                'status' => 1,
                'msg' => 'Berhasil Menambahkan Variasi Produk'
            ]);
        }
    }

    public function hapus_data_produk_variasi($produk_variasi_id){
        ProdukDetail::find($produk_variasi_id)->delete();
        return response()->json([
            'status' => 1,
            'msg'   => 'Berhasil Menghapus Data Produk Variasi',
        ]);
    }

    public function tambah_data_gambar_produk(Request $request, $produk_id){
        $validator = Validator::make($request->all(), [
            'path.*' => 'required',
        ], [
            'path.*.required' => 'Wajib diisi',
        ]);

         if (!$validator->passes()) {
            return response()->json([
                'status' => 0,
                'error' => $validator->errors()->toArray()
            ]);
        } else {
            $files = $request->file('path');
            foreach($files as $file_gambar){
                $tambah_gambar_produk = ProdukGambar::create([
                    'produk_id' => $produk_id,
                    'judul' => $file_gambar->getClientOriginalName(),
                    'path' => $file_gambar->store('gambar_produk', 'public')
                ]);
            }

            if (!$tambah_gambar_produk) {
                return response()->json([
                    'status' => 0,
                    'msg' => 'Terjadi kesalahan, Gagal Menambahkan Gambar Produk'
                ]);
            } else {
                return response()->json([
                    'status' => 1,
                    'msg' => 'Berhasil Menambahkan Gambar Produk'
                ]);
            }
        }
    }

    public function hapus_data_gambar_produk($gambar_produk_id){
        $gambar_produk = ProdukGambar::find($gambar_produk_id);
        $path = 'storage/'.$gambar_produk->path;
        if (File::exists($path)) {
            File::delete($path);
        }
        $gambar_produk->delete();
        return response()->json([
            'status' => 1,
            'msg'   => 'Berhasil Menghapus Data Produk Variasi',
        ]);
    }
}
