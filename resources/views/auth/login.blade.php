<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Penggajian Karyawan | Log in</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('public/admin/asset/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('public/admin/asset/dist/css/adminlte.min.css') }}">
    @yield('css')
</head>


<body class="hold-transition login-page">
    <div class="login center">
        <section class=" text-center text-lg-start">
            <style>
                .center {
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                }

                .rounded-t-5 {
                    border-top-left-radius: 0.5rem;
                    border-top-right-radius: 0.5rem;
                }

                @media (min-width: 992px) {
                    .rounded-tr-lg-0 {
                        border-top-right-radius: 0;
                    }

                    .rounded-bl-lg-5 {
                        border-bottom-left-radius: 0.5rem;
                    }
                }
            </style>
            <div class="card mb-3">
                <div class="row g-0 d-flex">
                    <div class="col-lg-5 d-none d-lg-flex">
                        <img src="{{ asset('public/img/logo.png') }}"
                            alt="PT. GASABA SUKSES MANDIRI" class="img-responsive rounded-t-5 rounded-tr-lg-0 rounded-bl-lg-5"/>
                    </div>
                    <div class="col-lg-7">
                        <div class="card-body py-5 px-md-5">
                            <p>MASUK KE HALAMAN SISTEM</p>
                            <p>PT. GASABA SUKSES MANDIRI</p>
                            <form method="POST" action="{{ route('login') }}" id="form">
                                @csrf
                                <!-- Email input -->
                                <div class="input-group mb-3">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Email" name="email" id="email">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-envelope"></span>
                                        </div>
                                    </div>
                                </div>
                                @error('email')
                                    <span class="error invalid-feedback" style="display: block;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="input-group mb-3">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Password" name="password" id="password">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-lock"></span>
                                        </div>
                                    </div>
                                </div>
                                @error('password')
                                    <span class="error invalid-feedback" style="display: block;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="row">
                                    <div class="col-4">
                                        <button type="submit" class="btn btn-primary btn-block">Masuk</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="{{ asset('public/admin/asset/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('public/admin/asset/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('public/admin/asset/dist/js/adminlte.js') }}"></script>
    <script src="{{ asset('public/admin/asset/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('public/admin/asset/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('public/admin/asset/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('public/admin/asset/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <script>
        $('#form').validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                },
                password: {
                    required: true,
                },
            },
            messages: {
                email: {
                    required: "Email Harus Di isi!",
                    email: "Harus Berupa Alamat Email"
                },
                password: {
                    required: "Password Harus Di isi!",
                },
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.input-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    </script>
</body>

</html>
