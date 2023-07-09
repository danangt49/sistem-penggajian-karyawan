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
        return view('gaji.home');
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
                $btn1 =
                    '
          <a class="btn btn-sm" href="gaji/' .
                    $row->no_slip_gaji .
                    '"><i class="fas fa-tools"></i></a>
          <a class="btn btn-sm" href="gaji-detail/' .
                    $row->no_slip_gaji .
                    '"><i class="fas fa-eye"></i></a>
          ';

                $btn2 =
                    '
          <a class="btn btn-sm" href="gaji/' .
                    $row->no_slip_gaji .
                    '"><i class="fas fa-tools"></i></a>
          <a class="btn btn-sm" href="gaji-detail/' .
                    $row->no_slip_gaji .
                    '"><i class="fas fa-eye"></i></a>
          <button data-no_slip_gaji="' .
                    $row->no_slip_gaji .
                    '"class="btn btn-sm delete"><i class="fas fa-trash-restore"></i></button>
          ';
                if ($row->status_pengajuan == 'Sudah') {
                    return $btn1;
                } else {
                    return $btn2;
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
            $kd_kehadiran = random_int(1, 9999);

            $gaji = Pegawai::where('nip', $request->nip)->first();
            $tunjangan = TunjanganSkill::where('kd_tunjangan_skill', $request->kd_tunjangan_skill)->first();
            $lembur = Lembur::where('kd_lembur', $request->kd_lembur)->first();
            $kasbon = Kasbon::where('kd_kasbon', $request->kd_kasbon)->first();

            $total = ($request->jumlah_kehadiran / $request->jumlah_hari_kerja_kalender) * $gaji->gaji_pokok;
            $gaji_bersih = $total + $tunjangan->jumlah_tunjangan_skill + $lembur->total_pendapatan_lembur - $kasbon->jumlah_kasbon;

            $data = [
                'no_slip_gaji' => $slip_gaji,
                'nip' => $request->nip,
                'tanggal_gaji' => $request->tanggal_gaji,
                'total_gaji_pokok' => $gaji->gaji_pokok,
                'total_tunjangan_skill' => $tunjangan->jumlah_tunjangan_skill,
                'total_biaya_lembur' => $lembur->total_pendapatan_lembur,
                'total_kasbon' => $kasbon->jumlah_kasbon,
                'gaji_kotor' => $gaji->gaji_pokok,
                'gaji_bersih' => $gaji_bersih,
                'keterangan' => $request->keterangan,
                'status_pengajuan' => $request->status_pengajuan,
            ];

            $data2 = [
                'kd_kehadiran' => $kd_kehadiran,
                'jumlah_kehadiran' => $request->jumlah_kehadiran,
                'jumlah_hari_kerja_kalender' => $request->jumlah_hari_kerja_kalender,
                'total_gaji' => $total,
            ];

            if($request->kd_kasbon == 1) {
                $sub_jumlah_kasbon = 0;
            } else {
                $sub_jumlah_kasbon = 1;
            }

            if($request->kd_tunjangan_skill == 1) {
                $sub_jumlah_tunjangan_skill = 0;
            } else {
                $sub_jumlah_tunjangan_skill = 1;
            }

            $data3 = [
                'no_slip_gaji' => $slip_gaji,
                'kd_tunjangan_skill' => $request->kd_tunjangan_skill,
                'kd_kasbon' => $request->kd_kasbon,
                'kd_lembur' => $request->kd_lembur,
                'kd_kehadiran' => $kd_kehadiran,
                'sub_total_tunjangan_skill' => $tunjangan->jumlah_tunjangan_skill,
                'sub_total_lembur' => $lembur->total_pendapatan_lembur,
                'sub_total_kasbon' => $kasbon->jumlah_kasbon,
                'sub_total_kehadiran' => $total,
                'sub_jumlah_tunjangan_skill' => $sub_jumlah_kasbon,
                'sub_jumlah_lembur' => $lembur->jumlah_jam_lembur,
                'sub_jumlah_kasbon' => $sub_jumlah_tunjangan_skill,
                'sub_jumlah_kehadiran' => $request->jumlah_kehadiran,
            ];

            Gaji::create($data);
            Kehadiran::create($data2);
            DetailGaji::create($data3);
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

            $gaji = Pegawai::where('nip', $request->nip)->first();
            $tunjangan = TunjanganSkill::where('kd_tunjangan_skill', $request->kd_tunjangan_skill)->first();
            $lembur = Lembur::where('kd_lembur', $request->kd_lembur)->first();
            $kasbon = Kasbon::where('kd_kasbon', $request->kd_kasbon)->first();

            $total = ($request->jumlah_kehadiran / $request->jumlah_hari_kerja_kalender) * $gaji->gaji_pokok;
            $gaji_bersih = $total + $tunjangan->jumlah_tunjangan_skill + $lembur->total_pendapatan_lembur - $kasbon->jumlah_kasbon;

            $data = [
                'no_slip_gaji' => $request->no_slip_gaji,
                'nip' => $request->nip,
                'tanggal_gaji' => $request->tanggal_gaji,
                'total_gaji_pokok' => $gaji->gaji_pokok,
                'total_tunjangan_skill' => $tunjangan->jumlah_tunjangan_skill,
                'total_biaya_lembur' => $lembur->total_pendapatan_lembur,
                'total_kasbon' => $kasbon->jumlah_kasbon,
                'gaji_kotor' => $gaji->gaji_pokok,
                'gaji_bersih' => $gaji_bersih,
                'keterangan' => $request->keterangan,
                'status_pengajuan' => $request->status_pengajuan,
            ];

            $data2 = [
                'jumlah_kehadiran' => $request->jumlah_kehadiran,
                'jumlah_hari_kerja_kalender' => $request->jumlah_hari_kerja_kalender,
                'total_gaji' => $total,
            ];

            if($request->kd_kasbon == 1) {
                $sub_jumlah_kasbon = 0;
            } else {
                $sub_jumlah_kasbon = 1;
            }

            if($request->kd_tunjangan_skill == 1) {
                $sub_jumlah_tunjangan_skill = 0;
            } else {
                $sub_jumlah_tunjangan_skill = 1;
            }

            $data3 = [
                'no_slip_gaji' => $request->no_slip_gaji,
                'kd_tunjangan_skill' => $request->kd_tunjangan_skill,
                'kd_kasbon' => $request->kd_kasbon,
                'kd_lembur' => $request->kd_lembur,
                'kd_kehadiran' => $request->kd_kehadiran,
                'sub_total_tunjangan_skill' => $tunjangan->jumlah_tunjangan_skill,
                'sub_total_lembur' => $lembur->total_pendapatan_lembur,
                'sub_total_kasbon' => $kasbon->jumlah_kasbon,
                'sub_total_kehadiran' => $total,
                'sub_jumlah_tunjangan_skill' => $sub_jumlah_tunjangan_skill,
                'sub_jumlah_lembur' => $lembur->jumlah_jam_lembur,
                'sub_jumlah_kasbon' => $sub_jumlah_kasbon,
                'sub_jumlah_kehadiran' => $request->jumlah_kehadiran,
            ];

            Gaji::where('no_slip_gaji', $request->no_slip_gaji)->update($data);
            Kehadiran::where('kd_kehadiran', $request->kd_kehadiran)->update($data2);
            DetailGaji::where('id_detail_gaji', $request->id_detail_gaji)->update($data3);
            return redirect('gaji')->with('success', 'Data Updated successfully');
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
        if (Gate::allows('isAdmin')) {
            $data['detail'] = Gaji::where('no_slip_gaji', $no_slip_gaji)->first();
            return view('gaji.detail')->with($data);
        } else {
             return view('error.404');
        }
    }

    public function cetak_pdf($no_slip_gaji)
    {
        if (Gate::allows('isAdmin')) {
            $detail = Gaji::where('no_slip_gaji', $no_slip_gaji)->first();

            $pdf = PDF::loadview('gaji/cetak', ['detail' => $detail]);
            return $pdf->download('Slip Gaji ' . $detail->pegawai->nm_pegawai . ' ' . $no_slip_gaji);
        } else {
             return view('error.404');
        }
    }

    public function cetak_all()
    {
        $all = Gaji::get();

        $pdf = PDF::loadview('gaji/cetak-all', ['all' => $all]);
        return $pdf->download('Laporan All Gaji ' . Sistem::konversiTanggal(Carbon::now()));
    }
}
