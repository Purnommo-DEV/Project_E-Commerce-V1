@extends('Back.layout.master', ['title' => 'Data Detail Pengguna'])
@section('konten-admin')
    <section class="section">
        <div class="row">
            <div class="col-12 col-lg-4 d-flex">
                <div class="card w-100">
                    <div class="card-body">
                        <div class="customer-profile text-center">
                            <img src="assets/images/avatars/01.png" width="120" height="120" class="rounded-circle"
                                alt="">
                            <div class="mt-4">
                                <h5 class="mb-1 customer-name fw-bold">{{ $pengguna->name }}</h5>
                                <p class="mb-0 customer-designation">Pelanggan</p>
                            </div>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            @foreach ($alamat_pengguna as $no => $data_alamat_pengguna)
                                <b>Alamat {{ $no + 1 }}</b> <br>
                                {{ $data_alamat_pengguna->alamat }}, {{ $data_alamat_pengguna->relasi_provinsi->name }},
                                {{ $data_alamat_pengguna->relasi_kota->name }} @if ($data_alamat_pengguna->alamat_utama == 1)
                                    (Alamat Utama)
                                @endif
                                <br>
                            @endforeach
                        </li>
                        <li class="list-group-item">
                            <b>Email</b>
                            <br>
                            {{ $pengguna->email }}
                        </li>
                        <li class="list-group-item">
                            @foreach ($alamat_pengguna as $no => $data_alamat_pengguna)
                                <b>Nomor HP {{ $no + 1 }}</b> <br>
                                {{ $data_alamat_pengguna->nomor_hp }}
                                <br>
                            @endforeach
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-12 col-lg-8 d-flex">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-3 fw-bold">Pesanan<span class="fw-light ms-2">( {{ $jumlah_pesanan }} )</span></h5>
                        <div class="product-table">
                            <div class="table-responsive white-space-nowrap">
                                <table class="table align-middle" id="table-data-pesanan">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Kode</th>
                                            <th>Tanggal</th>
                                            <th>Status Pesanan</th>
                                            <th>Metode Pembayaran</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--end row-->

        <div class="card mt-4">
            <div class="card-body">
                <h5 class="mb-3 fw-bold">Penilaian & Ulasan<span class="fw-light ms-2">( {{ $jumlah_penilaian }} )</span>
                </h5>
                <div class="product-table">
                    <div class="table-responsive white-space-nowrap">
                        <table class="table align-middle" id="table-data-penilaian-pesanan">
                            <thead class="table-light">
                                <tr>
                                    <th>Produk</th>
                                    <th>Penilaian</th>
                                    <th>Ulasan</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        var pengguna_kode = @json($pengguna);
        let daftar_data_pesanan = [];
        const table_data_pesanan = $('#table-data-pesanan').DataTable({
            "destroy": true,
            "pageLength": 5,
            "lengthMenu": false,
            "bLengthChange": false,
            "bFilter": false,
            "bInfo": true,
            "processing": true,
            "bServerSide": true,
            "responsive": false,
            "sScrollX": '100%',
            "sScrollXInner": "100%",
            ajax: {
                url: "/admin/data-pesanan-pengguna/" + pengguna_kode.kode,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                // data: function(d) {
                //     d.role_pengguna = data_role_pengguna;
                //     d.jurusan_pengguna = data_filter_jurusan;
                //     return d
                // }
            },
            columnDefs: [{
                    targets: '_all',
                    visible: true
                },
                {
                    "targets": 0,
                    "class": "text-nowrap text-center",
                    "render": function(data, type, row, meta) {
                        let i = 1;
                        daftar_data_pesanan[row.id] = row;
                        return row.kode_pesanan;
                    }
                },
                {
                    "targets": 1,
                    "class": "text-wrap text-center",
                    "render": function(data, type, row, meta) {
                        daftar_data_pesanan[row.id] = row;
                        return row.orders_date;
                    }
                },
                {
                    "targets": 2,
                    "class": "text-wrap text-center",
                    "render": function(data, type, row, meta) {
                        daftar_data_pesanan[row.id] = row;
                        return row.relasi_pesanan_status.relasi_status_master.status_pesanan;
                    }
                },
                {
                    "targets": 3,
                    "class": "text-wrap text-center",
                    "render": function(data, type, row, meta) {
                        daftar_data_pesanan[row.id] = row;
                        return row.metode_pembayaran;
                    }
                },
            ]
        });

        let daftar_data_penilaian_pesanan = [];
        const table_data_penilaian_pesanan = $('#table-data-penilaian-pesanan').DataTable({
            "destroy": true,
            "pageLength": 5,
            "lengthMenu": false,
            "bLengthChange": false,
            "bFilter": false,
            "bInfo": true,
            "processing": true,
            "bServerSide": true,
            "responsive": false,
            "sScrollX": '100%',
            "sScrollXInner": "100%",
            ajax: {
                url: "/admin/data-penilaian-pesanan-pengguna/" + pengguna_kode.kode,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                // data: function(d) {
                //     d.role_pengguna = data_role_pengguna;
                //     d.jurusan_pengguna = data_filter_jurusan;
                //     return d
                // }
            },
            columnDefs: [{
                    targets: '_all',
                    visible: true
                },
                {
                    "targets": 0,
                    "class": "text-wrap text-center",
                    "render": function(data, type, row, meta) {
                        let i = 1;
                        daftar_data_penilaian_pesanan[row.id] = row;
                        if (row.relasi_pesanan_detail.relasi_produk_detail.relasi_produk.produk_tipe_id ==
                            1) {
                            return `${row.relasi_pesanan_detail.relasi_produk_detail.relasi_produk.nama_produk}<br> Variasi: ${row.relasi_pesanan_detail.relasi_produk_detail.produk_variasi}`;
                        } else if (row.relasi_pesanan_detail.relasi_produk_detail.relasi_produk
                            .produk_tipe_id == 2) {
                            return row.relasi_pesanan_detail.relasi_produk_detail.relasi_produk
                                .nama_produk;
                        }

                    }
                },
                {
                    "targets": 1,
                    "class": "text-wrap text-center",
                    "render": function(data, type, row, meta) {
                        daftar_data_penilaian_pesanan[row.id] = row;
                        return row.rating;
                    }
                },
                {
                    "targets": 2,
                    "class": "text-wrap text-center",
                    "render": function(data, type, row, meta) {
                        daftar_data_penilaian_pesanan[row.id] = row;
                        return row.komentar;
                    }
                },
                {
                    "targets": 3,
                    "class": "text-wrap text-center",
                    "render": function(data, type, row, meta) {
                        daftar_data_penilaian_pesanan[row.id] = row;
                        return moment(row.created_at).format('DD-MMMM-YYYY');
                    }
                },
            ]
        });
    </script>
@endsection
