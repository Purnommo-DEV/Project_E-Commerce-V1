@extends('Back.layout.master', ['title' => 'Data Produk'])
@section('konten-admin')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <button type="button" class="btn btn-light btn-sm mt-2 mb-2" href="#" data-bs-toggle="modal"
                            data-bs-target="#modalTambahDataProduk"><i class="bi bi-plus"></i> Tambah Produk</button>

                        <div class="modal fade text-left" id="modalTambahDataProduk" data-bs-backdrop="static"
                            data-bs-keyboard="false" aria-labelledby="myModalLabel33" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Tambah Data Produk</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.TambahDataProduk') }}" id="formTambahDataProduk"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row align-items-end">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="nama-produk" class="col-form-label">Nama Produk</label>
                                                        <input type="text" class="form-control" id="nama_produk"
                                                            name="nama_produk">
                                                        <div class="input-group has-validation">
                                                            <label class="text-danger error-text nama_produk_error"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="message-text" class="col-form-label">Kategori</label>
                                                        <select class="form-control" name="kategori_id">
                                                            <option value="" selected disabled>-- Pilih Kategori --
                                                            </option>
                                                            @foreach ($kategori as $data_produk)
                                                                <option value="{{ $data_produk->id }}">
                                                                    {{ $data_produk->nama_kategori }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="input-group has-validation">
                                                            <label class="text-danger error-text kategori_id_error"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="message-text" class="col-form-label">Tipe Produk</label>
                                                        <select class="form-control" name="produk_tipe_id" id="pilih-tipe">
                                                            <option value="" selected disabled>-- Pilih Tipe --
                                                            </option>
                                                            @foreach ($tipe as $data_tipe)
                                                                <option value="{{ $data_tipe->id }}">
                                                                    {{ $data_tipe->produk_tipe }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="input-group has-validation">
                                                            <label
                                                                class="text-danger error-text produk_tipe_id_error"></label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Produk Variant -->
                                                <div id="produk-variasi-id">
                                                    <div class="row align-items-end">
                                                        <div class="col-md-4">
                                                            <div class="mb-3">
                                                                <label for="nama-produk"
                                                                    class="col-form-label">Variasi</label>
                                                                <input type="text" class="form-control"
                                                                    id="produk_variasi[0]" name="produk_variasi[0]">
                                                                <div class="input-group has-validation">
                                                                    <label
                                                                        class="text-danger error-text produk_variasi_error"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="mb-3">
                                                                <label for="nama-produk"
                                                                    class="col-form-label">Harga</label>
                                                                <input type="text" class="form-control"
                                                                    id="harga_p_variasi[0]" name="harga_p_variasi[0]">
                                                                <div class="input-group has-validation">
                                                                    <label
                                                                        class="text-danger error-text harga_p_variasi_error"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="mb-3">
                                                                <label for="nama-produk"
                                                                    class="col-form-label">Berat</label>
                                                                <input type="text" class="form-control"
                                                                    id="berat_p_variasi[0]" name="berat_p_variasi[0]">
                                                                <div class="input-group has-validation">
                                                                    <label
                                                                        class="text-danger error-text berat_p_variasi_error"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="mb-3">
                                                                <label for="nama-produk" class="col-form-label">Stok</label>
                                                                <input type="text" class="form-control"
                                                                    id="stok_p_variasi[0]" name="stok_p_variasi[0]">
                                                                <div class="input-group has-validation">
                                                                    <label
                                                                        class="text-danger error-text stok_p_variasi_error"></label>
                                                                </div>
                                                            </div>
                                                        </div>



                                                        <div class="col-md-2">
                                                            <div class="mb-3">
                                                                <button class="btn btn-primary" type="button"
                                                                    onclick="tambahFormProdukVariasi()">+</button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div id="div-ProdukVariasi"></div>
                                                </div>

                                                <!-- Produk Biasa -->
                                                <div id="produk-simple-id">
                                                    <div class="row align-items-end">
                                                        <div class="col-md-4">
                                                            <div class="mb-3">
                                                                <label for="nama-produk"
                                                                    class="col-form-label">Harga</label>
                                                                <input type="text" class="form-control" id="harga"
                                                                    name="harga_produk_biasa">
                                                                <div class="input-group has-validation">
                                                                    <label
                                                                        class="text-danger error-text harga_error"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="mb-3">
                                                                <label for="nama-produk"
                                                                    class="col-form-label">Berat</label>
                                                                <input type="text" class="form-control" id="berat"
                                                                    name="berat_produk_biasa">
                                                                <div class="input-group has-validation">
                                                                    <label
                                                                        class="text-danger error-text berat_error"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="mb-3">
                                                                <label for="nama-produk"
                                                                    class="col-form-label">Stok</label>
                                                                <input type="text" class="form-control" id="stok"
                                                                    name="stok_produk_biasa">
                                                                <div class="input-group has-validation">
                                                                    <label
                                                                        class="text-danger error-text stok_error"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="recipient-name" class="col-form-label">Deskripsi
                                                            Singkat</label>
                                                        <textarea class="form-control" name="deskripsi_singkat"></textarea>
                                                        <div class="input-group has-validation">
                                                            <label
                                                                class="text-danger error-text deskripsi_singkat_error"></label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="recipient-name" class="col-form-label">Deskripsi
                                                            Lengkap</label>
                                                        <textarea class="form-control" name="deskripsi_lengkap"></textarea>
                                                        <div class="input-group has-validation">
                                                            <label
                                                                class="text-danger error-text deskripsi_lengkap_error"></label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="recipient-name" class="col-form-label">Gambar</label>
                                                        <input type="file" accept="image/*" name="path[]"
                                                            accept="image/*" class="form-control" multiple>
                                                        <div class="input-group has-validation">
                                                            <label class="text-danger error-text path_error"></label>
                                                        </div>
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
                        </div>
                        <table class="table table-striped" id="table-data-produk">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th>Tipe</th>
                                    <th>Deskripsi Singkat</th>
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
        $("#produk-variasi-id").hide();
        $("#produk-simple-id").hide();
        $(function() {
            $formVariasi = $("#produk-variasi-id");
            $formSimple = $("#produk-simple-id");
            $('#pilih-tipe').on('change', function() {
                if (this.value === '1') {
                    $formSimple.show();
                    $formVariasi.hide();
                } else if (this.value === '2') {
                    $formVariasi.show();
                    var harga_produk_variasi_0 = document.getElementById(`harga_p_variasi[0]`);
                    harga_produk_variasi_0.addEventListener('keyup', function(e) {
                        harga_produk_variasi_0.value = formatRupiah(this.value, 'Rp. ');
                    });
                    $formSimple.hide();
                }
            });
        });

        var newId = 1;
        var produk_variasi = jQuery.validator.format(`
            <div class="row align-items-end">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="nama-produk"
                            class="col-form-label">Variasi</label>
                        <input type="text" class="form-control"
                            id="produk_variasi[{0}]" name="produk_variasi[{0}]"
                        >
                        <div class="input-group has-validation">
                            <label
                                class="text-danger error-text produk_variasi_error"></label>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-3">
                        <label for="nama-produk"
                            class="col-form-label">Harga</label>
                        <input type="text" class="form-control" id="harga_p_variasi[{0}]"
                            name="harga_p_variasi[{0}]">
                        <div class="input-group has-validation">
                            <label
                                class="text-danger error-text harga_p_variasi_error"></label>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-3">
                        <label for="nama-produk"
                            class="col-form-label">Berat</label>
                        <input type="text" class="form-control" id="berat_p_variasi[{0}]"
                            name="berat_p_variasi[{0}]">
                        <div class="input-group has-validation">
                            <label
                                class="text-danger error-text berat_p_variasi_error"></label>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-3">
                        <label for="nama-produk" class="col-form-label">Stok</label>
                        <input type="text" class="form-control" id="stok_p_variasi[{0}]"
                            name="stok_p_variasi[{0}]">
                        <div class="input-group has-validation">
                            <label
                                class="text-danger error-text stok_p_variasi_error"></label>
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="mb-3">
                        <button class="btn btn-danger hapusFormProdukVariasi">-</button>
                    </div>
                </div>
            </div>
        `);

        function tambahFormProdukVariasi() {
            $('#div-ProdukVariasi').append(produk_variasi(newId));
            var harga_produk_variasi = document.getElementById(`harga_p_variasi[${newId}]`);
            harga_produk_variasi.addEventListener('keyup', function(e) {
                harga_produk_variasi.value = formatRupiah(this.value, 'Rp. ');
            });
            newId++;
        }

        $('#div-ProdukVariasi').on('click', '.hapusFormProdukVariasi', function(e) {
            e.preventDefault();
            newId--;
            $(this).parent().parent().parent().remove();
        });

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }


        let daftar_data_produk = [];
        const table_data_produk = $('#table-data-produk').DataTable({
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
                url: "{{ route('admin.DataProduk') }}",
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
                        daftar_data_produk[row.id] = row;
                        return meta.row + 1;
                    }
                },
                {
                    "targets": 1,
                    "class": "text-wrap text-center",
                    "render": function(data, type, row, meta) {
                        daftar_data_produk[row.id] = row;
                        return row.nama_produk;
                    }
                },
                {
                    "targets": 2,
                    "class": "text-wrap text-center",
                    "render": function(data, type, row, meta) {
                        daftar_data_produk[row.id] = row;
                        return row.relasi_kategori.nama_kategori;
                    }
                },
                {
                    "targets": 3,
                    "class": "text-wrap text-center",
                    "render": function(data, type, row, meta) {
                        daftar_data_produk[row.id] = row;
                        return row.relasi_tipe.produk_tipe;
                    }
                },
                {
                    "targets": 4,
                    "class": "text-wrap text-center",
                    "render": function(data, type, row, meta) {
                        daftar_data_produk[row.id] = row;
                        return row.deskripsi_singkat;
                    }
                },
                {
                    "targets": 5,
                    "class": "text-nowrap text-center",
                    "render": function(data, type, row, meta) {
                        let tampilan;
                        tampilan = `
                                <div class="ms-auto">
                                    <a class="btn btn-success btn-sm" href="/admin/produk-detail/${row.slug}">Detail</a>
                                    <a class="btn btn-warning btn-sm" href="/admin/edit-data-produk/${row.id}">Edit</a>
                                    <button type="button" class="btn btn-danger btn-sm hapus_produk" id-produk = "${row.id}" href="#!">Hapus</button>
                                </div>
                                `
                        // <a class="btn btn-link text-dark text-gradient px-3 mb-0 edit_kategori" id-produk = "${row.id}" href="#!" ><i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Ubah</a>
                        return tampilan;
                    }
                },
            ]
        });

        $('#formTambahDataProduk').on('submit', function(e) {
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
                        table_data_produk.ajax.reload(null, false)

                        $("#formTambahDataProduk")[0].reset();
                        $("#modalTambahDataProduk").modal('hide')
                    }
                }
            });
        });

        // $('.batal').on('click', function() {
        //     $(document).find('label.error-text').text('');
        //     $("#role").empty().append('');
        // })


        $(document).on('click', '.hapus_produk', function(event) {
            const id = $(event.currentTarget).attr('id-produk');

            Swal.fire({
                title: 'Yakin ingin mengahpus data ini?',
                icon: 'warning',
                showDenyButton: true,
            }).then((willDelete) => {

                if (willDelete) {
                    $.ajax({
                        url: "/admin/hapus-data-produk/" + id,
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
                                    table_data_produk.ajax.reload()
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
