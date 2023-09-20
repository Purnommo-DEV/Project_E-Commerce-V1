<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function halaman_login(){
        return view('Auth.login');
    }

    public function autentikasi(Request $request){
        // if (Auth::attempt([
        //     'email' => $request->email,
        //     'password' => $request->password
        // ])) {

        //     if (auth()->user()->relasi_role->role == 'admin') {
        //         $auth = Auth::user();
        //         $success['token'] = $auth->createToken('auth_token')->plainTextToken;
        //         $success['name'] = $auth->name;

        //         return response()->json([
        //             'status'  => 1,
        //             'success' => true,
        //             'message' => 'Login Admin Berhasil',
        //             'data'    => $success,
        //             'route' => route('admin.Dashboard')

        //         ]);
        //     }
        // } else {
        //     return response()->json([
        //         'success' => false,
        //         'message' => "Periksa kembali Email dan Password anda",
        //         'data'    => null
        //     ]);
        // }
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ], [
            'email.required' => 'Wajib diisi',
            'email.email' => 'Harus berupa email @',
            'password.required' => 'Wajib diisi',
            'password.min' => 'Minimal 8 karakter',
        ]);
        if (!$validator->passes()) {
            return response()->json([
                'status' => 0,
                'error' => $validator->errors()->toArray()
            ]);
        } else {
        if (Auth::attempt($request->only('email', 'password'))) {
            if (auth()->user()->role_id == 1) {
                return response()->json([
                    'status' => 1,
                    'msg' => 'Berhasil login sebagai Admin !',
                    'route' => route('admin.HalamanPesanan')
                ]);
            }
            elseif (auth()->user()->role_id == 2) {
                return response()->json([
                    'status' => 1,
                    'msg' => 'Berhasil login sebagai Customer !',
                    'route' => route('HalamanBeranda')
                ]);
            }
        } else {
            return response()->json([
                'status' => 2,
                'msg' => 'Login gagal, Username / password salah !',
            ]);
        }
        }
    }

    public function logout(){
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('HalamanBeranda');
    }
}
