<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth; // Tambahkan import Auth
use Illuminate\Support\Str;

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
            'nama_gambar' => 'required|unique:galeri,nama_gambar|max:255', // Validasi nama gambar (unik, panjang maks)
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'deskripsi' => 'nullable|max:500', // Panjang maks deskripsi
        ]);

        $gambar = $request->file('gambar');
        $namaFile = Str::slug($request->nama_gambar) . '.' . $gambar->getClientOriginalExtension(); // Nama file yang aman
        $path = $gambar->storeAs('gambar', $namaFile, 'public'); // Simpan di storage/app/public/gambar

        Galeri::create([
            'nama_gambar' => $request->nama_gambar, // Gunakan nama yang diinput user
            'path' => $path,
            'deskripsi' => $request->deskripsi,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('admin.galeri.index')
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
            'nama_gambar' => 'required|unique:galeri,nama_gambar,' . $galeri->id . '|max:255', // Validasi unik, kecuali ID saat ini
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'deskripsi' => 'nullable|max:500', // Panjang maks deskripsi
        ]);

        $data = [
            'nama_gambar' => $request->nama_gambar, // Gunakan nama yang diinput user
            'deskripsi' => $request->deskripsi,
            'user_id' => Auth::id(),
        ];

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            Storage::disk('public')->delete($galeri->path);

            $gambar = $request->file('gambar');
            $namaFile = Str::slug($request->nama_gambar) . '.' . $gambar->getClientOriginalExtension(); // Nama file yang aman
            $path = $gambar->storeAs('gambar', $namaFile, 'public');

            $data['path'] = $path;

        }

        $galeri->update($data);

        return redirect()->route('admin.galeri.index')
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