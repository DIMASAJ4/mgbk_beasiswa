<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Beasiswa;
use App\Models\KampusMitra;
use App\Http\Requests\Admin\StoreBeasiswaRequest;
use App\Http\Requests\Admin\UpdateBeasiswaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BeasiswaController extends Controller
{
    /**
     * Display a listing of the scholarships.
     */
    public function index(Request $request)
    {
        $query = Beasiswa::with('kampusMitra');

        // Apply filters
        if ($request->filled('search')) {
            $query->where('nama_beasiswa', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kampus_id')) {
            $query->where('kampus_mitra_id', $request->kampus_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $beasiswas = $query->latest()->paginate(10)->withQueryString();
        $kampusMitras = KampusMitra::orderBy('nama_kampus')->get();

        return view('admin.beasiswa.index', compact('beasiswas', 'kampusMitras'));
    }

    /**
     * Show the form for creating a new scholarship.
     */
    public function create()
    {
        $kampusMitras = KampusMitra::orderBy('nama_kampus')->get();
        return view('admin.beasiswa.create', compact('kampusMitras'));
    }

    /**
     * Store a newly created scholarship in database.
     */
    public function store(StoreBeasiswaRequest $request)
    {
        $data = $request->validated();

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('beasiswa', 'public');
        }

        Beasiswa::create($data);

        return redirect()->route('admin.beasiswa.index')->with('success', 'Program beasiswa baru berhasil diterbitkan!');
    }

    /**
     * Show the form for editing the specified scholarship.
     */
    public function edit($id)
    {
        $beasiswa = Beasiswa::findOrFail($id);
        $kampusMitras = KampusMitra::orderBy('nama_kampus')->get();
        
        return view('admin.beasiswa.edit', compact('beasiswa', 'kampusMitras'));
    }

    /**
     * Update the specified scholarship in database.
     */
    public function update(UpdateBeasiswaRequest $request, $id)
    {
        $beasiswa = Beasiswa::findOrFail($id);
        $data = $request->validated();

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            if ($beasiswa->thumbnail && Storage::disk('public')->exists($beasiswa->thumbnail)) {
                Storage::disk('public')->delete($beasiswa->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('beasiswa', 'public');
        }

        $beasiswa->update($data);

        return redirect()->route('admin.beasiswa.index')->with('success', 'Program beasiswa berhasil diperbarui!');
    }

    /**
     * Remove the specified scholarship from database.
     */
    public function destroy($id)
    {
        $beasiswa = Beasiswa::findOrFail($id);

        // Delete thumbnail
        if ($beasiswa->thumbnail && Storage::disk('public')->exists($beasiswa->thumbnail)) {
            Storage::disk('public')->delete($beasiswa->thumbnail);
        }

        $beasiswa->delete();

        return redirect()->route('admin.beasiswa.index')->with('success', 'Program beasiswa berhasil dihapus!');
    }
}
