@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Kehadiran</h1>
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
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{ session('success') }}
                            </div>
                        @elseif (session('error'))
                            <div class="alert alert-danger" role="alert">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Data Kehadiran</h3>
                                        @if (Auth::user()->level == 'admin')
                                            <a href="{{ url('master/kehadiran/form') }}" class="btn btn-primary float-right"><i
                                                    class="fas fa-plus"></i> Tambah</a>
                                        @endif

                                        <a href="{{ url('master/kehadiran-cetak-all-pdf') }}"
                                            class="btn btn-success float-right" style="margin-right: 10px;"><i
                                                class="fas fa-print"></i> Cetak</a>
                                    </div>
                                    <div class="card-body">
                                        <table id="datatable" class="table table-bordered table-striped text-center">
                                        </table>
                                    </div>
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
    <link rel="stylesheet"
        href="{{ asset('public/admin/asset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('public/admin/asset/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('public/admin/asset/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
@stop

@section('js')
    <script src="{{ asset('public/admin/asset/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('public/admin/asset/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/admin/asset/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('public/admin/asset/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('public/admin/asset/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('public/admin/asset/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('public/admin/asset/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js" charset="utf-8">
    </script>
    <script>
        $(document).ready(function() {
            $('#datatable').dataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: "{{ url('master/json-kehadiran') }}",
                columns: [{
                        title: 'No',
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        title: 'Jumlah Kehadiran',
                        data: 'jumlah_kehadiran'
                    },
                    {
                        title: 'Jumlah Hari Kerja Kalender',
                        data: 'jumlah_hari_kerja_kalender'
                    },
                    @if (Auth::user()->level == 'admin')
                        {
                            title: 'Aksi',
                            data: 'action',
                            orderable: false,
                            searchable: false
                        }
                    @endif
                ]
            });
        });

        $('body').on('click', '.delete', function() {
            var csrf_token = "{{ csrf_token() }}";
            var document_kd_kehadiran = $(this).data("kd_kehadiran");
            swal({
                    title: "Apakah Anda Yakin ?",
                    text: "Anda Akan Menghapus Item Ini ?",
                    type: "warning",
                    confirmButtonText: "Ya, Hapus",
                    showCancelButton: true
                })
                .then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "{{ url('master/kehadiran-delete') }}" + '/' + document_kd_kehadiran,
                            type: "POST",
                            data: {
                                '_method': 'GET',
                                '_token': csrf_token
                            },
                            success: function() {
                                swal(
                                    'Sukses',
                                    'Hapus Data <b style="color:green;">Sukses</b> Klik OK!',
                                    'success'
                                ).then(function() {
                                    location.reload();
                                });
                            },
                            error: function() {
                                swal({
                                    title: 'Opps...',
                                    text: 'Error',
                                    type: 'error',
                                    timer: '1500'
                                })
                            }
                        });
                    } else if (result.dismiss === 'cancel') {
                        swal(
                            'Dibatalkan',
                            'Tetap Di Halaman Ini',
                            'error'
                        )
                    }
                })
        });
    </script>
@stop
