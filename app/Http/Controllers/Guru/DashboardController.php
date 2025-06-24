<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\HasilCpi;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSiswa = HasilCpi::count();
        $siswaLulus = HasilCpi::where('persentase', '>=', 70)->count();
        $siswaBelumLulus = HasilCpi::where('persentase', '<', 70)->count();
        $rataRataSkor = HasilCpi::avg('persentase') ?? 0;

        $grafikHasil = HasilCpi::with('siswa')
            ->orderBy('peringkat')
            ->take(10)
            ->get();

        return view('guru.dashboard', compact(
            'totalSiswa',
            'siswaLulus',
            'siswaBelumLulus',
            'rataRataSkor',
            'grafikHasil'
        ));
    }
}

// app/Http/Controllers/Guru/HasilCpiController.php
namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\HasilCpi;

class HasilCpiController extends Controller
{
    public function index()
    {
        $hasilCpi = HasilCpi::with('siswa')->orderBy('peringkat')->paginate(10);
        return view('guru.hasil-cpi.index', compact('hasilCpi'));
    }

    public function show($id)
    {
        $hasil = HasilCpi::with(['siswa', 'siswa.penilaian.kriteria'])->findOrFail($id);
        return view('guru.hasil-cpi.show', compact('hasil'));
    }

    public function cetakHasil()
    {
        $hasilCpi = HasilCpi::with('siswa')->orderBy('peringkat')->get();
        $tanggalCetak = now()->format('d F Y');

        return view('guru.laporan.cetak-hasil', compact('hasilCpi', 'tanggalCetak'));
    }
}
