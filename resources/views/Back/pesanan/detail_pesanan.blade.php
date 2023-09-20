@extends('Back.layout.master', ['title' => 'Data Detail Pesanan'])
@section('konten-admin')
    <section class="section">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div
                        class="d-flex flex-lg-row flex-column align-items-start align-items-lg-center justify-content-between gap-3">
                        <div class="flex-grow-1">
                            <h4 class="fw-bold">Order {{ $pesanan->kode_pesanan }}</h4>
                            <p class="mb-0">Customer ID : <a href="javascript:;">{{ $pesanan->relasi_user->id }}</a></p>
                        </div>
                        <div class="overflow-auto">
                            <div class="btn-group position-static">
                                <div class="btn-group position-static">
                                    <button type="button" class="btn btn-outline-primary px-4">
                                        <i class="bi bi-printer-fill me-2"></i>Print
                                    </button>
                                </div>
                                <div class="btn-group position-static">
                                    <button type="button" class="btn btn-outline-primary px-4">
                                        <i class="bi bi-arrow-clockwise me-2"></i>Refund
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="javascript:;">Action</a></li>
                                        <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
                                    </ul>
                                </div>
                                <div class="btn-group position-static">
                                    <button type="button" class="btn btn-outline-primary dropdown-toggle px-4"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        More Actions
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="javascript:;">Action</a></li>
                                        <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-8 d-flex">
                    <div class="card w-100">
                        <div class="card-body">
                            <h5 class="mb-3 fw-bold">Daftar Produk<span
                                    class="fw-light ms-2">({{ $pesanan_detail->count() }})</span></h5>
                            <div class="product-table">
                                <div class="table-responsive white-space-nowrap">
                                    <table class="table align-middle" id="table-list-produk">
                                        <thead class="table-light">
                                            <tr>

                                                <th>Nama Produk</th>
                                                <th>Kuantitas</th>
                                                <th>Harga</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pesanan_detail as $pesanan_detail)
                                                @php
                                                    $sub_total = $pesanan_detail->relasi_produk_detail->harga * $pesanan_detail->kuantitas;
                                                @endphp
                                                @if ($pesanan_detail->pesanan_id == $pesanan->id)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center gap-3">
                                                                <div class="product-box">
                                                                    <img src="{{ asset('storage/' . $pesanan_detail->relasi_produk->relasi_gambar->path) }}"
                                                                        width="100"
                                                                        class="object-fit-fill border rounded"
                                                                        style="display: initial; aspect-ratio: 4/3;">
                                                                </div>
                                                                <div class="product-info">
                                                                    <a href="javascript:;" class="product-title">
                                                                        {{ $pesanan_detail->relasi_produk->nama_produk }}</a>
                                                                    @if ($pesanan_detail->relasi_produk->produk_tipe_id == 2)
                                                                        <p class="mb-0 product-category">Variasi :
                                                                            {{ $pesanan_detail->relasi_produk_detail->produk_variasi }}
                                                                        </p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>{{ $pesanan_detail->kuantitas }}</td>
                                                        <td>{!! help_format_rupiah($pesanan_detail->relasi_produk_detail->harga) !!}</td>
                                                        <td>{!! help_format_rupiah($sub_total) !!}</td>
                                                    </tr>
                                                @endif
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4 d-flex">
                    <div class="w-100">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4 fw-bold">Ringkasan</h4>
                                <div>
                                    <div class="d-flex justify-content-between">
                                        @php
                                            $pesanan_status_batalkan_log = \App\Models\PesananStatusLog::where(['pesanan_id' => $pesanan->id, 'status_pesanan_id' => 7])->first();
                                            $total_tanpa_ongkir = $pesanan->total_pembayaran - $pesanan->total_ongkir;
                                        @endphp
                                        <p class="fw-semi-bold">Subtotal</p>
                                        <p class="fw-semi-bold">{!! help_format_rupiah($total_tanpa_ongkir) !!}</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="fw-semi-bold">Diskon :</p>
                                        <p class="text-danger fw-semi-bold">Rp. 0</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="fw-semi-bold">Pajak :</p>
                                        <p class="fw-semi-bold">Rp. 0</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="fw-semi-bold">Biaya Pengiriman :</p>
                                        <p class="fw-semi-bold">{!! help_format_rupiah($pesanan->total_ongkir) !!}</p>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between border-top pt-4">
                                    <h5 class="mb-0 fw-bold">Total :</h5>
                                    <h5 class="mb-0 fw-bold">{!! help_format_rupiah($pesanan->total_pembayaran) !!}</h5>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4 fw-bold">Status Pembayaran</h4>
                                <div>
                                    <div class="d-flex justify-content-between">
                                        <p class="fw-semi-bold">Bukti Bayar :</p>
                                        <p class="text-danger fw-semi-bold">Periksa Bukti</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="fw-semi-bold">Status Bayar : </p>
                                        @if ($pesanan_status->status_pesanan_id == 1)
                                            <p class="fw-semi-bold">Belum Membayar</p>
                                        @else
                                            <p class="fw-semi-bold">Telah Membayar</p>
                                        @endif
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        @if ($pesanan_status->status_pesanan_id == 1)
                                        @elseif ($pesanan_status->status_pesanan_id == 8)
                                        @else
                                            <p class="fw-semi-bold">Status Verifikasi :</p>
                                            @if ($pesanan_status->status_pesanan_id == 2)
                                                <p class="fw-semi-bold">Belum</p>
                                            @elseif($pesanan_status->status_pesanan_id == 7)
                                                <p class="fw-semi-bold">Dibatalkan oleh Admin
                                                    ({{ $pesanan_status_batalkan_log->catatan }})</p>
                                            @else
                                                <p class="fw-semi-bold">Ya</p>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        @if ($pesanan_status->status_pesanan_id == 1)
                                            <p class="fw-semi-bold">Jatuh Tempo :</p>
                                            <p class="fw-semi-bold">{!! help_tanggal_jam($pesanan->expired_date) !!}</p>
                                        @elseif ($pesanan_status->status_pesanan_id == 2)
                                        @endif
                                    </div>
                                </div>
                                @if ($pesanan_status->status_pesanan_id == 2)
                                    <button
                                        class="btn btn-sm btn-primary btn-block mb-3 verifikasi-pesanan">Verifikasi</button>
                                    <button type="button" class="btn btn-sm btn-danger btn-block btn-batalkan-pesanan"
                                        pesanan-id="{{ $pesanan->id }}">Batalkan</button>

                                    <div class="modal fade" id="modal-batalkan-pesanan" data-bs-backdrop="static"
                                        data-bs-keyboard="false" aria-labelledby="myModalLabel33" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modal-batalkan-pesananLabel">Batalkan
                                                        Pesanan</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form id="form-batalkan-pesanan">
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="exampleFormControlTextarea1">Alasan
                                                                Dibatalkan</label>
                                                            <textarea class="form-control" name="catatan" rows="3"></textarea>
                                                        </div>
                                                        <div class="input-group has-validation">
                                                            <label class="text-danger error-text catatan_error"
                                                                style="font-weight: bold; font-size: 0.8rem;"></label>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <button class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if (
                            $pesanan_status->status_pesanan_id == 1 ||
                                $pesanan_status->status_pesanan_id == 7 ||
                                $pesanan_status->status_pesanan_id == 8)
                        @else
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4 fw-bold">Status Pesanan</h4>
                                    @if ($pesanan_status->status_pesanan_id == 2)
                                        <label>Menunggu pembayaran di verifikasi</label>
                                    @elseif($pesanan_status->status_pesanan_id == 5)
                                        <label>Pesanan telah dikirimkan</label>
                                    @else
                                        <div>
                                            <div class="col">
                                                @if ($pesanan_status->status_pesanan_id == '6')
                                                    <label>Pesanan telah diterima</label>
                                                @else
                                                    <select name="req_pesanan_status" id="pesanan_status_id"
                                                        class="form-control" required>
                                                        <option value="#" selected disabled> -- Pilih Status --
                                                        </option>
                                                        @if ($pesanan_status->status_pesanan_id == '3')
                                                            <option value="4">Dikemas</option>
                                                        @elseif ($pesanan_status->status_pesanan_id == '4')
                                                            <option value="5">Dikirim</option>
                                                        @elseif($pesanan_status->status_pesanan_id == '5')
                                                            <option selected disabled>Dikirim</option>
                                                        @elseif($pesanan_status->status_pesanan_id == '6')
                                                            <option selected disabled> -- Selesai/Diterima --</option>
                                                        @endif
                                                    </select>
                                                    <div class="input-group has-validation">
                                                        <label class="text-danger error-text req_pesanan_status_error"
                                                            style="margin-top: 0.3rem; margin-bottom: 0.3rem; font-weight: 600; font-size: 0.8rem;"></label>
                                                    </div>
                                                @endif
                                            </div>
                                            @if ($pesanan_status->status_pesanan_id == '4')
                                                <div class="d-flex justify-content-between" id="resi">

                                                    {{-- @else --}}
                                                    {{-- <input class="form-control" type="text" name="resi"
                                                    value="{{ $pesanan_detail->resi }}" id="resi"
                                                    placeholder="Input Nomor Resi"> --}}
                                                </div>
                                                <div class="input-group has-validation"><label
                                                        class="text-danger error-text req_resi_error"
                                                        style="margin-bottom: 0.3rem; font-weight: 600; font-size: 0.8rem;"></label>
                                                </div>
                                            @else
                                            @endif
                                        </div>
                                        <div>
                                            @if ($pesanan_status->status_pesanan_id == '5' || $pesanan_status->status_pesanan_id == '6')
                                            @else
                                                <button type="button"
                                                    class="btn btn-primary btn-block btn-sm ubah-status-pesanan">
                                                    <b>Ubah Status Pesanan</b>
                                                </button>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-3 fw-bold">Pengiriman</h4>
                                    <div class="d-flex mb-3 justify-content-between">
                                        <table class="table align-midle">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        Resi
                                                    </td>
                                                    <td>
                                                        {{ $pesanan->kode_pengiriman }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Ekspedisi
                                                    </td>
                                                    <td>
                                                        {{ $pesanan->ekspedisi_layanan }}
                                                    </td>
                                                </tr>
                                                @foreach ($pesanan_status_log as $item)
                                                    <tr>
                                                        <td>{{ $item->relasi_status_master->status_pesanan }}</td>
                                                        <td>{!! help_tanggal_jam($item->created_at) !!}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div><!--end row-->
                </div><!--end col-->


                <h5 class="fw-bold mb-4">Billing Details</h5>
                <div class="card">
                    <div class="card-body">
                        <div class="row g-3 row-cols-1 row-cols-lg-4">
                            <div class="col">
                                <div class="d-flex align-items-start gap-3 border p-3 rounded">
                                    <div class="detail-icon fs-5">
                                        <i class="bi bi-person-circle"></i>
                                    </div>
                                    <div class="detail-info">
                                        <p class="fw-bold mb-1">Customer Name</p>
                                        <a href="javascript:;" class="mb-0">Jhon Maxwell</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="d-flex align-items-start gap-3 border p-3 rounded">
                                    <div class="detail-icon fs-5">
                                        <i class="bi bi-envelope-fill"></i>
                                    </div>
                                    <div class="detail-info">
                                        <h6 class="fw-bold mb-1">Email</h6>
                                        <a href="javascript:;" class="mb-0">abc@example.com</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="d-flex align-items-start gap-3 border p-3 rounded">
                                    <div class="detail-icon fs-5">
                                        <i class="bi bi-telephone-fill"></i>
                                    </div>
                                    <div class="detail-info">
                                        <h6 class="fw-bold mb-1">Phone</h6>
                                        <a href="javascript:;" class="mb-0">+01-585XXXXXXX</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="d-flex align-items-start gap-3 border p-3 rounded">
                                    <div class="detail-icon fs-5">
                                        <i class="bi bi-calendar-check-fill"></i>
                                    </div>
                                    <div class="detail-info">
                                        <h6 class="fw-bold mb-1">Shipping Date</h6>
                                        <p class="mb-0">15 Dec, 2022</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="d-flex align-items-start gap-3 border p-3 rounded">
                                    <div class="detail-icon fs-5">
                                        <i class="bi bi-gift-fill"></i>
                                    </div>
                                    <div class="detail-info">
                                        <h6 class="fw-bold mb-1">Gift Order</h6>
                                        <p class="mb-0">Gift voucher has available</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="d-flex align-items-start gap-3 border p-3 rounded">
                                    <div class="detail-icon fs-5">
                                        <i class="bi bi-house-door-fill"></i>
                                    </div>
                                    <div class="detail-info">
                                        <h6 class="fw-bold mb-1">Address 1</h6>
                                        <p class="mb-0">123 Street Name, City, Australia</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="d-flex align-items-start gap-3 border p-3 rounded">
                                    <div class="detail-icon fs-5">
                                        <i class="bi bi-house-fill"></i>
                                    </div>
                                    <div class="detail-info">
                                        <h6 class="fw-bold mb-1">Shipping Address</h6>
                                        <p class="mb-0">198 Street Name, City, Inited States of America</p>
                                    </div>
                                </div>
                            </div>

                        </div><!--end row-->
                    </div>
                </div>
            </div>
    </section>



@endsection
@section('script')
    <script>
        $(document).ready(function() {
            var table = $('#table-list-produk').DataTable({
                pageLength: 5,
                lengthMenu: [
                    [5, 10, 20, -1],
                    [5, 10, 20, 'Todos']
                ]
            })
        });

        var data_pesanan = @json($pesanan);

        $('#ekspedisi').html(data_pesanan.ekspedisi_layanan.split("_")[0])
        $('#layanan').html(data_pesanan.ekspedisi_layanan.split("_").pop())

        $(document).on('click', '.verifikasi-pesanan', function(event) {
            Swal.fire({
                title: 'Yakin ingin memverifikasi data ini?',
                icon: 'warning',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal',
                showCancelButton: true,
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: "{{ route('admin.VerifikasiPesanan') }}",
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            'pesanan_id': data_pesanan.id,
                        },
                        success: function(response) {
                            if (response.status_verifikasi_berhasil == 1) {
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
                    //alert ('no');
                    return false;
                }
            });
        });

        $("#resi").attr("style", "display:none")
        $("#pesanan_status_id").on("change", function() {
            if (this.value == "5") {
                $("#resi").html(
                    "<div class='col-md-12'><input class='form-control' type='text' id='input-resi' name='req_resi' placeholder='Input Nomor Resi' required></div>"
                )
            } else {
                $("#resi").attr("style", "display:none")
            }
        });

        $(document).on('click', '.ubah-status-pesanan', function(event) {
            if ($("#input-resi").val() == null) {
                var resi = "0"
            } else {
                var resi = $("#input-resi").val()
            }
            Swal.fire({
                title: 'Yakin ingin mengubah status pesanan ini?',
                icon: 'warning',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal',
                showCancelButton: true,
            }).then(function(result) {
                if (result.value) {

                    $.ajax({
                        url: "{{ route('admin.PerbaruiStatusPesanan') }}",
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            'req_pesanan_id': data_pesanan.id,
                            'req_pesanan_status': $("#pesanan_status_id").val(),
                            'req_resi': resi
                        },
                        success: function(response) {
                            if (response.status_form_kosong == 1) {
                                $.each(response.error, function(prefix, val) {
                                    $('label.' + prefix + '_error').text(val[0]);
                                    // $('span.'+prefix+'_error').text(val[0]);
                                });
                            } else if (response.ubah_status_berhasil == 1) {
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
                    //alert ('no');
                    return false;
                }
            });
        });

        $(document).on('click', '.btn-batalkan-pesanan', function(event) {
            $("#modal-batalkan-pesanan").modal('show');
            const id = $(event.currentTarget).attr('pesanan-id');
            $('#form-batalkan-pesanan').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                // Gabung atau selipkan data lainnya
                formData.append('pesanan_id', id);

                $.ajax({
                    url: "{{ route('admin.BatalkanPesananOlehAdmin') }}",
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
                        } else if (response.status_pembatalan_pesanan_oleh_admin == 1) {
                            $('#modal-batalkan-pesanan').hide();
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
                            $('#form-batalkan-pesanan').trigger("reset");
                            location.reload();
                        }
                    }
                });
            });
        });
    </script>
@endsection
