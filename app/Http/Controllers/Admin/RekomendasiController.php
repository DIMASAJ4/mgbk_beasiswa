<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Beasiswa;
use App\Models\Rekomendasi;
use App\Models\DataSiswa;
use App\Services\RekomendasisService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RekomendasiController extends Controller
{
    protected $rekomendasisService;

    public function __construct(RekomendasisService $rekomendasisService)
    {
        $this->rekomendasisService = $rekomendasisService;
    }

    /**
     * Display a listing of the recommendations.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Rekomendasi::with(['dataSiswa.user', 'beasiswa.kampusMitra'])
            ->byAdmin();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('dataSiswa.user', function ($uq) use ($search) {
                    $uq->where('name', 'like', "%{$search}%");
                })->orWhereHas('beasiswa', function ($bq) use ($search) {
                    $bq->where('nama_beasiswa', 'like', "%{$search}%");
                });
            });
        }

        $rekomendasis = $query->latest()->paginate(10)->withQueryString();

        return view('admin.rekomendasi.index', compact('rekomendasis', 'search'));
    }

    /**
     * Show the form for creating a new recommendation.
     */
    public function create()
    {
        // Get all students that have completed their profiles (have dataSiswa)
        $siswas = User::role('Siswa')
            ->whereHas('dataSiswa')
            ->orderBy('name')
            ->get();

        return view('admin.rekomendasi.create', compact('siswas'));
    }

    /**
     * AJAX fetch endpoint for student details and eligible scholarships.
     */
    public function siswaDetails($id)
    {
        $user = User::with('dataSiswa')->findOrFail($id);

        if (!$user->dataSiswa) {
            return response()->json(['error' => 'Profil siswa belum lengkap.'], 404);
        }

        $compatibilities = $this->rekomendasisService->calculateCompatibility($user->dataSiswa);

        // Check which scholarships are already recommended to this student
        $existingRecommendedIds = Rekomendasi::where('data_siswa_id', $user->dataSiswa->id)
            ->pluck('beasiswa_id')
            ->toArray();

        $mappedCompatibilities = [];
        foreach ($compatibilities as $comp) {
            $b = $comp['beasiswa'];
            $mappedCompatibilities[] = [
                'id' => $b->id,
                'nama_beasiswa' => $b->nama_beasiswa,
                'kampus_nama' => $b->kampusMitra->nama_kampus ?? '-',
                'jenis_formatted' => ucwords(str_replace('_', ' ', $b->jenis)),
                'match_score' => $comp['match_score'],
                'deadline' => $b->deadline ? $b->deadline->format('d M Y') : '-',
                'sudah_direkomendasikan' => in_array($b->id, $existingRecommendedIds),
            ];
        }

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'sekolah' => $user->dataSiswa->sekolah ?? $user->sekolah ?? 'SMA Negeri Padangsidimpuan',
                'kelas' => $user->dataSiswa->kelas ?? $user->kelas ?? 'XII IPA 1',
                'nilai_rata' => number_format($user->dataSiswa->nilai_rata, 2),
                'kondisi_ekonomi' => ucwords(str_replace('_', ' ', $user->dataSiswa->kondisi_ekonomi)),
                'minat_jurusan' => is_array($user->dataSiswa->minat_jurusan) 
                    ? implode(', ', $user->dataSiswa->minat_jurusan) 
                    : implode(', ', json_decode($user->dataSiswa->minat_jurusan, true) ?? []),
            ],
            'beasiswas' => $mappedCompatibilities
        ]);
    }

    /**
     * Store a newly created recommendation in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'beasiswa_id' => 'required|exists:beasiswas,id',
        ]);

        $userId = $request->input('user_id');
        $beasiswaId = $request->input('beasiswa_id');
        $adminId = auth()->id();

        try {
            // Find dataSiswa
            $dataSiswa = DataSiswa::where('user_id', $userId)->firstOrFail();

            // Check if already recommended
            $exists = Rekomendasi::where('data_siswa_id', $dataSiswa->id)
                ->where('beasiswa_id', $beasiswaId)
                ->exists();

            if ($exists) {
                return redirect()->back()->with('error', 'Beasiswa ini sudah pernah direkomendasikan ke siswa tersebut.');
            }

            $this->rekomendasisService->rekomendasiOlehAdmin($userId, $beasiswaId, $adminId);

            return redirect()->route('admin.rekomendasi.index')
                ->with('success', 'Rekomendasi beasiswa berhasil dikirim ke siswa.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membuat rekomendasi: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified recommendation from storage.
     */
    public function destroy($id)
    {
        $rekomendasi = Rekomendasi::findOrFail($id);

        if ($rekomendasi->dipilih_siswa) {
            return redirect()->back()->with('error', 'Rekomendasi tidak dapat dihapus karena sudah dipilih oleh siswa.');
        }

        $rekomendasi->delete();

        return redirect()->route('admin.rekomendasi.index')
            ->with('success', 'Rekomendasi berhasil dihapus.');
    }
}
