<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('master.user.home');
    }

    public function json()
    {
        $data = User::orderBy('created_at', 'DESC')->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn =
                    '
          <a class="btn btn-sm" href="user/' .
                    $row->id .
                    '"><i class="fas fa-tools"></i></a>
          <button data-id="' .
                    $row->id .
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
            return view('master.user.create');
        } else {
             return view('error.404');
        }
    }

    public function store(Request $request)
    {
        if (Gate::allows('isAdmin')) {
            $data = [
                'name' => $request->name,
                'level' => $request->level,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ];

            User::create($data);
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
            $data = [
                'name' => $request->name,
                'level' => $request->level,
                'email' => $request->email,
            ];

            User::where('id', $$request->id)->update($data);
            return redirect('master/user')->with('success', 'Data Sukses Diperbarui');
        } else {
             return view('error.404');
        }
    }

    public function delete($id)
    {
        if (Gate::allows('isAdmin')) {
            $data = User::find($id);
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
}