<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Produk</title>
</head>

<body>
    <header style="font-weight:bold; text-align:center; padding:1rem">
        LAPORAN PRODUK<br>
        Periode : {{ $periode }}
    </header>
    <table border="1" width="100%">
        <thead>
            <tr>
                <td style="font-weight:bold; text-align:center; padding:1rem">Produk</td>
                <td style="font-weight:bold; text-align:center; padding:1rem">Variasi</td>
                <td style="font-weight:bold; text-align:center; padding:1rem">Terjual</td>
                <td style="font-weight:bold; text-align:center; padding:1rem">Pendapatan Bersih</td>
                <td style="font-weight:bold; text-align:center; padding:1rem">Stok</td>
            </tr>
        </thead>
        <tbody>
            @php
                $total_pendapatan_bersih = 0;
            @endphp
            @foreach ($data as $data_pesanan_detail)
                @php
                    $total_pendapatan_bersih += $data_pesanan_detail->alias_total_pendapatan_bersih;
                @endphp
                <tr>
                    <td style="text-align:center; padding:0.5rem">{{ $data_pesanan_detail->relasi_produk->nama_produk }}
                    </td>
                    <td style="text-align:center; padding:0.5rem">
                        @if ($data_pesanan_detail->relasi_produk->produk_tipe_id == 2)
                            {{ $data_pesanan_detail->relasi_produk_detail->produk_variasi }}
                        @elseif($data_pesanan_detail->relasi_produk->produk_tipe_id == 1)
                            -
                        @endif
                    </td>
                    <td style="text-align:center; padding:0.5rem">{{ $data_pesanan_detail->alias_total_terjual }}</td>
                    <td style="text-align:center; padding:0.5rem">{!! help_format_rupiah($data_pesanan_detail->alias_total_pendapatan_bersih) !!}</td>
                    <td style="text-align:center; padding:0.5rem">{{ $data_pesanan_detail->relasi_produk_detail->stok }}
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3" style="font-weight:bold; text-align:center; padding:1rem">Total</td>
                <td style="font-weight:bold; text-align:center; padding:1rem">{!! help_format_rupiah($total_pendapatan_bersih) !!}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
