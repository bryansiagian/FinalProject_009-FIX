<?php

namespace App\Http\Controllers;

use App\Models\KodePos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class KodePosController extends Controller
{
    public function index()
    {
        $kodePos = KodePos::all();
        return view('admin.kode_pos.index', compact('kodePos'));
    }

    public function create()
    {
        return view('admin.kode_pos.create');
    }

    public function store(Request $request)
{
    Log::info($request->all());

    $request->validate([
        'kode_pos' => 'required|string|max:10|unique:kode_pos',
        'ongkos_kirim' => 'required|numeric|min:0',
    ]);

    $kodePos = KodePos::create([
        'kode_pos' => $request->kode_pos,
        'ongkos_kirim' => $request->ongkos_kirim,
        'user_id' => Auth::id(),
        'updated_by' => Auth::id(),
    ]);

    Log::info('Kode Pos Baru: ' . $kodePos->toJson()); // Tambahkan ini

    return redirect()->route('admin.kode_pos.index')->with('success', 'Kode pos berhasil ditambahkan.');
}

    public function edit(KodePos $kodePos)
    {
        return view('admin.kode_pos.edit', compact('kodePos'));
    }

    public function update(Request $request, KodePos $kodePos)  // Menggunakan $kodePos yang benar
    {
        $request->validate([
            'kode_pos' => 'required|string|max:10|unique:kode_pos,kode_pos,' . $kodePos->id,
            'ongkos_kirim' => 'required|numeric|min:0',
        ]);

        $kodePos->update([
            'kode_pos' => $request->kode_pos,
            'ongkos_kirim' => $request->ongkos_kirim,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('admin.kode_pos.index')->with('success', 'Kode pos berhasil diperbarui.');
    }

    public function destroy(KodePos $kodePos)
    {
        $kodePos->delete();
        return back()->with('success', 'Kode pos berhasil dihapus.');
    }

    // Fungsi untuk memeriksa kode pos dan mendapatkan ongkos kirim (Digunakan di halaman pemesanan)
    public function getOngkosKirim(string $kodePos): array
    {
        $kodePosData = KodePos::where('kode_pos', $kodePos)->first();

        if ($kodePosData) {
            return [
                'ada' => true,
                'ongkos_kirim' => $kodePosData->ongkos_kirim,
            ];
        } else {
            return [
                'ada' => false,
                'ongkos_kirim' => 0, // Atau nilai default lainnya
            ];
        }
    }
}