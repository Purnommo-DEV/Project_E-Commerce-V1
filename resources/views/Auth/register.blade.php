@extends('Front.layout.master', ['title' => 'Register'])
@section('konten')
    <div class="login-page bg-image pt-8 pb-8 pt-md-12 pb-md-12 pt-lg-17 pb-lg-17"
        style="background-image: url({{ asset('gambar/bg_loginRegister/bg.jpg') }})">
        <div class="container">
            <div class="form-box">
                <div class="form-tab">
                    <ul class="nav nav-pills nav-fill" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="signin-tab-2" data-toggle="tab" href="#signin-2" role="tab"
                                aria-controls="signin-2" aria-selected="false">Selamat Datang di </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="signin-2" role="tabpanel"
                            aria-labelledby="signin-tab-2">
                            <form class="form-stl" action="{{ route('UserRegister') }}" method="POST"
                                id="form-register-user">
                                @csrf
                                <div class="row">
                                    <div class="col col-6">
                                        <div class="form-group">
                                            <label for="singin-email-2">Nama Lengkap</label>
                                            <input type="text" id="frm-reg-lname" name="name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                placeholder="Purnomo Dev">
                                            <div class="input-group has-validation">
                                                <label class="text-danger error-text name_error"></label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="singin-password-2">Email</label>
                                            <input type="email" id="frm-reg-email" name="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                placeholder="contoh@gmail.com">
                                            <div class="input-group has-validation">
                                                <label class="text-danger error-text email_error"></label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="singin-password-2">Nomor Hp</label>
                                            <input type="text" id="frm-reg-email" name="nomor_hp"
                                                class="form-control @error('nomor_hp') is-invalid @enderror"
                                                placeholder="0895704043814">
                                            <div class="input-group has-validation">
                                                <label class="text-danger error-text nomor_hp_error"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col col-6">
                                        <div class="form-group">
                                            <label for="singin-password-2">Password *</label>
                                            <input type="password" id="frm-reg-pass" name="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                placeholder="Password">
                                            <span class="input-group-text" onclick="password_login_show();">
                                                <i class="fas fa-eye" id="show_eye"></i>
                                                <i class="fas fa-eye-slash d-none" id="hide_eye"></i>
                                            </span>
                                            <div class="input-group has-validation">
                                                <label class="text-danger error-text password_error"></label>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="singin-password-2">Alamat</label>
                                            <input type="text" id="frm-reg-email" name="alamat"
                                                class="form-control @error('alamat') is-invalid @enderror"
                                                placeholder="Jl. Alianyang, Gg. Sawi 2">
                                            <div class="input-group has-validation">
                                                <label class="text-danger error-text alamat_error"></label>
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
                                        <div class="form-footer">
                                            <button type="submit" class="btn btn-outline-primary-2 btn-block"
                                                style="width:100%">
                                                <span>Daftar</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>
                                        </div><!-- End .form-footer -->
                                    </div>
                                </div>
                            </form>
                        </div><!-- .End .tab-pane -->
                    </div><!-- End .tab-content -->
                </div><!-- End .form-tab -->
            </div><!-- End .form-box -->
        </div><!-- End .container -->
    </div><!-- End .login-page section-bg -->
@endsection
