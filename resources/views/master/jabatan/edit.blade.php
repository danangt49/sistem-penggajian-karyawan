@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Jabatan</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item">Master</li>
                            <li class="breadcrumb-item active">Jabatan</li>
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
                                        <h3 class="card-title">Edit Data Jabatan</h3>
                                    </div>
                                    <form id="form" action="{{ url('master/jabatan-update/'.$jabatan->kd_jabatan) }}" method="POST">
                                    @csrf
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label for="name">Nama Jabatan</label>
                                                        <input type="hidden" name="kd_jabatan" id="kd_jabatan" value="{{ $jabatan->kd_jabatan }}">
                                                        <input type="text" class="form-control" id="nm_jabatan" name="nm_jabatan" value="{{ $jabatan->nm_jabatan }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label for="name">Total Gaji</label>
                                                        <input type="number" class="form-control" id="total_gaji" name="total_gaji" value="{{ $jabatan->total_gaji }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                <a href="{{ url('master/jabatan') }}" class="btn btn-secondary">Batal</a>
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
                nm_jabatan: {
                    required: true,
                },
                total_gaji: {
                    required: true,
                    number: true
                },
            },
            messages: {
                nm_jabatan: {
                    required: "Nama Jabatan Harus Di isi!",
                },
                total_gaji: {
                    required: "Total Gaji Harus Di isi!",
                    number: "Harus Berupa Angka"
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