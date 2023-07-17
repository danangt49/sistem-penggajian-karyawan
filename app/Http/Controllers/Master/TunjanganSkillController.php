<?php

namespace App\Http\Controllers\Master;

use App\Helpers\Sistem;
use App\Http\Controllers\Controller;

use App\Models\TunjanganSkill;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use PDF;
use Yajra\DataTables\Facades\DataTables;

class TunjanganSkillController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Gate::allows('isAdmin') || Gate::allows('isDirektur')) {
            return view('master.tunjangan.home');
        } else {
            return view('error.404');
        }
    }

    public function json()
    {
        $data = TunjanganSkill::orderBy('created_at', 'DESC')->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('jumlah_tunjangan_skill', function ($row) {
                return Sistem::formatRupiah($row->jumlah_tunjangan_skill);
            })
            ->addColumn('action', function ($row) {
                $btn1 = '';
                $btn2 =
                    '
            <a class="btn btn-sm" data-toggle="tooltip" title="Edit Data" href="tunjangan-skill/' .
                    $row->kd_tunjangan_skill .
                    '"><i class="fas fa-tools"></i></a>
            <button data-kd_tunjangan_skill="' .
                    $row->kd_tunjangan_skill .
                    '" data-toggle="tooltip" title="Hapus Data" class="btn btn-sm delete"><i class="fas fa-trash-restore"></i></button>
            ';
                if ($row->kd_tunjangan_skill == 1) {
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
            return view('master.tunjangan.create');
        } else {
            return view('error.404');
        }
    }

    public function store(Request $request)
    {
        if (Gate::allows('isAdmin')) {
            $exiting = TunjanganSkill::where('nm_tunjangan_skill', $request->nm_tunjangan_skill)
                ->where('jumlah_tunjangan_skill', $request->jumlah_tunjangan_skill)
                ->exists();

            if ($exiting) {
                return redirect('master/tunjangan-skill')->with('error', 'Data sudah ada.');
            }

            $data = [
                'kd_tunjangan_skill' => $request->kd_tunjangan_skill,
                'nm_tunjangan_skill' => $request->nm_tunjangan_skill,
                'jumlah_tunjangan_skill' => $request->jumlah_tunjangan_skill,
                'keterangan' => $request->keterangan,
            ];

            TunjanganSkill::create($data);
            return redirect('master/tunjangan-skill')->with('success', 'Data Sukses Ditambahkan');
        } else {
            return view('error.404');
        }
    }

    public function edit($kd_tunjangan_skill)
    {
        if (Gate::allows('isAdmin')) {
            $data['tunjangan'] = TunjanganSkill::where('kd_tunjangan_skill', $kd_tunjangan_skill)->first();
            return view('master.tunjangan.edit')->with($data);
        } else {
            return view('error.404');
        }
    }

    public function update(Request $request)
    {
        if (Gate::allows('isAdmin')) {
            $exiting = TunjanganSkill::where('kd_tunjangan_skill', '!=', $request->kd_tunjangan_skill)
                ->where('nm_tunjangan_skill', $request->nm_tunjangan_skill)
                ->where('jumlah_tunjangan_skill', $request->jumlah_tunjangan_skill)
                ->exists();

            if ($exiting) {
                return redirect('master/tunjangan-skill')->with('error', 'Data sudah ada.');
            }

            $data = [
                'kd_tunjangan_skill' => $request->kd_tunjangan_skill,
                'nm_tunjangan_skill' => $request->nm_tunjangan_skill,
                'jumlah_tunjangan_skill' => $request->jumlah_tunjangan_skill,
                'keterangan' => $request->keterangan,
            ];

            TunjanganSkill::where('kd_tunjangan_skill', $request->kd_tunjangan_skill)->update($data);
            return redirect('master/tunjangan-skill')->with('success', 'Data Sukses Diperbarui');
        } else {
            return view('error.404');
        }
    }

    public function delete($kd_tunjangan_skill)
    {
        if (Gate::allows('isAdmin')) {
            $data = TunjanganSkill::where('kd_tunjangan_skill', $kd_tunjangan_skill)->first();
            $data->delete();
            return redirect('master/tunjangan-skill');
        } else {
            return view('error.404');
        }
    }

    public function cetak_all()
    {
        if (Gate::allows('isAdmin') || Gate::allows('isDirektur')) {
            $all = TunjanganSkill::get();

            $pdf = PDF::loadview('master/tunjangan/cetak-all', ['all' => $all]);
            return $pdf->download('Keseluruhan_Data_Tunjangan_Skill'.'.pdf');
        } else {
            return view('error.404');
        }
    }
}
