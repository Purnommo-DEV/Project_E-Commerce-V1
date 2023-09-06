@extends('Front.layout.master', ['title' => 'Login'])
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
                            <form class="form-stl" action="{{ route('UserLogin') }}" method="POST" id="form-login-user">
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
                                    </div>
                                    <div class="col col-12">
                                        <div class="form-footer">
                                            <button type="submit" class="btn btn-outline-primary-2 btn-block"
                                                style="width:100%">
                                                <span>Masuk</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>
                                        </div><!-- End .form-footer -->
                                    </div>
                                </div>
                            </form>
                            <div class="form-choice">
                                <div class="col col-12">
                                    <div class="form-footer">
                                        <a href="{{ route('Register') }}" class="btn btn-sm-outline-default btn-block"
                                            style="width:100%">Register</p>
                                    </div><!-- End .form-footer -->
                                </div>
                                {{-- <div class="row">
                                    <div class="col-sm-6">
                                        <a href="#" class="btn btn-login btn-g">
                                            <i class="icon-google"></i>
                                            Login With Google
                                        </a>
                                    </div><!-- End .col-6 -->
                                    <div class="col-sm-6">
                                        <a href="#" class="btn btn-login btn-f">
                                            <i class="icon-facebook-f"></i>
                                            Login With Facebook
                                        </a>
                                    </div><!-- End .col-6 -->
                                </div><!-- End .row --> --}}
                            </div><!-- End .form-choice -->
                        </div><!-- .End .tab-pane -->
                    </div><!-- End .tab-content -->
                </div><!-- End .form-tab -->
            </div><!-- End .form-box -->
        </div><!-- End .container -->
    </div><!-- End .login-page section-bg -->
@endsection
