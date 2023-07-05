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

        .page-header {
            text-align: center
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
                        <i class="fas fa-globe"></i>Riwayat Penggajian Karyawan <br> PT Gasaba Sukses Mandiri
                    </h2>
                </div>
            </div>

            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    <address>
                        <strong>{{ Auth::user()->name }}</strong><br>
                        Gedeg, Kec. Comal, Kab. Pemalang, Jawa Tengah<br>
                        No. Telp : 0815-4029-619 <br>
                        Tanggal : {{ Sistem::konversiTanggal(\Carbon\Carbon::now()) }}
                    </address>
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
                            @foreach ($all as $item)
                                <tr align="center">
                                    <td>{{ $item->nip }}</td>
                                    <td>{{ $item->karyawan->nm_pegawai }}</td>
                                    <td>{{ Sistem::formatRupiah($item->total_gaji_pokok) }}</td>
                                    <td>{{ $item->detailGaji->kehadiran->jumlah_kehadiran }} /
                                        {{ $item->detailGaji->kehadiran->jumlah_hari_kerja_kalender }}</td>
                                    <td>{{ Sistem::formatRupiah($item->detailGaji->kehadiran->total_gaji) }}</td>
                                    <td>{{ $item->detailGaji->tunjangan->nm_tunjangan_skill }}</td>
                                    <td>{{ $item->detailGaji->lembur->jumlah_jam_lembur }}/{{ Sistem::formatRupiah($item->detailGaji->lembur->biaya_lembur_perjam) }}
                                    </td>
                                    <td>{{ $item->detailGaji->kasbon->nm_kasbon }}</td>
                                    <td>{{ Sistem::formatRupiah($item->detailGaji->sub_total_tunjangan_skill) }}</td>
                                    <td>{{ Sistem::formatRupiah($item->detailGaji->sub_total_lembur) }}</td>
                                    <td>{{ Sistem::formatRupiah($item->detailGaji->sub_total_kasbon) }}</td>
                                    <td>{{ Sistem::formatRupiah($item->gaji_bersih) }}</td>
                                </tr>
                            @endforeach

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
