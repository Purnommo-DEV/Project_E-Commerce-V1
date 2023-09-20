@extends('Front.layout.master', ['title' => 'Profil'])
@section('konten')
    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card card-primary card-outline sticky-content"
                        style="box-shadow: 0 0 1px rgba(0,0,0,.125),0 1px 3px rgba(0,0,0,.2); padding: 1.25rem; min-height: 1px;">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                {{-- <img class="profile-user-img img-fluid img-circle"
                        src="../../dist/img/user4-128x128.jpg"
                        alt="User profile picture"> --}}
                            </div>
                            <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>
                            <p class="text-muted text-center">Pelanggan</p>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Alamat</b> <a class="float-right">{!! help_alamat_pengguna()->alamat !!}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Provinsi</b> <a class="float-right">{!! help_alamat_pengguna()->relasi_provinsi->name !!}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Kota</b> <a class="float-right">{!! help_alamat_pengguna()->relasi_kota->name !!}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Email</b> <a class="float-right">{{ Auth::user()->email }}</a>
                                </li>
                            </ul>
                            <a href="#" class="btn btn-primary btn-block" data-toggle="modal"
                                data-target="#ubahDataPelanggan"><b>Edit Profil</b></a>
                        </div>
                    </div>
                </div><!-- End .col-lg-6 -->

                <div class="col-lg-8" id="tab-content-header-body">
                    <div class="heading heading-flex heading-border mb-3"
                        style="box-shadow: 0 0 1px rgba(0,0,0,.125),0 1px 3px rgba(0,0,0,.2);">

                        <div class="heading-left">
                            <ul class="nav nav-pills nav-border-anim justify-content-center" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#belum-bayar-tab"
                                        role="tab">Belum Bayar</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#menunggu-verifikasi-tab"
                                        role="tab">Menunggu
                                        Verifikasi</a>
                                </li>
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
                        @include('Front.profil._menunggu_verifikasi')
                        @include('Front.profil._sedang_dikemas')
                        @include('Front.profil._dikirim')
                        @include('Front.profil._selesai')
                        @include('Front.profil._dibatalkan')
                    </div><!-- End .tab-content -->
                </div><!-- End .col-lg-6 -->
            </div><!-- End .row -->
        </div><!-- End .container -->

        {{-- <div class="col-md-9">
                    <div class="card"
                        style="box-shadow: 0 0 1px rgba(0,0,0,.125),0 1px 3px rgba(0,0,0,.2); padding: 1.25rem; min-height: 1px; word-wrap: break-word;">
                        <div class="card-header p-2"
                            style="background-color: transparent;border-bottom: 1px solid rgba(0,0,0,.125);padding: .75rem 1.25rem;position: relative;border-top-left-radius: .25rem;border-top-right-radius: .25rem;">
                            <ul class="nav nav-pills" style="justify-content: space-around;">
                                <li class="nav-item"><a class="nav-link active" href="#belum_bayar" data-toggle="tab">Belum
                                        Bayar</a></li>
                                <li class="nav-item"><a class="nav-link" href="#dikemas" data-toggle="tab">Dikemas</a></li>
                                <li class="nav-item"><a class="nav-link" href="#dikirim" data-toggle="tab">Dikirim</a></li>
                                <li class="nav-item"><a class="nav-link" href="#terkirim" data-toggle="tab">Selesai</a></li>
                                <li class="nav-item"><a class="nav-link" href="#penilaian" data-toggle="tab">Beri
                                        Penilaian</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="page-content">
                            <div class="container">
                                <div class="row">
                                    <div class="card">
                                        <div class="tab-content">
                                            @include('Front.profil.belum_bayar')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div> --}}

    </div><!-- End .page-content -->
@endsection
@section('script')
    <script>
        // Product Image Zoom plugin - product pages
        if ($.fn.elevateZoom) {
            $('#perbesar-gambar' + pesanan_id).elevateZoom({
                gallery: 'perbesar-gambar-galeri' + pesanan_id,
                galleryActiveClass: 'active',
                zoomType: "inner",
                cursor: "crosshair",
                zoomWindowFadeIn: 400,
                zoomWindowFadeOut: 400,
                responsive: true
            });

            // On click change thumbs active item
            $('.gambar-galeri-item' + pesanan_id).on('click', function(e) {
                $('#perbesar-gambar-galeri' + pesanan_id).find('a').removeClass('active');
                $(this).addClass('active');

                e.preventDefault();
            });

            var ez = $('#perbesar-gambar' + pesanan_id).data('elevateZoom');

            // Open popup - product images
            $('#btn-gambar-galeri').on('click', function(e) {
                const pesanan_id = $(event.currentTarget).attr('pesanan-id');
                if ($.fn.magnificPopup) {
                    $.magnificPopup.open({
                        items: ez.getGalleryList(),
                        type: 'image',
                        gallery: {
                            enabled: true
                        },
                        fixedContentPos: false,
                        removalDelay: 600,
                        closeBtnInside: false
                    }, 0);

                    e.preventDefault();
                }
            });
        }
    </script>
@endsection
