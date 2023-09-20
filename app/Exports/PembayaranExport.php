<?php

namespace App\Exports;

use App\Models\Pesanan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PembayaranExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $t_awal = request()->input('tgl_awal') ;
        $t_akhir   = request()->input('tgl_akhir') ;

        $data = Pesanan::select([
            'pesanan.*'
            ])->with('relasi_pesanan_status.relasi_status_master')
            ->orderBy('orders_date', 'desc');

            if($t_awal && $t_akhir){
                $tgl_awal = Carbon::parse($t_awal);
                $tgl_akhir = Carbon::parse($t_akhir);
                if($tgl_akhir->greaterThan($tgl_awal)){
                    $data = $data->whereBetween('orders_date', [$tgl_awal, $tgl_akhir])->get();
                }
            }else{
                $data = $data->get();
            }

        return $data;
    }

    public function map($catatan) : array {
        return [
            [
                $catatan->kode_pesanan,
                Carbon::parse($catatan->orders_date)->format('d F y'),
                $catatan->relasi_pesanan_status->relasi_status_master->status_pesanan,
                $this->rupiahFormat($catatan->total_pembayaran),
                $catatan->metode_pembayaran.'( Transfer Bank )',
            ],

        ];
    }

    public function headings() : array {
        return [
            'Kode Pesanan',
            'Tanggal',
            'Status',
            'Jumlah',
            'Metode Pembayaran'
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
                $t_awal = request()->input('tgl_awal') ;
                $t_akhir   = request()->input('tgl_akhir') ;

                $data = Pesanan::select([
                    'pesanan.*'
                    ])->with('relasi_pesanan_status.relasi_status_master')
                    ->orderBy('orders_date', 'desc');

                    if($t_awal && $t_akhir){
                        $tgl_awal = Carbon::parse($t_awal);
                        $tgl_akhir = Carbon::parse($t_akhir);
                        if($tgl_akhir->greaterThan($tgl_awal)){
                            $data = $data->whereBetween('orders_date', [$tgl_awal, $tgl_akhir])->get();
                        }
                    }else{
                        $data = $data->get();
                    }


                $sheet = $event->sheet->getDelegate();
                $sheet->insertNewRowBefore(1,3);
                $lastContentColumn = (string) $event->sheet->getDelegate()->getHighestColumn();
                $lastContentRow = (string) $event->sheet->getDelegate()->getHighestRow();
                $lastContentRowTotal = (string) $event->sheet->getDelegate()->getHighestRow();
                $cellE1 = (string) $lastContentColumn . '1';
                $cellELast = (string) 'E' . $lastContentRow;

                // JUDUL
                $event->sheet->getDelegate()
                    ->setCellValue('A1','LAPORAN PEMBAYARAN')->mergeCells('A1:E1');

                // PERIODE
                $event->sheet->getDelegate()
                    ->setCellValue('A2','Periode : '.Carbon::parse($t_awal)->format('d F y').' - '.Carbon::parse($t_akhir)->format('d F y'))->mergeCells('A2:E2');

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
            },

        ];
    }
}
