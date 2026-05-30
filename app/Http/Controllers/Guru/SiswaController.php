<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DataSiswa;
use App\Models\Rekomendasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    /**
     * Display a listing of students in the same school.
     */
    public function index(Request $request)
    {
        $guru = Auth::user();

        // Query students of the same school
        $query = User::role('Siswa')
            ->where('sekolah', $guru->sekolah)
            ->with(['dataSiswa', 'dataSiswa.rekomendasis']);

        // Apply Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nisn', 'like', '%' . $request->search . '%')
                  ->orWhere('kelas', 'like', '%' . $request->search . '%');
            });
        }

        // Apply Recommendation Status Filter
        if ($request->filled('status_rekomendasi')) {
            $status = $request->status_rekomendasi;
            if ($status === 'rekomendasi') {
                $query->whereHas('dataSiswa.rekomendasis');
            } elseif ($status === 'belum') {
                $query->whereDoesntHave('dataSiswa.rekomendasis');
            }
        }

        $siswas = $query->latest()->paginate(10)->withQueryString();

        return view('guru.siswa.index', compact('siswas'));
    }

    /**
     * Show form to edit student profile.
     */
    public function edit($id)
    {
        $guru = Auth::user();
        $siswa = User::role('Siswa')->with('dataSiswa')->findOrFail($id);

        // Security check: must be from the same school
        if ($siswa->sekolah !== $guru->sekolah) {
            abort(403, 'Akses Ditolak. Anda hanya dapat mengubah profil siswa dari sekolah Anda sendiri.');
        }

        return view('guru.siswa.edit', compact('siswa'));
    }

    /**
     * Update student profile.
     */
    public function update(Request $request, $id)
    {
        $guru = Auth::user();
        $siswa = User::role('Siswa')->with('dataSiswa')->findOrFail($id);

        if ($siswa->sekolah !== $guru->sekolah) {
            abort(403, 'Akses Ditolak.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'no_hp' => ['required', 'string', 'max:20'],
            'kelas' => ['required', 'string', 'max:50'],
            'nilai_rata' => ['required', 'numeric', 'min:0', 'max:100'],
            'kondisi_ekonomi' => ['required', 'in:mampu,kurang_mampu,tidak_mampu'],
            'minat_jurusan' => ['required', 'array', 'min:1', 'max:3'],
            'prestasi' => ['nullable', 'string'],
        ]);

        $siswa->update([
            'name' => $validated['name'],
            'no_hp' => $validated['no_hp'],
            'kelas' => $validated['kelas'],
        ]);

        $siswa->dataSiswa->update([
            'nilai_rata' => $validated['nilai_rata'],
            'kondisi_ekonomi' => $validated['kondisi_ekonomi'],
            'minat_jurusan' => $validated['minat_jurusan'],
            'prestasi' => $validated['prestasi'],
        ]);

        return redirect()->route('guru.siswa.index')->with('success', 'Data profil siswa ' . $siswa->name . ' berhasil diperbarui!');
    }

    /**
     * Delete student.
     */
    public function destroy($id)
    {
        $guru = Auth::user();
        $siswa = User::role('Siswa')->findOrFail($id);

        if ($siswa->sekolah !== $guru->sekolah) {
            abort(403, 'Akses Ditolak.');
        }

        $siswa->delete();

        return redirect()->route('guru.siswa.index')->with('success', 'Akun siswa berhasil dihapus!');
    }
}
