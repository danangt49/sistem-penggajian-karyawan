<?php

namespace App\Http\Controllers\Master;

use App\Helpers\Sistem;
use App\Http\Controllers\Controller;
use App\Libraries\Applib;
use App\Models\Pegawai;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use PDF;
use Yajra\DataTables\Facades\DataTables;

class PegawaiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('master.pegawai.home');
    }

    public function json()
    {
        $data = Pegawai::orderBy('created_at', 'DESC')->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('nama_jabatan', function ($row) {
                return Applib::getJabatan($row->kd_jabatan);
            })
            ->addColumn('tanggal_lahir', function ($row) {
                return Sistem::konversiTanggal($row->tanggal_lahir);
            })
            ->addColumn('tanggal_masuk', function ($row) {
                return Sistem::konversiTanggal($row->tanggal_masuk);
            })
            ->addColumn('gaji_pokok', function ($row) {
                return Sistem::formatRupiah($row->gaji_pokok);
            })
            ->addColumn('action', function ($row) {
                $btn =
                    '
          <a class="btn btn-sm" href="pegawai/' .
                    $row->nip .
                    '"><i class="fas fa-tools"></i></a>
          <button data-id="' .
                    $row->nip .
                    '"class="btn btn-sm delete"><i class="fas fa-trash-restore"></i></button>
          ';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        if (Gate::allows('isAdmin')) {
            return view('master.pegawai.create');
        } else {
            return view('error.404');
        }
    }

    public function store(Request $request)
    {
        if (Gate::allows('isAdmin')) {
            $data = [
                'nip' => $request->nip,
                'kd_jabatan' => $request->kd_jabatan,
                'gaji_pokok' => $request->gaji_pokok,
                'nm_pegawai' => $request->nm_pegawai,
                'tanggal_masuk' => $request->tanggal_masuk,
                'tanggal_lahir' => $request->tanggal_lahir,
                'no_telepon' => $request->no_telepon,
                'alamat' => $request->alamat,
            ];

            Pegawai::create($data);
            return redirect('master/pegawai')->with('success', 'Data Sukses Ditambahkan');
        } else {
            return view('error.404');
        }
    }

    public function edit($nip)
    {
        if (Gate::allows('isAdmin')) {
            $data['pegawai'] = Pegawai::where('nip', $nip)->first();
            return view('master.pegawai.edit')->with($data);
        } else {
            return view('error.404');
        }
    }

    public function update(Request $request)
    {
        if (Gate::allows('isAdmin')) {
            $data = [
                'nip' => $request->nip,
                'kd_jabatan' => $request->kd_jabatan,
                'gaji_pokok' => $request->gaji_pokok,
                'nm_pegawai' => $request->nm_pegawai,
                'tanggal_masuk' => $request->tanggal_masuk,
                'tanggal_lahir' => $request->tanggal_lahir,
                'no_telepon' => $request->no_telepon,
                'alamat' => $request->alamat,
            ];

            Pegawai::where('nip', $request->nip)->update($data);
            return redirect('master/pegawai')->with('success', 'Data Sukses Diperbarui');
        } else {
            return view('error.404');
        }
    }

    public function delete($nip)
    {
        if (Gate::allows('isAdmin')) {
            $data = Pegawai::where('nip', $nip)->first();
            $data->delete();
            return redirect('master/pegawai');
        } else {
            return view('error.404');
        }
    }

    public function cetak_all()
    {
        $all = Pegawai::get();

        $pdf = PDF::loadview('master/pegawai/cetak-all', ['all' => $all]);
        return $pdf->download('Keseluruhan Data Pegawai ' . Sistem::konversiTanggal(Carbon::now()));
    }
}
