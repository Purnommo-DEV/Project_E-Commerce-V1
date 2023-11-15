<?php

namespace App\Http\Controllers\Front;

use App\Models\Kota;
use App\Models\User;
use App\Models\Alamat;
use App\Models\Pesanan;
use App\Models\Provinsi;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PesananStatusLog;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfilController extends Controller
{
    public function profil(){
        $pesanan_belum_bayar = Pesanan::with('relasi_pesanan_status')
            ->whereRelation('relasi_pesanan_status', 'status_pesanan_id', 1)
            ->where('users_id', Auth::user()->id)
            ->get();

        $pesanan_sudah_bayar = Pesanan::with('relasi_pesanan_status')
            ->whereRelation('relasi_pesanan_status', 'status_pesanan_id', 10)
            ->where('users_id', Auth::user()->id)
            ->get();

        $pesanan_dikemas = Pesanan::with('relasi_pesanan_status')
            ->whereRelation('relasi_pesanan_status', 'status_pesanan_id', 4)
            ->where('users_id', Auth::user()->id)
            ->get();

        $pesanan_dikirim = Pesanan::with('relasi_pesanan_status')
            ->whereRelation('relasi_pesanan_status', 'status_pesanan_id', 5)
            ->where('users_id', Auth::user()->id)
            ->get();

        $pesanan_selesai = Pesanan::with('relasi_pesanan_status')
            ->whereRelation('relasi_pesanan_status', 'status_pesanan_id', 6)
            ->where('users_id', Auth::user()->id)
            ->get();

        $pesanan_batal = Pesanan::whereHas('relasi_pesanan_status', function($q){
            $q->whereIn('status_pesanan_id', ['7', '8', '9']);
        })->get();

        $alamat_pengguna = Alamat::where('users_id', Auth::user()->id)->get();
        $provinsi = Provinsi::pluck('name', 'id');
        $pengguna = User::select('name', 'email', 'jk', 'nomor_hp')->where('id', Auth::user()->id)->first();
        $total_alamat = $alamat_pengguna->count();
        return view('Front.profil.profil', compact('pesanan_belum_bayar', 'pesanan_sudah_bayar', 'pesanan_dikemas', 'pesanan_dikirim', 'pesanan_selesai', 'pesanan_batal', 'alamat_pengguna', 'provinsi', 'pengguna', 'total_alamat'));
    }

    public function ubah_akun_pengguna(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'nomor_hp' => 'required',
            'jk' => 'required'
        ], [
            'name.required' => 'Wajib diisi',
            'email.required' => 'Wajib diisi',
            'nomor_hp.required' => 'Wajib diisi',
            'jk.required' => 'Wajib diisi'
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'status' => 0,
                'error' => $validator->errors()->toArray()
            ]);
        } else {
            $data_user = User::where('id', $request->pengguna_id)->first();
            if($request->hasFile('foto')){
                $filenameWithExt = $request->file('foto')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('foto')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                $path = $request->file('foto')->store('gambar_profil', 'public');
                $posisi_file = 'storage/' . $data_user->path;
                if (File::exists($posisi_file)) {
                    File::delete($posisi_file);
                }
            }else{
                $path = $data_user->foto;
            }
            $ubah_data_user = $data_user->update([
                'name' => $request->name,
                'email' => $request->email,
                'foto' => $path,
                'nomor_hp' => $request->nomor_hp,
                'jk' => $request->jk
            ]);

            if (!$ubah_data_user) {
                return response()->json([
                    'status_gagal_ubah_profil' => 1,
                    'msg' => 'Terjadi kesalahan, Gagal Mengubah Akun'
                ]);
            } else {
                return response()->json([
                    'status_berhasil_ubah_profil' => 1,
                    'msg' => 'Berhasil Mengubah Akun'
                ]);
            }
        }
    }

    public function tambah_alamat_pengguna(Request $request){
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'alamat' => 'required',
            'provinsi_id' => 'required',
            'kota_id' => 'required'
        ], [
            'nama.required' => 'Wajib diisi',
            'alamat.required' => 'Wajib diisi',
            'provinsi_id.required' => 'Wajib diisi',
            'kota_id.required' => 'Wajib diisi'
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'status' => 0,
                'error' => $validator->errors()->toArray()
            ]);
        } else {
            $tambah_alamat_pengguna = Alamat::create([
                'users_id' => Auth::user()->id,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'provinsi_id' => $request->provinsi_id,
                'kota_id' => $request->kota_id
            ]);

            if (!$tambah_alamat_pengguna) {
                return response()->json([
                    'status_gagal_tambah_alamat' => 1,
                    'msg' => 'Terjadi kesalahan, Gagal Menambahkan Alamat'
                ]);
            } else {
                return response()->json([
                    'status_berhasil_tambah_alamat' => 1,
                    'msg' => 'Berhasil Menambahkan Alamat'
                ]);
            }
        }
    }

    public function data_alamat_customer($alamat_id){
        $data_alamat = Alamat::where('id', $alamat_id)->first();
        $kota = Kota::where('provinsi_id', $data_alamat->provinsi_id)->pluck('name', 'id');
        $provinsi = Provinsi::pluck('name', 'id');
        return response()->json([
            'data_alamat' => $data_alamat,
            'data_kota' => $kota,
            'data_provinsi' => $provinsi
        ]);
    }

    public function ubah_alamat_pengguna(Request $request, $alamat_id){
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'alamat' => 'required',
            'provinsi_id' => 'required',
            'kota_id' => 'required'
        ], [
            'nama.required' => 'Wajib diisi',
            'alamat.required' => 'Wajib diisi',
            'provinsi_id.required' => 'Wajib diisi',
            'kota_id.required' => 'Wajib diisi'
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'status' => 0,
                'error' => $validator->errors()->toArray()
            ]);
        } else {
            $data_alamat = Alamat::where('id', $alamat_id)->first();
            $ubah_data_alamat = $data_alamat->update([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'provinsi_id' => $request->provinsi_id,
                'kota_id' => $request->kota_id,
            ]);

            if (!$ubah_data_alamat) {
                return response()->json([
                    'status_gagal_ubah_alamat' => 1,
                    'msg' => 'Terjadi kesalahan, Gagal Mengubah Alamat'
                ]);
            } else {
                return response()->json([
                    'status_berhasil_ubah_alamat' => 1,
                    'msg' => 'Berhasil Mengubah Alamat'
                ]);
            }
        }
    }

    public function konfirmasi_hapus_alamat($alamat_id){
        Alamat::where([
            'users_id' => Auth::user()->id,
            'alamat_utama' => 1
            ])->delete();
            return response()->json([
                'status_berhasil_hapus_alamat' => 1,
                'msg' => 'Berhasil Hapus Alamat'
            ]);
    }

    public function konfirmasi_alamat_utama($alamat_id){
        $alamat_utama = Alamat::where([
                'users_id' => Auth::user()->id,
                'alamat_utama' => 1
            ])->first();

            $alamat_utama->update([
            'alamat_utama' => 0
        ]);

        $ubah_alamat_utama = Alamat::where([
            'users_id' => Auth::user()->id,
            'id' => $alamat_id
            ])->first();

            $ubah_alamat_utama->update([
            'alamat_utama' => 1
        ]);

        return response()->json([
                'status_menjadi_alamat_utama' => 1,
                'msg' => 'Berhasil Mengubah Menjadi Alamat Utama'
            ]);
    }

    public function ubah_password_customer(Request $request){
        $validator = Validator::make(
            $request->all(),
            [
                'passwordlama' => [
                    'required', function ($attribute, $value, $fail) {
                        if (!Hash::check($value, Auth::user()->password)) {
                            return $fail(__('Password anda tidak cocok'));
                        }
                    },
                    'min:3', 'max:30',
                ],
                'password' => 'required|min:8|max:30',
                'konfirmasipasswordbaru' => 'required|same:password'
            ],
            [
                'passwordlama.required' => 'Wajib diisi', // custom message
                'passwordlama.min' => 'Minimal 8 Karakter', // custom message
                'passwordlama.max' => 'Maksimal 30 Karakter', // custom message

                'password.required' => 'Wajib diisi', // custom message
                'password.min' => 'Minimal 8 Karakter', // custom message
                'password.max' => 'Maksimal 30 Karakter', // custom message

                'konfirmasipasswordbaru.required' => 'Wajib diisi', // custom message
                'konfirmasipasswordbaru.same' => 'Konfirmasi password tidak tepat' // custom message

            ]
        );

        if (!$validator->passes()) {
            return response()->json([
                'status' => 0,
                'error' => $validator->errors()->toArray()
            ]);
        } else {
            $updated = User::find(Auth::user()->id)
                ->update([
                    'password' => Hash::make($request->password)
                ]);

            if (!$updated) {
                return response()->json([
                    'status' => 0,
                    'msg' => 'Terjadi kesalahan, Gagal mengupdate password'
                ]);
            } else {
                return response()->json([
                    'status' => 1,
                    'msg' => 'Berhasil mengupdate password'
                ]);
            }
        }
    }
    // public function editable_ubah_nama_pengguna(Request $request){
    //     {
    //         if ($request->ajax()) {
    //             User::find($request->pk)
    //                 ->update([
    //                     'name' => $request->value
    //                 ]);

    //             return response()->json(['success' => true]);
    //         }
    //     }
    // }

}
