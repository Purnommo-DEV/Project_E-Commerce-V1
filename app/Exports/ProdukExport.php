<?php

namespace App\Exports;
use Carbon\Carbon;
use App\Models\PesananDetail;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProdukExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $t_awal = request()->input('tgl_awal') ;
        $t_akhir   = request()->input('tgl_akhir') ;

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

            if($t_awal && $t_akhir){
                $tgl_awal = Carbon::parse($t_awal);
                $tgl_akhir = Carbon::parse($t_akhir);
                if($tgl_akhir->greaterThan($tgl_awal)){
                    $data = $data->whereBetween('created_at', [$tgl_awal, $tgl_akhir])->get();
                }
            }else{
                $data = $data->get();
            }
        return $data;
    }

    public function map($catatan) : array {
        if($catatan->relasi_produk->produk_tipe_id == 1){
            return [
                [
                    $catatan->relasi_produk->nama_produk,
                    $catatan->relasi_produk_detail->produk_variasi = '-',
                    $catatan->alias_total_terjual,
                    $this->rupiahFormat($catatan->alias_total_pendapatan_bersih),
                    $catatan->relasi_produk_detail->stok
                ],

            ];
        }elseif($catatan->relasi_produk->produk_tipe_id == 2){
        return [
                [
                    $catatan->relasi_produk->nama_produk,
                    $catatan->relasi_produk_detail->produk_variasi,
                    $catatan->alias_total_terjual,
                    $this->rupiahFormat($catatan->alias_total_pendapatan_bersih),
                    $catatan->relasi_produk_detail->stok
                ],
            ];
        }
    }

    public function headings() : array {
        return [
            'Produk',
            'Variasi',
            'Terjual',
            'Pendapatan Bersih',
            'Stok'
        ] ;
    }

    public function rupiahFormat($expression)
    {
        return 'Rp.'.number_format($expression,0,',','.');
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {

                // $sum_piutang = DetailKegiatan::sum('piutang');
                // $sum_terbayar = DetailKegiatan::sum('terbayar');
                // $total_piutang = DetailKegiatan::sum('saldo');
                $t_awal = request()->input('tgl_awal') ;
                $t_akhir   = request()->input('tgl_akhir') ;

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

                    if($t_awal && $t_akhir){
                        $tgl_awal = Carbon::parse($t_awal);
                        $tgl_akhir = Carbon::parse($t_akhir);
                        if($tgl_akhir->greaterThan($tgl_awal)){
                            $data = $data->whereBetween('created_at', [$tgl_awal, $tgl_akhir])->get();
                            $sum_pendapatan_bersih = $data->sum('alias_total_pendapatan_bersih');
                        }
                    }else{
                        $data = $data->get();
                        $sum_pendapatan_bersih = $data->sum('alias_total_pendapatan_bersih');
                }

                $sheet = $event->sheet->getDelegate();
                $sheet->insertNewRowBefore(1,3);
                $lastContentColumn = (string) $event->sheet->getDelegate()->getHighestColumn();
                $lastContentRow = (string) $event->sheet->getDelegate()->getHighestRow();
                $lastContentRowTotal = (string) $event->sheet->getDelegate()->getHighestRow();
                $cellE1 = (string) $lastContentColumn . '1';
                $cellELast = (string) 'E' . $lastContentRow;


                $stringTotal = (string) 'A'. $lastContentRowTotal+1;
                $sumPendapatanBersih = (string) 'D'. $lastContentRowTotal+1;
                // JUDUL
                $event->sheet->getDelegate()
                    ->setCellValue('A1','LAPORAN PRODUK')->mergeCells('A1:E1');

                // PERIODE
                $event->sheet->getDelegate()
                    ->setCellValue('A2','Periode : '.Carbon::parse($t_awal)->format('d F y').' - '.Carbon::parse($t_akhir)->format('d F y'))->mergeCells('A2:E2');

                // TOTAL FOOTER
                $event->sheet->getDelegate()
                    ->setCellValue($stringTotal, "Total");

                // SUM PENDAPATAN BERSIH FOOTER
                $event->sheet->getDelegate()
                    ->setCellValue($sumPendapatanBersih, $this->rupiahFormat($sum_pendapatan_bersih));

                // JUDUL
                $event->sheet->getDelegate()->getStyle("A1:E1")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 15,
                    ],
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                 // PERIODE
                 $event->sheet->getDelegate()->getStyle("A2:E2")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                    ],
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);


                // HEADER
                $event->sheet->getDelegate()->getStyle("A4:E4")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                    ],
                    'borders' => [
                        'right'=>[
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ]
                    ],
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                // ISI
                $event->sheet->getDelegate()->getStyle("A4:$cellELast")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                // FOOTER
                $event->sheet->getDelegate()->getStyle("$stringTotal:$sumPendapatanBersih")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

            },

        ];
    }
}
