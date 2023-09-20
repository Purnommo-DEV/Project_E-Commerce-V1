@extends('Back.layout.master', ['title' => 'Laporan Inventory'])
@section('konten-admin')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.CetakLaporanInventory') }}" method="POST">
                            <section id="basic-input-groups">
                                <div class="row">
                                    @csrf
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
                        <table class="table table-striped" id="table-data-inventory">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Variasi</th>
                                    <th>Stok</th>
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
        let daftar_data_inventory = [];
        const table_data_inventory = $('#table-data-inventory')
            .DataTable({
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
                    url: "{{ route('admin.DataLaporanInventory') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
                            daftar_data_inventory[row.id] = row;
                            return row.relasi_produk.nama_produk;
                        }
                    },
                    {
                        "targets": 1,
                        "class": "text-wrap text-center",
                        "render": function(data, type, row, meta) {
                            daftar_data_inventory[row.id] = row;
                            if (row.relasi_produk.produk_tipe_id == 2) {
                                return row.produk_variasi;
                            } else {
                                return '-'
                            }
                        }
                    },
                    {
                        "targets": 2,
                        "class": "text-nowrap text-center",
                        "render": function(data, type, row, meta) {
                            daftar_data_inventory[row.id] = row;
                            return row.stok;
                        }
                    },

                ]
            });
    </script>
@endsection
