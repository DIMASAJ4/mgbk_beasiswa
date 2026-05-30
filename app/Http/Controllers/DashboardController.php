<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\KampusMitra;
use App\Models\Beasiswa;
use App\Models\DataSiswa;
use App\Models\Rekomendasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the primary dashboard based on user role.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->hasRole('Admin')) {
            // Stats for Admin
            $totalBeasiswa = Beasiswa::count();
            $totalKampus = KampusMitra::count();
            $totalGuru = User::role('Guru BK')->count();
            $totalSiswa = User::role('Siswa')->count();

            // Recent Scholarships
            $recentBeasiswas = Beasiswa::with('kampusMitra')->latest()->take(4)->get();

            // Mock Recent Activities
            $activities = [
                ['title' => 'Admin menyetujui beasiswa UGM.', 'time' => '2 jam yang lalu', 'icon' => 'fa-circle-check', 'color' => 'text-emerald-400'],
                ['title' => 'Kampus UI mendaftarkan 3 program.', 'time' => '5 jam yang lalu', 'icon' => 'fa-circle-plus', 'color' => 'text-indigo-400'],
                ['title' => 'Guru BK SMA 1 baru saja bergabung.', 'time' => '1 hari yang lalu', 'icon' => 'fa-user-plus', 'color' => 'text-purple-400'],
            ];

            return view('dashboard.admin', compact('totalBeasiswa', 'totalKampus', 'totalGuru', 'totalSiswa', 'recentBeasiswas', 'activities'));
        }

        if ($user->hasRole('Guru BK')) {
            // Stats for Guru BK
            $totalSiswaDibimbing = User::role('Siswa')->where('sekolah', $user->sekolah)->count();
            $rekomendasiDikirim = Rekomendasi::where('guru_bk_id', $user->id)->count();
            $beasiswaTersedia = Beasiswa::where('status', 'aktif')->count();
            
            // Unverified student profile count for this school
            $siswaBelumDiproses = DataSiswa::where('is_verified', false)
                ->whereHas('user', function($q) use ($user) {
                    $q->where('sekolah', $user->sekolah);
                })->count();

            // Recent Recommendations
            $recentRekomendasis = Rekomendasi::with(['dataSiswa.user', 'beasiswa'])
                ->where('guru_bk_id', $user->id)
                ->latest()
                ->take(4)
                ->get();

            // Recent Students managed by this Guru BK (5 latest)
            $recentSiswa = User::role('Siswa')
                ->where('sekolah', $user->sekolah)
                ->with('dataSiswa')
                ->latest()
                ->take(5)
                ->get();

            // Popular Scholarships
            $popularBeasiswas = Beasiswa::with('kampusMitra')->where('status', 'aktif')->take(3)->get();

            // Recent Active Scholarships (3 latest)
            $activeBeasiswas = Beasiswa::with('kampusMitra')->where('status', 'aktif')->latest()->take(3)->get();

            return view('dashboard.guru_bk', compact(
                'totalSiswaDibimbing', 'rekomendasiDikirim', 'beasiswaTersedia', 'siswaBelumDiproses', 
                'recentRekomendasis', 'popularBeasiswas', 'activeBeasiswas', 'recentSiswa'
            ));
        }

        // Default: Siswa Role
        $dataSiswa = DataSiswa::where('user_id', $user->id)->first();
        $dataSiswaId = $dataSiswa ? $dataSiswa->id : 0;

        // Recommendations for the Student (get all recommendations)
        $recommendations = Rekomendasi::with('beasiswa.kampusMitra')
            ->where('data_siswa_id', $dataSiswaId)
            ->orderByDesc('persentase_kecocokan')
            ->get();

        // Check if student has already chosen a scholarship
        $chosenRecommendation = Rekomendasi::with('beasiswa.kampusMitra')
            ->where('data_siswa_id', $dataSiswaId)
            ->where('dipilih_siswa', true)
            ->first();

        // All Available active scholarships
        $allBeasiswas = Beasiswa::with('kampusMitra')->where('status', 'aktif')->latest()->get();

        return view('dashboard.siswa', compact('user', 'dataSiswa', 'recommendations', 'allBeasiswas', 'chosenRecommendation'));
    }

    /**
     * Display the Admin Laporan screen.
     */
    public function laporan(Request $request)
    {
        if (!$request->user() || !$request->user()->hasRole('Admin')) {
            abort(403, 'Akses Ditolak.');
        }

        // Stats
        $totalRekomendasi = Rekomendasi::count();
        $siswaTerlayani = DataSiswa::where('is_verified', true)->count();
        $beasiswaAktif = Beasiswa::where('status', 'aktif')->count();
        $kampusMitra = KampusMitra::where('is_active', true)->count();

        // Detailed Recommendations list
        $recommendations = Rekomendasi::with(['dataSiswa.user', 'beasiswa.kampusMitra'])->latest()->take(4)->get();

        return view('admin.laporan', compact('totalRekomendasi', 'siswaTerlayani', 'beasiswaAktif', 'kampusMitra', 'recommendations'));
    }

    /**
     * Display the Guru BK Student Input form.
     */
    public function inputSiswa(Request $request)
    {
        if (!$request->user() || !$request->user()->hasRole('Guru BK')) {
            abort(403, 'Akses Ditolak.');
        }

        return view('guru.input-siswa');
    }

    /**
     * Store new student profile data from Guru BK.
     */
    public function storeSiswa(Request $request)
    {
        if (!$request->user() || !$request->user()->hasRole('Guru BK')) {
            abort(403, 'Akses Ditolak.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'nisn' => ['required', 'string', 'max:20', 'unique:users'],
            'no_hp' => ['required', 'string', 'max:20'],
            'kelas' => ['required', 'string', 'max:50'],
            'sekolah' => ['required', 'string', 'max:255'],
            'nilai_rata' => ['required', 'numeric', 'min:0', 'max:100'],
            'kondisi_ekonomi' => ['required', 'in:mampu,kurang_mampu,tidak_mampu'],
            'minat_jurusan' => ['required', 'array', 'min:1', 'max:3'],
            'prestasi' => ['nullable', 'string'],
        ]);

        // Create the user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt('password'),
            'role' => 'siswa',
            'nisn' => $validated['nisn'],
            'no_hp' => $validated['no_hp'],
            'kelas' => $validated['kelas'],
            'sekolah' => $validated['sekolah'],
        ]);

        // Assign the role using Spatie Permission
        $user->assignRole('Siswa');

        // Create DataSiswa profile
        DataSiswa::create([
            'user_id' => $user->id,
            'nilai_rata' => $validated['nilai_rata'],
            'kondisi_ekonomi' => $validated['kondisi_ekonomi'],
            'minat_jurusan' => $validated['minat_jurusan'],
            'prestasi' => $validated['prestasi'],
            'is_verified' => true, // Auto verified because input is by Guru BK
        ]);

        return redirect()->route('guru.input-siswa')->with('success', 'Data profil siswa ' . $user->name . ' berhasil disimpan dan terverifikasi!');
    }
}
