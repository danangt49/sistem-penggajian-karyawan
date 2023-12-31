<?php

namespace App\Http\Controllers\Master;

use App\Helpers\Sistem;
use App\Http\Controllers\Controller;
use App\Models\Kehadiran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;
use PDF;

class KehadiranController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Gate::allows('isAdmin') || Gate::allows('isDirektur')) {
            return view('master.kehadiran.home');
        } else {
            return view('error.404');
        }
    }

    public function json()
    {
        $data = Kehadiran::orderBy('created_at', 'DESC')->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn =
                    '
            <a class="btn btn-sm" data-toggle="tooltip" title="Edit Data" href="kehadiran/' .
                    $row->kd_kehadiran .
                    '"><i class="fas fa-tools"></i></a>
            <button data-kd_kehadiran="' .
                    $row->kd_kehadiran .
                    '" data-toggle="tooltip" title="Hapus Data" class="btn btn-sm delete"><i class="fas fa-trash-restore"></i></button>
            ';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        if (Gate::allows('isAdmin')) {
            return view('master.kehadiran.create');
        } else {
            return view('error.404');
        }
    }

    public function store(Request $request)
    {
        if (Gate::allows('isAdmin')) {
            $exiting = Kehadiran::where('jumlah_kehadiran', $request->jumlah_kehadiran)
                ->where('jumlah_hari_kerja_kalender', $request->jumlah_hari_kerja_kalender)
                ->exists();

            if ($exiting) {
                return redirect('master/kehadiran')->with('error', 'Data sudah ada.');
            }

            $data = [
                'kd_kehadiran' => $request->kd_kehadiran,
                'jumlah_kehadiran' => $request->jumlah_kehadiran,
                'jumlah_hari_kerja_kalender' => $request->jumlah_hari_kerja_kalender,
            ];

            Kehadiran::create($data);
            return redirect('master/kehadiran')->with('success', 'Data Sukses Ditambahkan');
        } else {
            return view('error.404');
        }
    }

    public function edit($kd_kehadiran)
    {
        if (Gate::allows('isAdmin')) {
            $data['kehadiran'] = Kehadiran::where('kd_kehadiran', $kd_kehadiran)->first();
            return view('master.kehadiran.edit')->with($data);
        } else {
            return view('error.404');
        }
    }

    public function update(Request $request)
    {
        if (Gate::allows('isAdmin')) {
            $exiting = Kehadiran::where('kd_kehadiran', '!=', $request->kd_kehadiran)
                ->where('jumlah_kehadiran', $request->jumlah_kehadiran)
                ->where('jumlah_hari_kerja_kalender', $request->jumlah_hari_kerja_kalender)
                ->exists();

            if ($exiting) {
                return redirect('master/kehadiran')->with('error', 'Data sudah ada.');
            }
            $data = [
                'kd_kehadiran' => $request->kd_kehadiran,
                'jumlah_kehadiran' => $request->jumlah_kehadiran,
                'jumlah_hari_kerja_kalender' => $request->jumlah_hari_kerja_kalender,
            ];

            Kehadiran::where('kd_kehadiran', $request->kd_kehadiran)->update($data);
            return redirect('master/kehadiran')->with('success', 'Data Sukses Diperbarui');
        } else {
            return view('error.404');
        }
    }

    public function delete($kd_kehadiran)
    {
        if (Gate::allows('isAdmin')) {
            $data = Kehadiran::find($kd_kehadiran);
            $data->delete();
            return redirect('master/kehadiran');
        } else {
            return view('error.404');
        }
    }

    public function cetak_all()
    {
        if (Gate::allows('isAdmin') || Gate::allows('isDirektur')) {
            $all = Kehadiran::get();

            $pdf = PDF::loadview('master/kehadiran/cetak-all', ['all' => $all]);
            return $pdf->download('Laporan_Keseluruhan_Data_Kehadiran'.'.pdf');
        } else {
            return view('error.404');
        }
    }
}
