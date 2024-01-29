<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>{{ ucfirst($submenu) . ' | ' . strtoupper($title) }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <link rel="shortcut icon" href="{{ URL::asset('assets/assets/images/logo/icon.png') }}">
    <link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-primary bg-soft">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary" style="padding: 15px 0px 0px 25px;">
                                        <h5 class="text-primary">Welcome Back !</h5>
                                        Sign in to
                                        <p>Information Absensi Damkar.</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="{{ URL::asset('assets/images/profile-img.png') }}" alt=""
                                        class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="auth-logo">
                                <a href="#" class="auth-logo-dark">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <img src="{{ URL::asset('assets/images/redkar.png') }}"
                                                alt="" class="rounded-circle" height="54">
                                        </span>
                                    </div>
                                </a>
                            </div>
                            @if (count($errors) > 0)
                                <div class="p-2">
                                    <div class="alert alert-danger" role="alert">
                                        Login Fail!
                                    </div>
                                </div>
                            @endif
                            @if (session()->has('Error'))
                                <div class="p-2">
                                    <div class="alert alert-danger" role="alert">
                                        Verifikasi Fail!
                                    </div>
                                </div>
                            @endif
                            @if (session()->has('loginError'))
                                <div class="p-2">
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('loginError') }}
                                    </div>
                                </div>
                            @endif
                            @if (session()->has('registerSucces'))
                                <div class="p-2">
                                    <div class="alert alert-success" role="alert">
                                        Register Succes!
                                    </div>
                                </div>
                            @endif
                            <div class="p-2">
                                <form class="needs-validation" action="{{ route('login.proses') }}" method="POST"
                                    novalidate>
                                    @csrf
                                    <div class="mb-3">
                                        <label for="validationCustom02" class="form-label">Email</label>
                                        <input type="text" class="form-control" name="email" id="email"
                                            placeholder="Email" autocomplete="off" autofocus
                                           required>
                                        <div class="invalid-feedback">
                                            Mohon masukan Email anda!
                                        </div>
                                        {{-- {!! $errors->first('email', '<div class="invalid-validasi" style="color:red">:message</div>') !!} --}}
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <div class="input-group auth-pass-inputgroup">
                                            <input type="password" name="password" minlength="5" class="form-control"
                                                placeholder="Password" aria-label="Password"
                                                aria-describedby="password-addon" required>
                                            <button class="btn btn-light" type="button" id="password-addon"><i
                                                    class="mdi mdi-eye-outline"></i></button>
                                            <div class="invalid-feedback">
                                                Silahkan Masukan kata Sandi dan kata Sandi harus terdiri dari 5 karakter
                                                atau lebih!
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3 d-grid">
                                        <button class="btn btn-primary waves-effect waves-light" type="submit">Log
                                            In</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 text-center">
                        <div>
                            <script>
                                document.write(new Date().getFullYear())
                            </script> | Absensi Damkar
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-validation.init.js') }}"></script>
</body>

</html>
