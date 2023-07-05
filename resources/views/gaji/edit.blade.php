@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Lembur</h1>
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
                                        <h3 class="card-title">Edit Data Gaji</h3>
                                    </div>
                                    <form id="form" action="{{ url('gaji-update/'.$gaji->no_slip_gaji) }}" method="POST">
                                    @csrf
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label for="nip">Nama Karyawan</label>
                                                        <input type='hidden' class="form-control"  name="no_slip_gaji" value="{{ $gaji->no_slip_gaji }}"/>
                                                        <input type="hidden" class="form-control"  name="id_detail_gaji" value="{{ $gaji->detailGaji->id_detail_gaji }}">
                                                        <input type="hidden" class="form-control"  name="kd_presensi" value="{{ $gaji->detailGaji->kd_presensi }}">
                                                        <select class="custom-select rounded-0" id="nip" name="nip">
                                                            @foreach ( Applib::dd_karyawan() as $key => $value)
                                                                <option value="{{ $key }}" {{ ( $key == $gaji->nip) ? 'selected' : '' }}>{{ $value }}</option>
                                                            @endforeach   
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label for="tanggal_gaji">Tanggal Gaji</label>
                                                        <div class='input-group date' id='datetimepicker'>
                                                            <input type='text' class="form-control" id="tanggal_gaji" name="tanggal_gaji" value="{{ $gaji->tanggal_gaji }}"/>
                                                            <span class="input-group-addon">
                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <div class="form-group">
                                                        <label for="kd_tunjangan_skill">Tunjangan Skill</label>
                                                        <select class="custom-select rounded-0" id="kd_tunjangan_skill" name="kd_tunjangan_skill">
                                                            @foreach ( Applib::dd_tunjangan() as $key => $value)
                                                                <option value="{{ $key }}" {{ ( $key == $gaji->detailGaji->kd_tunjangan_skill) ? 'selected' : '' }}>{{ $value }}</option>
                                                            @endforeach   
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <div class="form-group">
                                                        <label for="kd_kasbon">Kasbon</label>
                                                        <select class="custom-select rounded-0" id="kd_kasbon" name="kd_kasbon">
                                                            @foreach ( Applib::dd_kasbon() as $key => $value)
                                                                <option value="{{ $key }}" {{ ( $key == $gaji->detailGaji->kd_kasbon) ? 'selected' : '' }}>{{ $value }}</option>
                                                            @endforeach   
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <div class="form-group">
                                                        <label for="kd_lembur">Lembur</label>
                                                        <select class="custom-select rounded-0" id="kd_lembur" name="kd_lembur">
                                                            @foreach ( Applib::dd_lembur() as $key => $value)
                                                                <option value="{{ $key }}" {{ ( $key == $gaji->detailGaji->kd_lembur) ? 'selected' : '' }}>{{ $value }}</option>
                                                            @endforeach   
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label for="jumlah_presensi">Jumlah Kehadiran</label>
                                                        <input type="number" class="form-control" id="jumlah_presensi" name="jumlah_presensi" value="{{ $gaji->detailGaji->Presensi->jumlah_presensi }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label for="jumlah_hari_kerja_kalender">Jumlah Hari Kalender</label>
                                                        <input type="number" class="form-control" id="jumlah_hari_kerja_kalender" name="jumlah_hari_kerja_kalender" value="{{ $gaji->detailGaji->Presensi->jumlah_hari_kerja_kalender }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label for="keterangan">Keterangan</label>
                                                        <input type="text" class="form-control" id="keterangan" name="keterangan" value="{{ $gaji->keterangan }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label for="status_pengajuan">Status</label>
                                                        <select class="custom-select rounded-0" id="status_pengajuan" name="status_pengajuan">
                                                            <option value="Sudah" <?php if ($gaji->status_pengajuan): ?>selected<?php endif; ?>>Sudah</option>
                                                            <option value="Belum" <?php if ($gaji->status_pengajuan): ?>selected<?php endif; ?>>Belum</option>
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
                jumlah_presensi: {
                    required: true,
                    number:true
                },
                jumlah_hari_kerja_kalender: {
                    required: true,
                    number:true
                },
                keterangan: {
                    required: true,
                },
            },
            messages: {
                nip: {
                    required: "Nama Karyawan Harus Di isi!",
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
                nip: {
                    required: "Nama Karyawan Harus Di isi!",
                },
                jumlah_presensi: {
                    required: "Jumlah Kehadiran Harus Di isi!",
                    number: "Harus Berupa Angka"
                },
                jumlah_hari_kerja_kalender: {
                    required: "Jumlah Hari Kalender Harus Di isi!",
                    number: "Harus Berupa Angka"
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