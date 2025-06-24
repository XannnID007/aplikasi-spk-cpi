<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penilaian;
use App\Models\Siswa;
use App\Models\Kriteria;

class PenilaianController extends Controller
{
    public function index()
    {
        $penilaian = Penilaian::with(['siswa', 'kriteria'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('admin.penilaian.index', compact('penilaian'));
    }

    public function create()
    {
        $siswa = Siswa::orderBy('nama')->get();
        $kriteria = Kriteria::orderBy('kode')->get();
        return view('admin.penilaian.create', compact('siswa', 'kriteria'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'kriteria_id' => 'required|exists:kriteria,id',
            'nilai_mentah' => 'required|numeric|min:0|max:100'
        ]);

        // Cek apakah sudah ada penilaian untuk siswa dan kriteria ini
        $existing = Penilaian::where('siswa_id', $request->siswa_id)
            ->where('kriteria_id', $request->kriteria_id)
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Penilaian untuk siswa dan kriteria ini sudah ada.');
        }

        Penilaian::create($request->all());

        return redirect()->route('admin.penilaian.index')->with('success', 'Data penilaian berhasil ditambahkan.');
    }

    public function show($id)
    {
        $penilaian = Penilaian::with(['siswa', 'kriteria'])->findOrFail($id);
        return view('admin.penilaian.show', compact('penilaian'));
    }

    public function edit($id)
    {
        $penilaian = Penilaian::with(['siswa', 'kriteria'])->findOrFail($id);
        $siswa = Siswa::orderBy('nama')->get();
        $kriteria = Kriteria::orderBy('kode')->get();
        return view('admin.penilaian.edit', compact('penilaian', 'siswa', 'kriteria'));
    }

    public function update(Request $request, $id)
    {
        $penilaian = Penilaian::findOrFail($id);

        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'kriteria_id' => 'required|exists:kriteria,id',
            'nilai_mentah' => 'required|numeric|min:0|max:100'
        ]);

        // Cek duplikasi kecuali untuk record ini sendiri
        $existing = Penilaian::where('siswa_id', $request->siswa_id)
            ->where('kriteria_id', $request->kriteria_id)
            ->where('id', '!=', $id)
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Penilaian untuk siswa dan kriteria ini sudah ada.');
        }

        $penilaian->update($request->all());

        return redirect()->route('admin.penilaian.index')->with('success', 'Data penilaian berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $penilaian = Penilaian::findOrFail($id);
        $penilaian->delete();

        return redirect()->route('admin.penilaian.index')->with('success', 'Data penilaian berhasil dihapus.');
    }
}
