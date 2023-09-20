<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Pembayaran</title>
</head>

<body>
    <header style="font-weight:bold; text-align:center; padding:1rem">
        LAPORAN PEMBAYARAN<br>
        Periode : {{ $periode }}
    </header>
    <table border="1" width="100%">
        <thead>
            <tr>
                <td style="font-weight:bold; text-align:center; padding:1rem">Kode Pesanan</td>
                <td style="font-weight:bold; text-align:center; padding:1rem">Tanggal</td>
                <td style="font-weight:bold; text-align:center; padding:1rem">Status</td>
                <td style="font-weight:bold; text-align:center; padding:1rem">Jumlah</td>
                <td style="font-weight:bold; text-align:center; padding:1rem">Metode Pembayaran</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $data_pesanan_pembayaran)
                <tr>
                    <td style="text-align:center; padding:0.5rem">{{ $data_pesanan_pembayaran->kode_pesanan }}</td>
                    <td style="text-align:center; padding:0.5rem">{!! help_tanggal_jam($data_pesanan_pembayaran->orders_date) !!}</td>
                    <td style="text-align:center; padding:0.5rem">
                        {{ $data_pesanan_pembayaran->relasi_pesanan_status->relasi_status_master->status_pesanan }}</td>
                    <td style="text-align:center; padding:0.5rem">{!! help_format_rupiah($data_pesanan_pembayaran->total_pembayaran) !!}</td>
                    <td style="text-align:center; padding:0.5rem">
                        {{ $data_pesanan_pembayaran->metode_pembayaran }} (Transfer bank)
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
