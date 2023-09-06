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

            $stokTersedia = ProdukDetail::select('stok')->where([
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
            Keranjang::where('id', $data['keranjang_id'])->delete();
            return response()->json([
                'status_hapus_produk' => 1,
                'msg' => 'Produk telah di hapus dalam keranjang',
                'total_produk_keranjang'=> help_total_produk_keranjang()
            ]);
        }
    }
}
