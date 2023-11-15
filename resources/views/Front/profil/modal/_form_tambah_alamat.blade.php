<div class="modal fade" id="modal-form-tambah-alamat-pengguna" tabindex="-1"
    aria-labelledby="modal-form-tambah-alamat-penggunaLabel" aria-hidden="true" data-backdrop="static"
    data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-form-tambah-alamat-penggunaLabel">
                    Tambah Alamat</h5>
                <button type="button" class="close batal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 3rem !important;">

                <form id="form-tambah-alamat-pengguna">
                    @csrf
                    <div class="row">
                        <div class="col col-6">
                            <div class="form-group">
                                <label for="singin-email-2">Nama Penerima</label>
                                <input type="text" name="nama" class="form-control" placeholder="Nama">
                                <div class="input-group has-validation">
                                    <label class="text-danger error-text name_error"></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="singin-password-2">Provinsi</label>
                                <select class="form-control provinsi" name="provinsi_id" aria-hidden="true">
                                    <option value="" selected disabled>-- Pilih Provinsi --</option>
                                    @foreach ($provinsi as $provinsis => $value)
                                        <option value="{{ $provinsis }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                <div class="input-group has-validation">
                                    <label class="text-danger error-text provinsi_id_error"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col col-6">
                            <div class="form-group">
                                <label for="singin-password-2">Alamat</label>
                                <input type="text" name="alamat"
                                    class="form-control @error('alamat') is-invalid @enderror"
                                    placeholder="Jl. Alianyang, Gg. Sawi 2">
                                <div class="input-group has-validation">
                                    <label class="text-danger error-text alamat_error"></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="singin-password-2">Kota</label>
                                <select class="form-control kota" name="kota_id" aria-hidden="true">
                                    <option value="" required>-- Pilih Kota --</option>
                                </select>
                                <div class="input-group has-validation">
                                    <label class="text-danger error-text kota_id_error"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col col-12">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-secondary batal"
                                    data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('script')
    <script>
        $(document).on('click', '.tambah-alamat', function(event) {
            $("#modal-form-tambah-alamat-pengguna").modal('show');
            if ($("#form-tambah-alamat-pengguna").length > 0) {
                $("#form-tambah-alamat-pengguna").validate({
                    rules: {
                        nama: {
                            required: true,
                            maxlength: 50
                        },
                        provinsi_id: {
                            required: true,
                            maxlength: 50,
                        },
                        kota_id: {
                            required: true,
                            maxlength: 300
                        },
                        alamat: {
                            required: true,
                            maxlength: 300
                        },
                    },
                    messages: {
                        nama: {
                            required: "<label class='text-danger error-text' style='margin-bottom:0px !important; font-weight: 500; font-size: 1.3rem;'>Wajib diisi</label>",
                            maxlength: "Your name maxlength should be 50 characters long."
                        },
                        provinsi_id: {
                            required: "<label class='text-danger error-text' style='margin-bottom:0px !important; font-weight: 500; font-size: 1.3rem;'>Wajib diisi</label>",
                            maxlength: "The email name should less than or equal to 50 characters",
                        },
                        kota_id: {
                            required: "<label class='text-danger error-text' style='margin-bottom:0px !important; font-weight: 500; font-size: 1.3rem;'>Wajib diisi</label>",
                            maxlength: "Your message name maxlength should be 300 characters long."
                        },
                        alamat: {
                            required: "<label class='text-danger error-text' style='margin-bottom:0px !important; font-weight: 500; font-size: 1.3rem;'>Wajib diisi</label>",
                            maxlength: "Your message name maxlength should be 300 characters long."
                        },
                    },
                    submitHandler: function(form) {
                        var data = new FormData();
                        // Form data (Input yang ada di FORM, kecuali type file)
                        var form_data = $('#form-tambah-alamat-pengguna').serializeArray();
                        $.each(form_data, function(key, input) {
                            data.append(input.name, input.value);
                        });

                        //KASUS : Jika id tidak ditemukan maka ketika menekan tombol submit maka halaman akan reload
                        // data.append('pengguna_id', id);

                        //Custom data
                        data.append('key', 'value');

                        // AJAX request
                        $.ajax({
                            url: "{{ route('customer.TambahAlamatPengguna') }}",
                            method: "POST",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: data,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            beforeSend: function() {
                                $(document).find('label.error-text').text('');
                            },
                            success: function(data) {
                                if (data.status_gagal_tambah_alamat == 1) {
                                    $.each(data.error, function(prefix, val) {
                                        $('label.' + prefix + '_error').text(val[
                                            0]);
                                        // $('span.'+prefix+'_error').text(val[0]);
                                    });
                                } else if (data.status_berhasil_tambah_alamat == 1) {
                                    $("#modal-form-tambah-alamat-pengguna").modal('hide');
                                    const Toast = Swal.mixin({
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 3000,
                                        timerProgressBar: true,
                                        didOpen: (toast) => {
                                            toast.addEventListener('mouseenter',
                                                Swal
                                                .stopTimer)
                                            toast.addEventListener('mouseleave',
                                                Swal
                                                .resumeTimer)
                                        }
                                    })

                                    Toast.fire({
                                        icon: 'success',
                                        title: data.msg
                                    })
                                    $("#alamat-customer").load(location.href +
                                        " #alamat-customer>*", "");
                                }
                            }
                        });
                    }
                })
            }
        });
    </script>
@endpush
