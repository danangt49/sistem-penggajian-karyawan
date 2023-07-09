@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Pegawai</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item">Master</li>
                            <li class="breadcrumb-item active">Pegawai</li>
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
                                        <h3 class="card-title">Tambah Data Pegawai</h3>
                                    </div>
                                    <form id="form" action="{{ url('master/pegawai-store') }}" method="POST">
                                    @csrf
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label for="nip">NIP</label>
                                                        <input type="number" class="form-control" id="nip" name="nip">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label for="nm_pegawai">Nama</label>
                                                        <input type="text" class="form-control" id="nm_pegawai" name="nm_pegawai">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label for="kd_jabatan">Jabatan</label>
                                                        <select class="custom-select rounded-0" id="kd_jabatan" name="kd_jabatan">
                                                            @foreach ( Applib::dd_jabatan() as $key => $value)
                                                                <option value="{{ $key }}"> 
                                                                    {{ $value }} 
                                                                </option>
                                                            @endforeach   
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label for="no_telepon">No. Telp</label>
                                                        <input type="number" class="form-control" id="no_telepon" name="no_telepon">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label for="gaji_pokok">Gaji Pokok</label>
                                                        <input type="number" class="form-control" id="gaji_pokok" name="gaji_pokok">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label for="tanggal_lahir">Tanggal Lahir</label>
                                                        <div class='input-group date' id='datetimepicker'>
                                                            <input type='text' class="form-control" id="tanggal_lahir" name="tanggal_lahir"/>
                                                            <span class="input-group-addon">
                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label for="tanggal_masuk">Tanggal Masuk</label>
                                                        <div class='input-group date' id='datetimepicker'>
                                                            <input type='text' class="form-control" id="tanggal_masuk" name="tanggal_masuk"/>
                                                            <span class="input-group-addon">
                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <div class="form-group">
                                                        <label for="alamat">Alamat</label>
                                                        <textarea type="text" class="form-control" id="alamat" name="alamat"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                <a href="{{ url('master/pegawai') }}" class="btn btn-secondary">Batal</a>
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
@stop

@section('js')
    <script src="{{ asset('public/admin/asset/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('public/admin/asset/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('public/admin/asset/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('public/admin/asset/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
            
    <script>
        $(function () {
            $("#tanggal_lahir").datepicker({ 
                format: 'yyyy-mm-dd',
                autoclose: true, 
                todayHighlight: true
            }).datepicker('update', new Date());
        });

        $(function () {
            $("#tanggal_masuk").datepicker({ 
                format: 'yyyy-mm-dd',
                autoclose: true, 
                todayHighlight: true
            }).datepicker('update', new Date());
        });

        $('#form').validate({
            rules: {
                nip: {
                    required: true,
                    number: true
                },
                nm_pegawai: {
                    required: true,
                },
                tanggal_lahir: {
                    required: true,
                },
                tanggal_masuk: {
                    required: true,
                },
                no_telepon: {
                    required: true,
                    number: true
                },
                gaji_pokok: {
                    required: true,
                    number: true
                },
            },
            messages: {
                nip: {
                    required: "NIP Harus Di isi!",
                    number: "Harus Berupa Angka"
                },
                nm_pegawai: {
                    required: "Nama Harus Di isi!"
                },
                tanggal_lahir: {
                    required: "Tanggal Lahir Harus Di isi!",
                },
                tanggal_masuk: {
                    required: "Tanggal Masuk Harus Di isi!",
                },
                no_telepon: {
                    required: "No. Telp Harus Di isi!",
                    number: "Harus Berupa Angka"
                },
                gaji_pokok: {
                    required: "Gaji Pokok Harus Di isi!",
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