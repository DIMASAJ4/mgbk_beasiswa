<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Rekomendasi;
use App\Models\DataSiswa;
use App\Services\RekomendasisService;
use Illuminate\Http\Request;

class RekomendasiController extends Controller
{
    protected $rekomendasisService;

    public function __construct(RekomendasisService $rekomendasisService)
    {
        $this->rekomendasisService = $rekomendasisService;
    }

    /**
     * View detailed recommendation and compatibility breakdown.
     */
    public function detail($id)
    {
        $user = auth()->user();
        $dataSiswa = DataSiswa::where('user_id', $user->id)->firstOrFail();

        // Load recommendation and ensure it belongs to the logged-in student
        $rekomendasi = Rekomendasi::with(['beasiswa.kampusMitra'])
            ->where('id', $id)
            ->where('data_siswa_id', $dataSiswa->id)
            ->firstOrFail();

        $beasiswa = $rekomendasi->beasiswa;

        // Calculate detailed breakdown
        $studentGpa = floatval($dataSiswa->nilai_rata);
        $studentEconomic = $dataSiswa->kondisi_ekonomi;
        $studentInterests = is_array($dataSiswa->minat_jurusan) 
            ? $dataSiswa->minat_jurusan 
            : json_decode($dataSiswa->minat_jurusan, true) ?? [];

        // 1. Academic check
        $minGrade = 75.0;
        $requirementsList = is_array($beasiswa->persyaratan) 
            ? $beasiswa->persyaratan 
            : json_decode($beasiswa->persyaratan, true) ?? [];

        foreach ($requirementsList as $req) {
            if (preg_match('/(?:nilai|rata-rata|gpa|ipk|min|minimum)\s*([0-9]+(?:\.[0-9]+)?)/i', $req, $matches)) {
                $parsed = floatval($matches[1]);
                if ($parsed <= 4.0) {
                    $minGrade = $parsed * 25.0;
                } else {
                    $minGrade = $parsed;
                }
                break;
            }
        }

        $academicStatus = $studentGpa >= $minGrade ? 'Memenuhi Syarat' : 'Belum Memenuhi Syarat';
        $academicDesc = "Nilai rata-rata Anda " . number_format($studentGpa, 2) . " (Syarat minimum: " . number_format($minGrade, 2) . ")";

        // 2. Economic check
        if ($beasiswa->jenis === 'full_funding') {
            $economicStatus = ($studentEconomic === 'tidak_mampu' || $studentEconomic === 'kurang_mampu') ? 'Sesuai' : 'Tidak Sesuai';
        } else {
            $economicStatus = 'Sesuai';
        }
        $economicDesc = "Kondisi ekonomi Anda: " . ucwords(str_replace('_', ' ', $studentEconomic));

        // 3. Interest check
        $searchString = strtolower($beasiswa->nama_beasiswa . ' ' . $beasiswa->deskripsi . ' ' . implode(' ', $requirementsList));
        $interestMatched = false;
        foreach ($studentInterests as $interest) {
            if (str_contains($searchString, strtolower($interest))) {
                $interestMatched = true;
                break;
            }
        }
        $interestStatus = $interestMatched ? 'Relevan' : 'Kurang Relevan';
        $interestDesc = "Minat jurusan Anda: " . (empty($studentInterests) ? 'Belum ditentukan' : implode(', ', $studentInterests));

        // Check if student has already chosen this or another recommendation
        $hasChosenAny = Rekomendasi::sudahMemilih($user->id);
        $isThisChosen = $rekomendasi->dipilih_siswa;

        // Build requirements checklists (Met vs Unmet)
        $metRequirements = [];
        $unmetRequirements = [];

        foreach ($requirementsList as $req) {
            $isMet = true;
            if (preg_match('/(?:nilai|rata-rata|gpa|ipk|min|minimum)\s*([0-9]+(?:\.[0-9]+)?)/i', $req, $matches)) {
                $val = floatval($matches[1]);
                $threshold = ($val <= 4.0) ? $val * 25.0 : $val;
                if ($studentGpa < $threshold) {
                    $isMet = false;
                }
            }
            if (preg_match('/(?:tidak mampu|kurang mampu|ekonomi)/i', $req)) {
                if ($studentEconomic === 'mampu') {
                    $isMet = false;
                }
            }

            if ($isMet) {
                $metRequirements[] = $req;
            } else {
                $unmetRequirements[] = $req;
            }
        }

        return view('siswa.rekomendasi.detail', compact(
            'rekomendasi', 'beasiswa', 'dataSiswa', 
            'academicStatus', 'academicDesc',
            'economicStatus', 'economicDesc',
            'interestStatus', 'interestDesc',
            'hasChosenAny', 'isThisChosen',
            'metRequirements', 'unmetRequirements'
        ));
    }

    /**
     * Student chooses a recommendation.
     */
    public function pilih(Request $request)
    {
        $request->validate([
            'rekomendasi_id' => 'required|exists:rekomendasis,id',
        ]);

        $rekomendasiId = $request->input('rekomendasi_id');
        $user = auth()->user();

        try {
            // Student can only choose their own recommendation
            $dataSiswa = DataSiswa::where('user_id', $user->id)->firstOrFail();
            $rekomendasi = Rekomendasi::where('id', $rekomendasiId)
                ->where('data_siswa_id', $dataSiswa->id)
                ->firstOrFail();

            $this->rekomendasisService->pilihRekomendasi($rekomendasi->id, $user->id);

            return redirect()->route('siswa.dashboard')
                ->with('success', 'Selamat! Kamu telah memilih beasiswa ' . $rekomendasi->beasiswa->nama_beasiswa . '. Silakan hubungi Guru BK untuk langkah selanjutnya.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * View detailed scholarship (even if not recommended).
     */
    public function beasiswaDetail($id)
    {
        $user = auth()->user();
        $dataSiswa = DataSiswa::where('user_id', $user->id)->firstOrFail();

        // Check if there is an existing recommendation for this student and scholarship
        $rekomendasi = Rekomendasi::where('data_siswa_id', $dataSiswa->id)
            ->where('beasiswa_id', $id)
            ->first();

        if ($rekomendasi) {
            // Redirect to the existing recommendation detail page!
            return redirect()->route('siswa.rekomendasi.detail', $rekomendasi->id);
        }

        // Otherwise, load the scholarship directly
        $beasiswa = \App\Models\Beasiswa::with('kampusMitra')->findOrFail($id);

        // Calculate detailed breakdown
        $studentGpa = floatval($dataSiswa->nilai_rata);
        $studentEconomic = $dataSiswa->kondisi_ekonomi;
        $studentInterests = is_array($dataSiswa->minat_jurusan) 
            ? $dataSiswa->minat_jurusan 
            : json_decode($dataSiswa->minat_jurusan, true) ?? [];

        // 1. Academic check
        $minGrade = 75.0;
        $requirementsList = is_array($beasiswa->persyaratan) 
            ? $beasiswa->persyaratan 
            : json_decode($beasiswa->persyaratan, true) ?? [];

        foreach ($requirementsList as $req) {
            if (preg_match('/(?:nilai|rata-rata|gpa|ipk|min|minimum)\s*([0-9]+(?:\.[0-9]+)?)/i', $req, $matches)) {
                $parsed = floatval($matches[1]);
                if ($parsed <= 4.0) {
                    $minGrade = $parsed * 25.0;
                } else {
                    $minGrade = $parsed;
                }
                break;
            }
        }

        $academicStatus = $studentGpa >= $minGrade ? 'Memenuhi Syarat' : 'Belum Memenuhi Syarat';
        $academicDesc = "Nilai rata-rata Anda " . number_format($studentGpa, 2) . " (Syarat minimum: " . number_format($minGrade, 2) . ")";

        // 2. Economic check
        if ($beasiswa->jenis === 'full_funding') {
            $economicStatus = ($studentEconomic === 'tidak_mampu' || $studentEconomic === 'kurang_mampu') ? 'Sesuai' : 'Tidak Sesuai';
        } else {
            $economicStatus = 'Sesuai';
        }
        $economicDesc = "Kondisi ekonomi Anda: " . ucwords(str_replace('_', ' ', $studentEconomic));

        // 3. Interest check
        $searchString = strtolower($beasiswa->nama_beasiswa . ' ' . $beasiswa->deskripsi . ' ' . implode(' ', $requirementsList));
        $interestMatched = false;
        foreach ($studentInterests as $interest) {
            if (str_contains($searchString, strtolower($interest))) {
                $interestMatched = true;
                break;
            }
        }
        $interestStatus = $interestMatched ? 'Relevan' : 'Kurang Relevan';
        $interestDesc = "Minat jurusan Anda: " . (empty($studentInterests) ? 'Belum ditentukan' : implode(', ', $studentInterests));

        // Build requirements checklists (Met vs Unmet)
        $metRequirements = [];
        $unmetRequirements = [];

        foreach ($requirementsList as $req) {
            $isMet = true;
            if (preg_match('/(?:nilai|rata-rata|gpa|ipk|min|minimum)\s*([0-9]+(?:\.[0-9]+)?)/i', $req, $matches)) {
                $val = floatval($matches[1]);
                $threshold = ($val <= 4.0) ? $val * 25.0 : $val;
                if ($studentGpa < $threshold) {
                    $isMet = false;
                }
            }
            if (preg_match('/(?:tidak mampu|kurang mampu|ekonomi)/i', $req)) {
                if ($studentEconomic === 'mampu') {
                    $isMet = false;
                }
            }

            if ($isMet) {
                $metRequirements[] = $req;
            } else {
                $unmetRequirements[] = $req;
            }
        }

        // Calculate match score
        $compatibilities = $this->rekomendasisService->calculateCompatibility($dataSiswa);
        $matchScore = 0;
        foreach ($compatibilities as $comp) {
            if ($comp['beasiswa']->id == $beasiswa->id) {
                $matchScore = $comp['match_score'];
                break;
            }
        }

        $isGeneralView = true;
        $hasChosenAny = Rekomendasi::sudahMemilih($user->id);

        return view('siswa.rekomendasi.detail', compact(
            'beasiswa', 'dataSiswa', 
            'academicStatus', 'academicDesc',
            'economicStatus', 'economicDesc',
            'interestStatus', 'interestDesc',
            'metRequirements', 'unmetRequirements',
            'matchScore', 'isGeneralView', 'hasChosenAny'
        ));
    }
}
