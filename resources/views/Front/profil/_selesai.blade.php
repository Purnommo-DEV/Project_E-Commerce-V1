<div class="tab-pane p-0 fade" id="selesai-tab" role="tabpanel">
    <div class="product-group mb-lg-7 mb-4">
        <div class="col">
            @forelse ($pesanan_selesai as $data_pesanan)
                {{-- @if ($data_pesanan->relasi_pesanan_status->status_pesanan_id == 6) --}}
                <div class="products d-flex flex-column justify-content-between bg-white mt-2 mb-2 mt-xl-0">
                    @php
                        $pesanan_detail = \App\Models\PesananDetail::with(['relasi_produk.relasi_gambar', 'relasi_produk_detail.relasi_produk.relasi_kategori'])
                            ->where('pesanan_id', $data_pesanan->id)
                            ->get();
                        $pesanan_status_log = \App\Models\PesananStatusLog::with('relasi_status_master')
                            ->where([
                                'pesanan_id' => $data_pesanan->id,
                                'status_pesanan_id' => 6,
                            ])
                            ->first();
                    @endphp
                    @foreach ($pesanan_detail as $data_pesanan_detail)
                        @php
                            $penilaian = \App\Models\Penilaian::where('pesanan_detail_id', $data_pesanan_detail->id)->first();
                        @endphp
                        <div class="product d-flex flex-row overflow-hidden mb-0 p-0 shadow-none">
                            <figure class="mb-0 product-media bg-white d-flex justify-content-center align-items-center"
                                style="width:15%;">
                                <a href="{{ route('HalamanDetailProduk', $data_pesanan_detail->relasi_produk->slug) }}">
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
                                @if (empty($penilaian))
                                    <div class="product-price" style="margin-bottom: 0rem !important;">
                                        <button type="button" class="btn btn-sm btn-primary mb-0 nilai-produk"
                                            href="#!" data-toggle="modal"
                                            data-target="#modal-penilaian-produk-{{ $data_pesanan_detail->id }}"
                                            style="font-size: 1.3rem !important; min-width: 10rem !important;"
                                            pesanan-detail-id="{{ $data_pesanan_detail->id }}">Nilai</button>
                                    </div>
                                    @include('Front.profil.modal._form_penilaian')
                                @else
                                    <button type="button" class="btn btn-sm btn-primary mb-0 nilai-produk"
                                        href="#!" data-toggle="modal"
                                        data-target="#modal-lihat-penilaian-produk-{{ $data_pesanan_detail->id }}"
                                        style="font-size: 1.3rem !important; min-width: 10rem !important;"
                                        pesanan-detail-id="{{ $data_pesanan_detail->id }}">
                                        Lihat Penilaian
                                    </button>
                                    @include('Front.profil.modal._lihat_penilaian')
                                @endif
                            </div>
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
                                <a id="btn-product-gallery" style="color:black; font-weight:500;"
                                    href="#!">Konfirmasi
                                    produk diterima pada {!! help_tanggal_jam($pesanan_status_log->created_at) !!}</a>
                            </h3>
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
        $(document).on('click', '.nilai-produk', function(event) {
            const id = $(event.currentTarget).attr('pesanan-detail-id');
            $('#form-beri-nilai-produk-pesanan-' + id).on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                // Gabung atau selipkan data lainnya
                formData.append('pesanan_detail_id', id);

                $.ajax({
                    url: "{{ route('customer.BeriPenilaianProdukPesanan') }}",
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
                        } else if (response.beri_penilaian_berhasil == 1) {
                            $('#modal-penilaian-produk-' + id).modal('hide');
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
                            $('#form-beri-nilai-produk-pesanan-' + id).trigger("reset");
                            $("#tab-content-header-body").load(location.href +
                                " #tab-content-header-body>*", "");
                        }
                    }
                });
            });
        });
    </script>
@endpush
