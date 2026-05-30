<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KampusMitra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KampusController extends Controller
{
    /**
     * Display a listing of the campus partners.
     */
    public function index(Request $request)
    {
        $query = KampusMitra::withCount('beasiswas');

        if ($request->filled('search')) {
            $query->where('nama_kampus', 'like', '%' . $request->search . '%');
        }

        $kampuses = $query->latest()->paginate(10)->withQueryString();

        return view('admin.kampus.index', compact('kampuses'));
    }

    /**
     * Show the form for creating a new campus.
     */
    public function create()
    {
        return view('admin.kampus.create');
    }

    /**
     * Store a newly created campus in database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kampus' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'website' => ['nullable', 'url', 'max:255'],
            'kontak' => ['required', 'string', 'max:100'],
            'alamat' => ['required', 'string'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'is_active' => ['required', 'boolean'],
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('kampus_logo', 'public');
        }

        KampusMitra::create($validated);

        return redirect()->route('admin.kampus.index')->with('success', 'Kampus Mitra baru berhasil didaftarkan!');
    }

    /**
     * Show the form for editing the specified campus.
     */
    public function edit($id)
    {
        $kampus = KampusMitra::findOrFail($id);
        return view('admin.kampus.edit', compact('kampus'));
    }

    /**
     * Update the specified campus in database.
     */
    public function update(Request $request, $id)
    {
        $kampus = KampusMitra::findOrFail($id);

        $validated = $request->validate([
            'nama_kampus' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'website' => ['nullable', 'url', 'max:255'],
            'kontak' => ['required', 'string', 'max:100'],
            'alamat' => ['required', 'string'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'is_active' => ['required', 'boolean'],
        ]);

        if ($request->hasFile('logo')) {
            if ($kampus->logo && Storage::disk('public')->exists($kampus->logo)) {
                Storage::disk('public')->delete($kampus->logo);
            }
            $validated['logo'] = $request->file('logo')->store('kampus_logo', 'public');
        }

        $kampus->update($validated);

        return redirect()->route('admin.kampus.index')->with('success', 'Data Kampus Mitra berhasil diperbarui!');
    }

    /**
     * Remove the specified campus from database.
     */
    public function destroy($id)
    {
        $kampus = KampusMitra::findOrFail($id);

        if ($kampus->logo && Storage::disk('public')->exists($kampus->logo)) {
            Storage::disk('public')->delete($kampus->logo);
        }

        $kampus->delete();

        return redirect()->route('admin.kampus.index')->with('success', 'Kampus Mitra berhasil dihapus!');
    }
}
