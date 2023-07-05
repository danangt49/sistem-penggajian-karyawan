<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

class JabatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('master.jabatan.home');
    }

    public function json()
    {
        $data = Jabatan::orderBy('created_at', 'DESC')->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn =
                    '
          <a class="btn btn-sm" href="jabatan/' .
                    $row->kd_jabatan .
                    '"><i class="fas fa-tools"></i></a>
          <button data-kd_jabatan="' .
                    $row->kd_jabatan .
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
            return view('master.jabatan.create');
        } else {
             return view('error.404');
        }
    }

    public function store(Request $request)
    {
        if (Gate::allows('isAdmin')) {
            $data = [
                'nm_jabatan' => $request->nm_jabatan,
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
            $data = [
                'nm_jabatan' => $request->nm_jabatan,
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
}
