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
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Data Gaji</h3>
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
                ajax: "{{ url('data/json-gaji') }}",
                columns: [{
                        title: 'No',
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        title: 'Nama',
                        data: 'nm'
                    },
                    {
                        title: 'Tanggal Gaji',
                        data: 'tanggal_gaji'
                    },
                    {
                        title: 'Total Gaji Pokok',
                        data: 'total_gaji_pokok'
                    },
                    {
                        title: 'Total Tunjangan Skill',
                        data: 'total_tunjangan_skill'
                    },
                    {
                        title: 'Total Biaya Lembur',
                        data: 'total_biaya_lembur'
                    },
                    {
                        title: 'Total Kasbon',
                        data: 'total_kasbon'
                    },
                    {
                        title: 'Keterangan',
                        data: 'keterangan'
                    },
                    {
                        title: 'Status Pengajuan',
                        data: 'status_pengajuan',
                        render: function(data) {
                            if (data == "Sudah") {
                                return '<span class="badge badge-success">Sudah</span>';
                            } else {
                                return '<span class="badge badge-danger">Belum</span>';
                            }
                        }
                    },

                    {
                        title: 'Gaji Bersih',
                        data: 'gaji_bersih'

                    },
                    {
                        title: 'Aksi',
                        data: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
    </script>
@stop
