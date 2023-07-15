<?php

namespace App\Http\Controllers\Master;

use App\Helpers\Sistem;
use App\Http\Controllers\Controller;

use App\Models\Lembur;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use PDF;
use Yajra\DataTables\Facades\DataTables;

class LemburController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Gate::allows('isAdmin') || Gate::allows('isUser')) {
            return view('master.lembur.home');
        } else {
            return view('error.404');
        }
    }

    public function json()
    {
        $data = Lembur::orderBy('created_at', 'DESC')->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('biaya_lembur_perjam', function ($row) {
                return Sistem::formatRupiah($row->biaya_lembur_perjam);
            })
            ->addColumn('total_pendapatan_lembur', function ($row) {
                return Sistem::formatRupiah($row->total_pendapatan_lembur);
            })
            ->addColumn('action', function ($row) {
                $btn1 = '';
                $btn2 = '<a class="btn btn-sm" data-toggle="tooltip" title="Edit Data" href="lembur/' .$row->kd_lembur .'"><i class="fas fa-tools"></i></a>
                <button data-kd_lembur="' .$row->kd_lembur .'" data-toggle="tooltip" title="Hapus Data" class="btn btn-sm delete"><i class="fas fa-trash-restore"></i></button>';

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
            $exiting = Lembur::where('jumlah_jam_lembur', $request->jumlah_jam_lembur)
                ->where('biaya_lembur_perjam', $request->biaya_lembur_perjam)
                ->where('total_pendapatan_lembur', $request->total_pendapatan_lembur)
                ->exists();

            if ($exiting) {
                return redirect('master/lembur')->with('error', 'Data sudah ada.');
            }

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
            $exiting = Lembur::where('kd_lembur', '!=', $request->kd_lembur)
                ->where('jumlah_jam_lembur', $request->jumlah_jam_lembur)
                ->where('biaya_lembur_perjam', $request->biaya_lembur_perjam)
                ->where('total_pendapatan_lembur', $request->total_pendapatan_lembur)
                ->exists();

            if ($exiting) {
                return redirect('master/lembur')->with('error', 'Data sudah ada.');
            }

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

    public function cetak_all()
    {
        if (Gate::allows('isAdmin') || Gate::allows('isUser')) {
            $all = Lembur::get();

            $pdf = PDF::loadview('master/lembur/cetak-all', ['all' => $all]);
            return $pdf->download('Keseluruhan Data Lembur ' . Sistem::konversiTanggal(Carbon::now()));
        } else {
            return view('error.404');
        }
    }
}
