<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Letter;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year', now()->year);

        $incoming = Letter::where('status', 'incoming')
            ->whereYear('date_of_entry', $year)
            ->get();

        $outgoing = Letter::where('status', 'outgoing')
            ->whereYear('date_of_letter', $year)
            ->get();

        $years = Letter::selectRaw('YEAR(date_of_entry) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        return view('reports.index', compact('incoming', 'outgoing', 'years', 'year'));
    }

    public function download(Request $request)
    {
        $request->validate([
            'year' => 'required|integer',
        ]);

        $year = $request->year;

        $incoming = Letter::where('status', 'incoming')
            ->whereYear('date_of_entry', $year)
            ->orderBy('date_of_entry')
            ->get();

        $outgoing = Letter::where('status', 'outgoing')
            ->whereYear('date_of_letter', $year)
            ->orderBy('date_of_letter')
            ->get();

        $pdf = Pdf::loadView('reports.pdf', [
            'year' => $year,
            'incoming' => $incoming,
            'outgoing' => $outgoing,
        ])->setPaper('a4', 'portrait');

        $tanggal = Carbon::now()->translatedFormat('d F Y');
        $namaFile = "{$tanggal} - Laporan Surat Masuk & Keluar.pdf";

        return $pdf->download($namaFile);
    }
}
