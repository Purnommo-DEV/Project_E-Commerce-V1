<?php

namespace App\Http\Controllers\Back;

use App\Models\Kategori;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminKategori_Controller extends Controller
{
    public function kategori(){
        return view('Back.kategori.kategori');
    }

    public function data_kategori(Request $request){
        $data = Kategori::select([
            'kategori.*'
        ])->orderBy('created_at', 'desc');

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

    public function tambah_data_kategori(Request $request){
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required',
            'path' => 'required',
        ], [
            'nama_kategori.required' => 'Wajib diisi',
            'path.required' => 'Wajib diisi',
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'status' => 0,
                'error' => $validator->errors()->toArray()
            ]);
        } else {
            if($request->hasFile('path')){
                $filenameWithExt = $request->file('path')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('path')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                $path = $request->file('path')->store('gambar_kategori', 'public');
            }
            $tambah_kategori = Kategori::create([
                'nama_kategori' => $request->nama_kategori,
                'slug' => Str::slug($request->nama_kategori),
                'path' => $path
            ]);

            if (!$tambah_kategori) {
                return response()->json([
                    'status' => 0,
                    'msg' => 'Terjadi kesalahan, Gagal Menambahkan Kategori'
                ]);
            } else {
                return response()->json([
                    'status' => 1,
                    'msg' => 'Berhasil Menambahkan Kategori'
                ]);
            }
        }
    }

    public function edit_data_kategori(Request $request){
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required'
        ], [
            'nama_kategori.required' => 'Wajib diisi',
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'status' => 0,
                'error' => $validator->errors()->toArray()
            ]);
        } else {
            $data_kategori = Kategori::where('id', $request->id)->first();
            if($request->hasFile('path')){
                $filenameWithExt = $request->file('path')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('path')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                $path = $request->file('path')->store('gambar_kategori', 'public');
                $posisi_file = 'storage/' . $data_kategori->path;
                if (File::exists($posisi_file)) {
                    File::delete($posisi_file);
                }
            }else{
                $path = $data_kategori->path;
            }
            $ubah_data_kategori = $data_kategori->update([
                'nama_kategori' => $request->nama_kategori,
                'slug' => Str::slug($request->nama_kategori),
                'path' => $path
            ]);

            if (!$ubah_data_kategori) {
                return response()->json([
                    'status' => 0,
                    'msg' => 'Terjadi kesalahan, Gagal Mengubah Kategori'
                ]);
            } else {
                return response()->json([
                    'status' => 1,
                    'msg' => 'Berhasil Mengubah Kategori'
                ]);
            }
        }
    }

    public function hapus_data_kategori($kategori_id){
        $hapus_kategori = Kategori::find($kategori_id);
        $path = 'storage/' . $hapus_kategori->path;
        if (File::exists($path)) {
            File::delete($path);
        }
        $hapus_kategori->delete();
        return response()->json([
            'status' => 1,
            'msg'   => 'Berhasil Menghapus Data',
        ]);

    }
}
