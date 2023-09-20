<?php

namespace App\Http\Controllers\Back;

use PDF;
use Carbon\Carbon;
use App\Models\Pesanan;
use App\Models\ProdukDetail;
use Illuminate\Http\Request;
use App\Exports\ProdukExport;
use App\Models\PesananDetail;
use App\Exports\InventoryExport;
use App\Exports\PembayaranExport;
use App\Exports\PendapatanExport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class AdminLaporan_Controller extends Controller
{
    // LAPORAN PENDAPATAN
    public function halaman_laporan_pendapatan(){
        return view('Back.laporan.l_pendapatan');
    }

    public function data_laporan_pendapatan(Request $request){
        $data = Pesanan::select(
            "id" ,
            DB::raw("(count(id)) as alias_total_pesanan"),
            DB::raw("(sum(total_pembayaran)) as alias_total_pendapatan_kotor"),
            DB::raw("(sum(total_ongkir)) as alias_total_ongkir"),
            DB::raw("(DATE_FORMAT(created_at, '%d %M %Y')) as tanggal")
            )
            ->orderBy('created_at')
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%d-%m-%Y')"));

        if($request->input('req_tgl_awal') && $request->input('req_tgl_akhir')){
            $tgl_awal = Carbon::parse($request->input('req_tgl_awal'));
            $tgl_akhir = Carbon::parse($request->input('req_tgl_akhir'));
            if($tgl_akhir->greaterThan($tgl_awal)){
                $data = $data->whereBetween('created_at', [$tgl_awal, $tgl_akhir]);
                $data->get();
            }else{
                $data = $data->get();
            }
        }

        $rekamFilter = $data->get()->count();
        if ($request->input('length') != -1)
            $data = $data->skip($request->input('start'))->take($request->input('length'));
        $rekamTotal = $data->count();
        $data = $data->get();

        return response()->json([
            'draw' => $request->input('draw'),
            'data' => $data,
            'recordsTotal' => $rekamTotal,
            'recordsFiltered' => $rekamFilter,
        ]);
    }

    public function cetak_laporan_pendapatan(Request $request){
        $startDate = $request->input('tgl_awal');
		$endDate = $request->input('tgl_akhir');

		if ($startDate && !$endDate) {
			Session::flash('error', 'The end date is required if the start date is present');
			return redirect()->route('admin.HalamanLaporan.Pendapatan');
		}

		if (!$startDate && $endDate) {
			Session::flash('error', 'The start date is required if the end date is present');
			return redirect()->route('admin.HalamanLaporan.Pendapatan');
		}

		if ($startDate && $endDate) {
			if (strtotime($endDate) < strtotime($startDate)) {
				Session::flash('error', 'The end date should be greater or equal than start date');
				return redirect()->route('admin.HalamanLaporan.Pendapatan');
			}

			$earlier = new \DateTime($startDate);
			$later = new \DateTime($endDate);
			$diff = $later->diff($earlier)->format("%a");

			if ($diff >= 31) {
				Session::flash('error', 'The number of days in the date ranges should be lower or equal to 31 days');
				return redirect()->route('admin.HalamanLaporan.Pendapatan');
			}
		} else {
			$currentDate = date('Y-m-d');
			$startDate = date('Y-m-01', strtotime($currentDate));
			$endDate = date('Y-m-t', strtotime($currentDate));
		}

        if($request->jenis_ekspor == 'excel'){
            $nama_file = 'laporan_pendapatan_'.date('Y-m-d_H-i-s').'.xlsx';
            return Excel::download(new PendapatanExport, $nama_file);
        }
        elseif($request->jenis_ekspor == 'pdf'){
            $data = Pesanan::select(
                "id" ,
                DB::raw("(count(id)) as alias_total_pesanan"),
                DB::raw("(sum(total_pembayaran)) as alias_total_pendapatan_kotor"),
                DB::raw("(sum(total_ongkir)) as alias_total_ongkir"),
                DB::raw("(DATE_FORMAT(created_at, '%d %M %Y')) as tanggal")
                )
                ->orderBy('created_at')
                ->groupBy(DB::raw("DATE_FORMAT(created_at, '%d-%m-%Y')"));

                if($request->tgl_awal && $request->tgl_akhir){
                    $tgl_awal = Carbon::parse($request->tgl_awal);
                    $tgl_akhir = Carbon::parse($request->tgl_akhir);
                    if($tgl_akhir->greaterThan($tgl_awal)){
                        $data = $data->whereBetween('created_at', [$tgl_awal, $tgl_akhir])->get();
                    }
                }else{
                    $data = $data->get();
                }
            $print_data = PDF::loadView('Back.laporan.print._print_laporan_pendapatan', [
                'data' => $data,
                'periode' => $request->tgl_awal.' - '.$request->tgl_akhir
            ])->setPaper("A4", "portrait")->setOptions(['defaultFont' => 'sans-serif']);
            return $print_data->stream('laporan_pendapatan.pdf');
        }
    }
    // AKHIR LAPORAN PENDAPATAN




    // LAPORAN PRODUK
    public function halaman_laporan_produk(){
        return view('Back.laporan.l_produk');
    }

    public function data_laporan_produk(Request $request){
         $data = PesananDetail::select(
            "produk_id","produk_detail_id",
            DB::raw("(count(produk_id)) as alias_total_terjual"),
            DB::raw("(sum(total_harga)) as alias_total_pendapatan_bersih"),
            DB::raw("(DATE_FORMAT(created_at, '%d %M %Y')) as tanggal")
            )
            ->with('relasi_produk.relasi_gambar', 'relasi_produk_detail', 'relasi_pesanan.relasi_pesanan_status')
            ->whereRelation('relasi_pesanan.relasi_pesanan_status', 'status_pesanan_id', 6)
            ->orderBy('created_at')
            ->groupBy(DB::raw("produk_id"), DB::raw("produk_detail_id"));

            if($request->input('req_tgl_awal') && $request->input('req_tgl_akhir')){
                $tgl_awal = Carbon::parse($request->input('req_tgl_awal'));
                $tgl_akhir = Carbon::parse($request->input('req_tgl_akhir'));
                if($tgl_akhir->greaterThan($tgl_awal)){
                    $data = $data->whereBetween('created_at', [$tgl_awal, $tgl_akhir]);
                    $data->get();
                }else{
                    $data = $data->get();
                }
            }


            $rekamFilter = $data->get()->count();
            if ($request->input('length') != -1)
                $data = $data->skip($request->input('start'))->take($request->input('length'));
            $rekamTotal = $data->count();
            $data = $data->get();

            return response()->json([
                'draw' => $request->input('draw'),
                'data' => $data,
                'recordsTotal' => $rekamTotal,
                'recordsFiltered' => $rekamFilter,
            ]);
    }

    public function cetak_laporan_produk(Request $request){
        $startDate = $request->input('tgl_awal');
		$endDate = $request->input('tgl_akhir');

		if ($startDate && !$endDate) {
			Session::flash('error', 'The end date is required if the start date is present');
			return redirect()->route('admin.HalamanLaporan.Pendapatan');
		}

		if (!$startDate && $endDate) {
			Session::flash('error', 'The start date is required if the end date is present');
			return redirect()->route('admin.HalamanLaporan.Pendapatan');
		}

		if ($startDate && $endDate) {
			if (strtotime($endDate) < strtotime($startDate)) {
				Session::flash('error', 'The end date should be greater or equal than start date');
				return redirect()->route('admin.HalamanLaporan.Pendapatan');
			}

			$earlier = new \DateTime($startDate);
			$later = new \DateTime($endDate);
			$diff = $later->diff($earlier)->format("%a");

			if ($diff >= 31) {
				Session::flash('error', 'The number of days in the date ranges should be lower or equal to 31 days');
				return redirect()->route('admin.HalamanLaporan.Pendapatan');
			}
		} else {
			$currentDate = date('Y-m-d');
			$startDate = date('Y-m-01', strtotime($currentDate));
			$endDate = date('Y-m-t', strtotime($currentDate));
		}

        if($request->jenis_ekspor == 'excel'){
            $nama_file = 'laporan_produk_'.date('Y-m-d_H-i-s').'.xlsx';
            return Excel::download(new ProdukExport, $nama_file);
        }
        elseif($request->jenis_ekspor == 'pdf'){
            $data = PesananDetail::select(
                "produk_id","produk_detail_id",
                DB::raw("(count(produk_id)) as alias_total_terjual"),
                DB::raw("(sum(total_harga)) as alias_total_pendapatan_bersih"),
                DB::raw("(DATE_FORMAT(created_at, '%d %M %Y')) as tanggal")
                )
                ->with('relasi_produk.relasi_gambar', 'relasi_produk_detail', 'relasi_pesanan.relasi_pesanan_status')
                ->whereRelation('relasi_pesanan.relasi_pesanan_status', 'status_pesanan_id', 6)
                ->orderBy('created_at')
                ->groupBy(DB::raw("produk_id"), DB::raw("produk_detail_id"));

                if($request->input('req_tgl_awal') && $request->input('req_tgl_akhir')){
                    $tgl_awal = Carbon::parse($request->input('req_tgl_awal'));
                    $tgl_akhir = Carbon::parse($request->input('req_tgl_akhir'));
                    if($tgl_akhir->greaterThan($tgl_awal)){
                        $data = $data->whereBetween('created_at', [$tgl_awal, $tgl_akhir]);
                        $data->get();
                    }
                }else{
                    $data = $data->get();
                }

            $print_data = PDF::loadView('Back.laporan.print._print_laporan_produk', [
                'data' => $data,
                'periode' => $request->tgl_awal.' - '.$request->tgl_akhir
            ])->setPaper("A4", "portrait")->setOptions(['defaultFont' => 'sans-serif']);
            return $print_data->stream('laporan_produk.pdf');
        }
    }
    // AKHIR LAPORAN PENDAPATAN





    // LAPORAN INVENTORY
    public function halaman_laporan_inventory(){
        return view('Back.laporan.l_inventory');
    }

    public function data_laporan_inventory(Request $request){
        $data = ProdukDetail::select([
            'produk_detail.*'
        ])->with('relasi_produk')
        ->orderBy('created_at', 'desc');

        $rekamFilter = $data->get()->count();
        if ($request->input('length') != -1)
            $data = $data->skip($request->input('start'))->take($request->input('length'));
        $rekamTotal = $data->count();
        $data = $data->get();
        return response()->json([
            'draw' => $request->input('draw'),
            'data' => $data,
            'recordsTotal' => $rekamTotal,
            'recordsFiltered' => $rekamFilter
        ]);
    }

    public function cetak_laporan_inventory(Request $request){
        if($request->jenis_ekspor == 'excel'){
            $nama_file = 'laporan_inventory_'.date('Y-m-d_H-i-s').'.xlsx';
            return Excel::download(new InventoryExport, $nama_file);
        }
        elseif($request->jenis_ekspor == 'pdf'){
            $data = ProdukDetail::select([
                'produk_detail.*'
            ])->with('relasi_produk')
            ->orderBy('created_at', 'desc')
            ->get();

            $print_data = PDF::loadView('Back.laporan.print._print_laporan_inventory', [
                'data' => $data
            ])->setPaper("A4", "portrait")->setOptions(['defaultFont' => 'sans-serif']);
            return $print_data->stream('laporan_produk.pdf');
        }
    }
    // AKHIR LAPORAN PENDAPATAN





    // LAPORAN PEMBAYARAN
    public function halaman_laporan_pembayaran(){
        return view('Back.laporan.l_pembayaran');
    }

    public function data_laporan_pembayaran(Request $request){
        $data = Pesanan::select([
            'pesanan.*'
        ])->with('relasi_pesanan_status.relasi_status_master')
        ->orderBy('orders_date', 'desc');

        if($request->input('req_tgl_awal') && $request->input('req_tgl_akhir')){
            $tgl_awal = Carbon::parse($request->input('req_tgl_awal'));
            $tgl_akhir = Carbon::parse($request->input('req_tgl_akhir'));
            if($tgl_akhir->greaterThan($tgl_awal)){
                $data = $data->whereBetween('orders_date', [$tgl_awal, $tgl_akhir]);
                $data->get();
            }else{
                $data = $data->get();
            }
        }

        $rekamFilter = $data->get()->count();
        if ($request->input('length') != -1)
            $data = $data->skip($request->input('start'))->take($request->input('length'));
        $rekamTotal = $data->count();
        $data = $data->get();

        return response()->json([
            'draw' => $request->input('draw'),
            'data' => $data,
            'recordsTotal' => $rekamTotal,
            'recordsFiltered' => $rekamFilter,
        ]);
    }

    public function cetak_laporan_pembayaran(Request $request){
        $startDate = $request->input('tgl_awal');
		$endDate = $request->input('tgl_akhir');

		if ($startDate && !$endDate) {
			Session::flash('error', 'The end date is required if the start date is present');
			return redirect()->route('admin.HalamanLaporan.Pendapatan');
		}

		if (!$startDate && $endDate) {
			Session::flash('error', 'The start date is required if the end date is present');
			return redirect()->route('admin.HalamanLaporan.Pendapatan');
		}

		if ($startDate && $endDate) {
			if (strtotime($endDate) < strtotime($startDate)) {
				Session::flash('error', 'The end date should be greater or equal than start date');
				return redirect()->route('admin.HalamanLaporan.Pendapatan');
			}

			$earlier = new \DateTime($startDate);
			$later = new \DateTime($endDate);
			$diff = $later->diff($earlier)->format("%a");

			if ($diff >= 31) {
				Session::flash('error', 'The number of days in the date ranges should be lower or equal to 31 days');
				return redirect()->route('admin.HalamanLaporan.Pendapatan');
			}
		} else {
			$currentDate = date('Y-m-d');
			$startDate = date('Y-m-01', strtotime($currentDate));
			$endDate = date('Y-m-t', strtotime($currentDate));
		}

        if($request->jenis_ekspor == 'excel'){
            $nama_file = 'laporan_pembayaran_'.date('Y-m-d_H-i-s').'.xlsx';
            return Excel::download(new PembayaranExport, $nama_file);
        }
        elseif($request->jenis_ekspor == 'pdf'){
            $data = Pesanan::select([
                'pesanan.*'
            ])->with('relasi_pesanan_status.relasi_status_master')
            ->orderBy('orders_date', 'desc');

            if($startDate && $endDate){
                $tgl_awal = Carbon::parse($startDate);
                $tgl_akhir = Carbon::parse($endDate);
                if($tgl_akhir->greaterThan($tgl_awal)){
                    $data = $data->whereBetween('orders_date', [$tgl_awal, $tgl_akhir])->get();
                }
            }else{
                $data = $data->get();
            }

            $print_data = PDF::loadView('Back.laporan.print._print_laporan_pembayaran', [
                'data' => $data,
                'periode' => $request->tgl_awal.' - '.$request->tgl_akhir
            ])->setPaper("A4", "portrait")->setOptions(['defaultFont' => 'sans-serif']);
            return $print_data->stream('laporan_pembayaran.pdf');
        }
    }
    // AKHIR LAPORAN PEMBAYARAN
}
