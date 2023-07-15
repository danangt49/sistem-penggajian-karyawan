@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Gaji</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Gaji</li>
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
                                        <h3 class="card-title">Tambah Data Gaji</h3>
                                    </div>
                                    <form id="form" action="{{ url('gaji-store') }}" method="POST">
                                    @csrf
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label for="nip">Nama Pegawai</label>
                                                        <select class="custom-select rounded-0" id="nip" name="nip">
                                                            @foreach ( Applib::dd_pegawai_aktif() as $key => $value)
                                                                <option value="{{ $key }}"> 
                                                                    {{ $value }} 
                                                                </option>
                                                            @endforeach   
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label for="tanggal_gaji">Tanggal Gaji</label>
                                                        <div class='input-group date' id='datetimepicker'>
                                                            <input type='text' class="form-control" id="tanggal_gaji" name="tanggal_gaji"/>
                                                            <span class="input-group-addon">
                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="form-group">
                                                        <label for="kd_tunjangan_skill">Tunjangan Skill</label>
                                                        <select class="custom-select rounded-0" id="kd_tunjangan_skill" name="kd_tunjangan_skill">
                                                            @foreach ( Applib::dd_tunjangan() as $key => $value)
                                                                <option value="{{ $key }}"> 
                                                                    {{ $value }} 
                                                                </option>
                                                            @endforeach   
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="form-group">
                                                        <label for="kd_kasbon">Kasbon</label>
                                                        <select class="custom-select rounded-0" id="kd_kasbon" name="kd_kasbon">
                                                            @foreach ( Applib::dd_kasbon() as $key => $value)
                                                                <option value="{{ $key }}"> 
                                                                    {{ $value }} 
                                                                </option>
                                                            @endforeach   
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="form-group">
                                                        <label for="kd_lembur">Lembur</label>
                                                        <select class="custom-select rounded-0" id="kd_lembur" name="kd_lembur">
                                                            @foreach ( Applib::dd_lembur() as $key => $value)
                                                                <option value="{{ $key }}"> 
                                                                    {{ $value }} 
                                                                </option>
                                                            @endforeach   
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="form-group">
                                                        <label for="kd_kehadiran">Kehadiran</label>
                                                        <select class="custom-select rounded-0" id="kd_kehadiran" name="kd_kehadiran">
                                                            @foreach ( Applib::dd_kehadiran() as $key => $value)
                                                                <option value="{{ $key }}"> 
                                                                    {{ $value }} 
                                                                </option>
                                                            @endforeach   
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label for="keterangan">Keterangan</label>
                                                        <input type="text" class="form-control" id="keterangan" name="keterangan">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label for="status_pengajuan">Status</label>
                                                        <select class="custom-select rounded-0" id="status_pengajuan" name="status_pengajuan">
                                                            <option value="Sudah">Sudah</option>
                                                            <option value="Belum">Belum</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                <a href="{{ url('gaji') }}" class="btn btn-secondary">Batal</a>
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
            $("#tanggal_gaji").datepicker({ 
                format: 'yyyy-mm-dd',
                autoclose: true, 
                todayHighlight: true
            }).datepicker('update', new Date());
        });

        $('#form').validate({
            rules: {
                nip: {
                    required: true,
                },
                kd_tunjangan_skill: {
                    required: true,
                },
                kd_kasbon: {
                    required: true,
                },
                kd_lembur: {
                    required: true,
                },
                kd_kehadiran: {
                    required: true,
                },
                keterangan: {
                    required: true,
                },
            },
            messages: {
                nip: {
                    required: "Nama Pegawai Harus Di isi!",
                },
                kd_tunjangan_skill: {
                    required: "Tunjangan Skill Harus Di isi!",
                },
                kd_kasbon: {
                    required: "Kasbon Harus Di isi!",
                },
                kd_lembur: {
                    required: "Lembur Harus Di isi!",
                },
                kd_kehadiran: {
                    required: "Kehadiran Harus Di isi!",
                },
                keterangan: {
                    required: "Keterangan Harus Di isi!",
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