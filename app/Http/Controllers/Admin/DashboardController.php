<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\KampusMitra;
use App\Models\Beasiswa;
use App\Models\Rekomendasi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the Admin dashboard page.
     */
    public function index()
    {
        // Real counts
        $totalBeasiswa = Beasiswa::count();
        $totalKampus = KampusMitra::count();
        $totalGuru = User::role('Guru BK')->count();
        $totalSiswa = User::role('Siswa')->count();

        // Recent Beasiswas (5 latest)
        $recentBeasiswas = Beasiswa::with('kampusMitra')->latest()->take(5)->get();

        // Dynamically build recent activity logs
        $activities = [];

        // 1. Latest recommendations
        $latestRekomendasis = Rekomendasi::with(['dataSiswa.user', 'beasiswa'])
            ->latest()
            ->take(2)
            ->get();
            
        foreach ($latestRekomendasis as $r) {
            if ($r->dataSiswa && $r->dataSiswa->user) {
                $activities[] = [
                    'title' => 'Rekomendasi ' . $r->beasiswa->nama_beasiswa . ' untuk ' . $r->dataSiswa->user->name . ' dikirim.',
                    'time' => $r->created_at->diffForHumans(),
                    'icon' => 'fa-paper-plane',
                    'color' => 'text-indigo-500'
                ];
            }
        }

        // 2. Latest scholarships
        $latestBeasiswas = Beasiswa::with('kampusMitra')
            ->latest()
            ->take(2)
            ->get();

        foreach ($latestBeasiswas as $b) {
            $activities[] = [
                'title' => 'Program beasiswa ' . $b->nama_beasiswa . ' oleh ' . $b->kampusMitra->nama_kampus . ' telah dirilis.',
                'time' => $b->created_at->diffForHumans(),
                'icon' => 'fa-circle-plus',
                'color' => 'text-emerald-500'
            ];
        }

        // Fallback default activities if database is freshly cleared
        if (empty($activities)) {
            $activities = [
                ['title' => 'Database seeder berhasil dieksekusi.', 'time' => '1 jam yang lalu', 'icon' => 'fa-circle-check', 'color' => 'text-emerald-500'],
                ['title' => 'Sistem pendaftaran beasiswa MGBK aktif.', 'time' => '2 jam yang lalu', 'icon' => 'fa-server', 'color' => 'text-[#1D9E75]'],
                ['title' => 'Role & Permission disinkronkan.', 'time' => '1 hari yang lalu', 'icon' => 'fa-shield-halved', 'color' => 'text-[#1a3d6e]'],
            ];
        } else {
            // Sort by dynamic activity insertion or time limit to 3 items
            $activities = array_slice($activities, 0, 3);
        }

        return view('admin.dashboard', compact(
            'totalBeasiswa',
            'totalKampus',
            'totalGuru',
            'totalSiswa',
            'recentBeasiswas',
            'activities'
        ));
    }
}
