<?php

namespace App\Http\Controllers\Data;

use App\Helpers\Sistem;
use App\Http\Controllers\Controller;
use App\Libraries\Applib;
use App\Models\Gaji;
use App\Models\Pegawai;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
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
        if (Gate::allows('isPegawai')) {
            return view('data.gaji.home');
        } else {
            return view('error.404');
        }
    }

    public function json()
    {
        $pegawai = Pegawai::where('nm_pegawai', Auth::user()->name)->first();
        $data = Gaji::where('nip', $pegawai->nip)
            ->orderBy('created_at', 'DESC')
            ->get();
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
                $btn = ' <a class="btn btn-sm" href="/data/gaji-detail/' . $row->no_slip_gaji . '"><i class="fas fa-eye"></i></a>';
                return $btn;
            })

            ->rawColumns(['action'])
            ->make(true);
    }

    public function detail($no_slip_gaji)
    {
        if (Gate::allows('isPegawai')) {
            $pegawai = Pegawai::where('nm_pegawai', Auth::user()->name)->first();
            $data = Gaji::where('nip', $pegawai->nip)
                ->where('no_slip_gaji', $no_slip_gaji)
                ->first();
            return view('data.gaji.detail')->with('detail', $data);
        } else {
            return view('error.404');
        }
    }

    public function cetak_pdf($no_slip_gaji)
    {
        if (Gate::allows('isPegawai')) {
            $pegawai = Pegawai::where('nm_pegawai', Auth::user()->name)->first();
            $detail = Gaji::where('nip', $pegawai->nip)
                ->where('no_slip_gaji', $no_slip_gaji)
                ->first();

            $pdf = PDF::loadview('data/gaji/cetak', ['detail' => $detail]);
            return $pdf->download('Slip Gaji ' . $detail->pegawai->nm_pegawai . ' ' . $no_slip_gaji . '.pdf');
        } else {
            return view('error.404');
        }
    }

    public function cetak_all()
    {
        if (Gate::allows('isPegawai')) {
            $pegawai = Pegawai::where('nm_pegawai', Auth::user()->name)->first();
            $all = Gaji::where('nip', $pegawai->nip)->get();

            $pdf = PDF::loadview('data.gaji/cetak-all', ['all' => $all]);
            return $pdf->download('Laporan All Gaji ' . Sistem::konversiTanggal(Carbon::now()) . '.pdf');
        } else {
            return view('error.404');
        }
    }
}
