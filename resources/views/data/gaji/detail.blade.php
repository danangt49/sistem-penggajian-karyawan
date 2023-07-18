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
                                <div class="invoice p-3 mb-3">
                                    <div class="row">
                                        <div class="col-12">
                                            <h4>
                                                <img src="{{ asset('public/img/logo.png') }}" 
                                                class="brand-image img-circle elevation-3" style="opacity: .8" width="5%"> &nbsp;
                                                PT Gasaba Sukses Mandiri
                                                <small class="float-right">Tanggal :
                                                    {{ Sistem::konversiTanggal(\Carbon\Carbon::now()) }}</small>
                                            </h4>
                                        </div>

                                    </div>

                                    <div class="row invoice-info">
                                        <div class="col-sm-4 invoice-col mt-3">
                                            Dari
                                            <address>
                                                <strong>Admin</strong><br>
                                                Gedeg, Kec. Comal, Kab. Pemalang, Jawa Tengah<br>
                                                No. Telp : 0815-4029-619
                                            </address>
                                        </div>

                                        <div class="col-sm-4 invoice-col mt-3">
                                            Untuk
                                            <address>
                                                <strong>{{ $detail->pegawai->nm_pegawai }}</strong><br>
                                                {{ $detail->pegawai->alamat }}<br>
                                                No. Telp : {{ $detail->pegawai->no_telepon }}
                                            </address>
                                        </div>

                                        <div class="col-sm-4 invoice-col mt-3">
                                            <b>Slip Gaji #{{ $detail->no_slip_gaji }}<br>
                                                <b>Tanggal :</b>{{ Sistem::konversiTanggal($detail->tanggal_gaji) }} <br>
                                                <b>Gaji Pokok: Rp. </b>
                                                {{ Sistem::formatRupiah($detail->total_gaji_pokok) }} <br>
                                                <b>Status Pengajuan: </b> {{ $detail->status_pengajuan }}
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr align="center">
                                                        <th>NIP</th>
                                                        <th>Nama</th>
                                                        <th>Gaji Pokok (Rp.)</th>
                                                        <th>Jumlah Kehadiran/Dari (Hari)</th>
                                                        <th>Gaji Berdasarkan Kehadiran (Rp.)</th>
                                                        <th>Tunjangan Skill</th>
                                                        <th>Jumlah Lembur Jam/Rp.</th>
                                                        <th>Kasbon</th>
                                                        <th>Total Tunjangan Skill (Rp.)</th>
                                                        <th>Total Lembur (Rp.)</th>
                                                        <th>Total Kasbon (Rp.)</th>
                                                        <th>Gaji Bersih (Rp.)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr align="center">
                                                        <td>{{ $detail->nip }}</td>
                                                        <td>{{ $detail->pegawai->nm_pegawai }}</td>
                                                        <td>{{ Sistem::formatRupiah($detail->total_gaji_pokok) }}</td>
                                                        <td>{{ $detail->detailGaji->kehadiran->jumlah_kehadiran }} /
                                                            {{ $detail->detailGaji->kehadiran->jumlah_hari_kerja_kalender }}
                                                        </td>
                                                        <td>{{ Sistem::formatRupiah($detail->total_gaji) }}
                                                        </td>
                                                        <td>{{ $detail->detailGaji->tunjangan->nm_tunjangan_skill }}</td>
                                                        <td>{{ $detail->detailGaji->lembur->jumlah_jam_lembur }}/
                                                            {{ Sistem::formatRupiah($detail->detailGaji->lembur->biaya_lembur_perjam) }}
                                                        </td>
                                                        <td>{{ $detail->detailGaji->kasbon->nm_kasbon }}</td>
                                                        <td>{{ Sistem::formatRupiah($detail->detailGaji->sub_total_tunjangan_skill) }}
                                                        </td>
                                                        <td>{{ Sistem::formatRupiah($detail->detailGaji->sub_total_lembur) }}
                                                        </td>
                                                        <td>{{ Sistem::formatRupiah($detail->detailGaji->sub_total_kasbon) }}
                                                        </td>
                                                        <td>{{ Sistem::formatRupiah($detail->gaji_bersih) }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
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
@stop

@section('js')
    <script src="{{ asset('public/admin/asset/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
@stop
