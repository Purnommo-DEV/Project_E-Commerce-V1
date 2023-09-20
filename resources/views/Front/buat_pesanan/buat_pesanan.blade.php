@extends('Front.layout.master', ['title' => 'Buat Pesanan'])
@section('konten')
    <div id="gabung_isi_keranjang">
        <div class="page-content">
            <div class="cart">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9">
                            <table class="table table-mobile"
                                style="border-radius: 15px; background: #f9f9f9; overflow: hidden;">
                                <thead>
                                    <tr style="background: #a97c50;">
                                        <th style="color: white; padding-left: 2rem; padding-right: 2rem;"><b>Nama Produk</b>
                                        </th>
                                        <th style="color: white; padding-left: 2rem; padding-right: 2rem;"><b>Harga</b></th>
                                        <th style="color: white; padding-left: 2rem; padding-right: 2rem;"><b>Kuantitas</b>
                                        </th>
                                        <th style="color: white; padding-left: 2rem; padding-right: 2rem;"><b>Total</b></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php
                                        $total = 0;
                                        $sub_total = 0;
                                        $total_berat = 0;
                                    @endphp
                                    @foreach ($data_keranjang as $keranjang)
                                        <tr>
                                            <td style="padding-left: 2rem; padding-right: 2rem;" class="product-col">
                                                <div class="product" style="background: transparent;">
                                                    @php
                                                        $gambar_produk = \App\Models\ProdukGambar::where('produk_id', $keranjang->relasi_produk->id)
                                                            ->select(['produk_id', 'path'])
                                                            ->first();
                                                        $total_berat += $keranjang->total_berat * $keranjang->kuantitas;
                                                        $tujuan_kota = $data_alamat_customer->kota_id;
                                                    @endphp
                                                    <figure class="product-media">
                                                        <a href="#">
                                                            <img class="object-fit-fill border rounded"
                                                                style="aspect-ratio: 4/3;"
                                                                src="{{ asset('storage/' . $gambar_produk->path) }}"
                                                                alt="Product image">
                                                        </a>
                                                    </figure>

                                                    <h4 class="product-title">
                                                        <a href="#!">{{ $keranjang->relasi_produk->nama_produk }}<br>
                                                            @if ($keranjang->relasi_produk->produk_tipe_id == 2)
                                                                (Variasi :
                                                                {{ $keranjang->relasi_produk_detail->produk_variasi }})
                                                            @endif
                                                        </a>
                                                    </h4><!-- End .product-title -->
                                                </div><!-- End .product -->
                                            </td>
                                            <td style="padding-left: 2rem; padding-right: 2rem;" class="price-col">
                                                @currency($keranjang->relasi_produk_detail->harga)</td>
                                            <td style="padding-left: 2rem; padding-right: 2rem;" class="quantity-col">
                                                {{ $keranjang['kuantitas'] }}
                                            </td>
                                            @php
                                                $total = $keranjang->relasi_produk_detail->harga * $keranjang->kuantitas;
                                                $sub_total = $sub_total + $keranjang->relasi_produk_detail->harga * $keranjang->kuantitas;
                                            @endphp
                                            <td style="padding-left: 2rem; padding-right: 2rem;" class="price-col">
                                                @currency($total)</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table><!-- End .table table-wishlist -->
                        </div><!-- End .col-lg-9 -->
                        <aside class="col-lg-3">
                            <form action="{{ route('customer.ProsesBuatPesanan') }}" method="POST"
                                id="form-proses-buat-pesanan">
                                @csrf
                                {{-- <div class="summary summary-cart"> --}}
                                @csrf
                                <table class="table table-mobile"
                                    style="border-radius: 15px; background: #f9f9f9; overflow: hidden;">
                                    <thead>
                                        <tr style="background: #a97c50;">
                                            <th colspan="2"
                                                style="color: white; padding-left: 2rem; padding-right: 2rem;">
                                                <b>Ringkasan Belanja</b>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="summary-shipping">
                                            <th
                                                style="padding-bottom: 0px; border-bottom: none; color: black; padding-left: 2rem; padding-right: 2rem;">
                                                <b>Alamat
                                                    Pengiriman :</b>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="2" style="padding-left: 2rem; padding-right: 2rem;">
                                                {{ $data_alamat_customer->alamat }},
                                                {{ $data_alamat_customer->relasi_kota->name }},
                                                {{ $data_alamat_customer->relasi_provinsi->name }}
                                            </th>
                                        </tr>
                                        <tr class="summary-shipping">
                                            <th
                                                style="padding-bottom: 0px; border-bottom: none; color: black; padding-left: 2rem; padding-right: 2rem;">
                                                <b>Pilih
                                                    Ekspedisi
                                                    :</b>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="2"
                                                style="padding-bottom: 0px; padding-left: 2rem; padding-right: 2rem;">
                                                <select style="color: black;border-radius: 1rem;margin-bottom: 0px;"
                                                    name="req_kurir" id="pilih_kurir" class="form-control"
                                                    style="margin-bottom: 0px;">
                                                    <option style="color: black;border-radius: 1rem;margin-bottom: 0px;"
                                                        value="" selected disabled>-- Pilih Ekspedisi --
                                                    </option>
                                                    <option value="jne">Jalur Nugraha Ekakurir (JNE)</option>
                                                    <option value="pos">POS Indonesia</option>
                                                    <option value="tiki">Titipan Kilat (TIKI)</option>
                                                </select>
                                                <div class="input-group has-validation">
                                                    <label class="text-danger error-text req_kurir_error"
                                                        style="font-weight: bold; font-size: 1.2rem; padding-left: 2rem; padding-right: 2rem;"></label>
                                                </div>
                                            </th>
                                        </tr>
                                        <tr class="summary-shipping">
                                            <th
                                                style="padding-bottom: 0px; border-bottom: none; color: black; padding-left: 2rem; padding-right: 2rem;">
                                                <b>Pilih
                                                    Layanan
                                                    :</b>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="2"
                                                style="padding-bottom: 0px;  padding-left: 2rem; padding-right: 2rem;">
                                                <select style="color: black;border-radius: 1rem;margin-bottom: 0px;"
                                                    class="form-control" id="pilih-layanan" name="req_layanan"
                                                    style="margin-bottom: 0px;">
                                                    <option value="" selected disabled>-- Pilih Layanan --
                                                    </option>
                                                </select>
                                                <div class="input-group has-validation">
                                                    <label class="text-danger error-text req_layanan_error"
                                                        style="font-weight: bold; font-size: 1.2rem; padding-left: 2rem; padding-right: 2rem;"></label>
                                                </div>
                                            </th>
                                        </tr>
                                        <tr class="summary-shipping">
                                            <th
                                                style="padding-bottom: 0px; border-bottom: none; color: black; padding-left: 2rem; padding-right: 2rem;">
                                                <b>Metode
                                                    Pembayaran :</b>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td
                                                style="padding-bottom: 0px; padding-top: 0px; padding-left: 2rem; padding-right: 2rem;">
                                                <div class="custom-control custom-radio">
                                                    <input type="checkbox" id="metode_pembayaran" name="metode_pembayaran"
                                                        value="TF" class="custom-control-input transferBank">
                                                    <label class="custom-control-label" for="metode_pembayaran">
                                                        Transfer Bank
                                                    </label>
                                                </div>
                                            </td>
                                            <td>&nbsp;</td>
                                        </tr>

                                        <tr class="summary-subtotal" style="font-size: 1.3rem;">
                                            <th style="color: black; padding-left: 2rem; padding-right: 2rem;"><b>Total
                                                    :</b></th>
                                            <th style="padding-left: 2rem; padding-right: 2rem;">
                                                <span id="total_bayar">
                                                    <b>@currency($sub_total)</b>
                                                </span>
                                            </th>
                                        </tr>
                                        <tr class="summary-subtotal justify-content-center" style="font-size: 1.3rem;">
                                            <th colspan="2"
                                                style="color: black; padding-left: 2rem; padding-right: 2rem;">
                                                <button type="submit"
                                                    class="btn btn-outline-primary btn-block mb-3 tombols"
                                                    style="color: #c96; border-color:#c96; border-radius:1rem;"><span>Buat
                                                        Pesanan</span></button>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                                {{-- <button type="submit" class="btn btn-outline-primary btn-block mb-3 tombols"
                                    style="color: #c96; border-color:#c96;"><span>Buat Pesanan</span></button> --}}
                                {{-- <input type="hidden" name="total_berat" value="{{ $total_berat }}">
                                    <input type="hidden" id="totalBayar" name="total_bayar" value="">
                                    <input type="hidden" id="jasaPengiriman" name="pengiriman" value=""> --}}
                                {{-- </div> --}}
                            </form>
                        </aside>
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .cart -->
        </div><!-- End .page-content -->

    </div>
@endsection
@section('script')
    <script>
        let total_berat = @json($total_berat);

        $('select[name="req_kurir"]').on('change', function() {
            let kurir = $(this).val();

            if (kurir) {
                jQuery.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/customer/cek-data-ongkir',
                    type: "POST",
                    data: {
                        // Berat paket maksimal 30Kg, jika paket melebihi 30Kg maka akan error RajaOngkir BadRequest
                        // Jika salah satu data tidak cocok maka dapat terjadi error RajaOngkir BadRequest
                        // Jika salah satu kolom kosong maka dapat terjadi error RajaOngkir BadRequest
                        'kota_customer_id': 364,
                        'total_berat': total_berat,
                        'jenis_kurir': kurir
                    },
                    success: function(response) {
                        $('select[name="req_layanan"]').empty();
                        $('select[name="req_layanan"]').append(
                            '<option value="" selected disabled>-- Pilih Layanan --</option>');
                        $.each(response[0]['costs'], function(key, value) {
                            $('select[name="req_layanan"]').append('<option value="' + key +
                                '.' + value.cost[0].value + '">' +
                                value.service + ' Rp. ' + value.cost[0].value.toString()
                                .replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.") + ' (' + value
                                .cost[0].etd + ' hari)</option>');
                        });
                    },
                })
            } else {
                $('select[name="req_layanan"]').append(
                    '<option value="" selected disabled>-- Pilih Layanan --</option>');

            }
        });

        var subtotal = {{ $sub_total }}
        $('select[name="req_layanan"]').on('change', function() {
            var ongkir = $(this).find(":selected").val();
            // Menghapus nilai sebelum titik(.) dan titiknya
            var ongkir_split = ongkir.split(".").pop();
            if (ongkir_split === " ") {
                var total_bayar = subtotal
            } else {
                var total_bayar = parseInt(ongkir_split) + parseInt(subtotal)
            }
            $('#total_bayar').html('Rp. ' + total_bayar.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."))

        });

        $('#form-proses-buat-pesanan').on('submit', function(e) {
            var kurir = $('#pilih_kurir').find(":selected").val();
            var ongkir = $('#pilih-layanan').find(":selected").val();

            // Menghapus nilai setelah titik(.) dan titiknya
            var ongkir_split_before = ongkir.split(".")[0];
            // Menghapus nilai sebelum titik(.) dan titiknya
            var ongkir_split_after = ongkir.split(".").pop();
            var total_bayar = parseInt(ongkir_split_after) + parseInt(subtotal)

            // FORMAT MONEY TO INTEGER (UNFORMAT)
            // $(this).text($(this).text().replace('$', '').replace(/[^0-9$]/g, ''));

            e.preventDefault();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: {
                    'req_kota_customer': {{ $tujuan_kota }},
                    'req_total_berat': total_berat,
                    'req_total_ongkir': ongkir_split_after,
                    'req_kurir': kurir,
                    'req_layanan': ongkir_split_before,
                    'req_total_pembayaran': total_bayar,
                    'req_metode_pembayaran': $('#metode_pembayaran').val()
                },
                beforeSend: function() {
                    $(document).find('label.error-text').text('');
                },
                success: function(data) {
                    if (data.status_form_kosong == 1) {
                        $.each(data.error, function(prefix, val) {
                            $('label.' + prefix + '_error').text(val[0]);
                            // $('span.'+prefix+'_error').text(val[0]);
                        });
                    } else if (data.status_buat_pesanan == 1) {
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
                        $("#data_keranjang_header").html(data.data_keranjang_terbaru);
                        $(".cart-total-price").html(data.total_harga_produk_dlm_keranjang);
                        window.location.href = `${data.route}`;
                    }
                }
            });
        });
    </script>
@endsection
