<div class="tab-pane p-0 fade" id="dibatalkan-tab" role="tabpanel">
    <div class="product-group mb-lg-7 mb-4">
        <div class="col">
            @foreach ($pesanan as $data_pesanan)
                @if (
                    $data_pesanan->relasi_pesanan_status->status_pesanan_id == 7 ||
                        $data_pesanan->relasi_pesanan_status->status_pesanan_id == 8 ||
                        $data_pesanan->relasi_pesanan_status->status_pesanan_id == 9)
                    <div class="products d-flex flex-column justify-content-between bg-white mt-2 mb-2 mt-xl-0">
                        @php
                            $pesanan_detail = \App\Models\PesananDetail::with(['relasi_produk.relasi_gambar', 'relasi_produk_detail.relasi_produk.relasi_kategori'])
                                ->where('pesanan_id', $data_pesanan->id)
                                ->get();
                            $pesanan_status_log = \App\Models\PesananStatusLog::where('pesanan_id', $data_pesanan->id)->first();
                        @endphp
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
                                <!-- End .product-media bg-white d-flex justify-content-center align-items-center -->

                                <div class="product-body">
                                    <div class="product-cat text-left">
                                        <a href="#!">{{ $data_pesanan_detail->relasi_produk_detail->relasi_produk->relasi_kategori->nama_kategori }}
                                        </a>
                                    </div>
                                    <!-- End .product-cat  -->
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
                                    <!-- End .product-title letter-spacing-normal font-size-normal -->
                                    <div class="product-price mb-1 mt-1 text-dark">{!! help_format_rupiah($data_pesanan_detail->relasi_produk_detail->harga) !!}
                                    </div>
                                </div>
                                <!-- End .product-body -->
                            </div>
                        @endforeach
                        <div class="p-1 w-100" style="background-color:#d9d9d9!important; padding: 0.01rem!important;">
                        </div>
                        <div class="d-flex bd-highlight">
                            <div class="mt-1 mb-1 bd-highlight">
                                <h3 class="font-size-normal text-left mb-0"
                                    style="padding-left: 1rem; color:black; font-size: 1.3rem;">
                                    {{ $data_pesanan->relasi_pesanan_status->relasi_status_master->status_pesanan }}
                                </h3>
                            </div>
                        </div>
                        <div class="p-1 w-100" style="background-color:#d9d9d9!important; padding: 0.01rem!important;">
                        </div>
                        <div class="d-flex align-items-start flex-column bd-highlight">
                            <div class="mb-1 bd-highlight"><a href="#!"
                                    style="padding-left: 1rem; color:black; font-weight: 400;font-size: 1.3rem;">Alasan
                                    Pembatalan :
                                    {{ $pesanan_status_log->catatan }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
