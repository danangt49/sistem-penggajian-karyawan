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
            font-size: 7pt;
        }

        .invoice-col {
            font-size: 7pt;
        }

        table tr td,
        table tr th {
            font-size: 7pt;
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
                    <h4>Jurnal Akutansi</h4>
                    <address>
                        <strong>{{ Auth::user()->name }}</strong><br>
                        Gedeg, Kec. Comal, Kab. Pemalang, Jawa Tengah<br>
                        No. Telp : 0815-4029-619
                    </address>
                </div>
            </div>
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr align="center">
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Credit</th>
                                <th>Debit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($jurnal->count() > 0)
                                @php
                                    $total_kredit = 0;
                                    $total_debit = 0;
                                @endphp
                                @foreach ($jurnal as $item)
                                    <tr align="center">
                                        @php
                                            $total_kredit = $total_kredit + $item->kredit;
                                            $total_debit = $total_debit + $item->debit;
                                        @endphp
                                        <td>{{ Sistem::konversiTanggal($item->tanggal_gaji) }}</td>
                                        <td>Penggajian Karyawan Bejumlah {{ $item->jumlah_karyawan }}</td>
                                        <td></td>
                                        <td>{{ Sistem::formatRupiah($item->debit) }}</td>
                                    </tr>
                                    <tr align="center">
                                        <td>{{ Sistem::konversiTanggal($item->tanggal_gaji) }}</td>
                                        <td>Kas</td>
                                        <td>{{ Sistem::formatRupiah($item->kredit) }}</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="2" class="text-center">Total</td>
                                    <td class="text-center">{{ Sistem::formatRupiah($total_kredit) }}</td>
                                    <td class="text-center">{{ Sistem::formatRupiah($total_debit) }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="4" class="text-center">Tidak Ada Data</td>
                                </tr>
                            @endif
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
