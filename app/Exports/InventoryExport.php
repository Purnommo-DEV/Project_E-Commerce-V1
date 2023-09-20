<?php

namespace App\Exports;

use App\Models\ProdukDetail;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class InventoryExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = ProdukDetail::select([
            'produk_detail.*'
        ])->with('relasi_produk')
        ->orderBy('created_at', 'desc')
        ->get();

        return $data;
    }

    public function map($catatan) : array {
        if($catatan->relasi_produk->produk_tipe_id == 1){
            return [
                [
                    $catatan->relasi_produk->nama_produk,
                    $catatan->produk_variasi = '-',
                    $catatan->stok
                ],

            ];
        }elseif($catatan->relasi_produk->produk_tipe_id == 2){
            return [
                [
                    $catatan->relasi_produk->nama_produk,
                    $catatan->produk_variasi,
                    $catatan->stok
                ],
            ];
        }
    }

    public function headings() : array {
        return [
            'Produk',
            'Variasi',
            'Stok'
        ] ;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $sheet->insertNewRowBefore(1,3);
                $lastContentColumn = (string) $event->sheet->getDelegate()->getHighestColumn();
                $lastContentRow = (string) $event->sheet->getDelegate()->getHighestRow();
                $lastContentRowTotal = (string) $event->sheet->getDelegate()->getHighestRow();
                $cellE1 = (string) $lastContentColumn . '1';
                $cellELast = (string) 'C' . $lastContentRow;

                // JUDUL
                $event->sheet->getDelegate()
                    ->setCellValue('A1','LAPORAN INVENTORY')->mergeCells('A1:E1');

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
