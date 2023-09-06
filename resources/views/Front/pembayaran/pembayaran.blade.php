@extends('Front.layout.master', ['title' => 'Pembayaran'])
@section('konten')
    <div id="gabung_isi_keranjang">
        <div class="page-content">
            <div class="cart">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9" style="border-radius: 15px; background: #f9f9f9;">
                            <table class="table table-cart table-mobile">
                                <thead>
                                    <tr>
                                        <th style="color: black"><b>Nama Produk</b></th>
                                        <th style="color: black"><b>Harga</b></th>
                                        <th style="color: black"><b>Kuantitas</b></th>
                                        <th style="color: black"><b>Total</b></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php
                                        $total = 0;
                                        $sub_total = 0;
                                    @endphp
                                    @foreach ($data_keranjang as $keranjang)
                                        <tr>
                                            <td class="product-col">
                                                <div class="product" style="background: transparent;">
                                                    @php
                                                        $gambar_produk = \App\Models\ProdukGambar::where('produk_id', $keranjang->relasi_produk->id)
                                                            ->select(['produk_id', 'path'])
                                                            ->first();
                                                        $total_berat += $keranjang->total_berat * $keranjang->kuantitas;
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
                                            <td class="price-col">@currency($keranjang->relasi_produk_detail->harga)</td>
                                            <td class="quantity-col">
                                                {{ $keranjang['kuantitas'] }}
                                            </td>
                                            @php
                                                $total = $keranjang->relasi_produk_detail->harga * $keranjang->kuantitas;
                                                $sub_total = $sub_total + $keranjang->relasi_produk_detail->harga * $keranjang->kuantitas;
                                            @endphp
                                            <td class="price-col">@currency($total)</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table><!-- End .table table-wishlist -->
                        </div><!-- End .col-lg-9 -->
                        <aside class="col-lg-3">
                            <div class="summary summary-cart" style="border-radius: 15px;">
                                <h2 class="summary-title"><b>Ringkasan Belanja</b></h2>
                                @if (Session::has('success_message'))
                                    <div class="alert alert-success" role="alert" style="margin-top: 10px;">
                                        {{ Session::get('success_message') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                                @if (Session::has('error_message'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ Session::get('error_message') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                                @csrf
                                <table class="table table-summary">
                                    <tbody>
                                        <tr class="summary-shipping">
                                            <th style="padding-bottom: 0; border-bottom: none; color: black;"><b>Alamat
                                                    Pengiriman :</b></th>
                                        </tr>
                                        <tr>
                                            <th colspan="2">
                                                {{ $data_alamat_customer->alamat }},
                                                {{ $data_alamat_customer->relasi_kota->name }},
                                                {{ $data_alamat_customer->relasi_provinsi->name }}
                                            </th>
                                        </tr>
                                        <tr class="summary-shipping">
                                            <th style="padding-bottom: 0; border-bottom: none; color: black;"><b>Pilih
                                                    Ekspedisi
                                                    :</b></th>
                                        </tr>
                                        <tr>
                                            <th colspan="2">
                                                <select name="pilih_kurir" class="form-control">
                                                    <option value="" selected disabled>-- Pilih Ekspedisi --</option>
                                                    <option value="jne">Jalur Nugraha Ekakurir (JNE)</option>
                                                    <option value="pos">POS Indonesia</option>
                                                    <option value="tiki">Titipan Kilat (TIKI)</option>
                                                </select>
                                            </th>
                                        </tr>
                                        <tr class="summary-shipping">
                                            <th style="padding-bottom: 0; border-bottom: none; color: black;"><b>Pilih
                                                    Layanan
                                                    :</b></th>
                                        </tr>
                                        <tr>
                                            <th colspan="2">
                                                <select class="form-control" id="pilih-layanan" name="layanan">
                                                    <option value="" selected disabled>-- Pilih Layanan --</option>
                                                </select>
                                            </th>
                                        </tr>
                                        <tr class="summary-shipping">
                                            <th style="padding-bottom: 0; border-bottom: none; color: black;"><b>Metode
                                                    Pembayaran :</b></th>
                                        </tr>
                                        <tr>
                                            <td>
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
                                            <th style="color: black"><b>Total :</b></th>
                                            <th style="width: 10rem;">
                                                <span id="total_bayar">
                                                    <b>@currency($sub_total)</b>
                                                </span>
                                            </th>
                                        </tr>

                                    </tbody>
                                </table>
                                <input type="hidden" name="total_berat" value="{{ $total_berat }}">
                                <input type="hidden" id="totalBayar" name="total_bayar" value="">
                                <input type="hidden" id="jasaPengiriman" name="pengiriman" value="">
                                <button type="submit"
                                    class="btn btn-outline-primary btn-block mb-3 tombols"><span>Bayar</span></button>
                                </form>
                            </div>
                        </aside>
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .cart -->
        </div><!-- End .page-content -->

    </div>
@endsection
@section('script')
    <script>
        $('select[name="pilih_kurir"]').on('change', function() {
            let kurir = $(this).val();

            if (kurir) {
                jQuery.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/customer/cek-ongkir',
                    type: "POST",
                    data: {
                        'kota_customer_id': {{ $data_alamat_customer->kota_id }},
                        'total_berat': {{ $total_berat }},
                        'jenis_kurir': kurir
                    },
                    success: function(response) {
                        $('select[name="layanan"]').empty();
                        $('select[name="layanan"]').append(
                            '<option value="" selected disabled>-- Pilih Layanan --</option>');
                        $.each(response[0]['costs'], function(key, value) {
                            $('select[name="layanan"]').append('<option value="' + value.cost[0]
                                .value +
                                '">' +
                                value.service + ' Rp. ' + value.cost[0].value.toString()
                                .replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.") + ' (' + value
                                .cost[0].etd + ' hari)</option>');
                        });
                    },
                })
            } else {
                $('select[name="layanan"]').append(
                    '<option value="" selected disabled>-- Pilih Layanan --</option>');

            }
        });

        $('select[name="layanan"]').on('change', function() {
            var ongkir = $(this).find(":selected").val();
            var subtotal = {{ $sub_total }}
            if (ongkir === " ") {
                var total_bayar = subtotal
            } else {
                var total_bayar = parseInt(ongkir) + parseInt(subtotal)
            }
            $('#total_bayar').html('Rp. ' + total_bayar.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."))

        });
    </script>
@endsection
