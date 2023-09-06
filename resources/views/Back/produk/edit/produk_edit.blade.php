@extends('Back.layout.master', ['title' => 'Edit Data Produk'])
@section('konten-admin')
    <div class="pagetitle">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Vertical Form -->
                            {{-- <div id="divDataProduk"> --}}
                            <form class="row g-3 mt-2" action="{{ route('admin.UbahDataProduk') }}" method="POST"
                                id="formUbahDataProduk">
                                @csrf
                                <div class="col-4">
                                    <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                                    <label for="inputNanme4" class="form-label">Nama Produk</label>
                                    <input type="text" value="{{ $produk->nama_produk }}" name="nama_produk"
                                        class="form-control">
                                    <div class="input-group has-validation">
                                        <label class="text-danger error-text nama_produk_error"></label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <label for="inputNanme4" class="form-label">Kategori</label>
                                    <select class="form-control" name="kategori_id">
                                        <option value="" selected disabled>-- Pilih Kategori --</option>
                                        @foreach ($produk_kategori as $produk_kategoris)
                                            @if ($produk->kategori_id == $produk_kategoris->id)
                                                <option value="{{ $produk_kategoris->id }}" selected>
                                                    {{ $produk_kategoris->nama_kategori }}</option>
                                            @else
                                                <option value="{{ $produk_kategoris->id }}">
                                                    {{ $produk_kategoris->nama_kategori }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <div class="input-group has-validation">
                                        <label class="text-danger error-text kategori_id_error"></label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <label for="inputNanme4" class="form-label">Tipe</label>
                                    <input type="text" value="{{ $produk->relasi_tipe->produk_tipe }}"
                                        class="form-control" readonly>
                                </div>

                                @php
                                    $produk_biasa = \App\Models\ProdukDetail::where('produk_id', $produk->id)->first() ?? new \App\Models\ProdukDetail();
                                    $produk_variasi = \App\Models\ProdukDetail::where('produk_id', $produk->id)->get();
                                @endphp
                                @if ($produk->produk_tipe_id == 1)
                                    <div class="col-4">
                                        <label for="inputNanme4" class="form-label">Harga</label>
                                        <input type="text" value="{{ $produk_biasa->harga }}" name="harga_produk_biasa"
                                            class="form-control" id="harga_produk_biasa">
                                        <div class="input-group has-validation">
                                            <label class="text-danger error-text harga_produk_biasa_error"></label>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <label for="inputNanme4" class="form-label">Berat(g)</label>
                                        <input type="text" value="{{ $produk_biasa->berat }}" name="berat_produk_biasa"
                                            class="form-control" id="inputNanme4">
                                        <div class="input-group has-validation">
                                            <label class="text-danger error-text berat_produk_biasa_error"></label>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <label for="inputNanme4" class="form-label">Stok</label>
                                        <input type="text" value="{{ $produk_biasa->stok }}" name="stok_produk_biasa"
                                            class="form-control" id="inputNanme4">
                                        <div class="input-group has-validation">
                                            <label class="text-danger error-text stok_produk_biasa_error"></label>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-12">
                                    <label for="inputAddress" class="form-label">Deskripsi Singkat</label>
                                    <textarea name="deskripsi_singkat" class="form-control" id="inputAddress">{{ $produk->deskripsi_singkat }}</textarea>
                                    <div class="input-group has-validation">
                                        <label class="text-danger error-text deskripsi_singkat_error"></label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="inputAddress" class="form-label">Deskripsi Lengkap</label>
                                    <textarea name="deskripsi_lengkap" class="form-control" id="inputAddress">{{ $produk->deskripsi_lengkap }}</textarea>
                                    <div class="input-group has-validation">
                                        <label class="text-danger error-text deskripsi_lengkap_error"></label>
                                    </div>
                                </div>
                                {{-- </div> --}}
                                <div class="text-left">
                                    <button type="submit" class="btn btn-sm btn-primary">Update Produk</button>
                                </div>
                            </form><!-- Vertical Form -->
                        </div>
                    </div>
                </div>
            </div>

            @if ($produk->produk_tipe_id == 2)
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <button type="button" class="btn btn-light btn-sm mt-2 mb-2" href="#"
                                data-bs-toggle="modal" data-bs-target="#modalTambahDataProdukVariasi"><i
                                    class="bi bi-plus"></i>
                                Tambah Variasi Produk</button>

                            <div class="modal fade text-left" id="modalTambahDataProdukVariasi" data-bs-backdrop="static"
                                data-bs-keyboard="false" aria-labelledby="myModalLabel33" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Tambah Variasi Produk</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('admin.TambahDataProdukVariasi', $produk->id) }}"
                                                id="formTambahDataProdukVariasi" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="row align-items-end">
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
                                                                    <label for="nama-produk"
                                                                        class="col-form-label">Stok</label>
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

                            <form action="{{ route('admin.UpdateDataProdukVariasi') }}" method="POST"
                                id="formUbahDataProdukVariasi">
                                @csrf
                                <div id="divTableProdukVariasi">
                                    <table class="table table-striped" id="table-variasi-produk">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Variasi</th>
                                                <th>Harga</th>
                                                <th>Berat</th>
                                                <th>Stok</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($produk_variasi as $i => $data_produk_variasi)
                                                <input type="hidden" value="{{ $data_produk_variasi->id }}"
                                                    name="produk_variasi_id[]">
                                                <tr>
                                                    <td>{{ $i + 1 }}</td>
                                                    <td><input type="text" class="form-control"
                                                            value="{{ $data_produk_variasi->produk_variasi }}"
                                                            name="produk_variasi[]"></td>
                                                    <td><input type="text" class="form-control"
                                                            value="{{ $data_produk_variasi->harga }}" name="harga[]">
                                                    </td>
                                                    <td><input type="text" class="form-control"
                                                            value="{{ $data_produk_variasi->berat }}" name="berat[]">
                                                    </td>
                                                    <td><input type="text" class="form-control"
                                                            value="{{ $data_produk_variasi->stok }}" name="stok[]">
                                                    </td>
                                                    <td><a class="btn btn-sm btn-danger hapus_variasi"
                                                            variasi-id="{{ $data_produk_variasi->id }}"
                                                            href="#!">Hapus</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-left">
                                    <button type="submit" class="btn btn-sm btn-primary">Update Variasi
                                        Produk</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <button type="button" class="btn btn-light btn-sm mt-2 mb-2" href="#" data-bs-toggle="modal"
                        data-bs-target="#modalTambahDataGambarProduk"><i class="bi bi-plus"></i>
                        Tambah Gambar Produk</button>
                    <div class="modal fade text-left" id="modalTambahDataGambarProduk" data-bs-backdrop="static"
                        data-bs-keyboard="false" aria-labelledby="myModalLabel33" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah Gambar Produk</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('admin.TambahDataGambarProduk', $produk->id) }}"
                                        id="formTambahDataGambarProduk" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row align-items-end">
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="nama-produk" class="col-form-label">Gambar
                                                        Produk</label>
                                                    <input type="file" class="form-control imageUpload" name="path[]"
                                                        multiple>
                                                    <div class="input-group has-validation">
                                                        <label class="text-danger error-text path_error"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row imageOutput"></div>
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
                    <div id="divTableGambarProduk">
                        <div class="col-lg-12">
                            <div class="row align-items-top">
                                @foreach ($produk_gambar as $data_produk_gambar)
                                    <div class="col-lg-3">
                                        <div class="card text-center">
                                            <img src="{{ asset('storage/' . $data_produk_gambar->path) }}"
                                                class="card-img-top object-fit-fill border rounded"
                                                style="aspect-ratio: 4/3;">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $data_produk_gambar->judul }}</h5>
                                                <a class="btn btn-sm btn-danger hapus_gambar_produk"
                                                    gambar-produk-id="{{ $data_produk_gambar->id }}"
                                                    href="#!">Hapus</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </div>



    </div>
    </section>
@endsection
@section('script')
    <script>
        // UBAHPRODUK
        $('#formUbahDataProduk').on('submit', function(e) {
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
                        $("#divDataProduk").load(location.href +
                            " #divDataProduk>*", "");
                    }
                }
            });
        });

        // TAMBAH PRODUK VARIASI
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
            newId++;
        }

        $('#div-ProdukVariasi').on('click', '.hapusFormProdukVariasi', function(e) {
            e.preventDefault();
            newId--;
            $(this).parent().parent().parent().remove();
        });

        $('#formTambahDataProdukVariasi').on('submit', function(e) {
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
                        $("#formTambahDataProdukVariasi")[0].reset();
                        $("#modalTambahDataProdukVariasi").modal('hide');
                        // $("#div-ProdukVariasi").remove();
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 1000,
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
                            $("#divTableProdukVariasi").load(location.href +
                                " #divTableProdukVariasi>*", "");

                    }
                }
            });
        });

        // TAMBAH GAMBAR PRODUK
        $('#formTambahDataGambarProduk').on('submit', function(e) {
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
                        $("#formTambahDataGambarProduk")[0].reset();
                        $("#modalTambahDataGambarProduk").modal('hide');
                        // $("#div-ProdukVariasi").remove();
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 1000,
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
                            $("#divTableGambarProduk").load(location.href +
                                " #divTableGambarProduk>*", "");

                    }
                }
            });
        });

        // UBAH PRODUK VARIASI
        $('#formUbahDataProdukVariasi').on('submit', function(e) {
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
                        // $("#div-ProdukVariasi").remove();
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 1000,
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
                            $("#divTableProdukVariasi").load(location.href +
                                " #divTableProdukVariasi>*", "");

                    }
                }
            });
        });

        // HAPUS PRODUK VARIASI
        $(document).on('click', '.hapus_variasi', function(event) {
            const id = $(event.currentTarget).attr('variasi-id');

            Swal.fire({
                title: 'Yakin ingin mengahpus data ini?',
                icon: 'warning',
                showDenyButton: true,
            }).then((willDelete) => {

                if (willDelete) {
                    $.ajax({
                        url: "/admin/hapus-data-produk-variasi/" + id,
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
                                    $("#divTableProdukVariasi").load(location.href +
                                        " #divTableProdukVariasi>*", "");
                            }
                        }
                    });
                } else {
                    //alert ('no');
                    return false;
                }
            });
        });

        // HAPUS GAMBAR PRODUK
        $(document).on('click', '.hapus_gambar_produk', function(event) {
            const id = $(event.currentTarget).attr('gambar-produk-id');

            Swal.fire({
                title: 'Yakin ingin mengahpus data ini?',
                icon: 'warning',
                showDenyButton: true,
            }).then((willDelete) => {

                if (willDelete) {
                    $.ajax({
                        url: "/admin/hapus-data-gambar-produk/" + id,
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
                                    $("#divTableGambarProduk").load(location.href +
                                        " #divTableGambarProduk>*", "");
                            }
                        }
                    });
                } else {
                    //alert ('no');
                    return false;
                }
            });
        });

        // PREVIEW IMAGE UPLOAD

        // $(document).ready(function() {
        //     if (window.File && window.FileList && window.FileReader) {
        //         $("#imageUpload").on("change", function(e) {
        //             var multiple_files = e.target.files,
        //                 filesLength = multiple_files.length;
        //             for (var i = 0; i < filesLength; i++) {
        //                 var f = multiple_files[i]
        //                 var fileReader = new FileReader();
        //                 fileReader.onload = (function(e) {
        //                     var file = e.target;
        //                     $("<div class=\"row\"><div class=\"col-sm-6\"><div class=\"card\"><div class=\"card-body text-center pip\">" +
        //                         "<img class=\"card-img-top object-fit border rounded imageThumb\" style =\"aspect-ratio: 4/3;\" src=\"" +
        //                         e.target.result +
        //                         "\" title=\"" + file.name + "\"/>" +
        //                         "<br/><span class=\"img-delete\">Remove</span>" +
        //                         "</div></div></div></div>").insertAfter(
        //                         "#imageUpload");
        //                     $(".img-delete").click(function() {
        //                         $(this).parent(".pip").remove();
        //                     });
        //                 });
        //                 fileReader.readAsDataURL(f);
        //             }
        //         });
        //     } else {
        //         alert("|Sorry, | Your browser doesn't support to File API")
        //     }
        // });

        $(".imageUpload").change(function(event) {
            readURL(this);
        });
        $images = $('.imageOutput')

        function readURL(input) {
            if (input.files && input.files[0]) {

                $.each(input.files, function() {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $images.append(
                            '<div class="card text-center col-sm-6 mb-3 img-multiple"><img src="' + e
                            .target.result +
                            '"  class="card-img-top object-fit border rounded" style="aspect-ratio: 4/3;"/><div class="card-body"><span class="img-delete btn btn-sm btn-danger">Hapus</span></div></div>'
                        );
                        $(".img-delete").click(function() {
                            $(this).parent(".img-multiple").remove();
                        });
                    }
                    reader.readAsDataURL(this);
                });



                //  $.each(input.files, function() {
                //     var reader = new FileReader();
                //     reader.onload = function(e) {
                //         $images.append(
                //             ' <div class="col-sm-6 mb-3 img-multiple"><img src="' + e
                //             .target.result +
                //             '"  class="card-img-top object-fit border rounded" style="aspect-ratio: 4/3;"/></div><span class="img-delete">Remove</span>'
                //         );
                //         $(".img-delete").click(function() {
                //             $(this).parent(".img-multiple").remove();
                //         });
                //     }
                //     reader.readAsDataURL(this);
                // });

            }
        }

        // var harga_produk_variasi = document.getElementById('harga_produk_biasa');
        // harga_produk_variasi.addEventListener('keyup', function(e) {
        //     harga_produk_variasi.value = formatRupiah(this.value, 'Rp. ');
        // });

        // function formatRupiah(angka, prefix) {
        //     var number_string = angka.replace(/[^,\d]/g, '').toString(),
        //         split = number_string.split(','),
        //         sisa = split[0].length % 3,
        //         rupiah = split[0].substr(0, sisa),
        //         ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        //     if (ribuan) {
        //         separator = sisa ? '.' : '';
        //         rupiah += separator + ribuan.join('.');
        //     }
        //     rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        //     return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        // }
    </script>
@endsection
