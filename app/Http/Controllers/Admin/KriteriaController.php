<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kriteria;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriteria = Kriteria::orderBy('kode')->get();
        return view('admin.kriteria.index', compact('kriteria'));
    }

    public function create()
    {
        return view('admin.kriteria.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:kriteria|max:10',
            'nama' => 'required|string|max:255',
            'tren' => 'required|in:Positif,Negatif',
            'bobot' => 'required|numeric|min:0|max:1',
            'keterangan' => 'nullable|string'
        ]);

        Kriteria::create($request->all());

        return redirect()->route('admin.kriteria.index')->with('success', 'Data kriteria berhasil ditambahkan.');
    }

    public function show($id)
    {
        $kriteria = Kriteria::with('penilaian.siswa')->findOrFail($id);
        return view('admin.kriteria.show', compact('kriteria'));
    }

    public function edit($id)
    {
        $kriteria = Kriteria::findOrFail($id);
        return view('admin.kriteria.edit', compact('kriteria'));
    }

    public function update(Request $request, $id)
    {
        $kriteria = Kriteria::findOrFail($id);

        $request->validate([
            'kode' => 'required|max:10|unique:kriteria,kode,' . $id,
            'nama' => 'required|string|max:255',
            'tren' => 'required|in:Positif,Negatif',
            'bobot' => 'required|numeric|min:0|max:1',
            'keterangan' => 'nullable|string'
        ]);

        $kriteria->update($request->all());

        return redirect()->route('admin.kriteria.index')->with('success', 'Data kriteria berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kriteria = Kriteria::findOrFail($id);
        $kriteria->delete();

        return redirect()->route('admin.kriteria.index')->with('success', 'Data kriteria berhasil dihapus.');
    }
}
