<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\HasilCpi;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSiswa = Siswa::count();
        $totalKriteria = Kriteria::count();
        $totalPenilaian = Penilaian::count();
        $siswaTebaik = HasilCpi::with('siswa')->orderBy('peringkat')->first();
        $rataRataSkor = HasilCpi::avg('persentase') ?? 0;

        $grafikPeringkat = HasilCpi::with('siswa')
            ->orderBy('peringkat')
            ->take(5)
            ->get();

        $distribusiKategori = HasilCpi::select(
            DB::raw('CASE 
                    WHEN persentase >= 90 THEN "Sangat Siap"
                    WHEN persentase >= 80 THEN "Siap" 
                    WHEN persentase >= 70 THEN "Cukup Siap"
                    WHEN persentase >= 60 THEN "Kurang Siap"
                    ELSE "Belum Siap"
                END as kategori_kesiapan'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('kategori_kesiapan')
            ->get();

        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalKriteria',
            'totalPenilaian',
            'siswaTebaik',
            'rataRataSkor',
            'grafikPeringkat',
            'distribusiKategori'
        ));
    }
}
