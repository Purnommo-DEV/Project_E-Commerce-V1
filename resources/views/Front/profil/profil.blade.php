@extends('Front.layout.master', ['title' => 'Profil'])
@section('konten')
    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card card-primary card-outline"
                        style="box-shadow: 0 0 1px rgba(0,0,0,.125),0 1px 3px rgba(0,0,0,.2); padding: 1.25rem; min-height: 1px;">
                        <div class="card-body box-profile" style="padding:0px !important">
                            <div class="d-flex justify-content-center mb-2">
                                <img class="object-fit-fill border"
                                    style="aspect-ratio: 1/1; border-radius: 11.25rem!important; max-width: 30%;"
                                    src="{{ asset('storage/' . Auth::user()->foto) }}" alt="User profile picture">
                            </div>

                            <h5 class="profile-username text-center"><b>Akun dan Keamanan</b></h5>
                            <ul class="list-group list-group-unbordered mb-3" id="profil-customer">

                                <li class="list-group-item">
                                    <b>Nama Pengguna</b>
                                    <p href="" class="float-right">{{ Auth::user()->name ?? '' }}</p>
                                </li>
                                <li class="list-group-item">
                                    <b>Jenis Kelamin</b>
                                    <p href="" class="float-right">{{ Auth::user()->jk ?? '' }}</p>
                                </li>
                                <li class="list-group-item">
                                    <b>Email</b>
                                    <p href="" class="float-right">{{ Auth::user()->email ?? '' }}</p>
                                </li>
                                <li class="list-group-item">
                                    <b>Nomor HP</b>
                                    <p href="" class="float-right">{{ Auth::user()->nomor_hp ?? '' }}</p>
                                </li>
                                <li class="list-group-item">
                                    <b>Ganti Password</b>
                                    <a href="#!" data-toggle="modal" data-target="#ubahPassword"
                                        class="float-right">...</a>
                                </li>

                                <li class="list-group-item d-flex align-items-center">
                                    <a href="#!" class="btn btn-primary btn-block ubah-akun"><b>Ubah Akun</b></a>
                                </li>
                                @include('Front.profil.modal._form_ubah_akun')
                            </ul>

                            <h5 class="profile-username text-center"><b>Alamat Saya</b></h5>
                            <ul class="list-group list-group-unbordered mb-3" id="alamat-customer">

                                @foreach ($alamat_pengguna as $no => $data_alamat_pengguna)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <b>Alamat {{ $no + 1 }}</b>
                                        <span class="badge badge-none alamat-utama"
                                            radio-alamat-id="{{ $data_alamat_pengguna->id }}"><input
                                                class="form-check-input" type="radio" name="exampleRadios"
                                                style="margin-top: -0.6rem;"
                                                @if ($data_alamat_pengguna->alamat_utama == 1) @checked(true) @else @endif></span>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex">
                                            <div class="mr-auto p-2">
                                                <a class="float-right">{{ $data_alamat_pengguna->alamat }},
                                                    {{ $data_alamat_pengguna->relasi_provinsi->name }},
                                                    {{ $data_alamat_pengguna->relasi_kota->name }}</a>
                                            </div>
                                            <div class="p-2">
                                                <a href="javascript:void(0)" id="btn-modal-ubah-alamat"
                                                    data-id="{{ $data_alamat_pengguna->id }}"
                                                    class="badge btn-sm btn-primary" style="margin-left: 3px;">Ubah</a>
                                            </div>
                                            <div class="p-2"><span type="button"
                                                    class="badge btn-sm btn-danger hapus-alamat"
                                                    alamat-id="{{ $data_alamat_pengguna->id }}"
                                                    style="margin-left: 3px;">Hapus</span></div>
                                        </div>
                                    </li>
                                @endforeach
                                @if ($total_alamat < 3)
                                    <li class="list-group-item d-flex align-items-center">
                                        <a href="#!" class="btn btn-primary btn-block tambah-alamat"><b>Tambah
                                                Alamat</b></a>
                                    </li>
                                @else
                                @endif
                            </ul>
                            @include('Front.profil.modal._form_ubah_alamat')
                            @include('Front.profil.modal._form_tambah_alamat')
                            {{-- <a href="#" class="btn btn-primary btn-block" data-toggle="modal"
                                data-target="#ubahDataPelanggan"><b>Edit Profil</b></a> --}}
                        </div>
                    </div>
                </div><!-- End .col-lg-6 -->
                @include('Front.profil.modal._form_ubah_password')
                <div class="col-lg-8" id="tab-content-header-body">
                    <div class="heading heading-flex heading-border mb-3"
                        style="box-shadow: 0 0 1px rgba(0,0,0,.125),0 1px 3px rgba(0,0,0,.2);">

                        <div class="heading-left ">
                            <ul class="nav nav-pills nav-border-anim justify-content-center" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#belum-bayar-tab"
                                        role="tab">Belum Bayar</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#dibayar-tab" role="tab">Telah
                                        Bayar</a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#menunggu-verifikasi-tab"
                                        role="tab">Menunggu
                                        Verifikasi</a>
                                </li> --}}
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#sedang-dikemas-tab" role="tab">Sedang
                                        Dikemas</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#dikirim-tab" role="tab">Dikirim</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#selesai-tab" role="tab">Selesai</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#dibatalkan-tab"
                                        role="tab">Dibatalkan</a>
                                </li>
                            </ul>
                        </div><!-- End .heading-right -->
                    </div><!-- End .heading -->

                    <div class="tab-content">
                        @include('Front.profil._belum_bayar')
                        @include('Front.profil._dibayar')
                        {{-- @include('Front.profil._menunggu_verifikasi') --}}
                        @include('Front.profil._sedang_dikemas')
                        @include('Front.profil._dikirim')
                        @include('Front.profil._selesai')
                        @include('Front.profil._dibatalkan')
                    </div><!-- End .tab-content -->
                </div><!-- End .col-lg-6 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .page-content -->
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $('select[name="provinsi_id"]').on('change', function() {
                let provinsi_id = $(this).val();
                if (provinsi_id) {
                    jQuery.ajax({
                        url: '/kota/' + provinsi_id,
                        type: "GET",
                        dataType: "json",
                        success: function(response) {
                            $('select[name="kota_id"]').empty();
                            $('select[name="kota_id"]').append(
                                '<option value="">-- Pilih Kota --</option>');
                            $.each(response, function(key, value) {
                                $('select[name="kota_id"]').append('<option value="' +
                                    key + '">' + value + '</option>');
                            });
                        },
                    });
                } else {
                    $('select[name="kota_id"]').append('<option value="">-- Pilih Kota --</option>');
                }
            });
        });

        $(document).on('click', '.hapus-alamat', function(event) {
            const id = $(event.currentTarget).attr('alamat-id');
            Swal.fire({
                title: 'Yakin ingin menghapus ?',
                icon: 'warning',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal',
                showCancelButton: true,
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: "/customer/konfirmasi-hapus-alamat/" + id,
                        dataType: 'json',
                        success: function(response) {
                            if (response.status_berhasil_hapus_alamat == 1) {
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
                                        title: response.msg
                                    }),
                                    $("#alamat-customer").load(location.href +
                                        " #alamat-customer>*", "");
                            }
                        }
                    });
                }
            });
        });

        $(document).on('click', '.alamat-utama', function(event) {
            const id = $(event.currentTarget).attr('radio-alamat-id');
            Swal.fire({
                title: 'Yakin ingin mengubah menjadi alamat utama ?',
                icon: 'warning',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal',
                showCancelButton: true,
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: "/customer/konfirmasi-alamat-utama/" + id,
                        dataType: 'json',
                        success: function(response) {
                            if (response.status_menjadi_alamat_utama == 1) {
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
                                        title: response.msg
                                    }),
                                    $("#alamat-customer").load(location.href +
                                        " #alamat-customer>*", "");
                            }
                        }
                    });
                } else {
                    //alert ('no');
                    $("#alamat-customer").load(location.href +
                        " #alamat-customer>*", "");
                }
            });
        });
    </script>
@endpush
