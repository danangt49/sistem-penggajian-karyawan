@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">kehadiran</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item">Master</li>
                            <li class="breadcrumb-item active">Kehadiran</li>
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
                                        <h3 class="card-title">Edit Data Kehadiran</h3>
                                    </div>
                                    <form id="form"
                                        action="{{ url('master/kehadiran-update/' . $kehadiran->kd_kehadiran) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT') 
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label for="jumlah_kehadiran">Jumlah Kehadiran</label>
                                                        <input type="hidden" name="kd_kehadiran" id="kd_kehadiran"
                                                            value="{{ $kehadiran->kd_kehadiran }}">
                                                        <input type="number" class="form-control" id="jumlah_kehadiran"
                                                            name="jumlah_kehadiran"
                                                            value="{{ $kehadiran->jumlah_kehadiran }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label for="jumlah_hari_kerja_kalender">Jumlah Hari Kerja
                                                            Kalender</label>
                                                        <input type="number" class="form-control"
                                                            id="jumlah_hari_kerja_kalender"
                                                            name="jumlah_hari_kerja_kalender"
                                                            value="{{ $kehadiran->jumlah_hari_kerja_kalender }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                <a href="{{ url('master/kehadiran') }}" class="btn btn-secondary">Batal</a>
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet"
        type="text/css" />
@stop

@section('js')
    <script src="{{ asset('public/admin/asset/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('public/admin/asset/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('public/admin/asset/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('public/admin/asset/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

    <script>
        $('#form').validate({
            rules: {
                jumlah_kehadiran: {
                    required: true,
                    number: true
                },
                jumlah_hari_kerja_kalender: {
                    required: true,
                    number: true
                },
            },
            messages: {
                jumlah_kehadiran: {
                    required: "Jumlah Kehadiran Harus Di isi!",
                    number: "Harus Berupa Angka"
                },
                jumlah_hari_kerja_kalender: {
                    required: "Jumlah Hari Kerja Kalender Harus Di isi!",
                    number: "Harus Berupa Angka"
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
@stop
