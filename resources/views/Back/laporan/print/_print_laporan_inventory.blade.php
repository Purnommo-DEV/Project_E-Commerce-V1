<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Inventory</title>
</head>

<body>
    <header style="font-weight:bold; text-align:center; padding:1rem">
        LAPORAN INVENTORY<br>
    </header>
    <table border="1" width="100%">
        <thead>
            <tr>
                <td style="font-weight:bold; text-align:center; padding:1rem">Produk</td>
                <td style="font-weight:bold; text-align:center; padding:1rem">Variasi</td>
                <td style="font-weight:bold; text-align:center; padding:1rem">Stok</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $data_inventory)
                <tr>
                    <td style="text-align:center; padding:0.5rem">{{ $data_inventory->relasi_produk->nama_produk }}
                    </td>
                    <td style="text-align:center; padding:0.5rem">
                        @if ($data_inventory->relasi_produk->produk_tipe_id == 2)
                            {{ $data_inventory->produk_variasi }}
                        @elseif($data_inventory->relasi_produk->produk_tipe_id == 1)
                            -
                        @endif
                    </td>
                    <td style="text-align:center; padding:0.5rem">{{ $data_inventory->stok }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
