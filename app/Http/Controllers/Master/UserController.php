<?php

namespace App\Http\Controllers\Master;

use App\Helpers\Sistem;
use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use PDF;
use Yajra\DataTables\Facades\DataTables;
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Gate::allows('isAdmin') || Gate::allows('isUser')) {
            return view('master.user.home');
        } else {
            return view('error.404');
        }
    }

    public function json()
    {
        $data = User::orderBy('created_at', 'DESC')->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn =
                    '
          <a class="btn btn-sm" data-toggle="tooltip" title="Edit Data" href="user/' .
                    $row->id .
                    '"><i class="fas fa-tools"></i></a>
          <button data-id="' .
                    $row->id .
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
            return view('master.user.create');
        } else {
            return view('error.404');
        }
    }

    public function store(Request $request)
    {
        if (Gate::allows('isAdmin')) {
            $exiting = User::where('email', $request->email)->exists();

            if ($exiting) {
                return redirect('master/user')->with('error', 'Email Sudah Dipake');
            }

            $data = [
                'name' => $request->name,
                'level' => $request->level,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ];

            $data2 = [
                'status' => 'Aktif',
            ];

            User::create($data);
            Pegawai::where('nm_pegawai', $request->name)->update($data2);
            return redirect('master/user')->with('success', 'Data Sukses Ditambahkan');
        } else {
            return view('error.404');
        }
    }

    public function edit($id)
    {
        if (Gate::allows('isAdmin')) {
            $data['user'] = User::find($id);
            return view('master.user.edit')->with($data);
        } else {
            return view('error.404');
        }
    }

    public function update(Request $request)
    {
        if (Gate::allows('isAdmin')) {
            $exiting = User::where('id', '!=', $request->id)
                ->where('email', $request->email)
                ->exists();

            if ($exiting) {
                return redirect('master/user')->with('error', 'Email Sudah Dipake');
            }

            if ($request->level != null) {
                $data = [
                    'name' => $request->name,
                    'level' => $request->level,
                    'email' => $request->email,
                ];
            } else {
                $data = [
                    'name' => $request->name,
                    'email' => $request->email,
                ];
            }

            User::where('id', $request->id)->update($data);
            return redirect('master/user')->with('success', 'Data Sukses Diperbarui');
        } else {
            return view('error.404');
        }
    }

    public function delete($id)
    {
        if (Gate::allows('isAdmin')) {
            $data = User::find($id);
            $data2 = [
                'status' => 'Aktif',
            ];

            Pegawai::where('nm_pegawai', $data->name)->update($data2);
            $data->delete();
            return redirect('master/user');
        } else {
            return view('error.404');
        }
    }

    public function updateProfile(Request $request)
    {
        $data = [
            'name' => $request->name,
            'level' => $request->level,
            'email' => $request->email,
        ];

        User::where('id', $request->id)->update($data);
        return redirect('profil')->with('success', 'Profil Sukses Diperbarui');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword()],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);
        User::find($request->id)->update(['password' => Hash::make($request->new_password)]);
        return redirect('profil')->with('success', 'Password Sukses Diperbarui');
    }

    public function cetak_all()
    {
        if (Gate::allows('isAdmin') || Gate::allows('isUser')) {
            $all = User::get();

            $pdf = PDF::loadview('master/user/cetak-all', ['all' => $all]);
            return $pdf->download('Keseluruhan Data User ' . Sistem::konversiTanggal(Carbon::now()));
        } else {
            return view('error.404');
        }
    }
}
