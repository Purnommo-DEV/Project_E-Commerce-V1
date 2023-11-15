<div class="modal fade" id="modal-form-ubah-akun-pengguna" tabindex="-1"
    aria-labelledby="modal-form-ubah-akun-penggunaLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-form-ubah-akun-penggunaLabel">
                    Ubah Akun</h5>
                <button type="button" class="close batal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" style="padding: 3rem !important;">
                <form id="form-ubah-akun-pengguna" enctype="multipart/form-data">
                    {{-- form-group Produk Detail  --}}
                    <div class="form-group">
                        <div class="row">
                            <div class="col col-12">
                                <div class="row justify-content-center">
                                    <div class="d-flex justify-content-center mb-2">
                                        <img id="preview-foto" name="foto" class="object-fit-fill border"
                                            style="aspect-ratio: 1/1; border-radius: 11.25rem!important; max-width: 20%;"
                                            src="{{ asset('storage/' . Auth::user()->foto) }}"
                                            alt="User profile picture">
                                    </div>

                                    <div class="col col-4">
                                        <label class="text-center btn btn-sm btn-rounded btn-block sewa_id_upload"
                                            style="background-color: #f3f3f9; color: black;font-weight: bold;">Pilih
                                            Foto
                                            <input name="foto" id="foto" accept="image/png, image/jpeg"
                                                type="file" style="display: none;">
                                    </div>
                                </div>
                            </div>
                            <div class="col col-12">
                                <div class="form-group" style="margin-bottom:0px !important;">
                                    <label for="singin-password-2">Nama</label>
                                    <input type="text" name="name"
                                        class="form-control @error('alamat') is-invalid @enderror"
                                        placeholder="Masukkan Nama Lengkap">
                                    <div class="input-group has-validation">
                                        <label class="text-danger error-text name_error"></label>
                                    </div>
                                </div>
                                <div class="form-group"
                                    style="margin-bottom:0px
                                    !important;">
                                    <label for="singin-password-2">Jenis Kelamin</label>
                                    <select class="form-control provinsi" name="jk" aria-hidden="true">
                                        <option value="" selected disabled>-- Pilih Jenis Kelamin --</option>
                                    </select>
                                    <div class="input-group has-validation">
                                        <label class="text-danger error-text jk_error"></label>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-bottom:0px !important;">
                                    <label for="singin-password-2">Email</label>
                                    <input type="text" name="email" class="form-control"
                                        placeholder="Masukkan Email Aktif">
                                    <div class="input-group has-validation">
                                        <label class="text-danger error-text email_error"></label>
                                    </div>
                                </div>
                                <div class="form-group"
                                    style="margin-bottom:0px
                                    !important;">
                                    <label for="singin-password-2">Nomor Hp</label>
                                    <input type="text" name="nomor_hp"
                                        class="form-control @error('nomor_hp') is-invalid @enderror"
                                        placeholder="Masukkan Nomor Aktif">
                                    <div class="input-group has-validation">
                                        <label class="text-danger error-text nomor_hp_error"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary batal"
                                data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                        </div>
                </form>

            </div>
        </div>
    </div>
</div>
@push('script')
    <script>
        $('.sewa_id_upload').click(function() {
            $(document).ready(function(e) {
                $("#foto").change(function() {

                    let file = this.files[0];
                    // console.log(file);
                    let reader = new FileReader();

                    if (file['size'] < 2111775) {
                        reader.onload = (e) => {
                            $("#preview-foto").attr('src', e.target.result);
                        }
                        reader.readAsDataURL(this.files[0]);
                        $(".button_upload").removeAttr("hidden");
                    } else {
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
                            title: 'Ukuran gambar terlalu besar'
                        })
                        $("#foto").val(null);
                        $(".button_upload").attr("hidden", false);
                        // $('#preview-KTP').attr('src', '')
                    }

                });
            });
        })

        let pengguna = @json($pengguna);
        $(document).on('click', '.ubah-akun', function(event) {
            const id = "{{ Auth::user()->id }}";
            $("#modal-form-ubah-akun-pengguna").modal('show');
            $("#form-ubah-akun-pengguna [name='name']").val(pengguna.name);
            $("#form-ubah-akun-pengguna [name='email']").val(pengguna.email);
            $("#form-ubah-akun-pengguna [name='nomor_hp']").val(pengguna.nomor_hp);
            $("#form-ubah-akun-pengguna [name='jk']").append(
                $(
                    `<option value='laki-laki' ${'Laki-laki' === pengguna.jk ? 'selected' : ''}>Laki-laki</option>
                <option value='perempuan' ${'Perempuan' === pengguna.jk ? 'selected' : ''}>Perempuan</option>`
                ))

            if ($("#form-ubah-akun-pengguna").length > 0) {
                $("#form-ubah-akun-pengguna").validate({
                    rules: {
                        name: {
                            required: true,
                            maxlength: 50
                        },
                        email: {
                            required: true,
                            maxlength: 50,
                            email: true,
                        },
                        message: {
                            required: true,
                            maxlength: 300
                        },
                    },
                    messages: {
                        name: {
                            required: "<label class='text-danger error-text' style='margin-bottom:0px !important; font-weight: 500; font-size: 1.3rem;'>Wajib diisi</label>",
                            maxlength: "Your name maxlength should be 50 characters long."
                        },
                        email: {
                            required: "Wajib diisi",
                            email: "Masukkan email dengan benar",
                            maxlength: "The email name should less than or equal to 50 characters",
                        },
                        message: {
                            required: "Please enter message",
                            maxlength: "Your message name maxlength should be 300 characters long."
                        },
                    },
                    submitHandler: function(form) {

                        var data = new FormData();

                        // Form data (Input yang ada di FORM, kecuali type file)
                        var form_data = $('#form-ubah-akun-pengguna').serializeArray();
                        $.each(form_data, function(key, input) {
                            data.append(input.name, input.value);
                        });

                        // Form data (Input tambahan di luar dari Form)
                        data.append('pengguna_id', id);

                        // Form data (Input dengan type file)
                        var file_data = $('input[name="foto"]')[0].files;
                        for (var i = 0; i < file_data.length; i++) {
                            data.append("foto", file_data[i]);
                        }

                        //Custom data
                        data.append('key', 'value');

                        // AJAX request
                        $.ajax({
                            url: "{{ route('customer.UbahAkunPengguna') }}",
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
                                if (data.status_gagal_ubah_profil == 1) {
                                    $.each(data.error, function(prefix, val) {
                                        $('label.' + prefix + '_error').text(val[
                                            0]);
                                    });
                                } else if (data.status_berhasil_ubah_profil == 1) {
                                    $("#modal-form-ubah-akun-pengguna").modal('hide');
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
                                    $("#profil-customer").load(location.href +
                                        " #profil-customer>*", "");
                                }
                            }
                        });
                    }
                })
            }
        });
    </script>
@endpush
