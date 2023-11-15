@extends('Back.layout.master', ['title' => 'Data Slider'])
@section('konten-admin')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <button type="button" class="btn btn-light btn-sm mt-2 mb-2" href="#" data-bs-toggle="modal"
                            data-bs-target="#modalTambahDataSlider"><i class="bi bi-plus"></i> Tambah Slider</button>

                        <div class="modal fade text-left" id="modalTambahDataSlider" data-bs-backdrop="static"
                            data-bs-keyboard="false" aria-labelledby="myModalLabel33" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel33">Tambah Slider</h4>
                                        <button type="button" class="close batal" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <i data-feather="x"></i>
                                        </button>
                                    </div>
                                    <form action="{{ route('admin.TambahDataSlider') }}" id="formTambahDataSlider"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <label class="col col-form-label" for="judul">Judul</label>
                                                <div class="col-md-9">
                                                    <textarea type="text" name="judul" class="ckeditor form-control" id="exampleInputPassword1" placeholder="Judul"></textarea>
                                                </div>
                                                <div class="input-group has-validation">
                                                    <label class="text-danger error-text judul_error"></label>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col col-form-label" for="plat">Gambar</label>
                                                <div class="col-md-9">
                                                    <input type="file" accept="image/*" name="gambar"
                                                        class="form-control" id="exampleInputPassword1">
                                                </div>
                                                <div class="input-group has-validation">
                                                    <label class="text-danger error-text gambar_error"></label>
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
                        <table class="table table-striped" id="table-data-slider">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Judul</th>
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
    {{-- <div class="modal fade text-left" id="modalEditDataSlider" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Ubah Kendaraan</h4>
                    <button type="button" class="close batal" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form id="formEditDataSlider" name="formEditDataSlider" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="slider-id" hidden>
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label class="col col-form-label" for="judul">Judul</label>
                            <div class="col-md-9">
                                <textarea type="text" name="judul" id="judul-id" class="ckeditor form-control" placeholder="Judul"></textarea>
                            </div>
                            <div class="input-group has-validation">
                                <label class="text-danger error-text judul_error"></label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col col-form-label" for="plat">Gambar</label>
                            <div class="col-md-9">
                                <input type="file" accept="image/*" name="gambar" class="form-control"
                                    id="exampleInputPassword1">
                            </div>
                            <div class="input-group has-validation">
                                <label class="text-danger error-text gambar_error"></label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary batal" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary ml-1" id="ubah-data">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}

    <div class="modal fade text-left" id="modalEditDataSlider" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Ubah Kendaraan</h4>
                    <button type="button" class="close batal" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form id="formEditDataSlider" action="{{ route('admin.EditDataSlider') }}" method="POST"
                    enctype="multipart/form-data">
                    <input type="hidden" name="id" hidden>
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label class="col col-form-label" for="judul">Judul</label>
                            <div class="col-md-9">
                                <textarea type="text" name="judul" class="ckeditor form-control" id="judulEdit" placeholder="Judul"></textarea>
                            </div>
                            <div class="input-group has-validation">
                                <label class="text-danger error-text judul_error"></label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col col-form-label" for="plat">Gambar</label>
                            <div class="col-md-9">
                                <input type="file" accept="image/*" name="gambar" class="form-control"
                                    id="exampleInputPassword1">
                            </div>
                            <div class="input-group has-validation">
                                <label class="text-danger error-text gambar_error"></label>
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
        let daftar_data_slider = [];
        const table_data_slider = $('#table-data-slider').DataTable({
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
                url: "{{ route('admin.DataSlider') }}",
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
                        daftar_data_slider[row.id] = row;
                        return meta.row + 1;
                    }
                },
                {
                    "targets": 1,
                    "class": "text-wrap text-center",
                    "render": function(data, type, row, meta) {
                        daftar_data_slider[row.id] = row;
                        return row.judul;
                    }
                },
                {
                    "targets": 2,
                    "class": "text-wrap text-center",
                    "render": function(data, type, row, meta) {
                        daftar_data_slider[row.id] = row;
                        return `<img src="/storage/${row.gambar}" width="100">`
                    }
                },
                {
                    "targets": 3,
                    "class": "text-nowrap text-center",
                    "render": function(data, type, row, meta) {
                        let tampilan;
                        tampilan = `
                                <div class="ms-auto">
                                    <button type="button" class="btn btn-warning btn-sm edit_slider" id-slider = "${row.id}" href="#!">Edit</button>
                                    <button type="button" class="btn btn-danger btn-sm hapus_slider" id-slider = "${row.id}" href="#!">Hapus</button>
                                </div>
                                `
                        // <a class="btn btn-link text-dark text-gradient px-3 mb-0 edit_slider" id-slider = "${row.id}" href="#!" ><i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Ubah</a>
                        return tampilan;
                    }
                },
            ]
        });

        $('#formTambahDataSlider').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: new FormData(this),
                processData: false,
                dataType: 'json',
                contentType: false,
                cache: false,
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
                    }
                    table_data_slider.draw();
                    $("#formTambahDataSlider").trigger('reset');
                    $("#modalTambahDataSlider").modal('hide')
                },
            });
        });

        // CKEDITOR.replace('judulEdit');
        //     var editorData= CKEDITOR.instances['judulEdit'].getData();

        // $('body').on('click', '.edit_slider', function() {
        //     const id = $(this).attr('id-slider');
        //     const data_slider = daftar_data_slider[id];
        //     alert(id);

        //     $("#modalEditDataSlider").modal('show')
        //     var editorData = CKEDITOR.instances['judul-id'].setData(data_slider.judul);
        //     CKEDITOR.replace('judul-id');
        //     // $('#saveBtn').val("edit-user");
        //     // $("#formEditDataSlider [name='id']").val(id)
        //     $('#ubah-data').val("edit-slider")
        //     $('#slider-id').val(id);
        //     $('#judul-id').text(data_slider.judul);
        // });

        // $('#ubah-data').click(function(e) {
        //     e.preventDefault();
        //     var id_slider = $('#slider-id').val();
        //     var judul = $('#judul-id').text();
        //     $.ajax({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         data: {
        //             'id': id_slider,
        //             'judul': judul
        //         },
        //         url: "{{ route('admin.EditDataSlider') }}",
        //         type: "POST",
        //         // processData: false,
        //         dataType: 'json',
        //         // contentType: false,
        //         // beforeSend: function() {
        //         //     $(document).find('label.error-text').text('');
        //         // },
        //         success: function(data) {
        //             if (data.status == 0) {
        //                 $.each(data.error, function(prefix, val) {
        //                     $('label.' + prefix + '_error').text(val[0]);
        //                     // $('span.'+prefix+'_error').text(val[0]);
        //                 });
        //             } else if (data.status == 1) {
        //                 const Toast = Swal.mixin({
        //                     toast: true,
        //                     position: 'top-end',
        //                     showConfirmButton: false,
        //                     timer: 3000,
        //                     timerProgressBar: true,
        //                     didOpen: (toast) => {
        //                         toast.addEventListener('mouseenter', Swal
        //                             .stopTimer)
        //                         toast.addEventListener('mouseleave', Swal
        //                             .resumeTimer)
        //                     }
        //                 })

        //                 Toast.fire({
        //                     icon: 'success',
        //                     title: data.msg
        //                 })
        //                 $('#formEditDataSlider').trigger("reset");
        //                 $("#modalEditDataSlider").modal('hide');
        //                 table_data_slider.draw();
        //             }
        //         },
        //         error: function(data) {
        //             console.log('Error:', data);
        //         }
        //     });
        // });
        // $('.batal').on('click', function() {
        //     $(document).find('label.error-text').text('');
        //     $("#role").empty().append('');
        // })

        $(document).on('click', '.edit_slider', function(event) {
            const id = $(event.currentTarget).attr('id-slider');
            const data_slider = daftar_data_slider[id];
            var editorData = CKEDITOR.instances['judulEdit'].setData(data_slider.judul);
            $("#modalEditDataSlider").modal('show')
            $("#formEditDataSlider [name='id']").val(id)
            $("#formEditDataSlider [name='judul']").text(data_slider.judul);
            // $("#formEditDataSlider [name='gambar']").val(data_slider.gambar);
            CKEDITOR.replace('judulEdit');
            $('#formEditDataSlider').on('submit', function(e) {
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
                            $("#modalEditDataSlider").modal('hide');
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
                            table_data_slider.ajax.reload(null, false);
                        }
                    }
                });
            });
        });


        $(document).on('click', '.hapus_slider', function(event) {
            const id = $(event.currentTarget).attr('id-slider');

            Swal.fire({
                title: 'Yakin ingin mengahpus data ini?',
                icon: 'warning',
                showDenyButton: true,
            }).then((willDelete) => {

                if (willDelete) {
                    $.ajax({
                        url: "/admin/hapus-data-slider/" + id,
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
                                    table_data_slider.ajax.reload()
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
