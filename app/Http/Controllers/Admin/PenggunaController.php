<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DataSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    /**
     * Display a tabbed listing of users (Guru BK & Siswa).
     */
    public function index(Request $request)
    {
        $tab = $request->input('tab', 'guru'); // 'guru' or 'siswa'

        if ($tab === 'siswa') {
            $query = User::role('Siswa')->with('dataSiswa');
            
            if ($request->filled('search')) {
                $query->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('nisn', 'like', '%' . $request->search . '%')
                      ->orWhere('email', 'like', '%' . $request->search . '%');
            }
            
            $users = $query->latest()->paginate(10)->withQueryString();
        } else {
            // Default Guru BK
            $query = User::role('Guru BK');
            
            if ($request->filled('search')) {
                $query->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('nip', 'like', '%' . $request->search . '%')
                      ->orWhere('email', 'like', '%' . $request->search . '%');
            }
            
            $users = $query->latest()->paginate(10)->withQueryString();
            
            // Append student counts dynamically for current school
            foreach ($users as $guru) {
                $guru->jumlah_siswa = User::role('Siswa')->where('sekolah', $guru->sekolah)->count();
            }
        }

        return view('admin.pengguna.index', compact('users', 'tab'));
    }

    /**
     * Show form to create new Guru BK.
     */
    public function createGuru()
    {
        return view('admin.pengguna.create_guru');
    }

    /**
     * Store new Guru BK user.
     */
    public function storeGuru(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'nip' => ['required', 'string', 'max:50', 'unique:users'],
            'sekolah' => ['required', 'string', 'max:255'],
            'no_hp' => ['required', 'string', 'max:20'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'nip' => $validated['nip'],
            'sekolah' => $validated['sekolah'],
            'no_hp' => $validated['no_hp'],
            'role' => 'guru_bk',
        ]);

        $user->assignRole('Guru BK');

        return redirect()->route('admin.pengguna.index', ['tab' => 'guru'])->with('success', 'Akun Guru BK baru berhasil dibuat!');
    }

    /**
     * Show form to create new Siswa.
     */
    public function createSiswa()
    {
        $sekolahs = User::role('Guru BK')->whereNotNull('sekolah')->distinct()->pluck('sekolah');
        return view('admin.pengguna.create_siswa', compact('sekolahs'));
    }

    /**
     * Store new Siswa user.
     */
    public function storeSiswa(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'nisn' => ['required', 'string', 'max:20', 'unique:users'],
            'sekolah' => ['required', 'string', 'max:255'],
            'kelas' => ['required', 'string', 'max:50'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'nisn' => $validated['nisn'],
            'sekolah' => $validated['sekolah'],
            'kelas' => $validated['kelas'],
            'role' => 'siswa',
        ]);

        $user->assignRole('Siswa');

        // Create blank DataSiswa profile automatically
        DataSiswa::create([
            'user_id' => $user->id,
            'nilai_rata' => 0.00,
            'kondisi_ekonomi' => 'kurang_mampu',
            'minat_jurusan' => [],
            'is_verified' => false,
        ]);

        return redirect()->route('admin.pengguna.index', ['tab' => 'siswa'])->with('success', 'Akun Siswa baru berhasil dibuat!');
    }

    /**
     * Reset password of another user to default 'password'.
     */
    public function resetPassword($id)
    {
        $user = User::findOrFail($id);
        
        $user->update([
            'password' => Hash::make('password'),
        ]);

        return back()->with('success', 'Kata sandi pengguna ' . $user->name . ' berhasil direset menjadi "password"!');
    }

    /**
     * Remove the specified user.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'Akun pengguna berhasil dihapus dari sistem!');
    }
}
