<?php

namespace App\Http\Controllers;

use App\Helpers\Sistem;
use App\Libraries\Applib;
use App\Models\Kehadiran;
use App\Models\DetailGaji;
use App\Models\Gaji;
use App\Models\Pegawai;
use App\Models\Kasbon;
use App\Models\Lembur;
use App\Models\TunjanganSkill;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use PDF;
use Yajra\DataTables\Facades\DataTables;

class GajiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Gate::allows('isAdmin') || Gate::allows('isUser')) {
            return view('gaji.home');
        } else {
            return view('error.404');
        }
    }

    public function json()
    {
        $data = Gaji::orderBy('created_at', 'DESC')->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('nm', function ($row) {
                return Applib::getNama($row->nip);
            })
            ->addColumn('tanggal_gaji', function ($row) {
                return Sistem::konversiTanggal($row->tanggal_gaji);
            })
            ->addColumn('total_gaji_pokok', function ($row) {
                return Sistem::formatRupiah($row->total_gaji_pokok);
            })
            ->addColumn('total_tunjangan_skill', function ($row) {
                return Sistem::formatRupiah($row->total_tunjangan_skill);
            })
            ->addColumn('total_biaya_lembur', function ($row) {
                return Sistem::formatRupiah($row->total_biaya_lembur);
            })
            ->addColumn('total_kasbon', function ($row) {
                return Sistem::formatRupiah($row->total_kasbon);
            })
            ->addColumn('gaji_bersih', function ($row) {
                return Sistem::formatRupiah($row->gaji_bersih);
            })
            ->addColumn('action', function ($row) {
                $btn1 = '<a class="btn btn-sm" data-toggle="tooltip" title="Edit Data" href="gaji/' . $row->no_slip_gaji . '"><i class="fas fa-tools"></i></a>';
                $btn2 = ' <a class="btn btn-sm" data-toggle="tooltip" title="Detail Data" href="gaji-detail/' . $row->no_slip_gaji . '"><i class="fas fa-eye"></i></a>';
                $btn3 = '<button data-no_slip_gaji="' . $row->no_slip_gaji . '" data-toggle="tooltip" title="Hapus Data" class="btn btn-sm delete"><i class="fas fa-trash-restore"></i></button>';
                if ($row->status_pengajuan == 'Sudah') {
                    if (date('m-y', strtotime($row->tanggal_gaji)) < Carbon::now()->format('m-y')) {
                        return $btn2;
                    } else {
                        return $btn1 . $btn2;
                    }
                } else {
                    return $btn1 . $btn2 . $btn3;
                }
            })

            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        if (Gate::allows('isAdmin')) {
            return view('gaji.create');
        } else {
            return view('error.404');
        }
    }

    public function store(Request $request)
    {
        if (Gate::allows('isAdmin')) {
            $slip_gaji = random_int(1000, 9999);

            $existingGaji = Gaji::where('nip', $request->nip)
                ->whereMonth('tanggal_gaji', date('m', strtotime($request->tanggal_gaji)))
                ->whereYear('tanggal_gaji', date('Y', strtotime($request->tanggal_gaji)))
                ->first();

            if ($existingGaji) {
                return redirect('gaji')->with('error', 'Data gaji pegawai untuk bulan yang dipilih sudah ada.');
            }

            if (date('m', strtotime($request->tanggal_gaji)) > Carbon::now()->format('m-y')) {
                return redirect('gaji')->with('error', 'Data gaji pegawai untuk bulan yang dipilih belum bisa diinput.');
            }

            $pegawai = Pegawai::where('nip', $request->nip)->first();
            $tunjangan = TunjanganSkill::where('kd_tunjangan_skill', $request->kd_tunjangan_skill)->first();
            $lembur = Lembur::where('kd_lembur', $request->kd_lembur)->first();
            $kasbon = Kasbon::where('kd_kasbon', $request->kd_kasbon)->first();
            $kehadiran = Kehadiran::where('kd_kehadiran', $request->kd_kehadiran)->first();

            $totalGajiKehadiran = ($kehadiran->jumlah_kehadiran / $kehadiran->jumlah_hari_kerja_kalender) * $pegawai->gaji_pokok;
            $gaji_bersih = $totalGajiKehadiran + $tunjangan->jumlah_tunjangan_skill + $lembur->total_pendapatan_lembur - $kasbon->jumlah_kasbon;

            $data = [
                'no_slip_gaji' => $slip_gaji,
                'nip' => $request->nip,
                'tanggal_gaji' => $request->tanggal_gaji,
                'total_gaji' => $totalGajiKehadiran,
                'total_gaji_pokok' => $pegawai->gaji_pokok,
                'total_tunjangan_skill' => $tunjangan->jumlah_tunjangan_skill,
                'total_biaya_lembur' => $lembur->total_pendapatan_lembur,
                'total_kasbon' => $kasbon->jumlah_kasbon,
                'gaji_kotor' => $pegawai->gaji_pokok,
                'gaji_bersih' => $gaji_bersih,
                'keterangan' => $request->keterangan,
                'status_pengajuan' => $request->status_pengajuan,
            ];

            if ($request->kd_kasbon == 1) {
                $sub_jumlah_kasbon = 0;
            } else {
                $sub_jumlah_kasbon = 1;
            }

            if ($request->kd_tunjangan_skill == 1) {
                $sub_jumlah_tunjangan_skill = 0;
            } else {
                $sub_jumlah_tunjangan_skill = 1;
            }

            $data2 = [
                'no_slip_gaji' => $slip_gaji,
                'kd_tunjangan_skill' => $request->kd_tunjangan_skill,
                'kd_kasbon' => $request->kd_kasbon,
                'kd_lembur' => $request->kd_lembur,
                'kd_kehadiran' => $request->kd_kehadiran,
                'sub_total_tunjangan_skill' => $tunjangan->jumlah_tunjangan_skill,
                'sub_total_lembur' => $lembur->total_pendapatan_lembur,
                'sub_total_kasbon' => $kasbon->jumlah_kasbon,
                'sub_total_kehadiran' => $totalGajiKehadiran,
                'sub_jumlah_tunjangan_skill' => $sub_jumlah_kasbon,
                'sub_jumlah_lembur' => $lembur->jumlah_jam_lembur,
                'sub_jumlah_kasbon' => $sub_jumlah_tunjangan_skill,
                'sub_jumlah_kehadiran' => $kehadiran->jumlah_kehadiran,
            ];

            Gaji::create($data);
            DetailGaji::create($data2);
            return redirect('gaji')->with('success', 'Data Sukses Ditambahkan');
        } else {
            return view('error.404');
        }
    }

    public function edit($no_slip_gaji)
    {
        if (Gate::allows('isAdmin')) {
            $data['gaji'] = Gaji::where('no_slip_gaji', $no_slip_gaji)->first();
            return view('gaji.edit')->with($data);
        } else {
            return view('error.404');
        }
    }

    public function update(Request $request)
    {
        if (Gate::allows('isAdmin')) {
            $existingGaji = Gaji::where('no_slip_gaji', $request->no_slip_gaji)->first();

            $requestTanggalGaji = date('m-Y', strtotime($request->tanggal_gaji));
            $existingTanggalGaji = date('m-Y', strtotime($existingGaji->tanggal_gaji));

            if ($requestTanggalGaji != $existingTanggalGaji) {
                return redirect('gaji')->with('error', 'Data gaji pegawai untuk bulan yang dipilih sudah ada.');
            }

            $pegawai = Pegawai::where('nip', $request->nip)->first();
            $tunjangan = TunjanganSkill::where('kd_tunjangan_skill', $request->kd_tunjangan_skill)->first();
            $lembur = Lembur::where('kd_lembur', $request->kd_lembur)->first();
            $kasbon = Kasbon::where('kd_kasbon', $request->kd_kasbon)->first();
            $kehadiran = Kehadiran::where('kd_kehadiran', $request->kd_kehadiran)->first();

            $totalGajiKehadiran = ($kehadiran->jumlah_kehadiran / $kehadiran->jumlah_hari_kerja_kalender) * $pegawai->gaji_pokok;
            $gaji_bersih = $totalGajiKehadiran + $tunjangan->jumlah_tunjangan_skill + $lembur->total_pendapatan_lembur - $kasbon->jumlah_kasbon;

            $data = [
                'no_slip_gaji' => $request->no_slip_gaji,
                'nip' => $request->nip,
                'tanggal_gaji' => $request->tanggal_gaji,
                'total_gaji' => $totalGajiKehadiran,
                'total_gaji_pokok' => $pegawai->gaji_pokok,
                'total_tunjangan_skill' => $tunjangan->jumlah_tunjangan_skill,
                'total_biaya_lembur' => $lembur->total_pendapatan_lembur,
                'total_kasbon' => $kasbon->jumlah_kasbon,
                'gaji_kotor' => $existingGaji->gaji_kotor,
                'gaji_bersih' => $gaji_bersih,
                'keterangan' => $request->keterangan,
                'status_pengajuan' => $request->status_pengajuan,
            ];

            if ($request->kd_kasbon == 1) {
                $sub_jumlah_kasbon = 0;
            } else {
                $sub_jumlah_kasbon = 1;
            }

            if ($request->kd_tunjangan_skill == 1) {
                $sub_jumlah_tunjangan_skill = 0;
            } else {
                $sub_jumlah_tunjangan_skill = 1;
            }

            $data2 = [
                'no_slip_gaji' => $request->no_slip_gaji,
                'kd_tunjangan_skill' => $request->kd_tunjangan_skill,
                'kd_kasbon' => $request->kd_kasbon,
                'kd_lembur' => $request->kd_lembur,
                'kd_kehadiran' => $request->kd_kehadiran,
                'sub_total_tunjangan_skill' => $tunjangan->jumlah_tunjangan_skill,
                'sub_total_lembur' => $lembur->total_pendapatan_lembur,
                'sub_total_kasbon' => $kasbon->jumlah_kasbon,
                'sub_total_kehadiran' => $totalGajiKehadiran,
                'sub_jumlah_tunjangan_skill' => $sub_jumlah_tunjangan_skill,
                'sub_jumlah_lembur' => $lembur->jumlah_jam_lembur,
                'sub_jumlah_kasbon' => $sub_jumlah_kasbon,
                'sub_jumlah_kehadiran' => $kehadiran->jumlah_kehadiran,
            ];

            Gaji::where('no_slip_gaji', $request->no_slip_gaji)->update($data);
            DetailGaji::where('id_detail_gaji', $request->id_detail_gaji)->update($data2);
            return redirect('gaji')->with('success', 'Data Sukses Diperbarui');
        } else {
            return view('error.404');
        }
    }

    public function delete($no_slip_gaji)
    {
        if (Gate::allows('isAdmin')) {
            $data = Gaji::where('no_slip_gaji', $no_slip_gaji)->first();
            $data->delete();
            return redirect('gaji');
        } else {
            return view('error.404');
        }
    }

    public function detail($no_slip_gaji)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isUser')) {
            $data['detail'] = Gaji::where('no_slip_gaji', $no_slip_gaji)->first();
            return view('gaji.detail')->with($data);
        } else {
            return view('error.404');
        }
    }

    public function cetak_pdf($no_slip_gaji)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isUser')) {
            $detail = Gaji::where('no_slip_gaji', $no_slip_gaji)->first();

            $pdf = PDF::loadview('gaji/cetak', ['detail' => $detail]);
            return $pdf->download('Slip Gaji ' . $detail->pegawai->nm_pegawai . ' ' . $no_slip_gaji);
        } else {
            return view('error.404');
        }
    }

    public function cetak_all()
    {
        if (Gate::allows('isAdmin') || Gate::allows('isUser')) {
            $all = Gaji::get();

            $pdf = PDF::loadview('gaji/cetak-all', ['all' => $all]);
            return $pdf->download('Laporan All Gaji ' . Sistem::konversiTanggal(Carbon::now()));
        } else {
            return view('error.404');
        }
    }
}
