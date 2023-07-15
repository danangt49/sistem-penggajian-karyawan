<?php

namespace App\Http\Controllers\Master;

use App\Helpers\Sistem;
use App\Http\Controllers\Controller;

use App\Models\Kasbon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use PDF;
use Yajra\DataTables\Facades\DataTables;

class KasbonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Gate::allows('isAdmin') || Gate::allows('isUser')) {
            return view('master.kasbon.home');
        } else {
            return view('error.404');
        }
    }

    public function json()
    {
        $data = Kasbon::orderBy('created_at', 'DESC')->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('jumlah_kasbon', function ($row) {
                return Sistem::formatRupiah($row->jumlah_kasbon);
            })

            ->addColumn('action', function ($row) {
                $btn1 = '';
                $btn2 =
                    '
            <a class="btn btn-sm" href="kasbon/' .
                    $row->kd_kasbon .
                    '"><i class="fas fa-tools"></i></a>
            <button data-kd_kasbon="' .
                    $row->kd_kasbon .
                    '"class="btn btn-sm delete"><i class="fas fa-trash-restore"></i></button>
            ';
                if ($row->kd_kasbon == 1) {
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
        if (Gate::allows('isAdmin') || Gate::allows('isUser')) {
            return view('master.kasbon.create');
        } else {
            return view('error.404');
        }
    }

    public function store(Request $request)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isUser')) {
            $exiting = Kasbon::where('jumlah_kasbon', $request->jumlah_kasbon)->exists();

            if ($exiting) {
                return redirect('master/kasbon')->with('error', 'Data sudah ada.');
            }
            $data = [
                'kd_kasbon' => $request->kd_kasbon,
                'nm_kasbon' => $request->nm_kasbon,
                'jumlah_kasbon' => $request->jumlah_kasbon,
                'keterangan' => $request->keterangan,
            ];

            Kasbon::create($data);
            return redirect('master/kasbon')->with('success', 'Data Sukses Ditambahkan');
        } else {
            return view('error.404');
        }
    }

    public function edit($kd_kasbon)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isUser')) {
            $data['kasbon'] = Kasbon::where('kd_kasbon', $kd_kasbon)->first();
            return view('master.kasbon.edit')->with($data);
        } else {
            return view('error.404');
        }
    }

    public function update(Request $request)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isUser')) {
            $exiting = Kasbon::where('kd_kasbon', '!=', $request->kd_kasbon)
                ->where('jumlah_kasbon', $request->jumlah_kasbon)
                ->exists();

            if ($exiting) {
                return redirect('master/kasbon')->with('error', 'Data sudah ada.');
            }

            $data = [
                'kd_kasbon' => $request->kd_kasbon,
                'nm_kasbon' => $request->nm_kasbon,
                'jumlah_kasbon' => $request->jumlah_kasbon,
                'keterangan' => $request->keterangan,
            ];

            Kasbon::where('kd_kasbon', $request->kd_kasbon)->update($data);
            return redirect('master/kasbon')->with('success', 'Data Sukses Diperbarui');
        } else {
            return view('error.404');
        }
    }

    public function delete($kd_kasbon)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isUser')) {
            $data = Kasbon::find($kd_kasbon);
            $data->delete();
            return redirect('master/kasbon');
        } else {
            return view('error.404');
        }
    }

    public function cetak_all()
    {
        if (Gate::allows('isAdmin') || Gate::allows('isUser')) {
            $all = Kasbon::get();

            $pdf = PDF::loadview('master/kasbon/cetak-all', ['all' => $all]);
            return $pdf->download('Keseluruhan Data Kasbon ' . Sistem::konversiTanggal(Carbon::now()));
        } else {
            return view('error.404');
        }
    }
}
