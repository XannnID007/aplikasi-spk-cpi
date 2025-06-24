<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;
use App\Models\Kriteria;
use App\Models\Penilaian;

class PenilaianSeeder extends Seeder
{
    public function run()
    {
        // Data penilaian sesuai Excel
        $penilaianData = [
            // A1 - Akhdan Latif Azizan
            ['siswa_kode' => 'A1', 'kriteria_kode' => 'C1', 'nilai_mentah' => 75],
            ['siswa_kode' => 'A1', 'kriteria_kode' => 'C2', 'nilai_mentah' => 60],
            ['siswa_kode' => 'A1', 'kriteria_kode' => 'C3', 'nilai_mentah' => 60],
            ['siswa_kode' => 'A1', 'kriteria_kode' => 'C4', 'nilai_mentah' => 60],
            ['siswa_kode' => 'A1', 'kriteria_kode' => 'C5', 'nilai_mentah' => 80],
            ['siswa_kode' => 'A1', 'kriteria_kode' => 'C6', 'nilai_mentah' => 75],

            // A2 - Nayaka Dzakiyah Rafifah
            ['siswa_kode' => 'A2', 'kriteria_kode' => 'C1', 'nilai_mentah' => 60],
            ['siswa_kode' => 'A2', 'kriteria_kode' => 'C2', 'nilai_mentah' => 60],
            ['siswa_kode' => 'A2', 'kriteria_kode' => 'C3', 'nilai_mentah' => 60],
            ['siswa_kode' => 'A2', 'kriteria_kode' => 'C4', 'nilai_mentah' => 80],
            ['siswa_kode' => 'A2', 'kriteria_kode' => 'C5', 'nilai_mentah' => 60],
            ['siswa_kode' => 'A2', 'kriteria_kode' => 'C6', 'nilai_mentah' => 75],

            // A3 - Hayfa Hanum Hanania
            ['siswa_kode' => 'A3', 'kriteria_kode' => 'C1', 'nilai_mentah' => 75],
            ['siswa_kode' => 'A3', 'kriteria_kode' => 'C2', 'nilai_mentah' => 100],
            ['siswa_kode' => 'A3', 'kriteria_kode' => 'C3', 'nilai_mentah' => 100],
            ['siswa_kode' => 'A3', 'kriteria_kode' => 'C4', 'nilai_mentah' => 80],
            ['siswa_kode' => 'A3', 'kriteria_kode' => 'C5', 'nilai_mentah' => 100],
            ['siswa_kode' => 'A3', 'kriteria_kode' => 'C6', 'nilai_mentah' => 75],

            // A4 - Katya Yumna Aafiyah
            ['siswa_kode' => 'A4', 'kriteria_kode' => 'C1', 'nilai_mentah' => 60],
            ['siswa_kode' => 'A4', 'kriteria_kode' => 'C2', 'nilai_mentah' => 80],
            ['siswa_kode' => 'A4', 'kriteria_kode' => 'C3', 'nilai_mentah' => 100],
            ['siswa_kode' => 'A4', 'kriteria_kode' => 'C4', 'nilai_mentah' => 60],
            ['siswa_kode' => 'A4', 'kriteria_kode' => 'C5', 'nilai_mentah' => 80],
            ['siswa_kode' => 'A4', 'kriteria_kode' => 'C6', 'nilai_mentah' => 60],

            // A5 - Farell Putra Sagara
            ['siswa_kode' => 'A5', 'kriteria_kode' => 'C1', 'nilai_mentah' => 60],
            ['siswa_kode' => 'A5', 'kriteria_kode' => 'C2', 'nilai_mentah' => 100],
            ['siswa_kode' => 'A5', 'kriteria_kode' => 'C3', 'nilai_mentah' => 60],
            ['siswa_kode' => 'A5', 'kriteria_kode' => 'C4', 'nilai_mentah' => 80],
            ['siswa_kode' => 'A5', 'kriteria_kode' => 'C5', 'nilai_mentah' => 80],
            ['siswa_kode' => 'A5', 'kriteria_kode' => 'C6', 'nilai_mentah' => 75],

            // A6 - Shakila Sopiyah Maulidia
            ['siswa_kode' => 'A6', 'kriteria_kode' => 'C1', 'nilai_mentah' => 75],
            ['siswa_kode' => 'A6', 'kriteria_kode' => 'C2', 'nilai_mentah' => 100],
            ['siswa_kode' => 'A6', 'kriteria_kode' => 'C3', 'nilai_mentah' => 100],
            ['siswa_kode' => 'A6', 'kriteria_kode' => 'C4', 'nilai_mentah' => 80],
            ['siswa_kode' => 'A6', 'kriteria_kode' => 'C5', 'nilai_mentah' => 100],
            ['siswa_kode' => 'A6', 'kriteria_kode' => 'C6', 'nilai_mentah' => 60],

            // A7 - Safa Namira Hidayat
            ['siswa_kode' => 'A7', 'kriteria_kode' => 'C1', 'nilai_mentah' => 60],
            ['siswa_kode' => 'A7', 'kriteria_kode' => 'C2', 'nilai_mentah' => 80],
            ['siswa_kode' => 'A7', 'kriteria_kode' => 'C3', 'nilai_mentah' => 60],
            ['siswa_kode' => 'A7', 'kriteria_kode' => 'C4', 'nilai_mentah' => 80],
            ['siswa_kode' => 'A7', 'kriteria_kode' => 'C5', 'nilai_mentah' => 80],
            ['siswa_kode' => 'A7', 'kriteria_kode' => 'C6', 'nilai_mentah' => 75],

            // A8 - Reysa Rismawati
            ['siswa_kode' => 'A8', 'kriteria_kode' => 'C1', 'nilai_mentah' => 45],
            ['siswa_kode' => 'A8', 'kriteria_kode' => 'C2', 'nilai_mentah' => 100],
            ['siswa_kode' => 'A8', 'kriteria_kode' => 'C3', 'nilai_mentah' => 80],
            ['siswa_kode' => 'A8', 'kriteria_kode' => 'C4', 'nilai_mentah' => 80],
            ['siswa_kode' => 'A8', 'kriteria_kode' => 'C5', 'nilai_mentah' => 80],
            ['siswa_kode' => 'A8', 'kriteria_kode' => 'C6', 'nilai_mentah' => 100]
        ];

        foreach ($penilaianData as $p) {
            $siswa = Siswa::where('kode', $p['siswa_kode'])->first();
            $kriteria = Kriteria::where('kode', $p['kriteria_kode'])->first();

            if ($siswa && $kriteria) {
                Penilaian::create([
                    'siswa_id' => $siswa->id,
                    'kriteria_id' => $kriteria->id,
                    'nilai_mentah' => $p['nilai_mentah']
                ]);
            }
        }
    }
}
