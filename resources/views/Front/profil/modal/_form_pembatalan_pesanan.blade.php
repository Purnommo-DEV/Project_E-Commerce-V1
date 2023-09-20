<div class="modal fade" id="modal-batalkan-pesanan-{{ $data_pesanan->id }}" tabindex="-1"
    aria-labelledby="modal-batalkan-pesananLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-batalkan-pesananLabel">
                    Pembatalan Pesanan</h5>
                <button type="button" class="close batal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 3rem !important;">

                <form id="form-batalkan-pesanan-{{ $data_pesanan->id }}" enctype="multipart/form-data">

                    {{-- form-group Produk Detail  --}}
                    <div class="form-group">
                        <label style="margin-bottom: 1rem !important;">Produk
                            Pesanan</label>

                        @foreach ($pesanan_detail as $data_pesanan_detail)
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
                        @endforeach

                    </div>
                    {{-- form-group Gambar  --}}
                    <div class="form-group">
                        <label style="margin-bottom: 1rem !important;">Alasan Membatalkan</label>
                        <textarea name="catatan" class="form-control"></textarea>
                        <div class="input-group has-validation">
                            <label class="text-danger error-text catatan_error"
                                style="font-weight: bold; font-size: 1.2rem; padding-left: 0rem; padding-right: 2rem;"></label>
                        </div>
                    </div>
                    <!-- End .form-group Gambar -->
                    <div class="form-group">
                        <div class="row" style="padding:1rem;">
                            <div class="col p-1">
                                <button type="button" class="btn btn-sm btn-block btn-secondary batal"
                                    data-dismiss="modal">Batal</button>
                            </div>
                            <div class="col p-1">
                                <button class="btn btn-sm btn-block btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
