<?php

namespace App\Http\Controllers;

use App\Models\WilayahDesa;
use Illuminate\Http\Request;

class WilayahDesaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wilayahDesas = WilayahDesa::all();
        return view('admin.wilayah_desa.index', compact('wilayahDesas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.wilayah_desa.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'ongkos_kirim' => 'nullable|numeric|min:0',
            'tersedia_delivery' => 'required|boolean',
            'kode_pos' => 'nullable|string|max:10',
        ]);

        WilayahDesa::create($request->all());

        return redirect()->route('admin.wilayah-desa.index')
            ->with('success', 'Wilayah/Desa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WilayahDesa  $wilayahDesa
     * @return \Illuminate\Http\Response
     */
    public function show(WilayahDesa $wilayahDesa)
    {
        return view('admin.wilayah_desa.show', compact('wilayahDesa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WilayahDesa  $wilayahDesa
     * @return \Illuminate\Http\Response
     */
    public function edit(WilayahDesa $wilayahDesa)
    {
        return view('admin.wilayah_desa.edit', compact('wilayahDesa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WilayahDesa  $wilayahDesa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WilayahDesa $wilayahDesa)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'ongkos_kirim' => 'nullable|numeric|min:0',
            'tersedia_delivery' => 'required|boolean',
            'kode_pos' => 'nullable|string|max:10',
        ]);

        $wilayahDesa->update($request->all());

        return redirect()->route('admin.wilayah-desa.index')
            ->with('success', 'Wilayah/Desa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WilayahDesa  $wilayahDesa
     * @return \Illuminate\Http\Response
     */
    public function destroy(WilayahDesa $wilayahDesa)
    {
        $wilayahDesa->delete();

        return redirect()->route('admin.wilayah-desa.index')
            ->with('success', 'Wilayah/Desa berhasil dihapus.');
    }
}