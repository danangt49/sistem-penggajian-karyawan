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
                                                <i class="fas fa-globe"></i> PT Gasaba Sukses Mandiri
                                                <small class="float-right">Tanggal :
                                                    {{ Sistem::konversiTanggal(\Carbon\Carbon::now()) }}</small>
                                            </h4>
                                        </div>

                                    </div>

                                    <div class="row invoice-info">
                                        <div class="col-sm-4 invoice-col">
                                            Dari
                                            <address>
                                                <strong>{{ Auth::user()->name }}</strong><br>
                                                Gedeg, Kec. Comal, Kab. Pemalang, Jawa Tengah<br>
                                                No. Telp : 0815-4029-619
                                            </address>
                                        </div>

                                        <div class="col-sm-4 invoice-col">
                                            Untuk
                                            <address>
                                                <strong>{{ $detail->karyawan->nm_pegawai }}</strong><br>
                                                {{ $detail->karyawan->alamat }}<br>
                                                No. Telp : {{ $detail->karyawan->no_telepon }}
                                            </address>
                                        </div>

                                        <div class="col-sm-4 invoice-col">
                                            <b>Slip Gaji #{{ $detail->no_slip_gaji }}<br>
                                                <b>Tanggal :</b>{{ Sistem::konversiTanggal($detail->tanggal_gaji) }} <br>
                                                <b>Gaji Pokok: Rp. </b>
                                                {{ Sistem::formatRupiah($detail->total_gaji_pokok) }} <br>
                                                <b>Status Pengajuan: </b> {{ $detail->status_pengajuan }}
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr align="center">
                                                        <th>NIP</th>
                                                        <th>Nama</th>
                                                        <th>Gaji Pokok</th>
                                                        <th>Jumlah Kehadiran/Dari (Hari)</th>
                                                        <th>Gaji Berdasarkan Kehadiran</th>
                                                        <th>Tunjangan Skill</th>
                                                        <th>Jumlah Lembur(Jam)/Rp.</th>
                                                        <th>Kasbon</th>
                                                        <th>Total Tunjangan Skill</th>
                                                        <th>Total Lembur</th>
                                                        <th>Total Kasbon</th>
                                                        <th>Gaji Bersih</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr align="center">
                                                        <td>{{ $detail->nip }}</td>
                                                        <td>{{ $detail->karyawan->nm_pegawai }}</td>
                                                        <td>{{ Sistem::formatRupiah($detail->total_gaji_pokok) }}</td>
                                                        <td>{{ $detail->detailGaji->Presensi->jumlah_presensi }} /
                                                            {{ $detail->detailGaji->Presensi->jumlah_hari_kerja_kalender }}
                                                        </td>
                                                        <td>{{ Sistem::formatRupiah($detail->detailGaji->presensi->total_gaji) }}
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

                                    <div class="row no-print">
                                        <div class="col-12">
                                            <a href="{{ url('gaji-cetak-pdf/' . $detail->no_slip_gaji) }}" rel="noopener"
                                                target="_blank" class="btn btn-default"><i class="fas fa-print"></i>
                                                Print</a>
                                            </button>
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
