<div class="row">
    <div class="col-lg-9">
        <table class="table table-cart table-mobile" style="border-radius: 15px; background: #f9f9f9; overflow: hidden;">
            <thead>
                <tr style="background: #a97c50;">
                    <th style="color: white; padding-left: 2rem; padding-right: 2rem;"><b>Nama Produk</b>
                    </th>
                    <th style="color: white; padding-left: 2rem; padding-right: 2rem;"><b>Harga</b></th>
                    <th style="color: white; padding-left: 2rem; padding-right: 2rem;"><b>Kuantitas</b>
                    </th>
                    <th style="color: white; padding-left: 2rem; padding-right: 2rem;"><b>Total</b></th>
                    <th style="color: white; padding-left: 2rem; padding-right: 2rem;"></th>
                </tr>
            </thead>

            <tbody>
                @php
                    $total = 0;
                    $sub_total = 0;
                @endphp
                @foreach ($data_keranjang as $keranjang)
                    <tr>
                        <td style="padding-left: 2rem; padding-right: 2rem;" class="product-col" style="color:black;">
                            <div class="product">
                                @php
                                    $gambar_produk = \App\Models\ProdukGambar::where('produk_id', $keranjang->relasi_produk->id)
                                        ->select(['produk_id', 'path'])
                                        ->first();
                                @endphp
                                <figure class="product-media">
                                    <img class="object-fit-fill border rounded" style="aspect-ratio: 4/3;"
                                        src="{{ asset('storage/' . $gambar_produk->path) }}" alt="Product image">
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
                            <div class="cart-product-quantity">
                                <div class="d-flex flex-row align-items-center qty">
                                    <button class="btn btn-decrement btn-sm btn-spinner btnItemUpdate qtyMinus"
                                        type="button" data-cartid="{{ $keranjang['id'] }}"
                                        style="border-radius: 6px; max-width: 20px; color:black;"><i
                                            class="icon-minus"></i></button>
                                    <input type="text" name="kuantitas" id="appendedInputButtons"
                                        value="{{ $keranjang['kuantitas'] }}" pattern="[0-9]*"
                                        class="form-control kuantitas-input"
                                        style="text-align: center; border-radius: 6px;">
                                    <button class="btn btn-increment btn-sm btn-spinner btnItemUpdate qtyPlus"
                                        type="button" data-cartid="{{ $keranjang['id'] }}"
                                        style="border-radius: 6px; max-width: 20px; color:black;"><i
                                            class="icon-plus"></i></button>
                                </div>
                            </div>
                        </td>
                        @php
                            $total = $keranjang->relasi_produk_detail->harga * $keranjang->kuantitas;
                            $sub_total = $sub_total + $keranjang->relasi_produk_detail->harga * $keranjang->kuantitas;
                        @endphp
                        <td style="padding-left: 2rem; padding-right: 2rem;" class="price-col">
                            @currency($total)</td>
                        <td style="padding-left: 2rem; padding-right: 2rem;" class="remove-col">
                            <button class="btn btn-increment btn-danger btn-sm btn-spinner btn-sm btnItemDelete"
                                type="button" data-cartid="{{ $keranjang['id'] }}"
                                style="border-radius: 6px; max-width: 15px; height:30px;"><i class="icon-close"
                                    style=" color:white;"></i></button>
                            {{-- <button class="btn btnItemDelete" type="button"
                                data-cartid="{{ $keranjang->id }}"><i class="icon-close"></i></button> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table><!-- End .table table-wishlist -->
    </div><!-- End .col-lg-9 -->
    <aside class="col-lg-3">
        <div class="summary summary-cart">


            <table class="table table-summary" style="color:black;">
                <tbody>
                    <tr class="summary-total">
                        <td style="color:black;"><strong>Total : </strong></td>
                        <td style="color:black;"><strong>@currency($sub_total)</strong></td>
                    </tr><!-- End .summary-total -->
                </tbody>
            </table><!-- End .table table-summary -->
            @if ($sub_total > 0)
                <a href="{{ route('customer.HalamanBuatPesanan') }}"
                    class="btn btn-outline-primary-2 btn-order btn-block">Lanjut Buat Pesanan</a>
            @endif
        </div><!-- End .summary -->

        <a href="{{ route('HalamanBeranda') }}" class="btn btn-outline-dark-2 btn-block mb-3"><span>Lanjutkan
                Belanja</span><i class="icon-refresh"></i></a>
    </aside><!-- End .col-lg-3 -->
</div><!-- End .row -->
