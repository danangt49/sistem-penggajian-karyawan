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
                        <i class="fas fa-globe"></i>Jurnal Akutansi <br>
                        Tanggal {{ Sistem::konversiTanggal($start_date) }} Sampai
                        {{ Sistem::konversiTanggal($end_date) }} <br> PT Gasaba Sukses Mandiri
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
                                <th>Keterangan</th>
                                <th>Tanggal</th>
                                <th>Kredit (Rp.)</th>
                                <th>Debit (Rp.)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total_kredit = 0;
                                $total_debit = 0;
                            @endphp
                            @foreach ($all as $item)
                                @php
                                    $total_kredit += $item->kredit;
                                    $total_debit += $item->debit;
                                @endphp
                                <tr align="center">
                                    <td rowspan="2" style="vertical-align: middle;">{{ $loop->iteration }}</td>
                                    <td>KAS</td>
                                    <td>{{ Sistem::konversiTanggal($item->tanggal_gaji) }}</td>
                                    <td></td>
                                    <td>{{ Sistem::formatRupiah($item->debit) }}</td>
                                </tr>
                                <tr align="center">
                                    <td>Gaji Pegawai</td>
                                    <td>{{ Sistem::konversiTanggal($item->tanggal_gaji) }}</td>
                                    <td>{{ Sistem::formatRupiah($item->kredit) }}</td>
                                    <td></td>
                                </tr>
                            @endforeach
                            <tr align="center">
                                <td colspan="3"><strong>Total</strong></td>
                                <td>{{ Sistem::formatRupiah($total_kredit) }}</td>
                                <td>{{ Sistem::formatRupiah($total_debit) }}</td>
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
