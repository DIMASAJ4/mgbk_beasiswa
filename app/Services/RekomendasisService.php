<?php

namespace App\Services;

use App\Models\Beasiswa;
use App\Models\DataSiswa;

class RekomendasisService
{
    /**
     * Calculate scholarship compatibility match scores for a given student profile.
     */
    public function calculateCompatibility(DataSiswa $studentProfile)
    {
        $studentGpa = floatval($studentProfile->nilai_rata);
        $studentEconomic = $studentProfile->kondisi_ekonomi; // mampu, kurang_mampu, tidak_mampu
        
        $user = $studentProfile->user;
        $studentInterests = is_array($studentProfile->minat_jurusan) 
            ? $studentProfile->minat_jurusan 
            : json_decode($studentProfile->minat_jurusan, true) ?? [];

        // Fetch active scholarships
        $beasiswas = Beasiswa::with('kampusMitra')->where('status', 'aktif')->get();
        $results = [];

        foreach ($beasiswas as $b) {
            // 1. ACADEMIC MATCH (40%)
            $minGrade = 75.0; // Default minimum threshold
            $requirementsList = is_array($b->persyaratan) 
                ? $b->persyaratan 
                : json_decode($b->persyaratan, true) ?? [];

            foreach ($requirementsList as $req) {
                if (preg_match('/(?:nilai|rata-rata|gpa|ipk|min|minimum)\s*([0-9]+(?:\.[0-9]+)?)/i', $req, $matches)) {
                    $parsed = floatval($matches[1]);
                    if ($parsed <= 4.0) {
                        $minGrade = $parsed * 25.0; // conversion to 100 scale
                    } else {
                        $minGrade = $parsed;
                    }
                    break;
                }
            }

            if ($studentGpa >= $minGrade) {
                $academicScore = 100;
            } else {
                $deficit = $minGrade - $studentGpa;
                $academicScore = max(0, 100 - ($deficit * 6)); // Subtract 6% per point deficit
            }

            // 2. ECONOMIC MATCH (30%)
            if ($b->jenis === 'full_funding') {
                if ($studentEconomic === 'tidak_mampu') {
                    $economicScore = 100;
                } elseif ($studentEconomic === 'kurang_mampu') {
                    $economicScore = 80;
                } else {
                    $economicScore = 40;
                }
            } elseif ($b->jenis === 'partial_funding') {
                if ($studentEconomic === 'kurang_mampu') {
                    $economicScore = 100;
                } elseif ($studentEconomic === 'tidak_mampu') {
                    $economicScore = 90;
                } else {
                    $economicScore = 65;
                }
            } else {
                // Akomodasi
                if ($studentEconomic === 'tidak_mampu') {
                    $economicScore = 100;
                } elseif ($studentEconomic === 'kurang_mampu') {
                    $economicScore = 90;
                } else {
                    $economicScore = 60;
                }
            }

            // 3. INTEREST MATCH (30%)
            $searchString = strtolower($b->nama_beasiswa . ' ' . $b->deskripsi . ' ' . implode(' ', $requirementsList));
            $interestMatched = false;
            
            foreach ($studentInterests as $interest) {
                if (str_contains($searchString, strtolower($interest))) {
                    $interestMatched = true;
                    break;
                }
            }
            $interestScore = $interestMatched ? 100 : 50;

            // Compute weighted final score
            $finalScore = ($academicScore * 0.40) + ($economicScore * 0.30) + ($interestScore * 0.30);
            $finalScoreRounded = (int) round($finalScore);

            // Determine Met vs Unmet requirements checklists
            $metRequirements = [];
            $unmetRequirements = [];

            foreach ($requirementsList as $req) {
                $isMet = true;

                // Grade check
                if (preg_match('/(?:nilai|rata-rata|gpa|ipk|min|minimum)\s*([0-9]+(?:\.[0-9]+)?)/i', $req, $matches)) {
                    $val = floatval($matches[1]);
                    $threshold = ($val <= 4.0) ? $val * 25.0 : $val;
                    if ($studentGpa < $threshold) {
                        $isMet = false;
                    }
                }

                // Economy check
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

            $results[] = [
                'beasiswa' => $b,
                'match_score' => $finalScoreRounded,
                'met_requirements' => $metRequirements,
                'unmet_requirements' => $unmetRequirements
            ];
        }

        // Sort by highest match score
        usort($results, function($a, $b) {
            return $b['match_score'] <=> $a['match_score'];
        });

        return $results;
    }

    /**
     * Store recommendation made by Admin.
     */
    public function rekomendasiOlehAdmin($siswaId, $beasiswaId, $adminId)
    {
        $dataSiswa = DataSiswa::where('user_id', $siswaId)->first() 
            ?? DataSiswa::find($siswaId);
        
        if (!$dataSiswa) {
            throw new \Exception('Profil siswa tidak ditemukan.');
        }

        // Calculate match score
        $compatibilities = $this->calculateCompatibility($dataSiswa);
        $matchScore = 0;
        foreach ($compatibilities as $comp) {
            if ($comp['beasiswa']->id == $beasiswaId) {
                $matchScore = $comp['match_score'];
                break;
            }
        }

        return \App\Models\Rekomendasi::create([
            'data_siswa_id' => $dataSiswa->id,
            'beasiswa_id' => $beasiswaId,
            'guru_bk_id' => $adminId,
            'persentase_kecocokan' => $matchScore,
            'status' => 'dikirim',
            'direkomendasikan_oleh' => 'admin',
            'dipilih_siswa' => false,
        ]);
    }

    /**
     * Student selects a recommendation.
     */
    public function pilihRekomendasi($rekomendasiId, $siswaId)
    {
        $dataSiswa = DataSiswa::where('user_id', $siswaId)->first() 
            ?? DataSiswa::find($siswaId);
        
        if (!$dataSiswa) {
            throw new \Exception('Profil siswa tidak ditemukan.');
        }

        // Validate that student has not already selected any recommendation
        $hasSelected = \App\Models\Rekomendasi::sudahMemilih($dataSiswa->user_id);
        if ($hasSelected) {
            throw new \Exception('Kamu sudah memilih beasiswa. Tidak dapat memilih ulang.');
        }

        $rekomendasi = \App\Models\Rekomendasi::where('id', $rekomendasiId)
            ->where('data_siswa_id', $dataSiswa->id)
            ->first();

        if (!$rekomendasi) {
            throw new \Exception('Rekomendasi tidak ditemukan.');
        }

        $rekomendasi->update([
            'dipilih_siswa' => true,
            'dipilih_at' => now(),
        ]);

        return $rekomendasi;
    }

    /**
     * Cancel chosen recommendation (optional).
     */
    public function batalPilihan($siswaId)
    {
        $dataSiswa = DataSiswa::where('user_id', $siswaId)->first() 
            ?? DataSiswa::find($siswaId);
        
        if (!$dataSiswa) {
            throw new \Exception('Profil siswa tidak ditemukan.');
        }

        \App\Models\Rekomendasi::where('data_siswa_id', $dataSiswa->id)
            ->where('dipilih_siswa', true)
            ->update([
                'dipilih_siswa' => false,
                'dipilih_at' => null,
            ]);
    }
}
