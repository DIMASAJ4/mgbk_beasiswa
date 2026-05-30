<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rekomendasi;
use App\Models\DataSiswa;
use App\Models\Beasiswa;
use App\Models\KampusMitra;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    /**
     * Display analytical summaries and charts.
     */
    public function index(Request $request)
    {
        // 1. Date filter defaults
        $startDateVal = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDateVal = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));

        $startDate = Carbon::parse($startDateVal)->startOfDay();
        $endDate = Carbon::parse($endDateVal)->endOfDay();

        // 2. Fetch Aggregations within date range
        $totalRekomendasi = Rekomendasi::whereBetween('created_at', [$startDate, $endDate])->count();
        $siswaTerlayani = DataSiswa::where('is_verified', true)
            ->whereBetween('created_at', [$startDate, $endDate])->count();
        $beasiswaAktif = Beasiswa::where('status', 'aktif')->count();
        $kampusMitra = KampusMitra::where('is_active', true)->count();

        // 3. Detailed recommendations log
        $recommendations = Rekomendasi::with(['dataSiswa.user', 'beasiswa.kampusMitra', 'guruBk'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // 4. Bar Chart: Recommendations per month (last 12 months)
        $months = [];
        $recommendationCounts = [];
        for ($i = 11; $i >= 0; $i--) {
            $monthDate = now()->subMonths($i);
            $months[] = $monthDate->isoFormat('MMM YY');
            $recommendationCounts[] = Rekomendasi::whereYear('created_at', $monthDate->year)
                ->whereMonth('created_at', $monthDate->month)
                ->count();
        }

        // 5. Donut Chart: Scholarships distribution per campus
        $campusList = KampusMitra::withCount(['beasiswas' => function($q) {
            $q->where('status', 'aktif');
        }])->get();
        
        $campusLabels = $campusList->pluck('nama_kampus')->toArray();
        $campusCounts = $campusList->pluck('beasiswas_count')->toArray();

        return view('admin.laporan', compact(
            'totalRekomendasi', 'siswaTerlayani', 'beasiswaAktif', 'kampusMitra',
            'recommendations', 'startDateVal', 'endDateVal', 'months', 'recommendationCounts',
            'campusLabels', 'campusCounts'
        ));
    }

    /**
     * Export data to Excel-compatible CSV.
     */
    public function exportExcel(Request $request)
    {
        $startDateVal = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDateVal = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));

        $startDate = Carbon::parse($startDateVal)->startOfDay();
        $endDate = Carbon::parse($endDateVal)->endOfDay();

        $recommendations = Rekomendasi::with(['dataSiswa.user', 'beasiswa.kampusMitra', 'guruBk'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=laporan-beasiswa-mgbk.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];
        
        $callback = function() use ($recommendations) {
            $file = fopen('php://output', 'w');
            
            // UTF-8 BOM to prevent Excel display errors
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($file, ['No', 'Nama Siswa', 'NISN', 'Sekolah', 'Kelas', 'Beasiswa', 'Kampus', 'Kecocokan', 'Guru BK', 'Status', 'Tanggal']);
            
            foreach ($recommendations as $index => $r) {
                fputcsv($file, [
                    $index + 1,
                    $r->dataSiswa->user->name ?? 'N/A',
                    $r->dataSiswa->user->nisn ?? '-',
                    $r->dataSiswa->user->sekolah ?? '-',
                    $r->dataSiswa->user->kelas ?? '-',
                    $r->beasiswa->nama_beasiswa ?? 'N/A',
                    $r->beasiswa->kampusMitra->nama_kampus ?? 'N/A',
                    $r->persentase_kecocokan . '%',
                    $r->guruBk->name ?? 'N/A',
                    $r->status,
                    $r->created_at->format('d M Y')
                ]);
            }
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export printable layout view for PDF.
     */
    public function exportPdf(Request $request)
    {
        $startDateVal = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDateVal = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));

        $startDate = Carbon::parse($startDateVal)->startOfDay();
        $endDate = Carbon::parse($endDateVal)->endOfDay();

        $recommendations = Rekomendasi::with(['dataSiswa.user', 'beasiswa.kampusMitra', 'guruBk'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->get();

        return view('admin.laporan_pdf', compact('recommendations', 'startDateVal', 'endDateVal'));
    }
}
