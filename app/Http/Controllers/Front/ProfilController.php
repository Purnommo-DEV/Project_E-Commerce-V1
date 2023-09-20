<?php

namespace App\Http\Controllers\Front;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PesananStatusLog;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function profil(){
        $pesanan = Pesanan::with('relasi_pesanan_status.relasi_status_master')->where('users_id', Auth::user()->id)->get();
        return view('Front.profil.profil', compact('pesanan'));
    }
}
