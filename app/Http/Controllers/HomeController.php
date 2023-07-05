<?php

namespace App\Http\Controllers;

use App\Models\Gaji;
use App\Models\Karyawan;
use App\Models\Kasbon;
use App\Models\Lembur;
use App\Models\TunjanganSkill;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['total_karyawan'] = Karyawan::count();
        $data['total_kasbon'] = Kasbon::count();
        $data['total_lembur'] = Lembur::count();
        $data['total_tunjangan_skill'] = TunjanganSkill::count();
        
        $cart = Gaji::select('tanggal_gaji', DB::raw('sum(gaji_bersih) as kredit'), DB::raw('sum(gaji_bersih) as debit'))
                ->groupBy('tanggal_gaji')
                ->havingRaw('count(tanggal_gaji) > 0')
                ->get();

                $tanggal = $cart->pluck('tanggal_gaji');
                $kredit = $cart->pluck('kredit');
                $debit = $cart->pluck('debit');
        return view('home', compact('tanggal', 'kredit', 'debit'))->with($data);
    }

    public function profil()
    {
        return view('profil');
    }
}
