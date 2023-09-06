@extends('Back.layout.master', ['title' => 'Data Kategori'])
@section('konten-admin')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <button type="button" class="btn btn-light btn-sm mt-2 mb-2" href="#" data-bs-toggle="modal"
                            data-bs-target="#modalTambahDataKategori"><i class="bi bi-plus"></i> Tambah
                            Kategori</button>

                        <div class="modal fade text-left" id="modalTambahDataKategori" data-bs-backdrop="static"
                            data-bs-keyboard="false" aria-labelledby="myModalLabel33" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel33">Tambah Kategori</h4>
                                        <button type="button" class="close batal" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <i data-feather="x"></i>
                                        </button>
                                    </div>
                                    <form action="{{ route('admin.TambahDataKategori') }}" id="formTambahDataKategori"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <label class="col col-form-label" for="kategori">Nama Kategori</label>
                                                <div class="col-md-9">
                                                    <input type="text" name="nama_kategori" class="form-control"
                                                        id="exampleInputPassword1" placeholder="Tipe">
                                                </div>
                                                <div class="input-group has-validation">
                                                    <label class="text-danger error-text nama_kategori_error"></label>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col col-form-label" for="plat">Gambar</label>
                                                <div class="col-md-9">
                                                    <input type="file" name="path" class="form-control"
                                                        id="exampleInputPassword1">
                                                </div>
                                                <div class="input-group has-validation">
                                                    <label class="text-danger error-text path_error"></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light-secondary batal"
                                                data-bs-dismiss="modal">
                                                Batal
                                            </button>
                                            <button type="submit" class="btn btn-primary ml-1">
                                                Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <table class="table table-striped" id="table-data-kategori">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kategori</th>
                                    <th>Gambar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <div class="modal fade text-left" id="modalEditDataKategori" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Ubah Kendaraan</h4>
                    <button type="button" class="close batal" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form id="formEditDataKategori" action="{{ route('admin.EditDataKategori') }}" method="POST"
                    enctype="multipart/form-data">
                    <input type="hidden" name="id" hidden>
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label class="col col-form-label" for="kategori">Nama Kategori</label>
                            <div class="col-md-9">
                                <input type="text" name="nama_kategori" class="form-control" id="exampleInputPassword1"
                                    placeholder="Tipe">
                            </div>
                            <div class="input-group has-validation">
                                <label class="text-danger error-text nama_kategori_error"></label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col col-form-label" for="plat">Gambar</label>
                            <div class="col-md-9">
                                <input type="file" name="path" class="form-control" id="exampleInputPassword1">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary batal" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary ml-1">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        let daftar_data_kategori = [];
        const table_data_kategori = $('#table-data-kategori').DataTable({
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
                url: "{{ route('admin.DataKategori') }}",
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
                        daftar_data_kategori[row.id] = row;
                        return meta.row + 1;
                    }
                },
                {
                    "targets": 1,
                    "class": "text-wrap text-center",
                    "render": function(data, type, row, meta) {
                        daftar_data_kategori[row.id] = row;
                        return row.nama_kategori;
                    }
                },
                {
                    "targets": 2,
                    "class": "text-wrap text-center",
                    "render": function(data, type, row, meta) {
                        daftar_data_kategori[row.id] = row;
                        return `<img src="/storage/${row.path}" width="100">`
                    }
                },
                {
                    "targets": 3,
                    "class": "text-nowrap text-center",
                    "render": function(data, type, row, meta) {
                        let tampilan;
                        tampilan = `
                                <div class="ms-auto">
                                    <button type="button" class="btn btn-warning btn-sm edit_kategori" id-kategori = "${row.id}" href="#!">Edit</button>
                                    <button type="button" class="btn btn-danger btn-sm hapus_kategori" id-kategori = "${row.id}" href="#!">Hapus</button>
                                </div>
                                `
                        // <a class="btn btn-link text-dark text-gradient px-3 mb-0 edit_kategori" id-kategori = "${row.id}" href="#!" ><i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Ubah</a>
                        return tampilan;
                    }
                },
            ]
        });

        $('#formTambahDataKategori').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: new FormData(this),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {
                    $(document).find('label.error-text').text('');
                },
                success: function(data) {
                    if (data.status == 0) {
                        $.each(data.error, function(prefix, val) {
                            $('label.' + prefix + '_error').text(val[0]);
                            // $('span.'+prefix+'_error').text(val[0]);
                        });
                    } else if (data.status == 1) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal
                                    .stopTimer)
                                toast.addEventListener('mouseleave', Swal
                                    .resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'success',
                            title: data.msg
                        })
                        table_data_kategori.ajax.reload(null, false)

                        $("#formTambahDataKategori")[0].reset();
                        $("#modalTambahDataKategori").modal('hide')
                    }
                }
            });
        });

        $(document).on('click', '.edit_kategori', function(event) {
            const id = $(event.currentTarget).attr('id-kategori');
            const data_kategori = daftar_data_kategori[id]
            $("#modalEditDataKategori").modal('show');
            $("#formEditDataKategori [name='id']").val(id)
            $("#formEditDataKategori [name='nama_kategori']").val(data_kategori.nama_kategori);
            // $("#formEditDataKategori [name='path']").val(data_kategori.path);

            $('#formEditDataKategori').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: new FormData(this),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $(document).find('label.error-text').text('');
                    },
                    success: function(data) {
                        if (data.status == 0) {
                            $.each(data.error, function(prefix, val) {
                                $('label.' + prefix + '_error').text(val[0]);
                                // $('span.'+prefix+'_error').text(val[0]);
                            });
                        } else if (data.status == 1) {
                            $("#modalEditDataKategori").modal('hide');
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal
                                        .stopTimer)
                                    toast.addEventListener('mouseleave', Swal
                                        .resumeTimer)
                                }
                            })

                            Toast.fire({
                                icon: 'success',
                                title: data.msg
                            })
                            table_data_kategori.ajax.reload(null, false);
                        }
                    }
                });
            });
        });
        // $('.batal').on('click', function() {
        //     $(document).find('label.error-text').text('');
        //     $("#role").empty().append('');
        // })


        $(document).on('click', '.hapus_kategori', function(event) {
            const id = $(event.currentTarget).attr('id-kategori');

            Swal.fire({
                title: 'Yakin ingin mengahpus data ini?',
                icon: 'warning',
                showDenyButton: true,
            }).then((willDelete) => {

                if (willDelete) {
                    $.ajax({
                        url: "/admin/hapus-data-kategori/" + id,
                        dataType: 'json',
                        success: function(data) {
                            if (data.status == 0) {
                                alert("Gagal Hapus")
                            } else if (data.status == 1) {
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener('mouseenter', Swal
                                            .stopTimer)
                                        toast.addEventListener('mouseleave', Swal
                                            .resumeTimer)
                                    }
                                })

                                Toast.fire({
                                        icon: 'success',
                                        title: data.msg
                                    }),
                                    table_data_kategori.ajax.reload()
                            }
                        }
                    });
                } else {
                    //alert ('no');
                    return false;
                }
            });
        });
    </script>
@endsection
