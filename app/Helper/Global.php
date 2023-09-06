<?php

use App\Models\Keranjang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

function help_total_produk_keranjang(){
    if(Auth::check()){
        $user_id = Auth::user()->id;
        $total_produk_dalam_keranjang = Keranjang::where('users_id', $user_id)->count('kuantitas');
    }else{
        $session_id = Session::get('session_id');
        $total_produk_dalam_keranjang = Keranjang::where('session_id', $session_id)->count('kuantitas');
    }
    return $total_produk_dalam_keranjang;
}

function replace_between($str, $needle_start, $needle_end, $replacement) {
    $pos = strpos($str, $needle_start);
    $start = $pos === false ? 0 : $pos + strlen($needle_start);

    $pos = strpos($str, $needle_end, $start);
    $end = $start === false ? strlen($str) : $pos;

    return substr_replace($str,$replacement,  $start, $end - $start);
}
