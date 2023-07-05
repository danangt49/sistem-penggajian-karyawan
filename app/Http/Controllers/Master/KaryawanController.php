<?php

namespace App\Http\Controllers\Master;

use App\Helpers\Sistem;
use App\Http\Controllers\Controller;
use App\Libraries\Applib;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

class KaryawanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('master.karyawan.home');
    }

    public function json()
    {
        $data = Karyawan::orderBy('created_at', 'DESC')->get();
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
          <a class="btn btn-sm" href="karyawan/' .
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
            return view('master.karyawan.create');
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

            Karyawan::create($data);
            return redirect('master/karyawan')->with('success', 'Data Sukses Ditambahkan');
        } else {
            return view('error.404');
        }
    }

    public function edit($nip)
    {
        if (Gate::allows('isAdmin')) {
            $data['karyawan'] = Karyawan::where('nip', $nip)->first();
            return view('master.karyawan.edit')->with($data);
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

            Karyawan::where('nip', $request->nip)->update($data);
            return redirect('master/karyawan')->with('success', 'Data Sukses Diperbarui');
        } else {
            return view('error.404');
        }
    }

    public function delete($nip)
    {
        if (Gate::allows('isAdmin')) {
            $data = Karyawan::where('nip', $nip)->first();
            $data->delete();
            return redirect('master/karyawan');
        } else {
            return view('error.404');
        }
    }
}
