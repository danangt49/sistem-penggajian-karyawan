@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Home</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Home</li>
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
                            <div class="col-lg-2">
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3>{{ $total_pegawai }}</h3>
                                        <p>Pegawai</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-users"></i>
                                    </div>
                                    <a href="{{ url('master/pegawai') }}" class="small-box-footer">Selengkapnya... <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3>{{ $total_gaji }}</h3>
                                        <p>Gaji</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-envelope"></i>
                                    </div>
                                    <a href="{{ url('gaji') }}" class="small-box-footer">Selengkapnya... <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h3>{{ $total_tunjangan_skill }}</h3>
                                        <p>Tunjangan Skill</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-file"></i>
                                    </div>
                                    <a href="{{ url('master/tunjangan-skill') }}" class="small-box-footer">Selengkapnya...
                                        <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="small-box bg-warning">
                                    <div class="inner">
                                        <h3>{{ $total_lembur }}</h3>
                                        <p>Lembur</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-plus"></i>
                                    </div>
                                    <a href="{{ url('master/lembur') }}" class="small-box-footer">Selengkapnya... <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <h3>{{ $total_kasbon }}</h3>
                                        <p>Kasbon</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-minus"></i>
                                    </div>
                                    <a href="{{ url('master/kasbon') }}" class="small-box-footer">Selengkapnya... <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="small-box bg-secondary">
                                    <div class="inner">
                                        <h3>{{ $total_kehadiran }}</h3>
                                        <p>Kehadiran</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <a href="{{ url('master/kehadiran') }}" class="small-box-footer">Selengkapnya... <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <p>{{ Auth::user()->level}}</p>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <p>Diagram Batang & Jurnal Umum</p> 
                                        <hr>
                                        <form id="filter-form" action="{{ route('home') }}" method="GET">
                                            <div class="form-row">
                                                <div class="col-md-4 mb-3">
                                                    <label for="start_date">Dari</label>
                                                    <input type="date" class="form-control" id="start_date"
                                                        name="start_date" value="{{ $start_date }}">
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="end_date">Sampai</label>
                                                    <input type="date" class="form-control" id="end_date"
                                                        name="end_date" value="{{ $end_date }}">
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <button type="submit"
                                                        class="btn btn-primary float-right"><i
                                                        class="fas fa-filter"></i>Filter</button>
                                                    <a href="{{ route('download', ['start_date' => $start_date, 'end_date' => $end_date]) }}"
                                                        class="btn btn-success float-right" style="margin-right: 10px;"><i
                                                            class="fas fa-print"></i> Cetak</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="barChart" style="width: 100%; height: 400px;"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

@section('css')
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var kredit = {!! json_encode($kredit) !!};
        var debit = {!! json_encode($debit) !!};

        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('barChart').getContext('2d');
            var barChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($bulan) !!},
                    datasets: [{
                        label: 'Kredit',
                        data: kredit,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }, {
                        label: 'Debit',
                        data: debit,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Bulan'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            display: true,
                            title: {
                                display: true,
                                text: 'Jumlah (Rp.)'
                            }
                        }
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: 'Data Kredit & Debit per Tanggal Gaji'
                        }
                    }
                }
            });
        });
    </script>
@endsection
