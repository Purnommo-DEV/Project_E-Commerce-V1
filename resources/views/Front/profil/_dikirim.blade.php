<div class="tab-pane p-0 fade" id="dikirim-tab" role="tabpanel">
    <div class="product-group mb-lg-7 mb-4">
        <div class="col">
            @forelse ($pesanan_dikirim as $data_pesanan)
                {{-- @if ($data_pesanan->relasi_pesanan_status->status_pesanan_id == 5) --}}
                @php
                    $pesanan_detail = \App\Models\PesananDetail::with(['relasi_produk.relasi_gambar', 'relasi_produk_detail.relasi_produk.relasi_kategori'])
                        ->where('pesanan_id', $data_pesanan->id)
                        ->get();
                    $pesanan_status_log = \App\Models\PesananStatusLog::with('relasi_status_master')
                        ->where([
                            'pesanan_id' => $data_pesanan->id,
                            'status_pesanan_id' => 5,
                        ])
                        ->first();
                @endphp
                <div class="products d-flex flex-column justify-content-between bg-white mt-2 mb-2 mt-xl-0">
                    @foreach ($pesanan_detail as $data_pesanan_detail)
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
                                    href="#!">{{ $pesanan_status_log->relasi_status_master->status_pesanan }}
                                    pada {!! help_tanggal_jam($pesanan_status_log->created_at) !!}</a>
                            </h3>
                        </div>
                    </div>
                    <a class="btn btn-sm btn-primary btn-block mb-0 konfirmasi-pesanan-diterima"
                        pesanan-id="{{ $data_pesanan->id }}" href="#!">Pesanan Diterima</a>
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
@section('script')
    <script>
        $(document).on('click', '.konfirmasi-pesanan-diterima', function(event) {
            const id = $(event.currentTarget).attr('pesanan-id');
            Swal.fire({
                title: 'Yakin pesanan telah diterima?',
                icon: 'warning',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal',
                showCancelButton: true,
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: "{{ route('customer.KonfirmasiPesananDiterima') }}",
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            'req_pesanan_id': id,
                            'req_status_pesanan_id': 6 //Kode Status Selesai
                        },
                        success: function(response) {
                            if (response.konfirmasi_pesanan_berhasil == 1) {
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
                                    }),
                                    location.reload();
                            }
                        }
                    });
                } else {
                    Swal.fire(
                        "Cancel!",
                        "Your file has been cancel deleted.",
                        "failed"
                    )
                }
            });
        });
    </script>
@endsection
