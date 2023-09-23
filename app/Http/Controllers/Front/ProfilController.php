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

        // $pesanan_batal = Pesanan::with('relasi_pesanan_status')
        //     ->where('users_id', Auth::user()->id)
        //     ->whereRelation('relasi_pesanan_status', 'status_pesanan_id', ['7', '8', '9'])
        //     ->get();

            $pesanan_batal = Pesanan::whereHas('relasi_pesanan_status', function($q){
                $q->whereIn('status_pesanan_id', ['7', '8', '9']);
            })->get();

        return view('Front.profil.profil', compact('pesanan_belum_bayar', 'pesanan_sudah_bayar', 'pesanan_dikemas', 'pesanan_dikirim', 'pesanan_selesai', 'pesanan_batal'));
    }
}
