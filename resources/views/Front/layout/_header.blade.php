<header class="header header-7">
    <div class="header-middle sticky-header">
        <div class="container">
            <div class="header-left">
                <button class="mobile-menu-toggler">
                    <span class="sr-only">Toggle mobile menu</span>
                    <i class="icon-bars"></i>
                </button>

                <a href="{{ route('HalamanBeranda') }}" class="logo">
                    <img src="{{ asset('Front/assets/images/logo/logo.png') }}" alt="Logo" width="82"
                        height="25" />
                </a>
            </div>
            <!-- End .header-left -->

            <div class="header-right">

                @if (Auth::check())
                    {{-- <div class="header-search">
                        <a href="#" class="search-toggle" role="button"><i class="icon-search"></i></a>
                        <form action="#" method="get">
                            <div class="header-search-wrapper">
                                <label for="q" class="sr-only">Search</label>
                                <input type="search" class="form-control" name="q" id="q"
                                    placeholder="Search in..." required />
                            </div>
                            <!-- End .header-search-wrapper -->
                        </form>
                    </div> --}}
                    <!-- End .header-search -->

                    {{-- <a href="wishlist.html" class="wishlist-link">
                        <i class="icon-heart-o"></i>
                        <span class="wishlist-count">3</span>
                    </a> --}}

                    <div class="header-search">
                        <a href="#!" class="search-toggle active"><i class="icon-search"></i></a>
                        <form action="#" method="get">
                            <div class="header-search-wrapper show">
                                <label class="sr-only">Search</label>
                                <input type="search" class="form-control" name="q" placeholder="Search in..."
                                    required />
                            </div>
                            <!-- End .header-search-wrapper -->
                        </form>
                    </div>
                    <!-- End .header-search -->
                    <div class="dropdown cart-dropdown">
                        <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false" data-display="static">
                            <i class="icon-shopping-cart"></i>
                            <span
                                class="cart-count total_produk_keranjang_class">{{ help_total_produk_keranjang() }}</span>
                        </a>


                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-cart-products">
                                <div id="data_keranjang_header">
                                    @foreach (help_data_keranjang() as $data_keranjang)
                                        <div class="product">
                                            <div class="product-cart-details">
                                                <h4 class="product-title">
                                                    <a
                                                        href="product.html">{{ $data_keranjang->relasi_produk->nama_produk }}</a>
                                                </h4>
                                                <span class="cart-product-info">
                                                    <span
                                                        class="cart-product-qty">{{ $data_keranjang->kuantitas }}</span>
                                                    x @currency($data_keranjang->relasi_produk_detail->harga)
                                                </span>
                                            </div>
                                            <figure class="product-image-container">
                                                <a href="product.html" class="product-image">
                                                    <img src="{{ asset('storage/' . $data_keranjang->relasi_produk->relasi_gambar->path) }}"
                                                        alt="product" />
                                                </a>
                                            </figure>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="dropdown-cart-total">
                                    <span>Total</span>

                                    <span class="cart-total-price">{!! help_total_harga_produk_keranjang() !!}</span>
                                </div>

                                <div class="dropdown-cart-action">
                                    <a href="{{ route('customer.HalamanKeranjang') }}"
                                        class="btn btn-primary btn-block">Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown cart-dropdown">
                        <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false" data-display="static">
                            <i class="icon-user"></i>
                            <span class="cart-txt">{{ Auth::user()->name }}</span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-left">
                            <div class="dropdown-cart-products">

                                <div class="dropdown-cart-action">
                                    <a href="{{ route('customer.HalamanProfil') }}"
                                        class="btn btn-outline-primary-2">Akun
                                        Saya</a>
                                    <a href="{{ route('UserLogout') }}"
                                        class="btn btn-outline-primary-2"><span>Keluar</span><i
                                            class="icon-long-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('Login') }}" class="btn btn-sm btn-outline-primary-2"
                            style="min-width: 50px!important;">Masuk | Daftar
                        </a>
                @endif
                <!-- End .cart-dropdown -->
            </div>
            <!-- End .header-right -->
        </div>
        <!-- End .container -->
    </div>
    <!-- End .header-middle -->
</header>
<!-- End .header -->
