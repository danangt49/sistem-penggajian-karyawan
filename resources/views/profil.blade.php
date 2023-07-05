@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Profil</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Profil</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <section class="content">
                    <div class="container-fluid">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card card-primary card-outline">
                                    <div class="card-body box-profile">
                                        <div class="text-center">
                                            <img class="profile-user-img img-fluid img-circle"
                                                src="{{ asset('public/img/user.png') }}" alt="User profile picture">
                                        </div>
                                        <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>
                                        <ul class="list-group list-group-unbordered mb-3">
                                            <li class="list-group-item">
                                                <b>Nama</b> <a class="float-right">{{ Auth::user()->name }}</a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Email</b> <a class="float-right">{{ Auth::user()->email }}</a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Level</b> <a class="float-right">{{ Auth::user()->level }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-header p-2">
                                        <ul class="nav nav-pills">
                                            <li class="nav-item"><a class="nav-link" href="#info"
                                                    data-toggle="tab">Info</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#password"
                                                    data-toggle="tab">Password</a></li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="info">
                                                <form class="form-horizontal" id="profile" method="POST"
                                                    action="{{ url('profil-update/' . Auth::user()->id) }}">
                                                    @csrf
                                                    <div class="form-group row">
                                                        <label for="name" class="col-sm-2 col-form-label">Nama</label>
                                                        <div class="col-sm-10">
                                                            <input type="hidden" name="id" id="id"
                                                                value="{{ Auth::user()->id }}">
                                                            <input type="text" class="form-control" id="name"
                                                                name="name" value="{{ Auth::user()->name }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                                                        <div class="col-sm-10">
                                                            <input type="email" class="form-control" id="email"
                                                                name="email" value="{{ Auth::user()->email }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="level" class="col-sm-2 col-form-label">Level</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="level"
                                                                name="level" value="{{ Auth::user()->level }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="offset-sm-2 col-sm-10">
                                                            <button type="submit" class="btn btn-danger">Simpan</button>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>

                                            <div class="tab-pane" id="password">
                                                <form class="form-horizontal" id="password" method="POST"
                                                    action="{{ url('password-update/' . Auth::user()->id) }}">
                                                    @csrf
                                                    <div class="form-group row">
                                                        <label for="current_password"
                                                            class="col-sm-2 col-form-label">Password Lama</label>
                                                        <div class="col-sm-10">
                                                            <input type="password" class="form-control"
                                                                id="current_password">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="new_password" class="col-sm-2 col-form-label">Password
                                                            Baru</label>
                                                        <div class="col-sm-10">
                                                            <input type="password" class="form-control"
                                                                name="new_password" id="new_password">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="new_confirm_password"
                                                            class="col-sm-2 col-form-label">Konfirmasi Password
                                                            Baru</label>
                                                        <div class="col-sm-10">
                                                            <input type="password" class="form-control"
                                                                name="new_confirm_password" id="new_confirm_password">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="offset-sm-2 col-sm-10">
                                                            <button type="submit" class="btn btn-danger">Simpan</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

@section('css')
@endsection

@section('js')
    <script src="{{ asset('public/admin/asset/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('public/admin/asset/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('public/admin/asset/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('public/admin/asset/plugins/jquery-validation/additional-methods.min.js') }}"></script>

    <script>
        $('#profil').validate({
            rules: {
                name: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true,
                },
                level: {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: "Nama Harus Di isi!",
                },
                email: {
                    required: "Email Harus Di isi!",
                    email: "Harus Berupa Alamat Email"
                },
                level: {
                    required: "Level Harus Di isi!",
                },
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

        $('#password').validate({
            rules: {
                current_password: {
                    required: true,
                },
                new_password: {
                    required: true,
                    minLength: 8,
                },
                new_confirm_password: {
                    required: true,
                    minLength: 8,
                    equalTo: '#new_password'
                },

            },
            messages: {
                current_password: {
                    required: "Password Lama Harus Di isi!",
                },
                new_password: {
                    required: "Password Baru Harus Di isi!",
                    minLength: "Minimal 8 Karakter",
                },
                new_confirm_password: {
                    required: "Password Baru Harus Di isi!",
                    minLength: "Minimal 8 Karakter",
                    equalTo: "Konfirmasi Password Baru Harus Sama Dengan Password Baru",
                },

            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    </script>
@endsection
