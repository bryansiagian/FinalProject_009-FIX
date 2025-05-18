<?php

namespace App\Http\Controllers;

use App\Models\TentangKami;
use App\Models\KodePos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TentangKamiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tentang_kami = TentangKami::all();
        $kodePos = KodePos::all(); // Ambil semua kode pos
        return view('admin.tentang-kami.index', compact('tentang_kami', 'kodePos')); // Tampilkan daftar di halaman admin
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tentang-kami.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_toko' => 'nullable',
            'alamat' => 'nullable',
            'sejarah' => 'nullable',
            'deskripsi' => 'nullable',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id(); // Dapatkan ID user yang login

        TentangKami::create($data);

        return redirect()->route('admin.tentang-kami.index')
            ->with('success', 'Informasi Tentang Kami berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TentangKami $tentang_kami)
    {
        return view('admin.tentang-kami.show', compact('tentang_kami')); //Buat view show
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TentangKami $tentang_kami)
    {
        return view('admin.tentang-kami.edit', compact('tentang_kami'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TentangKami $tentang_kami)
    {
         $request->validate([
            'nama_toko' => 'nullable',
            'alamat' => 'nullable',
            'sejarah' => 'nullable',
            'deskripsi' => 'nullable',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id(); // Dapatkan ID user yang login

        $tentang_kami->update($data);

        return redirect()->route('admin.tentang-kami.index')
            ->with('success', 'Informasi Tentang Kami berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TentangKami $tentang_kami)
    {
        $tentang_kami->delete();

        return redirect()->route('admin.tentang-kami.index')
            ->with('success', 'Informasi Tentang Kami berhasil dihapus.');
    }
    /**
     * Display the resource on front page.
     */
    public function showFront()
    {
        $tentang_kami = TentangKami::first();
        $kodePos = KodePos::all(); // Ambil semua kode pos
        return view('tentang-kami.index', compact('tentang_kami', 'kodePos')); // Tampilkan di halaman depan
    }
}