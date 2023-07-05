<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;

use App\Models\Lembur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

class LemburController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('master.lembur.home');
    }

    public function json()
    {
        $data = Lembur::orderBy('created_at', 'DESC')->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn1 = '';
                $btn2 =
                    '
            <a class="btn btn-sm" href="lembur/' .
                    $row->kd_lembur .
                    '"><i class="fas fa-tools"></i></a>
            <button data-kd_lembur="' .
                    $row->kd_lembur .
                    '"class="btn btn-sm delete"><i class="fas fa-trash-restore"></i></button>
            ';

                if ($row->kd_lembur == 1) {
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
            return view('master.lembur.create');
        } else {
             return view('error.404');
        }
    }

    public function store(Request $request)
    {
        if (Gate::allows('isAdmin')) {
            $data = [
                'kd_lembur' => $request->kd_lembur,
                'nm_lembur' => $request->nm_lembur,
                'jumlah_jam_lembur' => $request->jumlah_jam_lembur,
                'biaya_lembur_perjam' => $request->biaya_lembur_perjam,
                'total_pendapatan_lembur' => $request->total_pendapatan_lembur,
            ];

            Lembur::create($data);
            return redirect('master/lembur')->with('success', 'Data Sukses Ditambahkan');
        } else {
             return view('error.404');
        }
    }

    public function edit($kd_lembur)
    {
        if (Gate::allows('isAdmin')) {
            $data['lembur'] = Lembur::where('kd_lembur', $kd_lembur)->first();
            return view('master.lembur.edit')->with($data);
        } else {
             return view('error.404');
        }
    }

    public function update(Request $request)
    {
        if (Gate::allows('isAdmin')) {
            $data = [
                'kd_lembur' => $request->kd_lembur,
                'nm_lembur' => $request->nm_lembur,
                'jumlah_jam_lembur' => $request->jumlah_jam_lembur,
                'biaya_lembur_perjam' => $request->biaya_lembur_perjam,
                'total_pendapatan_lembur' => $request->total_pendapatan_lembur,
            ];

            Lembur::where('kd_lembur', $request->kd_lembur)->update($data);
            return redirect('master/lembur')->with('success', 'Data Sukses Diperbarui');
        } else {
             return view('error.404');
        }
    }

    public function delete($kd_lembur)
    {
        if (Gate::allows('isAdmin')) {
            $data = Lembur::where('kd_lembur', $kd_lembur)->first();
            $data->delete();
            return redirect('master/lembur');
        } else {
             return view('error.404');
        }
    }
}
