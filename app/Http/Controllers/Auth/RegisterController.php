<?php

namespace App\Http\Controllers\Auth;

use App\Models\Kota;
use App\Models\User;
use App\Models\Alamat;
use App\Models\Provinsi;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function halaman_register(){
        $provinsi = Provinsi::pluck('name', 'id');
        return view('Auth.register', compact('provinsi'));
    }

    public function list_kota($id)
    {
        $kota = Kota::where('provinsi_id', $id)->pluck('name', 'id');
        return response()->json($kota);
    }

    public function user_register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',

            'alamat' => 'required|min:0',
            'provinsi_id' => 'required',
            'kota_id' => 'required',
            'nomor_hp' => 'required|digits:12',
        ], [
            'name.required' => 'Wajib diisi',
            'email.required' => 'Wajib diisi',
            'email.email' => 'Harus berupa email @',
            'email.unique' => 'Email yang anda masukkan telah terdaftar',
            'password.required' => 'Wajib diisi',
            'password.min' => 'Minimal 8 karakter',
            'alamat.required' => 'Wajib diisi',
            'provinsi_id.required' => 'Wajib diisi',
            'kota_id.required' => 'Wajib diisi',
            'nomor_hp.required' => 'Wajib diisi',
            'nomor_hp.digits' => 'Minimal 12 digit',
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'status' => 0,
                'error' => $validator->errors()->toArray()
            ]);
        } else {
            $user_register = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'kode' => 'CSR-' . Str::random('32'),
                'password' => Hash::make($request->password),
                'role_id' => 2
            ]);

            $alamat_user = Alamat::create([
                'users_id' => $user_register->id,
                'nama' => $request->name,
                'alamat' => $request->alamat,
                'provinsi_id' => $request->provinsi_id,
                'kota_id' => $request->kota_id,
                'nomor_hp' => $request->nomor_hp,
                'alamat_utama' => 1
            ]);

            if (!$user_register || !$alamat_user) {
                return response()->json([
                    'status' => 0,
                    'msg' => 'Terjadi kesalahan, Gagal Register'
                ]);
            } else {
                return response()->json([
                    'status' => 1,
                    'msg' => 'Berhasil Melakukan Registrasi',
                    'route' => route('Login')
                ]);
            }
        }
    }
}
