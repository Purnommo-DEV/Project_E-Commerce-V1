@extends('Back.layout.master', ['title' => 'Laporan Pembayaran'])
@section('konten-admin')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        <form action="{{ route('admin.CetakLaporanPembayaran') }}" method="POST">
                            <section id="basic-input-groups">
                                <div class="row">
                                    @csrf
                                    <div class="col-lg-4 mb-1">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="bi bi-calendar"></i>
                                            </span>
                                            <input type="text" id="tgl_awal" name="tgl_awal" class="form-control"
                                                placeholder="Dari Tanggal" aria-label="Username"
                                                aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mb-1">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="bi bi-calendar"></i>
                                            </span>
                                            <input type="text" id="tgl_akhir" name="tgl_akhir" class="form-control"
                                                placeholder="Ke Tanggal" aria-label="Username"
                                                aria-describedby="basic-addon1">
                                        </div>
                                    </div>

                                    <div class="col-lg-1 mb-1">
                                        <div class="input-group mb-3">
                                            <div class="btn-group mb-3 btn-group" role="group" aria-label="Basic example">
                                                <button type="button" id="filter"
                                                    class="btn btn-primary">Filter</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 mb-1">
                                        <div class="input-group mb-3">
                                            <select class="form-control" name="jenis_ekspor">
                                                <option value="" selected disabled>Ekspor ke -</option>
                                                <option value="excel">Excel</option>
                                                <option value="pdf">PDF</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-1 mb-1">
                                        <div class="input-group mb-3">
                                            <div class="btn-group mb-3 btn-group" role="group" aria-label="Basic example">
                                                <button type="submit" class="btn btn-outline-primary"><i
                                                        class="bi bi-printer" style="font-size: 15px;"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </form>
                        <table class="table table-striped" id="table-data-pembayaran">
                            <thead>
                                <tr>
                                    <th>Kode Pesanan</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Jumlah</th>
                                    <th>Metode Pembayaran</th>
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
        $(function() {
            $("#tgl_awal").datepicker({
                "dateFormat": "dd-mm-yy"
            });
        });
        $(function() {
            $("#tgl_akhir").datepicker({
                "dateFormat": "dd-mm-yy"
            });
        });

        var tgl_awal = $("#tgl_awal").val();
        var tgl_akhir = $("#tgl_akhir").val();

        let daftar_data_pembayaran = [];
        const table_data_pembayaran = $('#table-data-pembayaran')
            .DataTable({
                "destroy": true,
                "pageLength": 10,
                "lengthMenu": false,
                "bLengthChange": false,
                "bFilter": false,
                "bInfo": true,
                "processing": false,
                "bServerSide": true,
                "responsive": false,
                "sScrollX": '100%',
                "sScrollXInner": "100%",
                ajax: {
                    url: "{{ route('admin.DataLaporanPembayaran') }}",
                    error: function(xhr, textStatus, errorThrown) {
                        alert("Periksa Kembali Tanggal yang anda Inputkan");
                    },
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function(d) {
                        d.req_tgl_awal = tgl_awal;
                        d.req_tgl_akhir = tgl_akhir;
                        return d
                    }
                },
                columnDefs: [{
                        targets: '_all',
                        visible: true
                    },
                    {
                        "targets": 0,
                        "class": "text-wrap text-center",
                        "render": function(data, type, row, meta) {
                            daftar_data_pembayaran[row.id] = row;
                            return row.kode_pesanan;
                        }
                    },
                    {
                        "targets": 1,
                        "class": "text-wrap text-center",
                        "render": function(data, type, row, meta) {
                            daftar_data_pembayaran[row.id] = row;
                            return moment(row.orders_date).format('DD-MMMM-YYYY');
                        }
                    },
                    {
                        "targets": 2,
                        "class": "text-nowrap text-center",
                        "render": function(data, type, row, meta) {
                            daftar_data_pembayaran[row.id] = row;
                            let total_pendapatan_kotor = row.alias_total_pendapatan_kotor;
                            return row.relasi_pesanan_status.relasi_status_master.status_pesanan
                        }
                    },
                    {
                        "targets": 3,
                        "class": "text-nowrap text-center",
                        "render": function(data, type, row, meta) {
                            daftar_data_pembayaran[row.id] = row;
                            return $.fn.dataTable.render.number('.', ',', 2, 'Rp ').display(
                                row.total_pembayaran);
                        }
                    },
                    {
                        "targets": 4,
                        "class": "text-nowrap text-center",
                        "render": function(data, type, row, meta) {
                            daftar_data_pembayaran[row.id] = row;
                            let total_pendapatan_bersih = row.alias_total_pendapatan_kotor - row
                                .alias_total_ongkir;
                            return `${row.metode_pembayaran}`
                        }
                    },
                ]
            });

        $(document).on("click", "#filter", function(e) {
            e.preventDefault();
            tgl_awal = $("#tgl_awal").val();
            tgl_akhir = $("#tgl_akhir").val();
            table_data_pembayaran.ajax.reload();
        })

        // $(document).on("click", "#reset-filter", function(e) {
        //     e.preventDefault();
        //     tgl_awal = $("#tgl_awal").val();
        //     tgl_akhir = $("#tgl_akhir").val();
        //     table_data_pembayaran.ajax.reload();
        // })
    </script>
@endsection
