<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Pendapatan</title>
</head>

<body>
    <header style="font-weight:bold; text-align:center; padding:1rem">
        LAPORAN PENDAPATAN<br>
        Periode : {{ $periode }}
    </header>
    <table border="1" width="100%">
        <thead>
            <tr>
                <td style="font-weight:bold; text-align:center; padding:1rem">Tanggal</td>
                <td style="font-weight:bold; text-align:center; padding:1rem">Pesanan</td>
                <td style="font-weight:bold; text-align:center; padding:1rem">Pendapatan Kotor</td>
                <td style="font-weight:bold; text-align:center; padding:1rem">Pengiriman</td>
                <td style="font-weight:bold; text-align:center; padding:1rem">Pendapatan Bersih</td>
            </tr>
        </thead>
        <tbody>@php
            $total_pesanan = 0;
            $total_pendapatan_kotor = 0;
            $total_pendapatan_bersih = 0;
            $total_ongkir = 0;
        @endphp
            @foreach ($data as $data_pesanan)
                @php
                    $total_pendapatan_bersih += $data_pesanan->alias_total_pendapatan_kotor - $data_pesanan->alias_total_ongkir;
                    $total_pesanan += $data_pesanan->alias_total_pesanan;
                    $total_pendapatan_kotor += $data_pesanan->alias_total_pendapatan_kotor;
                    $total_ongkir += $data_pesanan->alias_total_ongkir;
                @endphp
                <tr>
                    <td style="text-align:center; padding:0.5rem">{{ $data_pesanan->tanggal }}</td>
                    <td style="text-align:center; padding:0.5rem">{{ $data_pesanan->alias_total_pesanan }}</td>
                    <td style="text-align:center; padding:0.5rem">{!! help_format_rupiah($data_pesanan->alias_total_pendapatan_kotor) !!}</td>
                    <td style="text-align:center; padding:0.5rem">{!! help_format_rupiah($data_pesanan->alias_total_ongkir) !!}</td>
                    <td style="text-align:center; padding:0.5rem">{!! help_format_rupiah($data_pesanan->alias_total_pendapatan_kotor - $data_pesanan->alias_total_ongkir) !!}</td>
                </tr>
            @endforeach
            <tr>
                <td style="font-weight:bold; text-align:center; padding:1rem">Total</td>
                <td style="font-weight:bold; text-align:center; padding:1rem">{{ $total_pesanan }}</td>
                <td style="font-weight:bold; text-align:center; padding:1rem">{!! help_format_rupiah($total_pendapatan_kotor) !!}</td>
                <td style="font-weight:bold; text-align:center; padding:1rem">{!! help_format_rupiah($total_ongkir) !!}</td>
                <td style="font-weight:bold; text-align:center; padding:1rem">{!! help_format_rupiah($total_pendapatan_bersih) !!}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
