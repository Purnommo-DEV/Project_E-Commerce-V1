<div class="modal fade" id="modal-form-ubah-alamat-pengguna" tabindex="-1"
    aria-labelledby="modal-form-ubah-alamat-penggunaLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-form-ubah-alamat-penggunaLabel">
                    Ubah Alamat</h5>
                <button type="button" class="close batal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" style="padding: 3rem !important;">

                <form id="form-ubah-alamat-pengguna">
                    {{-- form-group Produk Detail  --}}
                    <div class="form-group">
                        <div class="row">
                            <div class="col col-6">
                                <input type="hidden" id="alamat_id" style="display: none;">
                                <div class="form-group">
                                    <label for="singin-password-2">Penerima</label>
                                    <input type="text" id="nama_edit" name="nama"
                                        class="form-control @error('alamat') is-invalid @enderror"
                                        placeholder="Jl. Alianyang, Gg. Sawi 2">
                                    <div class="input-group has-validation">
                                        <label class="text-danger error-text nama_error"></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="singin-password-2">Alamat</label>
                                    <input type="text" id="alamat_edit" name="alamat"
                                        value="{{ $data_alamat_pengguna->alamat }}"
                                        class="form-control @error('alamat') is-invalid @enderror"
                                        placeholder="Jl. Alianyang, Gg. Sawi 2">
                                    <div class="input-group has-validation">
                                        <label class="text-danger error-text alamat_error"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-6">
                                <div class="form-group">
                                    <label for="singin-password-2">Provinsi</label>
                                    {{-- <select class="form-control provinsi" name="provinsi_id" aria-hidden="true">
                                        <option value="" selected disabled>--
                                            Pilih Provinsi --</option>
                                        @foreach ($provinsi as $provinsis => $value)
                                            @if ($data_alamat_pengguna->provinsi_id == $provinsis)
                                                <option value="{{ $provinsis }}" selected>
                                                    {{ $value }}
                                                </option>
                                            @else
                                                <option value="{{ $provinsis }}">
                                                    {{ $value }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select> --}}
                                    <select class="form-control provinsi" name="provinsi_id" id="provinsi_id"
                                        aria-hidden="true">
                                        <option value="" selected disabled>-- Pilih Provinsi --</option>
                                    </select>
                                    <div class="input-group has-validation">
                                        <label class="text-danger error-text provinsi_id_error"></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="singin-password-2">Kota</label>
                                    <select class="form-control kota" id="kota_id" name="kota_id" aria-hidden="true">
                                        <option value="" required>-- Pilih
                                            Kota --</option>
                                    </select>
                                    <div class="input-group has-validation">
                                        <label class="text-danger error-text kota_id_error"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary batal"
                            data-dismiss="modal">Batal</button>
                        <button class="btn btn-sm btn-primary" id="btn-submit-ubah-alamat">Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@push('script')
    <script>
        $('body').on('click', '#btn-modal-ubah-alamat', function() {
            let alamat_id = $(this).data('id');
            //fetch detail post with ajax
            $.ajax({
                url: `/customer/data-alamat-customer/${alamat_id}`,
                type: "GET",
                cache: false,
                success: function(response) {
                    //fill data to form
                    $('#alamat_id').val(response.data_alamat.id);
                    $('#nama_edit').val(response.data_alamat.nama);
                    $('#alamat_edit').val(response.data_alamat.alamat);
                    $.each(response.data_provinsi, function(key, value) {
                        $('select[name="provinsi_id"]')
                            .append(
                                `<option value="${key}" ${key == response.data_alamat.provinsi_id ? 'selected' : ''}>${value}</option>`
                            )
                    });
                    $.each(response.data_kota, function(key, value) {
                        $('select[name="kota_id"]')
                            .append(
                                `<option value="${key}" ${key == response.data_alamat.kota_id ? 'selected' : ''}>${value}</option>`
                            )
                    });

                    $('#modal-form-ubah-alamat-pengguna').modal('show');
                }
            });
        });

        $('#form-ubah-alamat-pengguna').on('submit', function(e) {
            const id = $('#alamat_id').val();
            e.preventDefault();
            var data = new FormData();
            // Form data (Input yang ada di FORM, kecuali type file)
            var form_data = $('#form-ubah-alamat-pengguna').serializeArray();
            $.each(form_data, function(key, input) {
                data.append(input.name, input.value);
            });

            //KASUS : Jika id tidak ditemukan maka ketika menekan tombol submit maka halaman akan reload
            // data.append('pengguna_id', id);

            //Custom data
            data.append('key', 'value');

            // AJAX request
            $.ajax({
                url: `/customer/ubah-alamat-pengguna/${id}`,
                type: "POST",
                cache: false,
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
                    if (data.status_gagal_ubah_alamat == 1) {
                        $.each(data.error, function(prefix, val) {
                            $('label.' + prefix + '_error').text(val[
                                0]);
                            // $('span.'+prefix+'_error').text(val[0]);
                        });
                    } else if (data.status_berhasil_ubah_alamat == 1) {
                        $("#modal-form-ubah-alamat-pengguna").modal('hide');
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
        });


        // $(document).on('click', '#btn-submit-ubah-alamat', function(event) {
        //     let alamat_id = $('#alamat_id').val();
        //     if ($("#form-ubah-alamat-pengguna").length > 0) {
        //         $("#form-ubah-alamat-pengguna").validate({
        //             rules: {
        //                 nama: {
        //                     required: true,
        //                     maxlength: 50
        //                 },
        //                 provinsi_id: {
        //                     required: true,
        //                     maxlength: 50,
        //                 },
        //                 kota_id: {
        //                     required: true,
        //                     maxlength: 300
        //                 },
        //                 alamat: {
        //                     required: true,
        //                     maxlength: 300
        //                 },
        //             },
        //             messages: {
        //                 nama: {
        //                     required: "<label class='text-danger error-text' style='margin-bottom:0px !important; font-weight: 500; font-size: 1.3rem;'>Wajib diisi</label>",
        //                     maxlength: "Your name maxlength should be 50 characters long."
        //                 },
        //                 provinsi_id: {
        //                     required: "<label class='text-danger error-text' style='margin-bottom:0px !important; font-weight: 500; font-size: 1.3rem;'>Wajib diisi</label>",
        //                     maxlength: "The email name should less than or equal to 50 characters",
        //                 },
        //                 kota_id: {
        //                     required: "<label class='text-danger error-text' style='margin-bottom:0px !important; font-weight: 500; font-size: 1.3rem;'>Wajib diisi</label>",
        //                     maxlength: "Your message name maxlength should be 300 characters long."
        //                 },
        //                 alamat: {
        //                     required: "<label class='text-danger error-text' style='margin-bottom:0px !important; font-weight: 500; font-size: 1.3rem;'>Wajib diisi</label>",
        //                     maxlength: "Your message name maxlength should be 300 characters long."
        //                 },
        //             },

        //             submitHandler: function(form) {
        //                 var data = new FormData();
        //                 // Form data (Input yang ada di FORM, kecuali type file)
        //                 var form_data = $('#form-ubah-alamat-pengguna').serializeArray();
        //                 $.each(form_data, function(key, input) {
        //                     data.append(input.name, input.value);
        //                 });

        //                 //KASUS : Jika id tidak ditemukan maka ketika menekan tombol submit maka halaman akan reload
        //                 // data.append('pengguna_id', id);

        //                 //Custom data
        //                 data.append('key', 'value');

        //                 // AJAX request
        //                 $.ajax({
        //                     url: `/customer/ubah-alamat-pengguna/${alamat_id}`,
        //                     type: "PUT",
        //                     cache: false,
        //                     headers: {
        //                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //                     },
        //                     data: data,
        //                     contentType: false,
        //                     processData: false,
        //                     dataType: 'json',
        //                     beforeSend: function() {
        //                         $(document).find('label.error-text').text('');
        //                     },
        //                     success: function(data) {
        //                         if (data.status_gagal_ubah_alamat == 1) {
        //                             $.each(data.error, function(prefix, val) {
        //                                 $('label.' + prefix + '_error').text(val[
        //                                     0]);
        //                                 // $('span.'+prefix+'_error').text(val[0]);
        //                             });
        //                         } else if (data.status_berhasil_ubah_alamat == 1) {
        //                             $("#modal-form-ubah-alamat-pengguna").modal('hide');
        //                             const Toast = Swal.mixin({
        //                                 toast: true,
        //                                 position: 'top-end',
        //                                 showConfirmButton: false,
        //                                 timer: 3000,
        //                                 timerProgressBar: true,
        //                                 didOpen: (toast) => {
        //                                     toast.addEventListener('mouseenter',
        //                                         Swal
        //                                         .stopTimer)
        //                                     toast.addEventListener('mouseleave',
        //                                         Swal
        //                                         .resumeTimer)
        //                                 }
        //                             })

        //                             Toast.fire({
        //                                 icon: 'success',
        //                                 title: data.msg
        //                             })
        //                             $("#alamat-customer").load(location.href +
        //                                 " #alamat-customer>*", "");
        //                         }
        //                     }
        //                 });
        //             }
        //         })
        //     }
        // });
    </script>
@endpush
