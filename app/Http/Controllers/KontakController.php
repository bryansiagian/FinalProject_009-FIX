<?php

namespace App\Http\Controllers;

use App\Models\Kontak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KontakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kontakList = Kontak::all();
        return view('admin.kontak.index', compact('kontakList')); // Tampilkan daftar di halaman admin
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kontak.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'alamat' => 'nullable',
            'telepon' => 'nullable',
            'email' => 'nullable|email',
            'peta' => 'nullable',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id(); // Dapatkan ID user yang login

        Kontak::create($data);

        return redirect()->route('admin.kontak.index')
            ->with('success', 'Informasi Kontak berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kontak $kontak)
    {
        return view('admin.kontak.show', compact('kontak'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kontak $kontak)
    {
        return view('admin.kontak.edit', compact('kontak'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kontak $kontak)
    {
        $request->validate([
            'alamat' => 'nullable',
            'telepon' => 'nullable',
            'email' => 'nullable|email',
            'peta' => 'nullable',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id(); // Dapatkan ID user yang login

        $kontak->update($data);

        return redirect()->route('admin.kontak.index')
            ->with('success', 'Informasi Kontak berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kontak $kontak)
    {
        $kontak->delete();

        return redirect()->route('admin.kontak.index')
            ->with('success', 'Informasi Kontak berhasil dihapus.');
    }

    /**
     * Display the resource on front page.
     */
    public function showFront()
    {
        $kontak = Kontak::all(); // Ambil yang pertama
        return view('kontak.index', compact('kontak')); // Tampilkan di halaman depan
    }
}