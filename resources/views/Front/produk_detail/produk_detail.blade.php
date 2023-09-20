@extends('Front.layout.master', ['title' => 'Detail Produk'])
@section('konten')

    <div class="page-content">
        <div class="container">
            <div class="product-details-top mb-2">
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
                                {{-- <div id="product-zoom-gallery" class="product-image-gallery">
                                    @foreach ($produk_gambar as $data_produk_gambar)
                                     <a class="product-gallery-item @if ($index == 0) {{ 'active' }} @endif"
                                                href="#"
                                                data-image="{{ asset('storage/' . $data_produk_gambar->path) }}"
                                                data-zoom-image="{{ asset('storage/' . $data_produk_gambar->path) }}">
                                                <img class="product-image object-fit-fill border rounded"
                                                    style="aspect-ratio: 4/3;"
                                                    src="{{ asset('storage/' . $data_produk_gambar->path) }}"
                                                    alt="product side">
                                            </a>


                                        <a class="product-gallery-item active" href="#"
                                            data-image="{{ asset('storage/' . $data_produk_gambar->path) }}"
                                            data-zoom-image="{{ asset('storage/' . $data_produk_gambar->path) }}">
                                            <img class="product-image object-fit-fill border rounded"
                                                style="aspect-ratio: 4/3;"
                                                src="{{ asset('storage/' . $data_produk_gambar->path) }}"
                                                alt="product side">
                                        </a>
                                    @endforeach
                                </div><!-- End .product-image-gallery --> --}}
                            </div><!-- End .row -->
                        </div><!-- End .product-gallery -->
                    </div><!-- End .col-md-6 -->

                    <div class="col-md-6">
                        <div class="product-details">
                            <h1 class="product-title">{{ $produk->nama_produk }}</h1><!-- End .product-title -->

                            <div class="ratings-container">
                                <div class="ratings">
                                    <div class="ratings-val" style="width: 80%;"></div><!-- End .ratings-val -->
                                </div><!-- End .ratings -->
                                <span class="ratings-text" style="color:black;">| 20 Penilaian | 25 Terjual</span>
                            </div><!-- End .rating-container -->
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

                                {{-- <div class="details-filter-row details-row-size">
                                    <label>Color:</label>

                                    <div class="product-nav product-nav-thumbs">
                                        <a href="#" class="active">
                                            <img src="assets/images/products/single/1-thumb.jpg" alt="product desc">
                                        </a>
                                        <a href="#">
                                            <img src="assets/images/products/single/2-thumb.jpg" alt="product desc">
                                        </a>
                                    </div><!-- End .product-nav -->
                                </div><!-- End .details-filter-row --> --}}



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

                                {{-- <div class="product-details-action">
                                    <div class="details-action-col">
                                        <div class="product-details-quantity">
                                            <input type="number" name="kuantitas" id="kuantitas" class="form-control"
                                                value="1" min="1" max="" step="1"
                                                data-decimals="0" required>
                                        </div><!-- End .product-details-quantity -->
                                        <button type="submit" class="btn-product btn-cart"><span>add to
                                                cart</span></button>
                                    </div><!-- End .details-action-col --> --}}

                                {{-- <div class="details-action-wrapper">
                                    <a href="#" class="btn-product btn-wishlist" title="Wishlist"><span>Add to
                                            Wishlist</span></a>
                                    <a href="#" class="btn-product btn-compare" title="Compare"><span>Add to
                                            Compare</span></a>
                                </div><!-- End .details-action-wrapper --> --}}
                                {{-- </div><!-- End .product-details-action --> --}}
                            </form>





                            <div class="product-details-footer">
                                <div class="product-cat">
                                    <span>Kategori:</span>
                                    <a href="#">{{ $produk->relasi_kategori->nama_kategori }}</a>
                                </div><!-- End .product-cat -->

                                {{-- <div class="social-icons social-icons-sm">
                                    <span class="social-label">Share:</span>
                                    <a href="#" class="social-icon" title="Facebook" target="_blank"><i
                                            class="icon-facebook-f"></i></a>
                                    <a href="#" class="social-icon" title="Twitter" target="_blank"><i
                                            class="icon-twitter"></i></a>
                                    <a href="#" class="social-icon" title="Instagram" target="_blank"><i
                                            class="icon-instagram"></i></a>
                                    <a href="#" class="social-icon" title="Pinterest" target="_blank"><i
                                            class="icon-pinterest"></i></a>
                                </div> --}}
                            </div><!-- End .product-details-footer -->
                        </div><!-- End .product-details -->
                    </div><!-- End .col-md-6 -->
                </div><!-- End .row -->
            </div><!-- End .product-details-top -->

            <div class="product-details-tab">
                <ul class="nav nav-pills justify-content-center" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="product-desc-link" data-toggle="tab" href="#product-desc-tab"
                            role="tab" aria-controls="product-desc-tab" aria-selected="true">Description</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="product-info-link" data-toggle="tab" href="#product-info-tab" role="tab"
                            aria-controls="product-info-tab" aria-selected="false">Additional
                            information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="product-shipping-link" data-toggle="tab" href="#product-shipping-tab"
                            role="tab" aria-controls="product-shipping-tab" aria-selected="false">Shipping &
                            Returns</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="product-review-link" data-toggle="tab" href="#product-review-tab"
                            role="tab" aria-controls="product-review-tab" aria-selected="false">Reviews (2)</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="product-desc-tab" role="tabpanel"
                        aria-labelledby="product-desc-link">
                        <div class="product-desc-content">
                            <h3>Product Information</h3>
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis
                                eros. Nullam malesuada erat ut turpis. Suspendisse urna viverra non, semper suscipit,
                                posuere a, pede. Donec nec justo eget felis facilisis fermentum. Aliquam porttitor mauris
                                sit amet orci. Aenean dignissim pellentesque felis. Phasellus ultrices nulla quis nibh.
                                Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus. </p>
                            <ul>
                                <li>Nunc nec porttitor turpis. In eu risus enim. In vitae mollis elit. </li>
                                <li>Vivamus finibus vel mauris ut vehicula.</li>
                                <li>Nullam a magna porttitor, dictum risus nec, faucibus sapien.</li>
                            </ul>

                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis
                                eros. Nullam malesuada erat ut turpis. Suspendisse urna viverra non, semper suscipit,
                                posuere a, pede. Donec nec justo eget felis facilisis fermentum. Aliquam porttitor mauris
                                sit amet orci. Aenean dignissim pellentesque felis. Phasellus ultrices nulla quis nibh.
                                Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus. </p>
                        </div><!-- End .product-desc-content -->
                    </div><!-- .End .tab-pane -->
                    <div class="tab-pane fade" id="product-info-tab" role="tabpanel"
                        aria-labelledby="product-info-link">
                        <div class="product-desc-content">
                            <h3>Information</h3>
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis
                                eros. Nullam malesuada erat ut turpis. Suspendisse urna viverra non, semper suscipit,
                                posuere a, pede. Donec nec justo eget felis facilisis fermentum. Aliquam porttitor mauris
                                sit amet orci. </p>

                            <h3>Fabric & care</h3>
                            <ul>
                                <li>Faux suede fabric</li>
                                <li>Gold tone metal hoop handles.</li>
                                <li>RI branding</li>
                                <li>Snake print trim interior </li>
                                <li>Adjustable cross body strap</li>
                                <li> Height: 31cm; Width: 32cm; Depth: 12cm; Handle Drop: 61cm</li>
                            </ul>

                            <h3>Size</h3>
                            <p>one size</p>
                        </div><!-- End .product-desc-content -->
                    </div><!-- .End .tab-pane -->
                    <div class="tab-pane fade" id="product-shipping-tab" role="tabpanel"
                        aria-labelledby="product-shipping-link">
                        <div class="product-desc-content">
                            <h3>Delivery & returns</h3>
                            <p>We deliver to over 100 countries around the world. For full details of the delivery options
                                we offer, please view our <a href="#">Delivery information</a><br>
                                We hope you’ll love every purchase, but if you ever need to return an item you can do so
                                within a month of receipt. For full details of how to make a return, please view our <a
                                    href="#">Returns information</a></p>
                        </div><!-- End .product-desc-content -->
                    </div><!-- .End .tab-pane -->
                    <div class="tab-pane fade" id="product-review-tab" role="tabpanel"
                        aria-labelledby="product-review-link">
                        <div class="reviews">
                            <h3>Reviews (2)</h3>
                            <div class="review">
                                <div class="row no-gutters">
                                    <div class="col-auto">
                                        <h4><a href="#">Samanta J.</a></h4>
                                        <div class="ratings-container">
                                            <div class="ratings">
                                                <div class="ratings-val" style="width: 80%;"></div>
                                                <!-- End .ratings-val -->
                                            </div><!-- End .ratings -->
                                        </div><!-- End .rating-container -->
                                        <span class="review-date">6 days ago</span>
                                    </div><!-- End .col -->
                                    <div class="col">
                                        <h4>Good, perfect size</h4>

                                        <div class="review-content">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus cum dolores
                                                assumenda asperiores facilis porro reprehenderit animi culpa atque
                                                blanditiis commodi perspiciatis doloremque, possimus, explicabo, autem fugit
                                                beatae quae voluptas!</p>
                                        </div><!-- End .review-content -->

                                        <div class="review-action">
                                            <a href="#"><i class="icon-thumbs-up"></i>Helpful (2)</a>
                                            <a href="#"><i class="icon-thumbs-down"></i>Unhelpful (0)</a>
                                        </div><!-- End .review-action -->
                                    </div><!-- End .col-auto -->
                                </div><!-- End .row -->
                            </div><!-- End .review -->

                            <div class="review">
                                <div class="row no-gutters">
                                    <div class="col-auto">
                                        <h4><a href="#">John Doe</a></h4>
                                        <div class="ratings-container">
                                            <div class="ratings">
                                                <div class="ratings-val" style="width: 100%;"></div>
                                                <!-- End .ratings-val -->
                                            </div><!-- End .ratings -->
                                        </div><!-- End .rating-container -->
                                        <span class="review-date">5 days ago</span>
                                    </div><!-- End .col -->
                                    <div class="col">
                                        <h4>Very good</h4>

                                        <div class="review-content">
                                            <p>Sed, molestias, tempore? Ex dolor esse iure hic veniam laborum blanditiis
                                                laudantium iste amet. Cum non voluptate eos enim, ab cumque nam, modi, quas
                                                iure illum repellendus, blanditiis perspiciatis beatae!</p>
                                        </div><!-- End .review-content -->

                                        <div class="review-action">
                                            <a href="#"><i class="icon-thumbs-up"></i>Helpful (0)</a>
                                            <a href="#"><i class="icon-thumbs-down"></i>Unhelpful (0)</a>
                                        </div><!-- End .review-action -->
                                    </div><!-- End .col-auto -->
                                </div><!-- End .row -->
                            </div><!-- End .review -->
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
