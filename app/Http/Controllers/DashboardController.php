<?php

namespace App\Http\Controllers;

use App\Exports\RentalExport;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{

    public function index()
    {
        $years = Rental::select(
            DB::raw('YEAR(tgl_keluar) year')
        )
            ->groupby('year')
            ->get();

        return view('dasboard.admin', compact('years'));
        // echo "hello";
    }

    public function chart(Request $request)
    {
        $penggunaan = Rental::select(
            DB::raw('count(id) as `jumlah_penggunaan`'),
            DB::raw('YEAR(tgl_keluar) as year, MONTH(tgl_keluar) as month')
        )
            ->where(DB::raw('YEAR(tgl_keluar)'), $request->get('year'))
            ->groupby('year', 'month')
            ->orderBy('month', 'desc')
            ->get();
        for ($i = 0; $i < 12; $i++) {
            $jumlah_pengguna[$i] = $penggunaan->where('month', $i + 1)->first()->jumlah_penggunaan ?? 0;
        }
        echo json_encode($jumlah_pengguna);
    }

    public function exportexcel(Request $request)
    {
        $year = $request->get('year');
        return Excel::download(new RentalExport($year), "laporan penggunaan mobil ($year).xlsx");
    }

    public function exportpdf(Request $request)
    {
        $year = $request->get('year');
        return Excel::download(new RentalExport($year), "laporan penggunaan mobil ($year).pdf", \Maatwebsite\Excel\Excel::DOMPDF);
    }
}
