<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    // **Public Methods**
    public function showGaleriPublic()
    {
        $galeri = Galeri::all();
        return view('galeri.index', compact('galeri')); // View publik
    }

    // **Admin Methods**
    public function index()
    {
        $galeri = Galeri::all();
        return view('admin.galeri.index', compact('galeri')); // View admin
    }

    public function create()
    {
        return view('admin.galeri.create'); // View admin
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_gambar' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi file
            'deskripsi' => 'nullable',
        ]);

        $gambar = $request->file('gambar');
        $namaGambar = time() . '_' . $gambar->getClientOriginalName();
        $path = $gambar->storeAs('gambar', $namaGambar, 'public'); // Simpan di storage/app/public/gambar

        Galeri::create([
            'nama_gambar' => $namaGambar,
            'path' => $path,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.galeri.index') // Route admin
            ->with('success', 'Gambar berhasil ditambahkan ke galeri.');
    }

    public function show(Galeri $galeri)
    {
        return view('admin.galeri.show', compact('galeri')); // View admin
    }

    public function edit(Galeri $galeri)
    {
        return view('admin.galeri.edit', compact('galeri')); // View admin
    }

    public function update(Request $request, Galeri $galeri)
    {
        $request->validate([
            'nama_gambar' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi file
            'deskripsi' => 'nullable',
        ]);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            Storage::disk('public')->delete($galeri->path);

            $gambar = $request->file('gambar');
            $namaGambar = time() . '_' . $gambar->getClientOriginalName();
            $path = $gambar->storeAs('gambar', $namaGambar, 'public');

            $galeri->update([
                'nama_gambar' => $namaGambar,
                'path' => $path,
                'deskripsi' => $request->deskripsi,
            ]);
        } else {
            $galeri->update([
                'nama_gambar' => $request->nama_gambar,
                'deskripsi' => $request->deskripsi,
            ]);
        }

        return redirect()->route('admin.galeri.index') // Route admin
            ->with('success', 'Gambar berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Galeri $galeri)
    {
        // Hapus gambar dari storage
        Storage::disk('public')->delete($galeri->path);

        $galeri->delete();

        return redirect()->route('admin.galeri.index') // Route admin
            ->with('success', 'Gambar berhasil dihapus dari galeri.');
    }
}
