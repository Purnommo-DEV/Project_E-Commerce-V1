<div class="modal fade" id="modal-penilaian-produk-{{ $data_pesanan_detail->id }}" tabindex="-1"
    aria-labelledby="modal-penilaian-produkLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-penilaian-produkLabel">
                    Penilaian Produk</h5>
                <button type="button" class="close batal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 3rem !important;">

                <form id="form-beri-nilai-produk-pesanan-{{ $data_pesanan_detail->id }}" enctype="multipart/form-data">

                    {{-- form-group Produk Detail  --}}
                    <div class="form-group">
                        <label style="margin-bottom: 1rem !important;">Produk
                            Pesanan</label>
                        <div class="product d-flex flex-row overflow-hidden mb-0 p-0 shadow-none"
                            style="border-width: 3px;border-style:solid;border-color: #cfcfcf6b;">
                            <figure
                                class="mb-0 shadow-none product-media bg-white d-flex justify-content-center align-items-center"
                                style="min-width: 79px !important; width:15% !important;">
                                <a href="#!">
                                    <img src="{{ asset('storage/' . $data_pesanan_detail->relasi_produk->relasi_gambar->path) }}"
                                        alt="Product image" class="product-image" style="aspect-ratio: 1/1;" />
                                </a>
                            </figure>
                            <div class="product-body">
                                <div class="product-cat text-left">
                                    <a href="#">{{ $data_pesanan_detail->relasi_produk_detail->relasi_produk->relasi_kategori->nama_kategori }}
                                    </a>
                                </div>
                                <h3 class="product-title letter-spacing-normal font-size-normal text-left mb-0">
                                    <a
                                        href="#!">{{ $data_pesanan_detail->relasi_produk_detail->relasi_produk->nama_produk }}</a>
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
                                <div class="product-price mb-1 mt-1 text-dark">
                                    {!! help_format_rupiah($data_pesanan_detail->relasi_produk_detail->harga) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End .form-group Produk Detail -->

                    {{-- form-group Rating  --}}
                    <div class="form-group">
                        <label style="margin-bottom: 1rem !important;">Beri
                            Peringkat</label>
                        <div class="d-flex justify-content-center">
                            <div class="ratings-container" style="margin-bottom: 1rem !important;">
                                <div class="comment-form-rating">
                                    <p class="stars">
                                        <label for="rated-1{{ $data_pesanan_detail->id }}" class="icon-star-o"
                                            style="font-size: 30px;"></label>
                                        <input type="radio" id="rated-1{{ $data_pesanan_detail->id }}" name="rating"
                                            value="1">
                                        <label for="rated-2{{ $data_pesanan_detail->id }}" class="icon-star-o"
                                            style="font-size: 30px;"></label>
                                        <input type="radio" id="rated-2{{ $data_pesanan_detail->id }}" name="rating"
                                            value="2">
                                        <label for="rated-3{{ $data_pesanan_detail->id }}" class="icon-star-o"
                                            style="font-size: 30px;"></label>
                                        <input type="radio" id="rated-3{{ $data_pesanan_detail->id }}" name="rating"
                                            value="3">
                                        <label for="rated-4{{ $data_pesanan_detail->id }}" class="icon-star-o"
                                            style="font-size: 30px;"></label>
                                        <input type="radio" id="rated-4{{ $data_pesanan_detail->id }}" name="rating"
                                            value="4">
                                        <label for="rated-5{{ $data_pesanan_detail->id }}" class="icon-star-o"
                                            style="font-size: 30px;"></label>
                                        <input type="radio" id="rated-5{{ $data_pesanan_detail->id }}" name="rating"
                                            value="5" checked="checked">
                                    <div class="input-group has-validation">
                                        <label class="text-danger error-text rating_error"
                                            style="font-weight: bold; font-size: 1.2rem; padding-left: 6rem; padding-right: 2rem;"></label>
                                    </div>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End .form-group Rating -->

                    {{-- form-group Gambar  --}}
                    <div class="form-group">
                        <label style="margin-bottom: 1rem !important;">Upload Bukti
                            Produk</label>
                        <input type="file" name="path" class="form-control">
                        <div class="input-group has-validation">
                            <label class="text-danger error-text path_error"
                                style="font-weight: bold; font-size: 1.2rem; padding-left: 0rem; padding-right: 2rem;"></label>
                        </div>
                    </div>

                    <!-- End .form-group Gambar -->

                    {{-- form-group Gambar  --}}
                    <div class="form-group">
                        <label style="margin-bottom: 1rem !important;">Komentar</label>
                        <textarea name="komentar" class="form-control"></textarea>
                        <div class="input-group has-validation">
                            <label class="text-danger error-text komentar_error"
                                style="font-weight: bold; font-size: 1.2rem; padding-left: 0rem; padding-right: 2rem;"></label>
                        </div>
                    </div>
                    <!-- End .form-group Gambar -->

                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary batal"
                            data-dismiss="modal">Batal</button>
                        <button class="btn btn-sm btn-primary">Beri Nilai</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
