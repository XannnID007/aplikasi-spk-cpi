<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HasilCpi;
use App\Models\Penilaian;
use App\Services\CpiService;

class HasilCpiController extends Controller
{
    public function index()
    {
        $hasilCpi = HasilCpi::with('siswa')->orderBy('peringkat')->paginate(10);
        return view('admin.hasil-cpi.index', compact('hasilCpi'));
    }

    public function show($id)
    {
        $hasil = HasilCpi::with(['siswa', 'siswa.penilaian.kriteria'])->findOrFail($id);
        return view('admin.hasil-cpi.show', compact('hasil'));
    }

    public function hitungCpi()
    {
        try {
            $cpiService = new CpiService();
            $cpiService->hitungCpi();

            return redirect()->back()->with('success', 'Perhitungan CPI berhasil dilakukan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function resetHasil()
    {
        try {
            HasilCpi::truncate();

            // Reset nilai normalisasi dan terbobot
            Penilaian::query()->update([
                'nilai_normalisasi' => null,
                'nilai_terbobot' => null
            ]);

            return redirect()->back()->with('success', 'Hasil CPI berhasil direset.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function cetakHasil()
    {
        $hasilCpi = HasilCpi::with('siswa')->orderBy('peringkat')->get();
        $tanggalCetak = now()->format('d F Y');

        return view('admin.laporan.cetak-hasil', compact('hasilCpi', 'tanggalCetak'));
    }
}
