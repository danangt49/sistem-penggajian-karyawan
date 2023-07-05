<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Pengajian Karyawan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <style type="text/css">
        .tgl {
            font-size: 6pt;
        }

        .invoice-col {
            font-size: 6pt;
        }

        table tr td,
        table tr th {
            font-size: 6pt;
            text-align: center
        }
    </style>
    <div class="wrapper">
        <section class="invoice">
            <div class="row">
                <div class="col-12">
                    <h2 class="page-header">
                        <i class="fas fa-globe"></i> PT Gasaba Sukses Mandiri
                        <small class="float-right tgl">Tanggal :
                            {{ Sistem::konversiTanggal(\Carbon\Carbon::now()) }}</small>
                    </h2>
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
                        <b>Gaji Pokok: Rp. </b> {{ Sistem::formatRupiah($detail->total_gaji_pokok) }} <br>
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
                                <td>{{ $detail->detailGaji->kehadiran->jumlah_kehadiran }} /
                                    {{ $detail->detailGaji->kehadiran->jumlah_hari_kerja_kalender }}</td>
                                <td>{{ Sistem::formatRupiah($detail->detailGaji->kehadiran->total_gaji) }}
                                </td>
                                <td>{{ $detail->detailGaji->tunjangan->nm_tunjangan_skill }}</td>
                                <td>{{ $detail->detailGaji->lembur->jumlah_jam_lembur }}/{{ Sistem::formatRupiah($detail->detailGaji->lembur->biaya_lembur_perjam) }}
                                </td>
                                <td>{{ $detail->detailGaji->kasbon->nm_kasbon }}</td>
                                <td>{{ Sistem::formatRupiah($detail->detailGaji->sub_total_tunjangan_skill) }}</td>
                                <td>{{ Sistem::formatRupiah($detail->detailGaji->sub_total_lembur) }}</td>
                                <td>{{ Sistem::formatRupiah($detail->detailGaji->sub_total_kasbon) }}</td>
                                <td>{{ Sistem::formatRupiah($detail->gaji_bersih) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
    <script>
        window.addEventListener("load", window.print());
    </script>
</body>

</html>
