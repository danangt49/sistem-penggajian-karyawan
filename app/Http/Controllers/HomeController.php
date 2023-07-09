<?php

namespace App\Http\Controllers;

use App\Helpers\Sistem;
use App\Models\Gaji;
use App\Models\Pegawai;
use App\Models\Kasbon;
use App\Models\Lembur;
use App\Models\TunjanganSkill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

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
    public function index(Request $request)
    {
        $data['total_pegawai'] = Pegawai::count();
        $data['total_kasbon'] = Kasbon::count();
        $data['total_lembur'] = Lembur::count();
        $data['total_tunjangan_skill'] = TunjanganSkill::count();

        $cart = Gaji::select('tanggal_gaji', DB::raw('sum(gaji_bersih) as kredit'), DB::raw('sum(gaji_bersih) as debit'))
            ->groupBy('tanggal_gaji')
            ->havingRaw('count(tanggal_gaji) > 0');

    $start_date = $request->input('start_date');
    $end_date = $request->input('end_date');

    if ($start_date && $end_date) {
        $cart->whereBetween('tanggal_gaji', [$start_date, $end_date]);
    }

    $cart = $cart->get();

    $tanggal = $cart->pluck('tanggal_gaji');
    $kredit = $cart->pluck('kredit');
    $debit = $cart->pluck('debit');

    return view('home', compact('tanggal', 'kredit', 'debit'))->with($data)->with([
        'start_date' => $start_date,
        'end_date' => $end_date,
    ]);
    }

    public function download(Request $request)
{
    $start_date = $request->input('start_date');
    $end_date = $request->input('end_date');

    $cart = Gaji::select('tanggal_gaji', DB::raw('sum(gaji_bersih) as kredit'), DB::raw('sum(gaji_bersih) as debit'))
        ->groupBy('tanggal_gaji')
        ->havingRaw('count(tanggal_gaji) > 0');

    if ($start_date && $end_date) {
        $cart->whereBetween('tanggal_gaji', [$start_date, $end_date]);
    }

    $all = $cart->get();

    $pdf = PDF::loadView('download', compact('all', 'start_date', 'end_date'));

    $filename = 'Jurnal Akutansi ' . Sistem::konversiTanggal($start_date) . ' Sampai ' . Sistem::konversiTanggal($end_date) . '.pdf';

    return $pdf->download($filename);
}

    public function profil()
    {
        return view('profil');
    }
}
