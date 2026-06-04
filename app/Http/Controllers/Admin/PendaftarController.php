<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Beasiswa;
use App\Models\KampusMitra;
use App\Models\Rekomendasi;
use Illuminate\Http\Request;

class PendaftarController extends Controller
{
    /**
     * Display a grid listing of all active scholarships with applicant counts.
     */
    public function index(Request $request)
    {
        $kampusId = $request->input('kampus_id');

        $query = Beasiswa::with('kampusMitra')
            ->where('status', 'aktif');

        if ($kampusId) {
            $query->where('kampus_mitra_id', $kampusId);
        }

        $beasiswas = $query->get()->map(function ($beasiswa) {
            // Count applicants who have chosen this scholarship
            $pendaftarCount = Rekomendasi::where('beasiswa_id', $beasiswa->id)
                ->where('dipilih_siswa', true)
                ->count();
            
            $beasiswa->pendaftar_count = $pendaftarCount;
            return $beasiswa;
        });

        $campuses = KampusMitra::where('is_active', true)->orderBy('nama_kampus')->get();

        return view('admin.pendaftar.index', compact('beasiswas', 'campuses', 'kampusId'));
    }

    /**
     * Display a detailed list of students who chose a specific scholarship.
     */
    public function show(Request $request, $beasiswaId)
    {
        $beasiswa = Beasiswa::with('kampusMitra')->findOrFail($beasiswaId);
        $search = $request->input('search');

        $query = Rekomendasi::with(['dataSiswa.user', 'guruBk'])
            ->where('beasiswa_id', $beasiswaId)
            ->where('dipilih_siswa', true);

        if ($search) {
            $query->whereHas('dataSiswa.user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $pendaftars = $query->latest('dipilih_at')->get();

        return view('admin.pendaftar.show', compact('beasiswa', 'pendaftars', 'search'));
    }

    /**
     * Export applicants list to Excel-compatible CSV.
     */
    public function exportExcel($beasiswaId)
    {
        $beasiswa = Beasiswa::with('kampusMitra')->findOrFail($beasiswaId);
        $pendaftars = Rekomendasi::with(['dataSiswa.user', 'guruBk'])
            ->where('beasiswa_id', $beasiswaId)
            ->where('dipilih_siswa', true)
            ->latest('dipilih_at')
            ->get();

        $filename = 'pendaftar-' . strtolower(str_replace(' ', '-', $beasiswa->nama_beasiswa)) . '.csv';

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename={$filename}",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($beasiswa, $pendaftars) {
            $file = fopen('php://output', 'w');
            
            // UTF-8 BOM to prevent Excel display errors
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($file, ["DAFTAR PENDAFTAR BEASISWA: " . strtoupper($beasiswa->nama_beasiswa)]);
            fputcsv($file, ["KAMPUS MITRA: " . strtoupper($beasiswa->kampusMitra->nama_kampus ?? '-')]);
            fputcsv($file, ["KUOTA: " . $beasiswa->kuota . " orang"]);
            fputcsv($file, ["DEADLINE: " . ($beasiswa->deadline ? $beasiswa->deadline->format('d M Y') : '-')]);
            fputcsv($file, []); // blank line
            
            fputcsv($file, ['No', 'Nama Siswa', 'NISN', 'Sekolah', 'Kelas', 'Nilai Rata-rata', 'Kondisi Ekonomi', 'Direkomendasikan Oleh', 'Tanggal Dipilih']);
            
            foreach ($pendaftars as $index => $p) {
                fputcsv($file, [
                    $index + 1,
                    $p->dataSiswa->user->name ?? 'N/A',
                    $p->dataSiswa->user->nisn ?? '-',
                    $p->dataSiswa->user->sekolah ?? '-',
                    $p->dataSiswa->user->kelas ?? '-',
                    number_format($p->dataSiswa->nilai_rata, 2),
                    ucwords(str_replace('_', ' ', $p->dataSiswa->kondisi_ekonomi)),
                    ucwords(str_replace('_', ' ', $p->direkomendasikan_oleh)),
                    $p->dipilih_at ? (($p->dipilih_at instanceof \DateTimeInterface) ? $p->dipilih_at->format('d M Y') : \Carbon\Carbon::parse($p->dipilih_at)->format('d M Y')) : '-'
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export printable layout view for PDF.
     */
    public function exportPdf($beasiswaId)
    {
        $beasiswa = Beasiswa::with('kampusMitra')->findOrFail($beasiswaId);
        $pendaftars = Rekomendasi::with(['dataSiswa.user', 'guruBk'])
            ->where('beasiswa_id', $beasiswaId)
            ->where('dipilih_siswa', true)
            ->latest('dipilih_at')
            ->get();

        return view('admin.pendaftar.pdf', compact('beasiswa', 'pendaftars'));
    }
}
