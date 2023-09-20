@extends('Front.layout.master', ['title' => 'Beranda'])
@section('konten')
    <div class="intro-slider-container mb-4">
        <div class="intro-slider owl-carousel owl-simple owl-nav-inside" data-toggle="owl"
            data-owl-options='{
                        "nav": false,
                        "dots": true,
                        "responsive": {
                            "992": {
                                "nav": true,
                                "dots": false
                            }
                        }
                    }'>
            @foreach ($slider as $data_slider)
                <div class="intro-slide"
                    style="
                    background-image: url({{ asset('storage/' . $data_slider->gambar) }});
                ">
                    <div class="container intro-content">
                        <h1 class="intro-title">{!! $data_slider->judul !!}</h1>
                        <!-- End .intro-title -->

                        {{-- <a href="category.html" class="btn btn-outline-primary-2">
                            <span>DISCOVER MORE</span>
                            <i class="icon-long-arrow-right"></i>
                        </a> --}}
                    </div>
                    <!-- End .intro-content -->
                </div>
            @endforeach
            <!-- End .intro-slide -->
        </div>
        <!-- End .intro-slider owl-carousel owl-simple -->

        <span class="slider-loader"></span><!-- End .slider-loader -->
    </div>

    <div class="mb-4"></div>
    <!-- End .mb-2 -->

    <div class="container banner-group-1">
        <div class="categories mb-4">
            <h3 class="title text-center font-weight-bold mt-4">Explore Popular Categories</h3>
            <div class="owl-carousel carousel-theme carousel-simple carousel-with-shadow row cols-2 cols-xs-3 cols-sm-4 cols-md-5 cols-lg-6 cols-xl-8"
                data-toggle="owl"
                data-owl-options='{
                        "nav": false,
                        "dots": false,
                        "margin": 10,
                        "loop": false,
                        "responsive": {
                            "0": {
                                "items":2
                            },
                            "480": {
                                "items":3
                            },
                            "576": {
                                "items":3
                            },
                            "768": {
                                "items":5
                            },
                            "992": {
                                "items":6
                            },
                            "1200": {
                                "items":8
                            }
                        }
                    }'
                style="justify-content: center; display: flex !important; width: 100%;">
                @foreach ($kategori as $data_kategori)
                    <div class="category position-relative">
                        <div class="category-image">
                            <a href="{{ route('KategoriDetail', $data_kategori->slug) }}">
                                <img src="{{ asset('storage/' . $data_kategori->path) }}" class="w-100" alt=""
                                    width="160" style="aspect-ratio: 2/2;">
                            </a>
                        </div>
                        <div
                            class="category-body letter-spacing-normal font-size-normal text-center position-absolute text-uppercase">
                            <a href="{{ route('KategoriDetail', $data_kategori->slug) }}"
                                class="category-title text-truncate font-weight-normal">{{ $data_kategori->nama_kategori }}</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- End .container -->

    <div class="mb-2"></div>
    <!-- End .mb-2 -->

    <div class="container">
        <div class="row">

            @foreach ($banner as $index => $data_banner)
                <div
                    class="col-sm-6 @if ($index == 0) col-lg-3 @elseif($index == 1) col-lg-3 order-lg-last @elseif($index == 2) @endif">
                    <div class="banner banner-overlay">
                        <a href="#">
                            <img class="card-img-top object-fit-fill border rounded"
                                src="{{ asset('storage/' . $data_banner->gambar) }}" alt="Banner"
                                @if ($index == 0 || $index == 1) style="width:277px; height:260px; aspect-ratio: 4/3;" @elseif ($index == 2) style="width:576px; height:260px" @endif />
                        </a>

                        <div class="banner-content">
                            <h4 class="banner-subtitle text-white">
                                {{-- <a href="#">Smart Offer</a> --}}
                            </h4>
                            <!-- End .banner-subtitle -->
                            <h3 class="banner-title text-white">
                                <a href="#">{!! $data_banner->judul !!}</a>
                            </h3>
                            <!-- End .banner-title -->
                            {{-- <a href="#" class="banner-link">Shop Now <i class="icon-long-arrow-right"></i></a> --}}
                        </div>
                        <!-- End .banner-content -->
                    </div>
                    <!-- End .banner -->
                </div>
            @endforeach
            <!-- End .col-lg-6 -->
        </div>
        <!-- End .row -->
    </div>
    <!-- End .container -->

    <div class="mb-3"></div>
    <!-- End .mb-3 -->

    <div class="bg-light pb-5">
        <div class="container deal-section">
            <h3 class="title text-center mt-5 font-weight-bold">Today's Best Deal</h3>
            <div class="deal-carousel owl-carousel owl-simple carousel-equal-height row cols-2 cols-md-3 cols-lg-4 cols-xl-5"
                data-toggle="owl"
                data-owl-options='{
                    "nav": true,
                    "dots": false,
                    "margin": 0,
                    "loop": false,
                    "responsive": {
                        "0": {
                            "items":2
                        },
                        "480": {
                            "items":2
                        },
                        "767": {
                            "items":3
                        },
                        "992": {
                            "items":4
                        },
                        "1200": {
                            "items":5
                        },
                        "1600": {
                            "items":5
                        }
                    }
                }'>

                @foreach ($produk as $index => $data_produk)
                    @php
                        $gambar_produk_first = App\Models\ProdukGambar::select('path')
                            ->where('produk_id', $data_produk->id)
                            ->orderBy('id', 'desc')
                            ->first();
                        $gambar_produk_last = App\Models\ProdukGambar::select('path')
                            ->where('produk_id', $data_produk->id)
                            ->latest()
                            ->first();
                        $produk_detail = App\Models\ProdukDetail::select('harga')
                            ->where('produk_id', $data_produk->id)
                            ->first();
                    @endphp
                    <div class="product d-flex flex-column overflow-hidden">
                        <figure class="mb-0 product-media bg-white d-flex justify-content-center align-items-center">
                            <span class="product-label label-sale">SALE</span>
                            <a href="{{ route('HalamanDetailProduk', $data_produk->slug) }}" class="w-100">
                                <img src="{{ asset('storage/' . $gambar_produk_first->path) }}" alt="Product image"
                                    class="product-image" style="aspect-ratio: 5/4;">
                                <img src="{{ asset('storage/' . $gambar_produk_last->path) }}" alt="Product image"
                                    class="product-image-hover" style="aspect-ratio: 5/4;">
                            </a>
                            {{-- <div class="product-countdown bg-light" data-until="+55h" data-relative="true"
                                data-labels-short="true"></div>
                            <div class="product-action-vertical">
                                <a href="#" class="btn-product-icon text-dark btn-wishlist"
                                    title="Add to wishlist">
                                    <span>add to wishlist</span>
                                </a>
                                <a href="popup/quickView.html" class="btn-product-icon text-dark btn-quickview"
                                    title="Quick view">
                                    <span>Quick view</span>
                                </a>
                                <a href="#" class="btn-product-icon text-dark btn-compare" title="Compare">
                                    <span>Compare</span>
                                </a>
                            </div> --}}
                        </figure>

                        <div class="product-body pb-1">
                            <div class="text-left product-cat font-weight-normal text-light mb-0">
                                <a href="#">{{ $data_produk->relasi_kategori->nama_kategori }}</a>
                            </div>
                            <h3 class="product-title letter-spacing-normal font-size-normal text-left mb-0">
                                <a
                                    href="{{ route('HalamanDetailProduk', $data_produk->slug) }}">{!! help_limit_karakter($data_produk->nama_produk) !!}</a>
                            </h3>
                        </div>
                        <div class="product-action position-relative visible">
                            <div class="ratings-container">
                                <div class="ratings">
                                    <div class="ratings-val" style="width: 100%;"></div>
                                </div>
                                <span class="ratings-text ml-2"> ( 2 Reviews )</span>
                            </div>
                        </div>
                        <div class="product-sold">
                            <div class="product-price mb-1">
                                <div class="new-price">{!! help_format_rupiah($produk_detail->harga) !!}</div>
                                <div class="old-price font-size-normal font-weight-normal">$290.00</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- End .container -->
    </div>


    <div class="bg-light pt-3 pb-5">
        <div class="container deal-section">
            <h3 class="title text-center mt-5 font-weight-bold">Today's Best Deal</h3>
            {{-- <div class="deal-carousel owl-carousel owl-simple carousel-equal-height row cols-2 cols-md-3 cols-lg-4 cols-xl-5"
                data-toggle="owl"
                data-owl-options='{
                    "nav": true,
                    "dots": false,
                    "margin": 0,
                    "loop": false,
                    "responsive": {
                        "0": {
                            "items":2
                        },
                        "480": {
                            "items":2
                        },
                        "767": {
                            "items":3
                        },
                        "992": {
                            "items":4
                        },
                        "1200": {
                            "items":5
                        },
                        "1600": {
                            "items":5
                        }
                    }
                }'> --}}
            <div class="row justify-content-center">
                @foreach ($produk as $index => $data_produk)
                    @php
                        $gambar_produk_first = App\Models\ProdukGambar::select('path')
                            ->where('produk_id', $data_produk->id)
                            ->orderBy('id', 'desc')
                            ->first();
                        $gambar_produk_last = App\Models\ProdukGambar::select('path')
                            ->where('produk_id', $data_produk->id)
                            ->latest()
                            ->first();
                        $produk_detail = App\Models\ProdukDetail::select('harga')
                            ->where('produk_id', $data_produk->id)
                            ->first();
                    @endphp
                    <div class="cols-12 col-6 col-md-6 col-lg-6 col-xl-3">
                        <div class="product d-flex flex-column overflow-hidden">
                            <figure class="mb-0 product-media bg-white d-flex justify-content-center align-items-center">
                                <span class="product-label label-sale">SALE</span>
                                <a href="{{ route('HalamanDetailProduk', $data_produk->slug) }}" class="w-100">
                                    <img src="{{ asset('storage/' . $gambar_produk_first->path) }}" alt="Product image"
                                        class="product-image" style="aspect-ratio: 5/4;">
                                    <img src="{{ asset('storage/' . $gambar_produk_last->path) }}" alt="Product image"
                                        class="product-image-hover" style="aspect-ratio: 5/4;">
                                </a>
                                {{-- <div class="product-countdown bg-light" data-until="+55h" data-relative="true"
                                data-labels-short="true"></div>
                            <div class="product-action-vertical">
                                <a href="#" class="btn-product-icon text-dark btn-wishlist"
                                    title="Add to wishlist">
                                    <span>add to wishlist</span>
                                </a>
                                <a href="popup/quickView.html" class="btn-product-icon text-dark btn-quickview"
                                    title="Quick view">
                                    <span>Quick view</span>
                                </a>
                                <a href="#" class="btn-product-icon text-dark btn-compare" title="Compare">
                                    <span>Compare</span>
                                </a>
                            </div> --}}
                            </figure>

                            <div class="product-body pb-1">
                                <div class="text-left product-cat font-weight-normal text-light mb-0">
                                    <a href="#">{{ $data_produk->relasi_kategori->nama_kategori }}</a>
                                </div>
                                <h3 class="product-title letter-spacing-normal font-size-normal text-left mb-0">
                                    <a
                                        href="{{ route('HalamanDetailProduk', $data_produk->slug) }}">{!! help_limit_karakter($data_produk->nama_produk) !!}</a>
                                </h3>
                            </div>
                            <div class="product-action position-relative visible">
                                <div class="ratings-container">
                                    <div class="ratings">
                                        <div class="ratings-val" style="width: 100%;"></div>
                                    </div>
                                    <span class="ratings-text ml-2"> ( 2 Reviews )</span>
                                </div>
                            </div>
                            <div class="product-sold">
                                <div class="product-price mb-1">
                                    <div class="new-price">{!! help_format_rupiah($produk_detail->harga) !!}</div>
                                    <div class="old-price font-size-normal font-weight-normal">$290.00</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- End .container -->
    </div>
@endsection
