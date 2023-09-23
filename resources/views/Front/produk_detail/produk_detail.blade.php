@extends('Front.layout.master', ['title' => 'Detail Produk'])
@section('konten')

    <div class="page-content">
        <div class="container">
            <div class="product-details-top mb-0">
                <div class="row">
                    <div class="col-md-6">
                        <div class="product-gallery">
                            <div class="row">

                                <figure class="product-main-image">
                                    @php
                                        $produk_gambar_1 = \App\Models\ProdukGambar::where('produk_id', $produk->id)->first();
                                        $produk_detail = \App\Models\ProdukDetail::where('produk_id', $produk->id)
                                            ->select('harga', 'id')
                                            ->first();
                                    @endphp
                                    <img class="product-image object-fit-fill border rounded" style="aspect-ratio: 2/2;"
                                        id="product-zoom" src="{{ asset('storage/' . $produk_gambar_1->path) }}"
                                        data-zoom-image="{{ asset('storage/' . $produk_gambar_1->path) }}"
                                        alt="product image">

                                    <a href="#" id="btn-product-gallery" class="btn-product-gallery">
                                        <i class="icon-arrows"></i>
                                    </a>
                                </figure><!-- End .product-main-image -->
                                <div class="owl-carousel carousel-theme carousel-simple carousel-with-shadow row cols-2 cols-xs-3 cols-sm-4 cols-md-5 cols-lg-6 cols-xl-8"
                                    data-toggle="owl"
                                    data-owl-options='{
                                        "nav": false,
                                        "dots": false,
                                        "loop": false,
                                        "responsive": {
                                            "0": {
                                                "items":4
                                            },
                                            "480": {
                                                "items":4
                                            },
                                            "576": {
                                                "items":5
                                            },
                                            "768": {
                                                "items":5
                                            },
                                            "992": {
                                                "items":7
                                            },
                                            "1200": {
                                                "items":8
                                            }
                                        }
                                    }'
                                    style="padding: 0 !important; margin-left: 0rem !important; margin-right: 0rem !important;">

                                    @foreach ($produk_gambar as $index => $data_produk_gambar)
                                        <div id="product-zoom-gallery" class="product-image-gallery">
                                            <a class="product-gallery-item @if ($index == 0) {{ 'active' }} @endif"
                                                href="#"
                                                data-image="{{ asset('storage/' . $data_produk_gambar->path) }}"
                                                data-zoom-image="{{ asset('storage/' . $data_produk_gambar->path) }}">
                                                <img class="product-image object-fit-fill border rounded"
                                                    style="aspect-ratio: 2/2;"
                                                    src="{{ asset('storage/' . $data_produk_gambar->path) }}"
                                                    alt="product side">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div><!-- End .row -->
                        </div><!-- End .product-gallery -->
                    </div><!-- End .col-md-6 -->

                    <div class="col-md-6">
                        <div class="product-details">
                            <h1 class="product-title">{{ $produk->nama_produk }}</h1><!-- End .product-title -->

                            <div class="product-details-action" style="margin-bottom: 0rem!important;">
                                <div class="details-action-wrapper"
                                    style="margin-top: 0rem!important; margin-left: 0rem!important;">
                                    <div class="d-flex flex-row bd-highlight mb-2">
                                        <div class="bd-highlight">
                                            {{-- <div class="ratings-container"> --}}
                                            @if ($rating_produk)
                                                @php
                                                    $statusPenilaianProduk = App\Models\Penilaian::with('relasi_pesanan_detail')
                                                        ->whereRelation('relasi_pesanan_detail', 'produk_id', $produk->id)
                                                        ->get();
                                                    $rating = App\Models\Penilaian::with('relasi_pesanan_detail')
                                                        ->whereRelation('relasi_pesanan_detail', 'produk_id', $produk->id)
                                                        ->avg('rating');
                                                    $avgRating = number_format($rating, 1);
                                                @endphp
                                                <div class="new-price"
                                                    style="display: inline-block; letter-spacing: 0rem; line-height: 1; font-size: 1.6rem!important;">
                                                    {{ $avgRating }}
                                                    <div class="ratings"
                                                        style="padding-left: 0.6rem; font-size: 1.6rem!important;">
                                                        <div class="ratings-val"
                                                            @if ($rating_produk->rating == 1) style="width: 20%; padding-left: 0.6rem; font-size: 1.6rem!important;"
                                                            @elseif($rating_produk->rating == 2) style="width: 40%; padding-left: 0.6rem; font-size: 1.6rem!important;"
                                                            @elseif($rating_produk->rating == 3) style="width: 60%; padding-left: 0.6rem; font-size: 1.6rem!important;"
                                                            @elseif ($rating_produk->rating == 4) style="width: 80%; padding-left: 0.6rem; font-size: 1.6rem!important;"
                                                            @elseif($rating_produk->rating == 5) style="width: 100%; padding-left: 0.6rem; font-size: 1.6rem!important;" @endif>
                                                        </div>
                                                        <!-- End .ratings-val -->
                                                    </div><!-- End .ratings -->
                                                </div>
                                            @else
                                                {{-- <label class="text-danger">Belum Ada Review</label> --}}
                                            @endif
                                            {{-- </div> --}}
                                        </div>
                                        <div class="bd-highlight">
                                            <div class="new-price"
                                                style="display: inline-block; font-size: 1.6rem; letter-spacing: 0rem; line-height: 1;">
                                                <span class="ratings-text ml-2"
                                                    style="color:chocolate; font-size:1.6rem;">{{ $jumlah_penilaian_produk }}
                                                    Penilaian</span>
                                            </div>
                                        </div>
                                        <div class="bd-highlight">
                                            <div class="new-price"
                                                style="display: inline-block; font-size: 1.6rem; letter-spacing: 0rem; line-height: 1;">
                                                <span class="ratings-text ml-2"
                                                    style="color:chocolate; font-size:1.6rem;">{{ $jumlah_produk_terjual }}
                                                    Terjual</span>
                                            </div>
                                        </div>
                                    </div>


                                </div><!-- End .details-action-wrapper -->
                            </div><!-- End .product-details-action -->
                            <div class="product-price">
                                @if ($produk->produk_tipe_id == 1)
                                    <span id="harga">@currency($produk_biasa->harga)</span>
                                @elseif($produk->produk_tipe_id == 2)
                                    <span id="harga">@currency($produk_detail->harga)</span>
                                @endif
                            </div><!-- End .product-price -->

                            <div class="product-content">
                                <p>{{ $produk->deskripsi_singkat }}</p>
                            </div><!-- End .product-content -->

                            <form action="{{ route('customer.TambahKeKeranjang') }}" method="POST"
                                id="formTambahProdukKeKeranjang">
                                @csrf
                                @if ($produk->produk_tipe_id == 1)
                                    <input type="hidden" name="produk_detail_id" value="{{ $produk_detail->id }}" hidden>
                                @elseif ($produk->produk_tipe_id == 2)
                                    <div class="details-filter-row details-row-size">
                                        <label for="size">Variasi:</label>
                                        <div class="select-custom">
                                            <select name="produk_detail_id" id="produk_detail_id" class="form-control">
                                                <option value="" selected disabled>-- Pilih Variasi --</option>
                                                @foreach ($produk_variasi as $data_produk_variasi)
                                                    <option value="{{ $data_produk_variasi->id }}">
                                                        {{ $data_produk_variasi->produk_variasi }}</option>
                                                @endforeach
                                            </select>
                                            <div class="input-group has-validation">
                                                <label class="text-danger error-text produk_detail_id_error"></label>
                                            </div>

                                        </div><!-- End .select-custom -->
                                    </div><!-- End .details-filter-row -->
                                @endif

                                <input type="hidden" name="produk_id" value="{{ $produk->id }}" hidden>
                                <div class="details-filter-row details-row-size">
                                    <label for="qty">Kuantitas :</label>
                                    <div class="product-details-quantity">
                                        <input type="number" name="kuantitas" id="kuantitas" class="form-control"
                                            value="1" min="1" max="" step="1" data-decimals="0"
                                            required>
                                    </div><!-- End .product-details-quantity -->
                                </div><!-- End .details-filter-row -->

                                <div class="product-details-action">
                                    <button type="submit" class="btn-product btn-cart"><span>add to
                                            cart</span></button>
                                </div><!-- End .product-details-action -->
                            </form>

                            <div class="product-details-footer">
                                <div class="product-cat">
                                    <span>Kategori:</span>
                                    <a href="#">{{ $produk->relasi_kategori->nama_kategori }}</a>
                                </div><!-- End .product-cat -->
                            </div><!-- End .product-details-footer -->
                        </div><!-- End .product-details -->
                    </div><!-- End .col-md-6 -->
                </div><!-- End .row -->
            </div><!-- End .product-details-top -->

            <div class="product-details-tab">
                <ul class="nav nav-pills justify-content-center" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="deskripsi-link" data-toggle="tab" href="#deskripsi-tab"
                            role="tab" aria-controls="deskripsi-tab" aria-selected="true">Diskripsi</a>

                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="ulasan-link" data-toggle="tab" href="#ulasan-tab" role="tab"
                            aria-controls="ulasan-tab" aria-selected="false">Ulasan
                            ({{ $jumlah_penilaian_produk }})</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="deskripsi-tab" role="tabpanel"
                        aria-labelledby="deskripsi-link">
                        <div class="deskripsi-content">
                            <h3>Informasi Produk</h3>
                            <p>{{ $produk->deskripsi_lengkap }}</p>
                        </div><!-- End .deskripsi-content -->
                    </div><!-- .End .tab-pane -->
                    <div class="tab-pane fade" id="ulasan-tab" role="tabpanel" aria-labelledby="ulasan-link">
                        <div class="reviews">
                            <h3>Ulasan
                                ({{ $jumlah_penilaian_produk }})</h3>
                            @foreach ($penilaian_produk as $data_penilaian_produk)
                                <div class="review">
                                    <div class="row no-gutters">
                                        <div class="col-auto">
                                            <h4><a
                                                    href="#">{{ $data_penilaian_produk->relasi_pesanan_detail->relasi_pesanan->relasi_user->name }}</a>
                                            </h4>
                                            <div class="ratings-container">
                                                <div class="ratings">
                                                    <div class="ratings-val"
                                                        @if ($data_penilaian_produk->rating == 1) style="width: 20%;"
                                                        @elseif($data_penilaian_produk->rating == 2) style="width: 40%;"
                                                        @elseif($data_penilaian_produk->rating == 3) style="width: 60%;"
                                                        @elseif ($data_penilaian_produk->rating == 4) style="width: 80%;"
                                                        @elseif($data_penilaian_produk->rating == 5) style="width: 100%;" @endif>
                                                    </div>
                                                    <!-- End .ratings-val -->
                                                </div><!-- End .ratings -->
                                            </div><!-- End .rating-container -->
                                            <span class="review-date">6 days ago</span>
                                        </div><!-- End .col -->
                                        <div class="col">
                                            <div class="review-content">
                                                <p>{{ $data_penilaian_produk->komentar }}</p>
                                            </div><!-- End .review-content -->

                                            <div class="review-action">
                                                <img class="product-image object-fit-fill border rounded"
                                                    style="aspect-ratio: 2/2; max-width: 15rem !important"
                                                    id="product-zoom"
                                                    src="{{ asset('storage/' . $data_penilaian_produk->path) }}"
                                                    data-zoom-image="{{ asset('storage/' . $data_penilaian_produk->path) }}"
                                                    alt="product image">
                                            </div><!-- End .review-action -->
                                        </div><!-- End .col-auto -->
                                    </div><!-- End .row -->
                                </div><!-- End .review -->
                            @endforeach
                        </div><!-- End .reviews -->
                    </div><!-- .End .tab-pane -->
                </div><!-- End .tab-content -->
            </div><!-- End .product-details-tab -->
        </div><!-- End .owl-carousel -->
    </div><!-- End .container -->
    </div><!-- End .page-content -->
@endsection
@section('script')
    <script>
        function check(kuantitas) {
            div.addEventListener('click', function() {});
            var max = kuantitas.getAttribute("data-max");
            if (parseInt(kuantitas.value) > parseInt(max)) {
                alert("Amount out of max!");
            }
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $("#produk_detail_id").change(function() {
            var produk_detail_id = $(this).val();
            var data_max = $(this).attr('max');

            if (produk_detail_id == "") {
                alert("Mohon Pilih Variasi");
                return false;
            }

            const {
                format
            } = new Intl.NumberFormat('id-ID', {
                style: "currency",
                currency: "IDR",
                minimumFractionDigits: 0
            });

            $.ajax({
                url: '/response-produk-variasi',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    produk_detail_id: produk_detail_id
                },
                type: 'post',
                success: function(response) {
                    let harga = response.resp_produk_variasi.harga;
                    $('#kuantitas').attr("max", response.resp_produk_variasi.stok).val(1);
                    $('#harga').html(format(harga));
                },
                error: function() {
                    alert("error");
                }
            });
        });

        $('#formTambahProdukKeKeranjang').on('submit', function(e) {
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
                    if (data.status_login == 0) {
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
                            icon: 'error',
                            title: data.msg
                        });
                    } else if (data.status_login == 1) {
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
                        });
                    } else if (data.status_melebihi_batas == 0) {
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
                            icon: 'error',
                            title: data.msg
                        });
                    } else if (data.status_hitung_produk == 0) {
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
                            icon: 'warning',
                            title: data.msg
                        });
                    } else if (data.status_tmb_keranjang == 0) {
                        $.each(data.error, function(prefix, val) {
                            $('label.' + prefix + '_error').text(val[0]);
                            // $('span.'+prefix+'_error').text(val[0]);
                        });
                    } else if (data.status_tmb_keranjang == 1) {
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
                        });
                        $("#data_keranjang_header").html(data.data_keranjang_terbaru);
                        $('.total_produk_keranjang_class').html(data
                            .total_produk_keranjang);
                        $(".cart-total-price").html(data.total_harga_produk_dlm_keranjang);
                    }
                }
            });
        });
    </script>
@endsection
