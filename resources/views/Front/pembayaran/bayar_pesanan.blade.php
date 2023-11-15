@extends('Front.layout.master', ['title' => 'Bayar Pesanan'])
@section('konten')
    <div class="page-content">
        <div class="container">
            {{-- <table class="table"> --}}
            <div class="row">
                <div class="col-md-6">
                    <div id="div-status-pesanan">
                        <table class="table table-bordered"
                            style="border: 2px aliceblue; border-color:black; font-weight: 400; color: black; border-radius: 15px; background: #f9f9f9; overflow: hidden;">
                            <tbody>
                                <tr>
                                    <th colspan="4" style="background: #a97c50; padding-left: 0.6rem; padding-right: 1rem">
                                        <strong style="color: white; weight">Pesanan
                                            Detail</strong>
                                    </th>
                                </tr>
                                <tr>
                                    <td style="font-weight: 800; padding-top:3%; padding-bottom:3%; padding-left: 0.6rem; padding-right: 1rem;"
                                        rowspan="4">Pemesanan</td>
                                    <td
                                        style="padding-top:3%; padding-bottom:3%; padding-left: 0.6rem; padding-right: 1rem;">
                                        Tanggal</td>
                                    <td
                                        style="padding-top:3%; padding-bottom:3%; padding-left: 0.6rem; padding-right: 1rem;">
                                        {!! help_tanggal_jam($pesanan->orders_date) !!}</td>
                                </tr>
                                <tr>
                                    <td
                                        style="padding-top:3%; padding-bottom:3%; padding-left: 0.6rem; padding-right: 1rem;">
                                        Kode Pesanan</td>
                                    <td
                                        style="padding-top:3%; padding-bottom:3%; padding-left: 0.6rem; padding-right: 1rem;">
                                        {{ $pesanan->kode_pesanan }}</td>
                                </tr>
                                <tr>
                                    <td
                                        style="padding-top:3%; padding-bottom:3%; padding-left: 0.6rem; padding-right: 1rem;">
                                        Total</td>
                                    <td
                                        style="padding-top:3%; padding-bottom:3%; padding-left: 0.6rem; padding-right: 1rem;">
                                        <strong>@currency($pesanan->total_pembayaran)</strong><br>
                                        ( Termasuk Ongkir : @currency($pesanan->total_ongkir) )
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        style="padding-top:3%; padding-bottom:3%; padding-left: 0.6rem; padding-right: 1rem;">
                                        Berat</td>
                                    <td
                                        style="padding-top:3%; padding-bottom:3%; padding-left: 0.6rem; padding-right: 1rem;">
                                        {{ $pesanan->total_berat }}(g)</td>
                                </tr>
                                <tr>
                                    <td
                                        style="font-weight: 800; padding-top:3%; padding-bottom:3%; padding-left: 0.6rem; padding-right: 1rem;">
                                        Penerima dan Alamat Pengiriman</td>
                                    <td
                                        colspan="2"style="padding-top:3%; padding-bottom:3%; padding-left: 0.6rem; padding-right: 1rem;">
                                        {{ $pesanan->relasi_alamat_pengiriman->nama }}<br>
                                        {{ $pesanan->relasi_alamat_pengiriman->alamat }},
                                        {{ $pesanan->relasi_alamat_pengiriman->relasi_provinsi->name }},
                                        {{ $pesanan->relasi_alamat_pengiriman->relasi_kota->name }}</td>

                                </tr>
                                <tr>
                                    <td style="font-weight: 800; padding-top:3%; padding-bottom:3%; padding-left: 0.6rem; padding-right: 1rem;"
                                        rowspan="2">Pengiriman</td>
                                    <td
                                        style="padding-top:3%; padding-bottom:3%; padding-left: 0.6rem; padding-right: 1rem;">
                                        Ekspedisi</td>
                                    <td
                                        style="padding-top:3%; padding-bottom:3%; padding-left: 0.6rem; padding-right: 1rem;">
                                        <span id="ekspedisi"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        style="padding-top:3%; padding-bottom:3%; padding-left: 0.6rem; padding-right: 1rem;">
                                        Layanan</td>
                                    <td
                                        style="padding-top:3%; padding-bottom:3%; padding-left: 0.6rem; padding-right: 1rem;">
                                        <span id="layanan"></span>
                                    </td>
                                </tr>


                                <tr>
                                    <td style="font-weight: 800; padding-top:3%; padding-bottom:3%; padding-left: 0.6rem; padding-right: 1rem;"
                                        rowspan="@if ($pesanan_status->status_pesanan_id == 1) 3 @else 2 @endif)">Status Pesanan dan
                                        Bukti Pembayaran</td>
                                    <td style="padding-top:3%; padding-bottom:3%; padding-left: 0.6rem; padding-right: 1rem;"
                                        colspan="2">{{ $pesanan_status->relasi_status_master->status_pesanan }}
                                    </td>

                                </tr>
                                @if ($pesanan_status->status_pesanan_id == 1)
                                    <tr>
                                        <td
                                            style="padding-top:3%; padding-bottom:3%; padding-left: 0.6rem; padding-right: 1rem;">
                                            Jatuh Tempo</td>
                                        <td
                                            style="padding-top:3%; padding-bottom:3%; padding-left: 0.6rem; padding-right: 1rem;">
                                            <span style="color: red; font-weight:bold;">{!! help_tanggal_jam($pesanan->expired_date) !!}</span>
                                        </td>
                                    </tr>
                                @endif
                                @if ($pesanan_status->status_pesanan_id == 1)
                                    <tr>
                                        <td style="padding-top:3%; padding-bottom:3%; padding-left: 0.6rem; padding-right: 1rem;"
                                            colspan="2">
                                            {{-- <a href="#!" data-toggle="modal"
                                                data-target="#modal-upload-bukti-bayar"
                                                class="btn btn-outline-primary btn-sm"
                                                style="color: #0078b1; border-color:#0078b1; font-size: 1rem;">Upload Bukti
                                                Pembayaran</a> --}}
                                            <button class="btn btn-outline-primary btn-sm"
                                                style="color: #0078b1; border-color:#0078b1; font-size: 1rem;"
                                                id="pay-button">Bayar Sekarang</button>
                                        </td>

                                    </tr>
                                @else
                                    <tr>
                                        <td style="padding-top:3%; padding-bottom:3%; padding-left: 0.6rem; padding-right: 1rem;"
                                            colspan="2">
                                            <div class="product-gallery">
                                                <div class="row">
                                                    <figure class="product-main-image">
                                                        <a href="#!" id="btn-product-gallery"
                                                            class="btn-product-gallery"
                                                            style="left: 2rem; right:none !important">
                                                            <i class="icon-arrows"></i>
                                                        </a>

                                                        <div id="product-zoom-gallery" class="product-image-gallery">
                                                            <img class="product-image object-fit-fill border rounded"
                                                                style="aspect-ratio: 1/1; width:50%" id="product-zoom"
                                                                src="{{ asset('storage/' . $pesanan->bukti_pembayaran) }}"
                                                                data-zoom-image="{{ asset('storage/' . $pesanan->bukti_pembayaran) }}"
                                                                alt="product image">
                                                        </div>
                                                    </figure>
                                                    <div id="product-zoom-gallery" class="product-image-gallery">
                                                        <a class="product-gallery-item" href="#"
                                                            data-image="{{ asset('storage/' . $pesanan->bukti_pembayaran) }}"
                                                            data-zoom-image="{{ asset('storage/' . $pesanan->bukti_pembayaran) }}">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div><!-- End .col-6 -->

                <div class="modal fade" id="modal-upload-bukti-bayar" tabindex="-1"
                    aria-labelledby="modal-upload-bukti-bayarLabel" aria-hidden="true">
                    <div class="modal-dialog">

                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modal-upload-bukti-bayarLabel">Pembayaran dengan Transfer Bank
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('customer.UploadBuktiPembayaran', $pesanan->id) }}" method="POST"
                                style="padding: 2rem;" enctype="multipart/form-data" id="form-upload-bukti-pembayaran">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col col-12">
                                            <div class="form-group">

                                                <label for="singin-password-2">Nama Bank : BCA <br>Nomor Rekening :
                                                    232323232 (Nama
                                                    Admin)</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="singin-password-2">Upload Bukti Transver</label>
                                                <input type="file" accept="image/*" name="bukti_pembayaran"
                                                    class="form-control">
                                                <div class="input-group has-validation">
                                                    <label class="text-danger error-text bukti_pembayaran_error"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-sm btn-secondary"
                                        data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                                </div>
                            </form>

                        </div>

                    </div>
                </div>


                <div class="modal fade" id="modal-lihat-bukti-bayar" tabindex="-1"
                    aria-labelledby="modal-lihat-bukti-bayarLabel" aria-hidden="true">
                    <div class="modal-dialog">

                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modal-lihat-bukti-bayarLabel">Pembayaran dengan Transfer Bank
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col col-12">
                                        <div class="form-group">
                                            <label for="singin-password-2">Gambar Bukti Pembayaran</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-secondary"
                                    data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-md-6">
                    <table class="table table-bordered"
                        style="border: 2px aliceblue; border-color:black;font-weight: 400; color: black;border-radius: 15px; background: #f9f9f9; overflow: hidden;">
                        <thead>
                            <tr>
                                <th colspan="5" style="background: #a97c50; padding-left: 0.6rem; padding-right: 1rem">
                                    <strong style="color: white">Produk
                                        Pesanan</strong>
                                </th>
                            </tr>
                            <tr>
                                <th style="padding-left: 0.6rem; padding-right: 1rem"><strong>Gambar</strong></th>
                                <th style="padding-left: 0.6rem; padding-right: 1rem"><strong>Nama Produk</strong>
                                </th>
                                <th style="padding-left: 0.6rem; padding-right: 1rem"><strong>Harga</strong></th>
                                <th style="padding-left: 0.6rem; padding-right: 1rem"><strong>Kuantitas</strong>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pesanan_detail as $pesanan_detail)
                                @if ($pesanan_detail->pesanan_id == $pesanan->id)
                                    <tr>
                                        <td
                                            style="padding-top:3%; padding-bottom:3%; padding-left: 0.6rem; padding-right: 1rem;">
                                            <img src="{{ asset('storage/' . $pesanan_detail->relasi_produk->relasi_gambar->path) }}"
                                                width="100" class="object-fit-fill border rounded"
                                                style="display: initial; aspect-ratio: 4/3;">
                                        </td>
                                        <td
                                            style="padding-top:3%; padding-bottom:3%; padding-left: 0.6rem; padding-right: 1rem;">
                                            {{ $pesanan_detail->relasi_produk->nama_produk }}
                                            @if ($pesanan_detail->relasi_produk->produk_tipe_id == 2)
                                                (Variasi : {{ $pesanan_detail->relasi_produk_detail->produk_variasi }})
                                            @endif
                                        </td>
                                        <td
                                            style="padding-top:3%; padding-bottom:3%; padding-left: 0.6rem; padding-right: 1rem;">
                                            @currency($pesanan_detail->relasi_produk_detail->harga)</td>
                                        <td
                                            style="padding-top:3%; padding-bottom:3%; padding-left: 0.6rem; padding-right: 1rem;">
                                            {{ $pesanan_detail->kuantitas }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- End .col-6 -->
            </div>
            {{-- </table> --}}
        </div>
    </div><!-- End .container -->
    </div><!-- End .page-content -->
@endsection
@section('script')
    <script>
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function() {
            window.snap.pay('{{ $snap_token }}', {
                onSuccess: function(result) {
                    /* You may add your own implementation here */
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
                        title: "Pembayaran Berhasil"
                    })
                    window.location.href = "{{ route('customer.HalamanProfil') }}";
                    console.log(result);
                },
                onPending: function(result) {
                    /* You may add your own implementation here */
                    alert("wating your payment!");
                    console.log(result);
                },
                onError: function(result) {
                    /* You may add your own implementation here */
                    alert("payment failed!");
                    console.log(result);
                },
                onClose: function() {
                    /* You may add your own implementation here */
                    alert('you closed the popup without finishing the payment');
                }
            })
        });

        var ekspedisi_layanan = @json($pesanan->ekspedisi_layanan);

        $('#ekspedisi').html(ekspedisi_layanan.split("_")[0])
        $('#layanan').html(ekspedisi_layanan.split("_").pop())

        $('#form-upload-bukti-pembayaran').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: new FormData(this),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {
                    $(document).find('label.error-text').text('');
                },
                success: function(data) {
                    if (data.status_form_kosong == 1) {
                        $.each(data.error, function(prefix, val) {
                            $('label.' + prefix + '_error').text(val[0]);
                            // $('span.'+prefix+'_error').text(val[0]);
                        });
                    } else if (data.status_upload_berhasil == 1) {
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
                            title: data.msg
                        })

                        // $("#div-status-pesanan").load(location.href +
                        // " #div-status-pesanan>*", "");

                        location.reload();

                        $("#form-upload-bukti-pembayaran")[0].reset();
                        $("#modal-upload-bukti-bayar").modal('hide')
                    }
                }
            });
        });
    </script>
@endsection
