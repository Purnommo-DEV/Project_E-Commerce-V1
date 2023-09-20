@extends('Front.layout.master', ['title' => 'Kategori Produk'])
@section('konten')
    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="toolbox">
                        <div class="toolbox-left">
                            <div class="toolbox-info">
                                Showing <span>9 of 56</span> Products
                            </div><!-- End .toolbox-info -->
                        </div><!-- End .toolbox-left -->

                        <div class="toolbox-right">
                            <form name="urutanProduk" id="urutanProduk" method="get"
                                action="{{ route('KategoriDetail', $kategori->slug) }}">
                                <div class="toolbox-sort">
                                    <label for="sortby">Urutkan Berdasarkan :</label>
                                    <div class="select-custom">
                                        <select name="urutan" id="urutan" class="form-control">
                                            <option value="">Pilih</option>
                                            <option value="produk_terbaru"
                                                @if (isset($_GET['urutan']) && $_GET['urutan'] == '') selected="" @endif>Semua</option>
                                            <option value="produk_terbaru"
                                                @if (isset($_GET['urutan']) && $_GET['urutan'] == 'produk_terbaru') selected="" @endif>Produk Terbaru</option>
                                            <option value="produk_a_z" @if (isset($_GET['urutan']) && $_GET['urutan'] == 'produk_a_z') selected="" @endif>
                                                Produk A-Z</option>
                                            <option value="produk_harga_rendah"
                                                @if (isset($_GET['urutan']) && $_GET['urutan'] == 'produk_harga_rendah') selected="" @endif>Produk Harga Terendah
                                            </option>
                                            <option
                                                value="produk_harga_tinggi"@if (isset($_GET['urutan']) && $_GET['urutan'] == 'produk_harga_tinggi') selected="" @endif>
                                                Produk Harga Tertinggi</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div><!-- End .toolbox-right -->
                    </div><!-- End .toolbox -->

                    <div class="products mb-3" id="daftar-produk">
                        @include('Front.kategori_detail.daftar_produk_kategori')
                    </div>

                    {{-- <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link page-link-prev" href="#" aria-label="Previous" tabindex="-1"
                                    aria-disabled="true">
                                    <span aria-hidden="true"><i class="icon-long-arrow-left"></i></span>Prev
                                </a>
                            </li>
                            <li class="page-item active" aria-current="page"><a class="page-link" href="#">1</a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item-total">of 6</li>
                            <li class="page-item">
                                <a class="page-link page-link-next" href="#" aria-label="Next">
                                    Next <span aria-hidden="true"><i class="icon-long-arrow-right"></i></span>
                                </a>
                            </li>
                        </ul>
                    </nav> --}}
                </div><!-- End .col-lg-9 -->
                <aside class="col-lg-3 order-lg-first">
                    <div class="sidebar sidebar-shop">
                        <div class="widget widget-clean">
                            <label>Filters:</label>
                            <a href="#" class="sidebar-filter-clear">Clean All</a>
                        </div><!-- End .widget widget-clean -->

                        <div class="widget widget-collapsible">
                            <h3 class="widget-title">Customer Rating</h3><!-- End .widget-title -->

                            <div class="collapse show" id="widget-1">
                                <div class="widget-body">
                                    <div class="filter-items">

                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="cus-rating-1">
                                                <label class="custom-control-label" for="cus-rating-1">
                                                    <span class="ratings-container">
                                                        <span class="ratings">
                                                            <span class="ratings-val"
                                                                style="width: 100%;"></span><!-- End .ratings-val -->
                                                        </span><!-- End .ratings -->
                                                        <span class="ratings-text">( 24 )</span>
                                                    </span><!-- End .rating-container -->
                                                </label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .filter-item -->

                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="cus-rating-2">
                                                <label class="custom-control-label" for="cus-rating-2">
                                                    <span class="ratings-container">
                                                        <span class="ratings">
                                                            <span class="ratings-val"
                                                                style="width: 80%;"></span><!-- End .ratings-val -->
                                                        </span><!-- End .ratings -->
                                                        <span class="ratings-text">( 8 )</span>
                                                    </span><!-- End .rating-container -->
                                                </label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .filter-item -->

                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="cus-rating-3">
                                                <label class="custom-control-label" for="cus-rating-3">
                                                    <span class="ratings-container">
                                                        <span class="ratings">
                                                            <span class="ratings-val"
                                                                style="width: 60%;"></span><!-- End .ratings-val -->
                                                        </span><!-- End .ratings -->
                                                        <span class="ratings-text">( 5 )</span>
                                                    </span><!-- End .rating-container -->
                                                </label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .filter-item -->

                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="cus-rating-4">
                                                <label class="custom-control-label" for="cus-rating-4">
                                                    <span class="ratings-container">
                                                        <span class="ratings">
                                                            <span class="ratings-val"
                                                                style="width: 40%;"></span><!-- End .ratings-val -->
                                                        </span><!-- End .ratings -->
                                                        <span class="ratings-text">( 1 )</span>
                                                    </span><!-- End .rating-container -->
                                                </label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .filter-item -->

                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="cus-rating-5">
                                                <label class="custom-control-label" for="cus-rating-5">
                                                    <span class="ratings-container">
                                                        <span class="ratings">
                                                            <span class="ratings-val"
                                                                style="width: 20%;"></span><!-- End .ratings-val -->
                                                        </span><!-- End .ratings -->
                                                        <span class="ratings-text">( 3 )</span>
                                                    </span><!-- End .rating-container -->
                                                </label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .filter-item -->

                                    </div><!-- End .filter-items -->
                                </div><!-- End .widget-body -->
                            </div><!-- End .collapse -->
                        </div><!-- End .widget -->

                        <div class="widget widget-collapsible">
                            <h3 class="widget-title">
                                <a data-toggle="collapse" href="#widget-5" role="button" aria-expanded="true"
                                    aria-controls="widget-5">
                                    Price
                                </a>
                            </h3><!-- End .widget-title -->

                            <div class="collapse show" id="widget-5">
                                <div class="widget-body">
                                    <div class="filter-price">
                                        <div class="filter-price-text">
                                            Price Range:
                                            <span id="filter-price-range"></span>
                                        </div><!-- End .filter-price-text -->

                                        <div id="price-slider"></div><!-- End #price-slider -->
                                    </div><!-- End .filter-price -->
                                </div><!-- End .widget-body -->
                            </div><!-- End .collapse -->
                        </div><!-- End .widget -->
                    </div><!-- End .sidebar sidebar-shop -->
                </aside><!-- End .col-lg-3 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .page-content -->
@endsection
@section('script')
    <script>
        $("#urutan").on('change', function() {
            var urutan = $(this).val();
            $.ajax({
                method: "get",
                dataType: 'html',
                url: "{{ route('FilterUrtukan') }}",
                data: {
                    urutan: urutan
                },
                success: function(data) {
                    $('#daftar-produk').html(data);
                }
            })
        });
    </script>
@endsection
