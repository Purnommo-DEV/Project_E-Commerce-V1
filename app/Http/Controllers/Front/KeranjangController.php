<?php

namespace App\Http\Controllers\Front;

use App\Models\Keranjang;
use App\Models\ProdukDetail;
use App\Http\Controllers\Controller;
use App\Models\ProdukGambar;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function keranjang(){
        $data_keranjang = Keranjang::func_data_keranjang_pengguna();
        return view('Front.keranjang.keranjang', compact('data_keranjang'));
    }

    public function update_kuantitas_produk_keranjang(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $detailKeranjang = Keranjang::find($data['cartid']);

            $stokTersedia = ProdukDetail::select(['id', 'stok'])->where([
                'id'=>$detailKeranjang['produk_detail_id']])
                    ->first()
                    ->toArray();

            if($data['kts'] > $stokTersedia['stok']){
                return response()->json([
                    'status_stok_lebih'=> 1,
                    'msg'=> "Kuantitas melebihi batas stok produk"
                ]);
            }else if($data['kts'] < 0){
                return response()->json([
                    'status_stok_kurang_dari_0' => 1,
                    'msg' => "Kuantitas produk tidak boleh kurang dari 0"
                ]);
            }else{
                ProdukDetail::where('id', $stokTersedia['id'])->update([
                    'stok' => $stokTersedia['stok'] - ($data['kts'] - $detailKeranjang->kuantitas)
                ]);

                Keranjang::where('id', $data['cartid'])->update([
                    'kuantitas'=>$data['kts']
                ]);
                return response()->json([
                    'status_kuantitas_berubah'=> 1,
                    'msg' => 'Kuantitas berubah'
                ]);
            }
        }
    }

    public function hapus_produk_dalam_keranjang(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $data_keranjang = Keranjang::where('id', $data['keranjang_id'])->first();

            $data_produk_detail = ProdukDetail::where([
                'id' => $data_keranjang->produk_detail_id,
                'produk_id' => $data_keranjang->produk_id
            ])->first();

            $data_produk_detail->update([
                'stok' => $data_produk_detail->stok + $data_keranjang->kuantitas
            ]);
            $data_keranjang->delete();

            return response()->json([
                'status_hapus_produk' => 1,
                'msg' => 'Produk telah di hapus dalam keranjang',
                'total_produk_keranjang'=> help_total_produk_keranjang(),
                'data_keranjang_terbaru' => help_data_isi_keranjang_baru(),
                'total_harga_produk_dlm_keranjang' => help_total_harga_produk_keranjang()
            ]);
        }
    }
}
