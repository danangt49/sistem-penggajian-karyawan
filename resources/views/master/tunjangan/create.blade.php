@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Tunjangan Skill</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item">Master</li>
                            <li class="breadcrumb-item active">Tunjangan Skill</li>
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
                                        <h3 class="card-title">Tambah Data Tunjangan Skill</h3>
                                    </div>
                                    <form id="form" action="{{ url('master/tunjangan-skill-store') }}" method="POST">
                                    @csrf
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label for="nm_tunjangan_skill">Nama</label>
                                                        <input type="hidden" name="kd_tunjangan_skill" id="kd_tunjangan_skill">
                                                        <input type="text" class="form-control" id="nm_tunjangan_skill" name="nm_tunjangan_skill">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label for="jumlah_tunjangan_skill">Jumlah (Rp.)</label>
                                                        <input type="number" class="form-control" id="jumlah_tunjangan_skill" name="jumlah_tunjangan_skill">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <div class="form-group">
                                                        <label for="keterangan">Keterangan</label>
                                                        <input type="text" class="form-control" id="keterangan" name="keterangan">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                <a href="{{ url('master/tunjangan-skill') }}" class="btn btn-secondary">Batal</a>
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
                nm_tunjangan_skill: {
                    required: true,
                },
                jumlah_tunjangan_skill: {
                    required: true,
                    number:true
                },
                keterangan: {
                    required: true
                },
            },
            messages: {
                nm_tunjangan_skill: {
                    required: "Nama Harus Di isi!",
                },
                jumlah_tunjangan_skill: {
                    required: "Jumlah Jam Harus Di isi!",
                    number: "Harus Berupa Angka"
                },
                keterangan: {
                    required: "Keterangan Harus Di isi!"
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