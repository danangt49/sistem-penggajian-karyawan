<?php

namespace App\Http\Controllers;

use App\Models\Gaji;
use App\Models\Pegawai;
use App\Models\Kasbon;
use App\Models\Kehadiran;
use App\Models\Lembur;
use App\Models\TunjanganSkill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
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
        if (Gate::allows('isAdmin') || Gate::allows('isDirektur')) {
            $data['total_gaji'] = Pegawai::count();
            $data['total_pegawai'] = Pegawai::count();
            $data['total_kasbon'] = Kasbon::count();
            $data['total_lembur'] = Lembur::count();
            $data['total_tunjangan_skill'] = TunjanganSkill::count();
            $data['total_kehadiran'] = Kehadiran::count();

            $cart = Gaji::select(DB::raw("DATE_FORMAT(tanggal_gaji, '%M') AS bulan"), DB::raw('MONTH(tanggal_gaji) AS bulan_num'), DB::raw('SUM(gaji_bersih) AS kredit'), DB::raw('SUM(gaji_bersih) AS debit'))
                ->whereYear('tanggal_gaji', date('Y')) // Filter berdasarkan tahun saat ini
                ->groupBy('bulan', 'bulan_num')
                ->havingRaw('COUNT(*) > 0');

            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');

            if ($start_date && $end_date) {
                $cart->whereBetween('tanggal_gaji', [$start_date, $end_date]);
            }

            $cart = $cart->get();

            $bulan = $cart->pluck('bulan');
            $kredit = $cart->pluck('kredit');
            $debit = $cart->pluck('debit');

            return view('home', compact('bulan', 'kredit', 'debit'))
                ->with($data)
                ->with([
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                ]);
        } else {
            return view('data.gaji.home');
        }
    }

    public function download(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $cart = Gaji::select(DB::raw("DATE_FORMAT(tanggal_gaji, '%M %Y') AS bulan_tahun"), DB::raw('SUM(gaji_bersih) AS kredit'), DB::raw('SUM(gaji_bersih) AS debit'))
            ->whereYear('tanggal_gaji', date('Y')) // Filter berdasarkan tahun saat ini
            ->groupBy('bulan_tahun')
            ->havingRaw('COUNT(*) > 0');

        if ($start_date && $end_date) {
            $cart->whereBetween('tanggal_gaji', [$start_date, $end_date]);
        }

        $all = $cart->get();

        $pdf = PDF::loadView('download', compact('all', 'start_date', 'end_date'));

        $filename = 'Jurnal_Umum.pdf';

        return $pdf->download($filename);
    }

    public function profil()
    {
        return view('profil');
    }
}
