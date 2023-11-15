<!-- Plugins JS File -->
<script src="{{ asset('Front/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('Front/assets/js/jquery.colorbox.js') }}"></script>
<script src="{{ asset('Front/assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('Front/assets/js/jquery.hoverIntent.min.js') }}"></script>
<script src="{{ asset('Front/assets/js/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('Front/assets/js/superfish.min.js') }}"></script>
<script src="{{ asset('Front/assets/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('Front/assets/js/bootstrap-input-spinner.js') }}"></script>
<script src="{{ asset('Front/assets/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('Front/assets/js/jquery.plugin.min.js') }}"></script>
<script src="{{ asset('Front/assets/js/jquery.countdown.min.js') }}"></script>
<script src="{{ asset('Front/assets/js/jquery.elevateZoom.min.js') }}"></script>
<script src="{{ asset('Back/assets/vendors/form/jquery.form.min.js') }}"></script>
<script src="{{ asset('Back/assets/vendors/validate/jquery.validate.min.js') }}"></script>
<script src="{{ asset('Back/assets/vendors/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('Back/assets/vendors/sweetalert2/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('Front/assets/js/jquery.sticky-kit.min.js') }}"></script>
<!-- Main JS File -->
<script src="{{ asset('Front/assets/js/main.js') }}"></script>
<script src="{{ asset('Front/assets/js/demos/demo-13.js') }}"></script>
<script src="https://cdn.jsdelivr.net/gh/Talv/x-editable@develop/dist/bootstrap4-editable/js/bootstrap-editable.min.js">
</script>


{{-- User Registrasi --}}
<script>
    $(document).ready(function() {
        //Examples of how to assign the Colorbox event to elements
        $(".group1").colorbox({
            rel: "group1"
        });
        //Example of preserving a JavaScript event for inline calls.
        $("#click").click(function() {
            var maxHeight = $(window).height() - 30 + "px";
            $("#click")
                .css({
                    "max-height": maxHeight,
                    "background-color": "#f00",
                    color: "#fff",
                    cursor: "inherit",
                })
                .text(
                    "Open this window again and this message will still be here."
                );
            return false;
        });
    });

    $('#form-register-user').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: new FormData(this),
            processData: false,
            dataType: 'json',
            contentType: false,
            beforeSend: function() {
                $(document).find('label.error-text').text('');
            },
            success: function(data) {
                if (data.status == 0) {
                    $.each(data.error, function(prefix, val) {
                        $('label.' + prefix + '_error').text(val[0]);
                        // $('span.'+prefix+'_error').text(val[0]);
                    });
                } else if (data.status == 1) {
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
                        }),
                        setTimeout(function() {
                            window.location.href = `${data.route}`;
                        }, 1000); // 1 second
                }
            }
        });
    });

    // User Login
    $('#form-login-user').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: new FormData(this),
            processData: false,
            dataType: 'json',
            contentType: false,
            beforeSend: function() {
                $(document).find('label.error-text').text('');
            },
            success: function(data) {
                if (data.status == 0) {
                    $.each(data.error, function(prefix, val) {
                        $('label.' + prefix + '_error').text(val[0]);
                        // $('span.'+prefix+'_error').text(val[0]);
                    });
                } else if (data.status == 1) {
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
                        }),
                        setTimeout(function() {
                            window.location.href = `${data.route}`;
                        }, 1000); // 1 second
                } else if (data.status == 2) {
                    swal({
                        title: "Gagal",
                        text: `${data.msg}`,
                        icon: "error",
                        buttons: true,
                        successMode: true,
                    });
                }
            }
        });
    });
</script>

{{-- Tampilkan Password --}}
<script>
    function password_login_show() {
        var x = document.getElementById("password_user");
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
</script>

{{-- Pilih Provinsi dan Kota --}}
<script>
    $(document).ready(function() {
        //active select2
        // $(".provinsi, .kota").select2({
        //     theme:'bootstrap4',dropdownCssClass: "bigdrop",
        // });
        //ajax select kota asal
        $('select[name="provinsi_id"]').on('change', function() {
            let provinsi_id = $(this).val();
            if (provinsi_id) {
                jQuery.ajax({
                    url: '/kota/' + provinsi_id,
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        $('select[name="kota_id"]').empty();
                        $('select[name="kota_id"]').append(
                            '<option value="">-- Pilih Kota --</option>');
                        $.each(response, function(key, value) {
                            $('select[name="kota_id"]').append('<option value="' +
                                key + '">' + value + '</option>');
                        });
                    },
                });
            } else {
                $('select[name="kota_id"]').append('<option value="">-- Pilih Kota --</option>');
            }
        });
    });
</script>
