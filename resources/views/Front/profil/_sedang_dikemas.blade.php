<div class="tab-pane p-0 fade" id="sedang-dikemas-tab" role="tabpanel">
    <div class="product-group mb-lg-7 mb-4">
        <div class="col">
            @forelse ($pesanan as $data_pesanan)
                @if ($data_pesanan->relasi_pesanan_status->status_pesanan_id == 4)
                    @php
                        $pesanan_detail = \App\Models\PesananDetail::with(['relasi_produk.relasi_gambar', 'relasi_produk_detail.relasi_produk.relasi_kategori'])
                            ->where('pesanan_id', $data_pesanan->id)
                            ->get();
                        $pesanan_status_log = \App\Models\PesananStatusLog::with('relasi_status_master')
                            ->where([
                                'pesanan_id' => $data_pesanan->id,
                                'status_pesanan_id' => 4,
                            ])
                            ->first();
                    @endphp
                    <div class="products d-flex flex-column justify-content-between bg-white mt-2 mb-2 mt-xl-0">
                        @foreach ($pesanan_detail as $data_pesanan_detail)
                            <div class="product d-flex flex-row overflow-hidden mb-0 p-0 shadow-none">
                                <figure
                                    class="mb-0 product-media bg-white d-flex justify-content-center align-items-center"
                                    style="width:15%;">
                                    <a
                                        href="{{ route('HalamanDetailProduk', $data_pesanan_detail->relasi_produk->slug) }}">
                                        <img src="{{ asset('storage/' . $data_pesanan_detail->relasi_produk->relasi_gambar->path) }}"
                                            alt="Product image" class="product-image" style="aspect-ratio: 1/1;" />
                                    </a>
                                </figure>
                                <div class="product-body">
                                    <div class="product-cat text-left">
                                        <a href="#!">{{ $data_pesanan_detail->relasi_produk_detail->relasi_produk->relasi_kategori->nama_kategori }}
                                        </a>
                                    </div>
                                    <h3 class="product-title letter-spacing-normal font-size-normal text-left mb-0">
                                        <a
                                            href="{{ route('HalamanDetailProduk', $data_pesanan_detail->relasi_produk->slug) }}">{{ $data_pesanan_detail->relasi_produk_detail->relasi_produk->nama_produk }}</a>
                                    </h3>
                                    @if ($data_pesanan_detail->relasi_produk->produk_tipe_id == 2)
                                        <h3 class="product-title letter-spacing-normal font-size-normal text-left mb-0">
                                            <a href="#!">Variasi :
                                                {{ $data_pesanan_detail->relasi_produk_detail->produk_variasi }}</a>
                                        </h3>
                                    @endif
                                    <h3 class="product-title letter-spacing-normal font-size-normal text-left mb-0">
                                        <a href="#!">x
                                            {{ $data_pesanan_detail->kuantitas }}</a>
                                    </h3>
                                    <div class="product-price mb-1 mt-1 text-dark">{!! help_format_rupiah($data_pesanan_detail->relasi_produk_detail->harga) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="p-1 w-100"
                                style="background-color:#d9d9d9!important; padding: 0.01rem!important;">
                            </div>
                        @endforeach
                        <div class="p-1 w-100" style="background-color:#d9d9d9!important; padding: 0.01rem!important;">
                        </div>
                        <div class="d-flex bd-highlight">
                            <div class="mt-1 mb-1 bd-highlight">
                                <h3 class="font-size-normal text-left mb-0"
                                    style="padding-left: 1rem; color:black; font-size: 1.3rem;">
                                    <a id="btn-product-gallery" style="color:black; font-weight:500;"
                                        href="#!">{{ $pesanan_status_log->relasi_status_master->status_pesanan }}
                                        pada {!! help_tanggal_jam($pesanan_status_log->created_at) !!}</a>
                                </h3>
                            </div>
                        </div>

                        <div id="product-zoom-gallery" class="product-image-gallery" style="display: none">
                            <img class="product-image object-fit-fill border rounded"
                                style="aspect-ratio: 1/1; width:50%" id="product-zoom"
                                src="{{ asset('storage/' . $data_pesanan->bukti_pembayaran) }}"
                                data-zoom-image="{{ asset('storage/' . $data_pesanan->bukti_pembayaran) }}"
                                alt="product image">
                            <a class="product-gallery-item" href="#"
                                data-image="{{ asset('storage/' . $data_pesanan->bukti_pembayaran) }}"
                                data-zoom-image="{{ asset('storage/' . $data_pesanan->bukti_pembayaran) }}">
                            </a>
                        </div>
                    </div>
                @endif
            @empty
            @endforelse
        </div>
    </div>
</div>
