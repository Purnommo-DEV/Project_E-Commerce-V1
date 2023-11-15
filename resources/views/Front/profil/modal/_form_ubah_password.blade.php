<div class="modal fade" id="ubahPassword" tabindex="-1" aria-labelledby="modal-form-ubah-alamat-penggunaLabel"
    aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-form-ubah-alamat-penggunaLabel">
                    Ubah Password</h5>
                <button type="button" class="close batal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" style="padding: 3rem !important;">

                <form class="forms-sample" id="form-ubah-password">
                    {{-- form-group Produk Detail  --}}
                    <div class="form-group">
                        <div class="col">
                            <label for="validationCustom01" class="form-label" style="font-size: medium;">Password
                                Lama</label>
                            <div class="input-group has-validation">
                                <input name="passwordlama" type="password" class="form-control" id="passwordlama" />
                                <span class="input-group-text" onclick="password_show_hide1();">
                                    <i class="bi bi-eye" id="show_eye"></i>
                                    <i class="bi bi-eye-slash d-none" id="hide_eye"></i>
                                </span>
                                <div class="input-group has-validation">
                                    <label class="text-danger error-text passwordlama_error"></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col">
                            <label for="validationCustom01" class="form-label" style="font-size: medium;">Password
                                Baru</label>
                            <div class="input-group has-validation">
                                <input name="password" type="password" class="input form-control" id="password" />
                                <span class="input-group-text" onclick="password_show_hide2();">
                                    <i class="bi bi-eye" id="show_eye2"></i>
                                    <i class="bi bi-eye-slash d-none" id="hide_eye2"></i>
                                </span>
                                <div class="input-group has-validation">
                                    <label class="text-danger error-text password_error"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col">
                            <label for="validationCustom01" class="form-label" style="font-size: medium;">Konfirmasi
                                Password Baru</label>
                            <div class="input-group has-validation">
                                <input name="konfirmasipasswordbaru" type="password" class="input form-control"
                                    id="konfirmasipasswordbaru" />
                                <span class="input-group-text" onclick="password_show_hide3();">
                                    <i class="bi bi-eye" id="show_eye3"></i>
                                    <i class="bi bi-eye-slash d-none" id="hide_eye3"></i>
                                </span>
                                <div class="input-group has-validation">
                                    <label class="text-danger error-text konfirmasipasswordbaru_error"></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary batal"
                            data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-sm btn-primary"
                            id="btn-submit-ubah-alamat">Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        $('#form-ubah-password').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('customer.UbahPassword') }}",
                method: "POST",
                data: new FormData(this),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {
                    // $(document).find('span.error-text').text('');
                    $(document).find('label.error-text').text('');
                },
                success: function(data) {
                    if (data.status == 0) {
                        $.each(data.error, function(prefix, val) {

                            $('label.' + prefix + '_error').text(val[0]);
                            // $('span.'+prefix+'_error').text(val[0]);
                        });
                    } else {
                        $('#form-ubah-password')[0].reset();
                        // alert(data.msg);
                        swal("Berhasil!", data.msg, "success");
                    }
                }
            });
        });

        function password_show_hide1() {
            var x = document.getElementById("passwordlama");
            var show_eye = document.getElementById("show_eye");
            var hide_eye = document.getElementById("hide_eye");
            hide_eye.classList.remove("d-none");
            if (x.type === "password") {
                x.type = "text";
                show_eye.style.display = "none";
                hide_eye.style.display = "block";
            } else {
                x.type = "password";
                show_eye.style.display = "block";
                hide_eye.style.display = "none";
            }
        }

        function password_show_hide2() {
            var x = document.getElementById("password");
            var show_eye = document.getElementById("show_eye2");
            var hide_eye = document.getElementById("hide_eye2");
            hide_eye.classList.remove("d-none");
            if (x.type === "password") {
                x.type = "text";
                show_eye.style.display = "none";
                hide_eye.style.display = "block";
            } else {
                x.type = "password";
                show_eye.style.display = "block";
                hide_eye.style.display = "none";
            }
        }

        function password_show_hide3() {
            var x = document.getElementById("konfirmasipasswordbaru");
            var show_eye = document.getElementById("show_eye3");
            var hide_eye = document.getElementById("hide_eye3");
            hide_eye.classList.remove("d-none");
            if (x.type === "password") {
                x.type = "text";
                show_eye.style.display = "none";
                hide_eye.style.display = "block";
            } else {
                x.type = "password";
                show_eye.style.display = "block";
                hide_eye.style.display = "none";
            }
        }
    </script>
@endpush
