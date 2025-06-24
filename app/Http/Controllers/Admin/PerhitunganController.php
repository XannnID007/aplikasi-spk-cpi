<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\HasilCpi;
use Illuminate\Http\Request;

class PerhitunganController extends Controller
{
    public function index()
    {
        $siswa = Siswa::with(['penilaian.kriteria', 'hasilCpi'])
            ->orderBy('nama')
            ->get();

        $kriteria = Kriteria::orderBy('kode')->get();

        $totalSiswa = $siswa->count();
        $totalKriteria = $kriteria->count();
        $totalPenilaian = Penilaian::count();
        $hasHasilCpi = HasilCpi::count() > 0;

        // Statistik perhitungan
        $statistik = [
            'total_siswa' => $totalSiswa,
            'total_kriteria' => $totalKriteria,
            'total_penilaian' => $totalPenilaian,
            'penilaian_lengkap' => $this->hitungPenilaianLengkap($siswa, $kriteria),
            'has_hasil_cpi' => $hasHasilCpi,
            'rata_rata_skor' => $hasHasilCpi ? HasilCpi::avg('skor_total') : 0,
        ];

        return view('admin.perhitungan.index', compact('siswa', 'kriteria', 'statistik'));
    }

    public function show($siswaId)
    {
        $siswa = Siswa::with(['penilaian.kriteria', 'hasilCpi'])
            ->findOrFail($siswaId);

        $kriteria = Kriteria::orderBy('kode')->get();

        // Data perhitungan detail untuk siswa ini
        $perhitunganDetail = $this->getPerhitunganDetail($siswa, $kriteria);

        return view('admin.perhitungan.show', compact('siswa', 'kriteria', 'perhitunganDetail'));
    }

    public function matrix()
    {
        $siswa = Siswa::with(['penilaian.kriteria'])->orderBy('nama')->get();
        $kriteria = Kriteria::orderBy('kode')->get();

        // Matrix data untuk tabel perhitungan
        $matrixData = $this->buildMatrixData($siswa, $kriteria);

        return view('admin.perhitungan.matrix', compact('siswa', 'kriteria', 'matrixData'));
    }

    public function normalisasi()
    {
        $kriteria = Kriteria::with('penilaian.siswa')->orderBy('kode')->get();

        // Data normalisasi per kriteria
        $normalisasiData = [];
        foreach ($kriteria as $k) {
            $nilai = $k->penilaian->pluck('nilai_mentah');
            if ($nilai->count() > 0) {
                $normalisasiData[$k->kode] = [
                    'kriteria' => $k,
                    'nilai_min' => $nilai->min(),
                    'nilai_max' => $nilai->max(),
                    'rata_rata' => $nilai->avg(),
                    'data_penilaian' => $k->penilaian->map(function ($p) use ($k, $nilai) {
                        if ($k->tren === 'Positif') {
                            $normalisasi = ($p->nilai_mentah / $nilai->min()) * 100;
                        } else {
                            $normalisasi = ($nilai->min() / $p->nilai_mentah) * 100;
                        }
                        return [
                            'siswa' => $p->siswa,
                            'nilai_mentah' => $p->nilai_mentah,
                            'nilai_normalisasi_calculated' => $normalisasi,
                            'nilai_normalisasi_stored' => $p->nilai_normalisasi,
                            'nilai_terbobot' => $normalisasi * $k->bobot,
                        ];
                    })->sortBy('siswa.nama')
                ];
            }
        }

        return view('admin.perhitungan.normalisasi', compact('kriteria', 'normalisasiData'));
    }

    private function hitungPenilaianLengkap($siswa, $kriteria)
    {
        $lengkap = 0;
        foreach ($siswa as $s) {
            if ($s->penilaian->count() == $kriteria->count()) {
                $lengkap++;
            }
        }
        return $lengkap;
    }

    private function getPerhitunganDetail($siswa, $kriteria)
    {
        $detail = [];

        foreach ($kriteria as $k) {
            $penilaian = $siswa->penilaian->where('kriteria_id', $k->id)->first();

            if ($penilaian) {
                // Ambil semua nilai untuk kriteria ini untuk menghitung normalisasi
                $semuaNilai = Penilaian::where('kriteria_id', $k->id)->pluck('nilai_mentah');
                $nilaiMin = $semuaNilai->min();

                // Hitung normalisasi
                if ($k->tren === 'Positif') {
                    $normalisasi = ($penilaian->nilai_mentah / $nilaiMin) * 100;
                } else {
                    $normalisasi = ($nilaiMin / $penilaian->nilai_mentah) * 100;
                }

                $terbobot = $normalisasi * $k->bobot;

                $detail[] = [
                    'kriteria' => $k,
                    'penilaian' => $penilaian,
                    'nilai_min_kriteria' => $nilaiMin,
                    'normalisasi_calculated' => $normalisasi,
                    'terbobot_calculated' => $terbobot,
                    'rumus_normalisasi' => $k->tren === 'Positif'
                        ? "({$penilaian->nilai_mentah} / {$nilaiMin}) × 100"
                        : "({$nilaiMin} / {$penilaian->nilai_mentah}) × 100",
                    'rumus_terbobot' => number_format($normalisasi, 2) . " × " . number_format($k->bobot, 3)
                ];
            }
        }

        return $detail;
    }

    private function buildMatrixData($siswa, $kriteria)
    {
        $matrix = [];

        foreach ($siswa as $s) {
            $row = [
                'siswa' => $s,
                'kriteria_data' => []
            ];

            foreach ($kriteria as $k) {
                $penilaian = $s->penilaian->where('kriteria_id', $k->id)->first();
                $row['kriteria_data'][$k->kode] = $penilaian ? $penilaian->nilai_mentah : null;
            }

            $matrix[] = $row;
        }

        return $matrix;
    }
}
