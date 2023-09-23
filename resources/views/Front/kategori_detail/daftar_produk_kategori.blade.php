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
                            class="product-image"
                            style="aspect-ratio: 5/4; padding: 0rem !important; object-fit: cover;">
                        <img src="{{ asset('storage/' . $gambar_produk_last->path) }}" alt="Product image"
                            class="product-image-hover"
                            style="aspect-ratio: 5/4; padding: 0rem !important; object-fit: cover;">
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
                        <a href="{{ route('HalamanDetailProduk', $data_produk->slug) }}">{!! help_limit_karakter($data_produk->nama_produk) !!}</a>
                    </h3>
                </div>
                <div class="product-action position-relative visible">
                    <div class="ratings-container">
                        @if (App\Models\Penilaian::with('relasi_pesanan_detail')->whereRelation('relasi_pesanan_detail', 'produk_id', $data_produk->id)->first())
                            @php
                                $statusPenilaianProduk = App\Models\Penilaian::with('relasi_pesanan_detail')
                                    ->whereRelation('relasi_pesanan_detail', 'produk_id', $data_produk->id)
                                    ->get();
                                $rating = App\Models\Penilaian::with('relasi_pesanan_detail')
                                    ->whereRelation('relasi_pesanan_detail', 'produk_id', $data_produk->id)
                                    ->avg('rating');
                                $avgRating = number_format($rating, 1);
                            @endphp
                            <div class="new-price"
                                style="display: inline-block; font-size: 1.7rem; letter-spacing: 0rem; line-height: 1;">
                                <?php $star = 1;
                                while($star <= $avgRating){ ?>
                                <label for="rating2" class="icon-star" style="color:orange;"></label>
                                <?php $star++; } ?>


                                <span class="ratings-text ml-2"
                                    style="color:chocolate; font-size:1.3rem;">({{ $avgRating }})</span>
                                {{-- <label class="ratings-text"
                                style="color:chocolate">({{ count($statusPenilaianProduk) }})
                                Review</label> --}}
                            </div>
                        @else
                            {{-- <label class="text-danger">Belum Ada Review</label> --}}
                        @endif
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
</div><!-- End .row -->
