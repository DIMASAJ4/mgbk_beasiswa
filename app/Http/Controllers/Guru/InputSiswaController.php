<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DataSiswa;
use App\Models\Beasiswa;
use App\Models\Rekomendasi;
use App\Services\RekomendasisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class InputSiswaController extends Controller
{
    protected $recommender;

    public function __construct(RekomendasisService $recommender)
    {
        $this->recommender = $recommender;
    }

    /**
     * Show form to create student and check matching.
     */
    public function create()
    {
        return view('guru.siswa.create');
    }

    /**
     * Store new student and run the match engine.
     */
    public function store(Request $request)
    {
        $guru = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'nisn' => ['required', 'string', 'max:20', 'unique:users'],
            'kelas' => ['required', 'string', 'max:50'],
            'no_hp' => ['required', 'string', 'max:20'],
            'nilai_rata' => ['required', 'numeric', 'min:0', 'max:100'],
            'kondisi_ekonomi' => ['required', 'in:mampu,kurang_mampu,tidak_mampu'],
            'minat_jurusan' => ['required', 'array', 'min:1'],
            'prestasi' => ['nullable', 'string'],
        ]);

        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make('password'), // default password
            'nisn' => $validated['nisn'],
            'kelas' => $validated['kelas'],
            'no_hp' => $validated['no_hp'],
            'sekolah' => $guru->sekolah, // auto-scoped to teacher's school
            'role' => 'siswa',
        ]);

        $user->assignRole('Siswa');

        // Create student profile
        $studentProfile = DataSiswa::create([
            'user_id' => $user->id,
            'nilai_rata' => $validated['nilai_rata'],
            'kondisi_ekonomi' => $validated['kondisi_ekonomi'],
            'minat_jurusan' => $validated['minat_jurusan'],
            'prestasi' => $validated['prestasi'],
            'is_verified' => true, // verified since BK teacher created it
        ]);

        // Calculate recommendations
        $recommendations = $this->recommender->calculateCompatibility($studentProfile);

        // Flash message
        session()->flash('success', 'Akun profil siswa ' . $user->name . ' berhasil dibuat dan terverifikasi!');

        return view('guru.siswa.create', [
            'student' => $user,
            'profile' => $studentProfile,
            'recommendations' => $recommendations
        ]);
    }

    /**
     * Process recommendation logic for an existing student profile.
     */
    public function proses($id)
    {
        $guru = Auth::user();
        $siswa = User::role('Siswa')->with('dataSiswa')->findOrFail($id);

        if ($siswa->sekolah !== $guru->sekolah) {
            abort(403, 'Akses Ditolak.');
        }

        if (!$siswa->dataSiswa) {
            // Auto create blank profile if none exists
            $siswa->dataSiswa = DataSiswa::create([
                'user_id' => $siswa->id,
                'nilai_rata' => 0.00,
                'kondisi_ekonomi' => 'kurang_mampu',
                'minat_jurusan' => [],
                'is_verified' => false,
            ]);
        }

        // Calculate recommendations
        $recommendations = $this->recommender->calculateCompatibility($siswa->dataSiswa);

        return view('guru.siswa.create', [
            'student' => $siswa,
            'profile' => $siswa->dataSiswa,
            'recommendations' => $recommendations
        ]);
    }

    /**
     * Send specific recommendation to student.
     */
    public function storeProses(Request $request)
    {
        $guru = Auth::user();
        
        $validated = $request->validate([
            'data_siswa_id' => ['required', 'exists:data_siswas,id'],
            'beasiswa_id' => ['required', 'exists:beasiswas,id'],
            'match_score' => ['required', 'integer', 'min:0', 'max:100'],
        ]);

        // Create recommendation entry
        $rekomendasi = Rekomendasi::create([
            'data_siswa_id' => $validated['data_siswa_id'],
            'beasiswa_id' => $validated['beasiswa_id'],
            'guru_bk_id' => $guru->id,
            'persentase_kecocokan' => $validated['match_score'],
            'status' => 'dikirim', // auto-sent to student
            'catatan' => 'Direkomendasikan otomatis oleh sistem berdasarkan profil akademik Anda.',
        ]);

        $student = DataSiswa::with('user')->findOrFail($validated['data_siswa_id']);

        return redirect()->route('guru.siswa.index')->with('success', 'Rekomendasi beasiswa berhasil dikirim ke siswa ' . $student->user->name . '!');
    }
}
