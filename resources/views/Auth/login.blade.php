@extends('Front.layout.master', ['title' => 'Login'])
@section('konten')
    <div class="login-page bg-image pt-8 pb-8 pt-md-12 pb-md-12 pt-lg-17 pb-lg-17"
        style="background-image: url({{ asset('Front/assets/images/slide-3.jpg') }})">
        <div class="container">
            <div class="form-box">
                <div class="form-tab">
                    <ul class="nav nav-pills nav-fill" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="signin-tab-2" data-toggle="tab" href="#signin-2" role="tab"
                                aria-controls="signin-2" aria-selected="false">Selamat Datang</a>
                        </li>
                    </ul>

                    <form action="{{ route('UserLogin') }}" method="POST" id="form-login-user">
                        @csrf

                        <div class="row">

                            <div class="col col-12">
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
                                    <label for="singin-password-2">Password *</label>
                                    <input type="password" id="frm-reg-pass" name="password"
                                        class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                                    {{-- <span class="input-group-text" onclick="password_login_show();">
                                        <i class="fas fa-eye" id="show_eye"></i>
                                        <i class="fas fa-eye-slash d-none" id="hide_eye"></i>
                                    </span> --}}
                                    <div class="input-group has-validation">
                                        <label class="text-danger error-text password_error"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-12">
                                <div class="form-footer">
                                    <button type="submit" class="btn btn-outline-primary-2 btn-block" style="width:100%">
                                        <span>Masuk</span>
                                        <i class="icon-long-arrow-right"></i>
                                    </button>
                                </div><!-- End .form-footer -->
                            </div>

                            <div class="col col-12">
                                <div class="form-footer d-flex justify-content-center">
                                    Belum punya akun? <a href="{{ route('Register') }}" style="text-decoration:none;">&nbsp;
                                        <strong style="color: #c96">
                                            Daftar</strong></a>
                                </div><!-- End .form-footer -->
                            </div>
                        </div>
                    </form>

                </div><!-- End .form-tab -->
            </div><!-- End .form-box -->
        </div><!-- End .container -->
    </div><!-- End .login-page section-bg -->
@endsection
