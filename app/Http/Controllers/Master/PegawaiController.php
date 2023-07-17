<?php

namespace App\Http\Controllers\Master;

use App\Helpers\Sistem;
use App\Http\Controllers\Controller;
use App\Libraries\Applib;
use App\Models\Pegawai;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use PDF;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class PegawaiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Gate::allows('isAdmin') || Gate::allows('isDirektur')) {
            return view('master.pegawai.home');
        } else {
            return view('error.404');
        }
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
                $btn = '<a class="btn btn-sm" data-toggle="tooltip" title="Edit Data" href="pegawai/' . $row->nip . '"><i class="fas fa-tools"></i></a>';
                $btn2 = '<button data-id="' . $row->nip . '" data-toggle="tooltip" title="Edit Status Data" class="btn btn-sm update"><i class="fas fa-paper-plane"></i></button>';
                $btn3 = '<button data-id="' . $row->nip . '" data-toggle="tooltip" title="Hapus Data" class="btn btn-sm delete"><i class="fas fa-trash-restore"></i></button>';

                if ($row->status == 'Belum Aktif') {
                    return $btn . $btn3;
                } else {
                    return $btn . $btn2 . $btn3;
                }
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
            $existingPegawai = Pegawai::where('nip', $request->nip)->first();
            if ($existingPegawai) {
                return redirect('master/pegawai')->with('error', 'Nip Sudah Digunakan');
            }

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

    public function updateStatus($nip)
    {
        if (Gate::allows('isAdmin')) {
            $pegawai = Pegawai::where('nip', $nip)->first();
            if ($pegawai->status == 'Aktif' || $pegawai->status == 'Belum Aktif') {
                $data = [
                    'status' => 'Tidak Aktif',
                ];

                $data2 = [
                    'status' => 'TIDAK',
                ];
            } else {
                $data = [
                    'status' => 'Aktif',
                ];

                $data2 = [
                    'status' => 'AKTIF',
                ];
            }

            Pegawai::where('nip', $nip)->update($data);
            User::where('name', $pegawai->nm_pegawai)->update($data2);
            return redirect('master/pegawai');
        } else {
            return view('error.404');
        }
    }

    public function update(Request $request)
    {
        if (Gate::allows('isAdmin')) {
            // $existingPegawai = Pegawai::where('nip', '!=', $request->nip)->exists();

            // Log::info($existingPegawai);
            // Log::info($request);

            // if ($existingPegawai) {
            //     return redirect('master/pegawai')->with('error', 'NIP Sudah Digunakan');
            // }

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
        if (Gate::allows('isAdmin') || Gate::allows('isDirektur')) {
            $all = Pegawai::get();

            $pdf = PDF::loadview('master/pegawai/cetak-all', ['all' => $all]);
            return $pdf->download('Keseluruhan_Data_Pegawai'.'pdf');
        } else {
            return view('error.404');
        }
    }

    public function json_get_by_status()
    {
        $pegawai = Pegawai::where('status', 'Belum Aktif')->get();
        return response()->json($pegawai);
    }
}
