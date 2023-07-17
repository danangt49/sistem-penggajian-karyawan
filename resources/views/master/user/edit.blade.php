@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">User</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item">Master</li>
                            <li class="breadcrumb-item active">User</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Edit Data User</h3>
                                    </div>
                                    <form id="form" action="{{ url('master/user-update/'.$user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                        <div class="card-body">
                                            <div class="row">
                                                @if ($user->level != "pegawai")
                                                    <div class="col-md-6 mb-3">
                                                        <div class="form-group">
                                                            <label for="level">Level</label>
                                                            <select class="custom-select rounded-0" id="level" name="level">
                                                                <option value="admin" <?php if ($user->level=="admin"): ?>selected<?php endif; ?>>Admin</option>
                                                                <option value="direktur" <?php if ($user->level=="direktur"): ?>selected<?php endif; ?>>Direktur</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label for="name">Nama</label>
                                                        <input type="hidden" name="id" id="id" value="{{ $user->id }}">
                                                        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label for="email">Email</label>
                                                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                <a href="{{ url('master/user') }}" class="btn btn-secondary">Batal</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
    <script src="{{ asset('public/admin/asset/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('public/admin/asset/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('public/admin/asset/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('public/admin/asset/plugins/jquery-validation/additional-methods.min.js') }}"></script>
            
    <script>
        $('#form').validate({
            rules: {
                name: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true,
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
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    </script>
@stop