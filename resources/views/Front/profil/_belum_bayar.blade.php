<div class="tab-pane p-0 fade show active" id="belum-bayar-tab" role="tabpanel">
    <div class="product-group mb-lg-7 mb-4">
        <div class="col">
            @forelse ($pesanan_belum_bayar as $data_pesanan)
                {{-- @if ($data_pesanan->relasi_pesanan_status->status_pesanan_id == 1) --}}
                <div class="products d-flex flex-column justify-content-between bg-white mt-2 mb-2 mt-xl-0">
                    @php
                        $pesanan_detail = \App\Models\PesananDetail::with(['relasi_produk.relasi_gambar', 'relasi_produk_detail.relasi_produk.relasi_kategori'])
                            ->where('pesanan_id', $data_pesanan->id)
                            ->get();
                    @endphp
                    @foreach ($pesanan_detail as $data_pesanan_detail)
                        <div class="product d-flex flex-row overflow-hidden mb-0 p-0 shadow-none">
                            <figure class="mb-0 product-media bg-white d-flex justify-content-center align-items-center"
                                style="width:15%;">
                                <a href="{{ route('HalamanDetailProduk', $data_pesanan_detail->relasi_produk->slug) }}">
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
                                        <a
                                            href="{{ route('HalamanDetailProduk', $data_pesanan_detail->relasi_produk->slug) }}">Variasi
                                            :
                                            {{ $data_pesanan_detail->relasi_produk_detail->produk_variasi }}</a>
                                    </h3>
                                @endif
                                <h3 class="product-title letter-spacing-normal font-size-normal text-left mb-0">
                                    <a
                                        href="{{ route('HalamanDetailProduk', $data_pesanan_detail->relasi_produk->slug) }}">x
                                        {{ $data_pesanan_detail->kuantitas }}</a>
                                </h3>
                                <!-- End .product-title letter-spacing-normal font-size-normal -->
                                <div class="product-price mb-1 mt-1 text-dark">{!! help_format_rupiah($data_pesanan_detail->relasi_produk_detail->harga) !!}
                                </div>
                            </div>
                            <!-- End .product-body -->
                        </div>
                        <div class="p-1 w-100" style="background-color:#d9d9d9!important; padding: 0.01rem!important;">
                        </div>
                    @endforeach

                    <div class="p-1 w-100" style="background-color:#d9d9d9!important; padding: 0.01rem!important;">
                    </div>
                    <div class="d-flex bd-highlight">
                        <div class="mt-1 mb-1 bd-highlight">
                            <h3 class="font-size-normal text-left mb-0"
                                style="padding-left: 1rem; color:black; font-size: 1.3rem;">
                                Jumlah harus dibayar :
                                <b style="color:#0078b1;">{!! help_format_rupiah($data_pesanan->total_pembayaran) !!}</b> (
                                {{ $pesanan_detail->count() }} Produk)
                            </h3>
                        </div>
                    </div>
                    <div class="p-1 w-100" style="background-color:#d9d9d9!important; padding: 0.01rem!important;">
                    </div>
                    <div class="d-flex align-items-start flex-column bd-highlight">
                        <div class="mt-1 mb-1 bd-highlight"><a href="#!"
                                style="padding-left: 1rem; color:black; font-weight: 400; font-size: 1rem;"> Bayar
                                Sebelum
                                {!! help_tanggal_jam($data_pesanan->expired_date) !!}
                            </a>
                        </div>
                    </div>
                    <div class="row" style="padding:1rem;">
                        <div class="col p-1">
                            <a class="btn btn-sm btn-primary btn-block mb-0"
                                href="{{ route('customer.HalamanBayarPesanan', $data_pesanan->id) }}">Bayar
                                Sekarang</a>
                        </div>
                        <div class="col p-1">
                            <a class="btn btn-sm btn-danger btn-block mb-0 btn-batalkan-pesanan" href="#!"
                                pesanan-id="{{ $data_pesanan->id }}">Batalkan
                                Pesanan
                            </a>
                            @include('Front.profil.modal._form_pembatalan_pesanan')
                        </div>
                    </div>
                </div>
                {{-- @endif --}}
            @empty
                <div class="element mb-2" style="border: none;">
                    <img src="{{ asset('Front/assets/images/empty-order.png') }}" alt=""
                        style="max-width: 15%;">
                    <h6>Belum memiliki Pesanan</h6>
                </div>
            @endforelse
        </div>
    </div>
</div>
@push('script')
    <script>
        $('.batal').on('click', function() {
            $(document).find('label.error-text').text('');
        })
        $(document).on('click', '.btn-batalkan-pesanan', function(event) {
            const id = $(event.currentTarget).attr('pesanan-id');
            $('#modal-batalkan-pesanan-' + id).modal('show');

            $('#form-batalkan-pesanan-' + id).on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                // Gabung atau selipkan data lainnya
                formData.append('pesanan_id', id);

                $.ajax({
                    url: "{{ route('customer.BatalkanPesananOlehPelanggan') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $(document).find('label.error-text').text('');
                    },
                    success: function(response) {
                        if (response.status_form_kosong == 1) {
                            $.each(response.error, function(prefix, val) {
                                $('label.' + prefix + '_error').text(val[0]);
                                // $('span.'+prefix+'_error').text(val[0]);
                            });
                        } else if (response.pembatalan_pesanan_oleh_pengguna == 1) {
                            $('#modal-batalkan-pesanan-' + id).modal('hide');
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
                                title: response.msg
                            })
                            $('#modal-batalkan-pesanan-' + id).trigger("reset");
                            $("#tab-content-header-body").load(location.href +
                                " #tab-content-header-body>*", "");
                        }
                    }
                });
            });
        });
    </script>
@endpush
