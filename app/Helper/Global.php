<?php

use App\Models\Alamat;
use App\Models\Keranjang;
use Illuminate\Support\Str;
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

function help_tanggal_jam($data)
{
    return \Carbon\Carbon::parse($data)
       ->isoFormat('dddd, D MMMM Y, H:mm');
}

function help_limit_karakter($deskripsi)
{
    return Str::limit($deskripsi, 50, '...');
}

function help_data_keranjang(){
    return Keranjang::where('users_id', Auth::user()->id)->get(['produk_id', 'produk_detail_id', 'kuantitas', 'total_bayar']);
}

function help_data_isi_keranjang_baru(){
    $html_data_keranjang_header = '';
    foreach(help_data_keranjang() as $data_keranjang){
        $html_data_keranjang_header .= '<div class="product">';
        $html_data_keranjang_header .= '<div class="product-cart-details">';
        $html_data_keranjang_header .= '<h4 class="product-title">';
        if($data_keranjang->relasi_produk->produk_tipe_id == 2){
            $html_data_keranjang_header .= '<a href="product.html">'.$data_keranjang->relasi_produk->nama_produk.'('.$data_keranjang->relasi_produk_detail->produk_variasi.')</a>';
        }else{
            $html_data_keranjang_header .= '<a href="product.html">'.$data_keranjang->relasi_produk->nama_produk.'</a>';
        }
        $html_data_keranjang_header .= '</h4>';
        $html_data_keranjang_header .= '<span class="cart-product-info">';
        $html_data_keranjang_header .= '<span class="cart-product-qty">'.$data_keranjang->kuantitas.'</span>';
        $html_data_keranjang_header .= 'x'."Rp. ". number_format($data_keranjang->relasi_produk_detail->harga,0,',','.');
        $html_data_keranjang_header .= '</span>';
        $html_data_keranjang_header .= '</div>';
        $html_data_keranjang_header .= '<figure class="product-image-container">';
        $html_data_keranjang_header .= '<a href="product.html" class="product-image">';
        $html_data_keranjang_header .= '<img src="'.asset("storage/" . $data_keranjang->relasi_produk->relasi_gambar->path).'">';
        $html_data_keranjang_header .= '</a>';
        $html_data_keranjang_header .= '</figure>';
        $html_data_keranjang_header .= '</div>';
    }
    return $html_data_keranjang_header;
}

function help_format_rupiah($data){
    return "Rp. ". number_format($data,0,',','.');
}

function help_total_harga_produk_keranjang(){
    $data_keranjang = Keranjang::with('relasi_produk_detail')->where('users_id', Auth::user()->id)->get();
    $total = 0;
    $sub_total = 0;
    foreach($data_keranjang as $keranjang){
        $total = $keranjang->relasi_produk_detail->harga * $keranjang->kuantitas;
        $sub_total = $sub_total + $keranjang->relasi_produk_detail->harga * $keranjang->kuantitas;
    }
    return "Rp. ". number_format($sub_total,0,',','.');
}

function help_alamat_pengguna(){
    $alamat_pengguna = Alamat::where([
        'users_id' => Auth::user()->id,
        'alamat_utama' => 1
        ])->first();
    return $alamat_pengguna;
}
