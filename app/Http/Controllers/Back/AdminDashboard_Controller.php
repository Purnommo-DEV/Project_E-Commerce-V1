<?php

namespace App\Http\Controllers\Back;

use App\Models\User;
use App\Models\Produk;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use App\Models\PesananDetail;
use App\Models\PesananStatus;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AdminDashboard_Controller extends Controller
{
    public function dashboard(){

        $penjualan_perbulan = Pesanan::select(DB::raw("COUNT(*) as count"), DB::raw("MONTHNAME(created_at) as month_name"))
                    ->whereYear('created_at', date('Y'))
                    ->groupBy(DB::raw("Month(created_at)"))
                    ->pluck('count', 'month_name');
        $bulan_memiliki_penjualan = $penjualan_perbulan->keys();
        $total_penjualan = $penjualan_perbulan->values();

        $total_produk = Produk::count();
        $total_pesanan = PesananStatus::whereIn('status_pesanan_id', ['4', '5', '6'])->count();
        $total_pelanggan = User::where('role_id', 2)->count();

        $produk_banyak_terjual = PesananDetail::select(
            "produk_id","produk_detail_id",
            DB::raw("(count(produk_id)) as alias_total_terjual"),
            DB::raw("(sum(total_harga)) as alias_total_pendapatan_bersih"),
            DB::raw("(DATE_FORMAT(created_at, '%d %M %Y')) as tanggal")
            )
            ->with('relasi_produk.relasi_gambar', 'relasi_produk_detail', 'relasi_pesanan.relasi_pesanan_status')
            ->whereRelation('relasi_pesanan.relasi_pesanan_status', 'status_pesanan_id', 6)
            ->orderBy('alias_total_terjual', 'desc')
            ->groupBy(DB::raw("produk_id"), DB::raw("produk_detail_id"))->get();

        return view('Back.dashboard.dashboard', compact('bulan_memiliki_penjualan', 'total_penjualan', 'total_produk', 'total_pesanan', 'total_pelanggan','produk_banyak_terjual'));
    }
}
