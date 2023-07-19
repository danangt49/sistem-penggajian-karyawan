<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Penggajian Pegawai</title>
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
                    <h4 class="page-header">
                        <i class="fas fa-globe"></i>Laporan Keseluruhan Data Lembur <br> PT Gasaba Sukses Mandiri
                    </h4>
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
                <div class="col-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr align="center">
                                <th>No</th>
                                <th>Nama Lembur</th>
                                <th>Jumlah Jam Lembur</th>
                                <th>Biaya Lembur Perjam (Rp.)</th>
                                <th>Total Pendapatan Lembur (Rp.)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($all as $item)
                                <tr align="center">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nm_lembur }}</td>
                                    <td>{{ $item->jumlah_jam_lembur }}</td>
                                    <td>{{ Sistem::formatRupiah($item->biaya_lembur_perjam) }}</td>
                                    <td>{{  Sistem::formatRupiah($item->total_pendapatan_lembur) }}</td>
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
