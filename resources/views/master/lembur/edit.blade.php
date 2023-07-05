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
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item">Master</li>
                            <li class="breadcrumb-item active">Lembur</li>
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
                                        <h3 class="card-title">Edit Data Lembur</h3>
                                    </div>
                                    <form id="form" action="{{ url('master/lembur-update/'.$lembur->kd_lembur) }}" method="POST">
                                    @csrf
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label for="nm_lembur">Nama</label>
                                                        <input type="text" class="form-control" id="nm_lembur" name="nm_lembur" value="{{ $lembur->nm_lembur }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label for="jumlah_jam_lembur">Jumlah Jam</label>
                                                        <input type="number" class="form-control" id="jumlah_jam_lembur" name="jumlah_jam_lembur" value="{{ $lembur->jumlah_jam_lembur }}" onkeyup="total();">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label for="biaya_lembur_perjam">Biaya Perjam (Rp.)</label>
                                                        <input type="number" class="form-control" id="biaya_lembur_perjam" name="biaya_lembur_perjam" value="{{ $lembur->biaya_lembur_perjam }}" onkeyup="total();">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label for="total_pendapatan_lembur">Total</label>
                                                        <input type="number" class="form-control" id="total_pendapatan_lembur" name="total_pendapatan_lembur" value="{{ $lembur->total_pendapatan_lembur }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                <a href="{{ url('master/lembur') }}" class="btn btn-secondary">Batal</a>
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
        function total(){
            const jam = document.getElementById('jumlah_jam_lembur').value;
            const biaya = document.getElementById('biaya_lembur_perjam').value;
            const total = jam * biaya;
            document.getElementById('total_pendapatan_lembur').value = total; 
        }
        $('#form').validate({
            rules: {
                nm_lembur: {
                    required: true,
                },
                jumlah_jam_lembur: {
                    required: true,
                    number:true
                },
                biaya_lembur_perjam: {
                    required: true,
                    number:true
                },
            },
            messages: {
                nm_lembur: {
                    required: "Nama Harus Di isi!",
                },
                jumlah_jam_lembur: {
                    required: "Jumlah Jam Harus Di isi!",
                    number: "Harus Berupa Angka"
                },
                biaya_lembur_perjam: {
                    required: "Biaya Harus Di isi!",
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