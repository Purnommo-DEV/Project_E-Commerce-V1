@extends('Front.layout.master', ['title' => 'Keranjang Belanja'])
@section('konten')
    <div class="page-content">
        <div class="cart">
            <div class="container">
                <div id="gabung_isi_keranjang">
                    @include('Front.keranjang._data_keranjang')
                </div><!-- End .container -->
            </div><!-- End .page-content -->
        </div><!-- End .cart -->
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
            }).then(function(result) {

                if (result.value) {
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
                                });
                                // Jika " #gabung_isi_keranjang>*" halaman tidak akan bertimpa (ada spasi sebelum #)
                                // Jika "#gabung_isi_keranjang>*" halamana akan bertimpa (tidak ada spasi sebelum #)

                                $("#gabung_isi_keranjang").load(location.href +
                                    " #gabung_isi_keranjang>*", "");
                                $('.total_produk_keranjang_class').html(data
                                    .total_produk_keranjang);
                                $("#data_keranjang_header").html(data.data_keranjang_terbaru);
                                $(".cart-total-price").html(data
                                    .total_harga_produk_dlm_keranjang);


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
