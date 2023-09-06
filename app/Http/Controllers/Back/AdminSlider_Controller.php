<?php

namespace App\Http\Controllers\Back;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class AdminSlider_Controller extends Controller
{
    public function slider(){
        return view('Back.slider.slider');
    }

    public function data_slider(Request $request){
        $data = Slider::select([
            'slider.*'
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

    public function tambah_data_slider(Request $request){
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'gambar' => 'required',
        ], [
            'judul.required' => 'Wajib diisi',
            'gambar.required' => 'Wajib diisi',
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'status' => 0,
                'error' => $validator->errors()->toArray()
            ]);
        } else {
            if($request->hasFile('gambar')){
                $filenameWithExt = $request->file('gambar')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('gambar')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                $gambar = $request->file('gambar')->store('gambar_slider', 'public');
            }
            $tambah_slider = Slider::create([
                'judul' => $request->judul,
                'gambar' => $gambar
            ]);

            if (!$tambah_slider) {
                return response()->json([
                    'status' => 0,
                    'msg' => 'Terjadi kesalahan, Gagal Menambahkan Gambar Slider'
                ]);
            } else {
                return response()->json([
                    'status' => 1,
                    'msg' => 'Berhasil Menambahkan Gambar Slider'
                ]);
            }
        }
    }

    public function edit_data_slider(Request $request){
        $validator = Validator::make($request->all(), [
            'judul' => 'required'
        ], [
            'judul.required' => 'Wajib diisi',
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'status' => 0,
                'error' => $validator->errors()->toArray()
            ]);
        } else {
            $data_banner = Slider::where('id', $request->id)->first();
            if($request->hasFile('gambar')){
                $filenameWithExt = $request->file('gambar')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('gambar')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                $gambar = $request->file('gambar')->store('gambar_slider', 'public');
                $posisi_file = 'storage/' . $data_banner->gambar;
                if (File::exists($posisi_file)) {
                    File::delete($posisi_file);
                }
            }else{
                $gambar = $data_banner->gambar;
            }
            $ubah_data_banner = $data_banner->update([
                'judul' => $request->judul,
                'gambar' => $gambar
            ]);

            if (!$ubah_data_banner) {
                return response()->json([
                    'status' => 0,
                    'msg' => 'Terjadi kesalahan, Gagal Mengubah Banner'
                ]);
            } else {
                return response()->json([
                    'status' => 1,
                    'msg' => 'Berhasil Mengubah Banner'
                ]);
            }
        }
    }

    public function hapus_data_slider($banner_id){
        $hapus_banner = Slider::find($banner_id);
        $path = 'storage/' . $hapus_banner->path;
        if (File::exists($path)) {
            File::delete($path);
        }
        $hapus_banner->delete();
        return response()->json([
            'status' => 1,
            'msg'   => 'Berhasil Menghapus Data',
        ]);

    }
}
