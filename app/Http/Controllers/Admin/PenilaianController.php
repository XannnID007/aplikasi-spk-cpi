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
        // Mengurutkan berdasarkan siswa.kode, lalu kriteria.kode secara berurutan
        $penilaian = Penilaian::with(['siswa', 'kriteria'])
            ->join('siswa', 'penilaian.siswa_id', '=', 'siswa.id')
            ->join('kriteria', 'penilaian.kriteria_id', '=', 'kriteria.id')
            ->select('penilaian.*')
            ->orderByRaw('
                CASE 
                    WHEN siswa.kode REGEXP "^[A-Z][0-9]+$" THEN 
                        CONCAT(
                            LPAD(ASCII(SUBSTRING(siswa.kode, 1, 1)), 3, "0"),
                            LPAD(CAST(SUBSTRING(siswa.kode, 2) AS UNSIGNED), 5, "0")
                        )
                    ELSE siswa.kode 
                END
            ')
            ->orderByRaw('
                CASE 
                    WHEN kriteria.kode REGEXP "^[A-Z][0-9]+$" THEN 
                        CONCAT(
                            LPAD(ASCII(SUBSTRING(kriteria.kode, 1, 1)), 3, "0"),
                            LPAD(CAST(SUBSTRING(kriteria.kode, 2) AS UNSIGNED), 5, "0")
                        )
                    ELSE kriteria.kode 
                END
            ')
            ->paginate(15);

        return view('admin.penilaian.index', compact('penilaian'));
    }

    public function create()
    {
        // Mengurutkan siswa dan kriteria secara berurutan untuk dropdown
        $siswa = Siswa::orderByRaw('
            CASE 
                WHEN kode REGEXP "^[A-Z][0-9]+$" THEN 
                    CONCAT(
                        LPAD(ASCII(SUBSTRING(kode, 1, 1)), 3, "0"),
                        LPAD(CAST(SUBSTRING(kode, 2) AS UNSIGNED), 5, "0")
                    )
                ELSE kode 
            END
        ')->get();

        $kriteria = Kriteria::orderByRaw('
            CASE 
                WHEN kode REGEXP "^[A-Z][0-9]+$" THEN 
                    CONCAT(
                        LPAD(ASCII(SUBSTRING(kode, 1, 1)), 3, "0"),
                        LPAD(CAST(SUBSTRING(kode, 2) AS UNSIGNED), 5, "0")
                    )
                ELSE kode 
            END
        ')->get();

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

        // Mengurutkan siswa dan kriteria secara berurutan untuk dropdown
        $siswa = Siswa::orderByRaw('
            CASE 
                WHEN kode REGEXP "^[A-Z][0-9]+$" THEN 
                    CONCAT(
                        LPAD(ASCII(SUBSTRING(kode, 1, 1)), 3, "0"),
                        LPAD(CAST(SUBSTRING(kode, 2) AS UNSIGNED), 5, "0")
                    )
                ELSE kode 
            END
        ')->get();

        $kriteria = Kriteria::orderByRaw('
            CASE 
                WHEN kode REGEXP "^[A-Z][0-9]+$" THEN 
                    CONCAT(
                        LPAD(ASCII(SUBSTRING(kode, 1, 1)), 3, "0"),
                        LPAD(CAST(SUBSTRING(kode, 2) AS UNSIGNED), 5, "0")
                    )
                ELSE kode 
            END
        ')->get();

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

    /**
     * Mendapatkan daftar penilaian yang dikelompokkan berdasarkan siswa
     * Berguna untuk menampilkan progress penilaian per siswa
     */
    public function getGroupedBySiswa()
    {
        $siswaWithPenilaian = Siswa::with(['penilaian.kriteria'])
            ->orderByRaw('
                CASE 
                    WHEN kode REGEXP "^[A-Z][0-9]+$" THEN 
                        CONCAT(
                            LPAD(ASCII(SUBSTRING(kode, 1, 1)), 3, "0"),
                            LPAD(CAST(SUBSTRING(kode, 2) AS UNSIGNED), 5, "0")
                        )
                    ELSE kode 
                END
            ')
            ->get();

        $totalKriteria = Kriteria::count();

        return view('admin.penilaian.grouped', compact('siswaWithPenilaian', 'totalKriteria'));
    }

    /**
     * Mendapatkan daftar siswa yang belum dinilai untuk kriteria tertentu
     */
    public function getSiswaWithMissingAssessments()
    {
        $kriteria = Kriteria::orderByRaw('
            CASE 
                WHEN kode REGEXP "^[A-Z][0-9]+$" THEN 
                    CONCAT(
                        LPAD(ASCII(SUBSTRING(kode, 1, 1)), 3, "0"),
                        LPAD(CAST(SUBSTRING(kode, 2) AS UNSIGNED), 5, "0")
                    )
                ELSE kode 
            END
        ')->get();

        $siswa = Siswa::orderByRaw('
            CASE 
                WHEN kode REGEXP "^[A-Z][0-9]+$" THEN 
                    CONCAT(
                        LPAD(ASCII(SUBSTRING(kode, 1, 1)), 3, "0"),
                        LPAD(CAST(SUBSTRING(kode, 2) AS UNSIGNED), 5, "0")
                    )
                ELSE kode 
            END
        ')->get();

        $missingAssessments = [];

        foreach ($siswa as $s) {
            foreach ($kriteria as $k) {
                $exists = Penilaian::where('siswa_id', $s->id)
                    ->where('kriteria_id', $k->id)
                    ->exists();

                if (!$exists) {
                    $missingAssessments[] = [
                        'siswa' => $s,
                        'kriteria' => $k,
                        'link' => route('admin.penilaian.create', [
                            'siswa_id' => $s->id,
                            'kriteria_id' => $k->id
                        ])
                    ];
                }
            }
        }

        return view('admin.penilaian.missing', compact('missingAssessments'));
    }
}
