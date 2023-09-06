@extends('Front.layout.master', ['title' => 'Keranjang Belanja'])
@section('konten')
    <div id="gabung_isi_keranjang">
        <div class="page-content">
            <div class="cart">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9">
                            <table class="table table-cart table-mobile">
                                <thead>
                                    <tr>
                                        <th>Nama Produk</th>
                                        <th>Harga</th>
                                        <th>Kuantitas</th>
                                        <th>Total</th>
                                        <th></th>
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
                                                <div class="product">
                                                    @php
                                                        $gambar_produk = \App\Models\ProdukGambar::where('produk_id', $keranjang->relasi_produk->id)
                                                            ->select(['produk_id', 'path'])
                                                            ->first();
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
                                                <div class="cart-product-quantity">
                                                    <div class="d-flex flex-row align-items-center qty">
                                                        <button
                                                            class="btn btn-decrement btn-warning btn-sm btn-spinner btnItemUpdate qtyMinus"
                                                            type="button" data-cartid="{{ $keranjang['id'] }}"
                                                            style="border-radius: 6px;max-width: 20px;"><i
                                                                class="icon-minus"></i></button>
                                                        <input type="text" name="kuantitas" id="appendedInputButtons"
                                                            value="{{ $keranjang['kuantitas'] }}" pattern="[0-9]*"
                                                            class="form-control kuantitas-input"
                                                            style="text-align: center; border-radius: 6px;">
                                                        <button
                                                            class="btn btn-increment btn-primary btn-sm btn-spinner btnItemUpdate qtyPlus"
                                                            type="button" data-cartid="{{ $keranjang['id'] }}"
                                                            style="border-radius: 6px;max-width: 20px;"><i
                                                                class="icon-plus"></i></button>
                                                    </div>
                                                </div>
                                            </td>
                                            @php
                                                $total = $keranjang->relasi_produk_detail->harga * $keranjang->kuantitas;
                                                $sub_total = $sub_total + $keranjang->relasi_produk_detail->harga * $keranjang->kuantitas;
                                            @endphp
                                            <td class="price-col">@currency($total)</td>
                                            <td class="remove-col">
                                                <button
                                                    class="btn btn-increment btn-danger btn-sm btn-spinner btnItemDelete"
                                                    type="button" data-cartid="{{ $keranjang['id'] }}"
                                                    style="border-radius: 6px;max-width: 20px;"><i
                                                        class="icon-close"></i></button>
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
                                <h3 class="summary-title">Cart Total</h3><!-- End .summary-title -->

                                <table class="table table-summary">
                                    <tbody>
                                        <tr class="summary-total" style="color:black;">
                                            <td>Total:</td>
                                            <td>@currency($sub_total)</td>
                                        </tr><!-- End .summary-total -->
                                    </tbody>
                                </table><!-- End .table table-summary -->

                                <a href="{{ route('customer.HalamanPembayaran') }}"
                                    class="btn btn-outline-primary-2 btn-order btn-block">Lanjutkan Ke
                                    Pembayaran</a>
                            </div><!-- End .summary -->

                            <a href="category.html" class="btn btn-outline-dark-2 btn-block mb-3"><span>Lanjutkan
                                    Belanja</span><i class="icon-refresh"></i></a>
                        </aside><!-- End .col-lg-3 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .cart -->
        </div><!-- End .page-content -->

    </div>
@endsection
@section('script')
    <script>
        $(".kuantitas-input").change(function(event) {
            $("#gabung_isi_keranjang").load(location.href + " #gabung_isi_keranjang>*", "");
        });

        $(document).on('click', '.btnItemUpdate', function() {
            if ($(this).hasClass('qtyMinus')) {
                var kuantitas = $(this).next().val();
                if (kuantitas <= 1) {
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
                        icon: 'error',
                        title: 'Kuantitas produk tidak boleh kurang dari 0'
                    });
                    return false;
                } else {
                    kuantitas_baru = parseInt(kuantitas) - 1;
                }
            }
            if ($(this).hasClass('qtyPlus')) {
                var kuantitas = $(this).prev().val();
                kuantitas_baru = parseInt(kuantitas) + 1;
            }
            var cartid = $(this).data('cartid');
            $.ajax({
                data: {
                    "cartid": cartid,
                    "kts": kuantitas_baru
                },
                url: '/customer/update-kuantitas-produk-keranjang',
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(resp) {
                    if (resp.status_stok_lebih == 1) {
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
                            icon: 'error',
                            title: resp.msg
                        });
                    } else if (resp.status_stok_kurang_dari_0 == 1) {
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
                            icon: 'error',
                            title: resp.msg
                        });
                    } else if (resp.status_kuantitas_berubah == 1) {
                        $("#gabung_isi_keranjang").load(location.href + " #gabung_isi_keranjang>*", "");
                    }
                },
                error: function() {
                    alert("Update Kuantitas Gagal");
                }
            });
        });

        $(document).on('click', '.btnItemDelete', function(event) {
            const id = $(event.currentTarget).attr('id-produk');
            var cartid = $(this).data('cartid');
            Swal.fire({
                title: 'Yakin ingin mengahpus data ini?',
                icon: 'warning',
                showDenyButton: true,
            }).then((willDelete) => {

                if (willDelete) {
                    $.ajax({
                        data: {
                            "keranjang_id": cartid,
                        },
                        url: "/customer/hapus-produk-dalam-keranjang",
                        dataType: 'json',
                        success: function(data) {
                            if (data.status == 0) {
                                alert("Gagal Hapus")
                            } else if (data.status_hapus_produk == 1) {
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 2000,
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
                                    }),
                                    $("#gabung_isi_keranjang").load(location.href +
                                        " #gabung_isi_keranjang>*", "");
                                $('.total_produk_keranjang_class').html(data
                                    .total_produk_keranjang)
                            }
                        }
                    });
                } else {
                    //alert ('no');
                    return false;
                }
            });
        });

        // $(document).on('click', '.btnItemDelete', function() {
        //     var cartid = $(this).data('cartid');
        //     var peringatan = confirm("Yakin Ingin Menghapus?");
        //     if (peringatan) {
        //         $.ajax({
        //             data: {
        //                 "keranjang_id": cartid,
        //             },
        //             url: '/customer/hapus-produk-dalam-keranjang',
        //             type: 'post',
        //             success: function(resp) {
        //                 $(".totalBarangKeranjangClass").html(resp.AmbilDataTotalBarangKeranjang);
        //                 $("#GabungKeranjang").html(resp.view);
        //             },
        //             error: function() {
        //                 alert("error");
        //             }
        //         });
        //     }
        // });
    </script>
@endsection
