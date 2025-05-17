<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth facade
use Illuminate\Support\Facades\Storage; // Import Storage facade

class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource for admin.
     */
    public function index()
    {
        $pengumumen = Pengumuman::all();
        return view('admin.pengumuman.index', compact('pengumumen'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pengumuman.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $namaGambar = time() . '.' . $gambar->getClientOriginalExtension();
            $path = $gambar->storeAs('public/pengumuman', $namaGambar);
            $data['gambar'] = $namaGambar;
        }

        $data['user_id'] = Auth::id();

        Pengumuman::create($data);

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    /**
     * Display the specified resource for admin.
     */
    public function showAdmin(Pengumuman $pengumuman)
    {
        return view('admin.pengumuman.show', compact('pengumuman'));
    }

    /**
     * Display the specified resource for public.
     */
    public function show(Pengumuman $pengumuman)
    {
        return view('pengumuman.show', compact('pengumuman'));
    }


    /**
     * Display the listing of the resource for public.
     */
    public function showPengumumanPublic()
    {
        $pengumumen = Pengumuman::orderBy('created_at', 'desc')->get();
        return view('pengumuman.index', compact('pengumumen'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengumuman $pengumuman)
    {
        return view('admin.pengumuman.edit', compact('pengumuman'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengumuman $pengumuman)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            if ($pengumuman->gambar) {
                Storage::delete('public/pengumuman/' . $pengumuman->gambar);
            }

            $gambar = $request->file('gambar');
            $namaGambar = time() . '.' . $gambar->getClientOriginalExtension();
            $path = $gambar->storeAs('public/pengumuman', $namaGambar);
            $data['gambar'] = $namaGambar;
        }

        $data['user_id'] = Auth::id();

        $pengumuman->update($data);

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengumuman $pengumuman)
    {
        //Hapus gambar sebelum menghapus pengumuman
        if ($pengumuman->gambar) {
            Storage::delete('public/pengumuman/' . $pengumuman->gambar);
        }
        $pengumuman->delete();

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }
}