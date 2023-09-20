@extends('Back.layout.master', ['title' => 'Data Pesanan'])
@section('konten-admin')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped" id="table-data-pesanan">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Customer</th>
                                    <th>Kode Pesanan</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
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
        let daftar_data_pesanan = [];
        const table_data_pesanan = $('#table-data-pesanan').DataTable({
            "destroy": true,
            "pageLength": 10,
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
                url: "{{ route('admin.DataPesanan') }}",
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
                        return meta.row + 1;
                    }
                },
                {
                    "targets": 1,
                    "class": "text-wrap text-center",
                    "render": function(data, type, row, meta) {
                        daftar_data_pesanan[row.id] = row;
                        return row.relasi_user.name;
                    }
                },
                {
                    "targets": 2,
                    "class": "text-wrap text-center",
                    "render": function(data, type, row, meta) {
                        daftar_data_pesanan[row.id] = row;
                        return row.kode_pesanan;
                    }
                },
                {
                    "targets": 3,
                    "class": "text-wrap text-center",
                    "render": function(data, type, row, meta) {
                        daftar_data_pesanan[row.id] = row;
                        return moment(row.orders_date).format('dddd, DD-MMMM-YYYY, HH:mm:ss');
                    }
                },
                {
                    "targets": 4,
                    "class": "text-wrap text-center",
                    "render": function(data, type, row, meta) {
                        daftar_data_pesanan[row.id] = row;
                        return row.relasi_pesanan_status.relasi_status_master.status_pesanan;
                    }
                },
                {
                    "targets": 5,
                    "class": "text-nowrap text-center",
                    "render": function(data, type, row, meta) {
                        let tampilan;
                        tampilan = `
                                <div class="ms-auto">
                                    <a class="btn btn-success btn-sm" href="/admin/detail-pesanan/${row.id}">Detail</a>
                                </div>
                                `
                        // <a class="btn btn-link text-dark text-gradient px-3 mb-0 edit_kategori" id-produk = "${row.id}" href="#!" ><i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Ubah</a>
                        return tampilan;
                    }
                },
            ]
        });
    </script>
@endsection
