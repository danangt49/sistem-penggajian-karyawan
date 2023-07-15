<?php

namespace App\Http\Controllers\Master;

use App\Helpers\Sistem;
use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use PDF;
use Yajra\DataTables\Facades\DataTables;

class JabatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Gate::allows('isAdmin') || Gate::allows('isUser')) {
            return view('master.jabatan.home');
        } else {
            return view('error.404');
        }
    }

    public function json()
    {
        $data = Jabatan::orderBy('created_at', 'DESC')->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('total_gaji', function ($row) {
                return Sistem::formatRupiah($row->total_gaji);
            })
            ->addColumn('action', function ($row) {
                $btn =
                    '
          <a class="btn btn-sm" data-toggle="tooltip" title="Edit Data" href="jabatan/' .
                    $row->kd_jabatan .
                    '"><i class="fas fa-tools"></i></a>
          <button data-kd_jabatan="' .
                    $row->kd_jabatan .
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
            return view('master.jabatan.create');
        } else {
            return view('error.404');
        }
    }

    public function store(Request $request)
    {
        if (Gate::allows('isAdmin')) {
            $exiting = Jabatan::where('nm_jabatan', $request->nm_jabatan)
                ->where('total_gaji', $request->total_gaji)
                ->exists();

            if ($exiting) {
                return redirect('master/jabatan')->with('error', 'Data sudah ada.');
            }

            $data = [
                'nm_jabatan' => $request->nm_jabatan,
                'total_gaji' => $request->total_gaji,
            ];

            Jabatan::create($data);
            return redirect('master/jabatan')->with('success', 'Data Sukses Ditambahkan');
        } else {
            return view('error.404');
        }
    }

    public function edit(Request $request)
    {
        if (Gate::allows('isAdmin')) {
            $data['jabatan'] = Jabatan::where('kd_jabatan', $request->kd_jabatan)->first();
            return view('master.jabatan.edit')->with($data);
        } else {
            return view('error.404');
        }
    }

    public function update(Request $request)
    {
        if (Gate::allows('isAdmin')) {
            $exiting = Jabatan::where('kd_jabatan', '!=', $request->kd_jabatan)
                ->where('nm_jabatan', $request->nm_jabatan)
                ->where('total_gaji', $request->total_gaji)
                ->exists();

            if ($exiting) {
                return redirect('master/jabatan')->with('error', 'Data sudah ada.');
            }

            $data = [
                'nm_jabatan' => $request->nm_jabatan,
                'total_gaji' => $request->total_gaji,
            ];

            Jabatan::where('kd_jabatan', $request->kd_jabatan)->update($data);
            return redirect('master/jabatan')->with('success', 'Data Sukses Diperbarui');
        } else {
            return view('error.404');
        }
    }

    public function delete(Request $request)
    {
        if (Gate::allows('isAdmin')) {
            $data = Jabatan::where('kd_jabatan', $request->kd_jabatan)->first();
            $data->delete();
            return redirect('master/jabatan');
        } else {
            return view('error.404');
        }
    }

    public function cetak_all()
    {
        if (Gate::allows('isAdmin') || Gate::allows('isUser')) {
            $all = Jabatan::get();

            $pdf = PDF::loadview('master/jabatan/cetak-all', ['all' => $all]);
            return $pdf->download('Keseluruhan Data Jabatan ' . Sistem::konversiTanggal(Carbon::now()));
        } else {
            return view('error.404');
        }
    }

    public function json_get_by_kd_jabatan(Request $request)
    {
        $jabatan = Jabatan::where('kd_jabatan', $request->kd_jabatan)->first();

        if ($jabatan) {
            return response()->json($jabatan);
        } else {
            return response()->json(['error' => 'Jabatan Tidak Ada'], 404);
        }
    }
}
