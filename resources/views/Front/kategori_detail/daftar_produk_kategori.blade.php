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
        <div class="col-6 col-md-4 col-lg-4 col-xl-3">
            <div class="product product-7">
                <figure class="product-media">
                    <a href="{{ route('HalamanDetailProduk', $data_produk->slug) }}" class="w-100">
                        <img src="{{ asset('storage/' . $gambar_produk_first->path) }}" alt="Product image"
                            class="product-image" style="aspect-ratio: 5/4;">
                        <img src="{{ asset('storage/' . $gambar_produk_last->path) }}" alt="Product image"
                            class="product-image-hover" style="aspect-ratio: 5/4;">
                    </a>
                </figure><!-- End .product-media -->

                <div class="product-body">
                    <div class="text-left product-cat font-weight-normal text-light mb-0">
                        <a href="#">{{ $data_produk->relasi_kategori->nama_kategori }}</a>
                    </div>
                    <h3 class="product-title letter-spacing-normal font-size-normal text-left mb-0">
                        <a href="{{ route('HalamanDetailProduk', $data_produk->slug) }}">{!! help_limit_karakter($data_produk->nama_produk) !!}</a>
                    </h3>
                </div><!-- End .product-body -->
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
            </div><!-- End .product -->
        </div><!-- End .col-sm-6 col-lg-4 col-xl-3 -->
    @endforeach
</div><!-- End .row -->
