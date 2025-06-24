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
        // Konversi dari skala 1-5 ke skala 0-100: 1=20, 2=40, 3=60, 4=80, 5=100
        $penilaianData = [
            // A1 - Akhdan Latif Azizan (C1=5->100, C2=3->60, C3=3->60, C4=3->60, C5=4->80, C6=4->80)
            ['siswa_kode' => 'A1', 'kriteria_kode' => 'C1', 'nilai_mentah' => 100],
            ['siswa_kode' => 'A1', 'kriteria_kode' => 'C2', 'nilai_mentah' => 60],
            ['siswa_kode' => 'A1', 'kriteria_kode' => 'C3', 'nilai_mentah' => 60],
            ['siswa_kode' => 'A1', 'kriteria_kode' => 'C4', 'nilai_mentah' => 60],
            ['siswa_kode' => 'A1', 'kriteria_kode' => 'C5', 'nilai_mentah' => 80],
            ['siswa_kode' => 'A1', 'kriteria_kode' => 'C6', 'nilai_mentah' => 80],

            // A2 - Nayaka Dzakiyah Rafifah (C1=4->80, C2=3->60, C3=3->60, C4=4->80, C5=3->60, C6=4->80)
            ['siswa_kode' => 'A2', 'kriteria_kode' => 'C1', 'nilai_mentah' => 80],
            ['siswa_kode' => 'A2', 'kriteria_kode' => 'C2', 'nilai_mentah' => 60],
            ['siswa_kode' => 'A2', 'kriteria_kode' => 'C3', 'nilai_mentah' => 60],
            ['siswa_kode' => 'A2', 'kriteria_kode' => 'C4', 'nilai_mentah' => 80],
            ['siswa_kode' => 'A2', 'kriteria_kode' => 'C5', 'nilai_mentah' => 60],
            ['siswa_kode' => 'A2', 'kriteria_kode' => 'C6', 'nilai_mentah' => 80],

            // A3 - Hayfa Hanum Hanania (C1=5->100, C2=5->100, C3=5->100, C4=4->80, C5=5->100, C6=4->80)
            ['siswa_kode' => 'A3', 'kriteria_kode' => 'C1', 'nilai_mentah' => 100],
            ['siswa_kode' => 'A3', 'kriteria_kode' => 'C2', 'nilai_mentah' => 100],
            ['siswa_kode' => 'A3', 'kriteria_kode' => 'C3', 'nilai_mentah' => 100],
            ['siswa_kode' => 'A3', 'kriteria_kode' => 'C4', 'nilai_mentah' => 80],
            ['siswa_kode' => 'A3', 'kriteria_kode' => 'C5', 'nilai_mentah' => 100],
            ['siswa_kode' => 'A3', 'kriteria_kode' => 'C6', 'nilai_mentah' => 80],

            // A4 - Katya Yumna Aafiyah (C1=4->80, C2=4->80, C3=5->100, C4=3->60, C5=4->80, C6=5->100)
            ['siswa_kode' => 'A4', 'kriteria_kode' => 'C1', 'nilai_mentah' => 80],
            ['siswa_kode' => 'A4', 'kriteria_kode' => 'C2', 'nilai_mentah' => 80],
            ['siswa_kode' => 'A4', 'kriteria_kode' => 'C3', 'nilai_mentah' => 100],
            ['siswa_kode' => 'A4', 'kriteria_kode' => 'C4', 'nilai_mentah' => 60],
            ['siswa_kode' => 'A4', 'kriteria_kode' => 'C5', 'nilai_mentah' => 80],
            ['siswa_kode' => 'A4', 'kriteria_kode' => 'C6', 'nilai_mentah' => 100],

            // A5 - Farell Putra Sagara (C1=4->80, C2=5->100, C3=3->60, C4=4->80, C5=4->80, C6=4->80)
            ['siswa_kode' => 'A5', 'kriteria_kode' => 'C1', 'nilai_mentah' => 80],
            ['siswa_kode' => 'A5', 'kriteria_kode' => 'C2', 'nilai_mentah' => 100],
            ['siswa_kode' => 'A5', 'kriteria_kode' => 'C3', 'nilai_mentah' => 60],
            ['siswa_kode' => 'A5', 'kriteria_kode' => 'C4', 'nilai_mentah' => 80],
            ['siswa_kode' => 'A5', 'kriteria_kode' => 'C5', 'nilai_mentah' => 80],
            ['siswa_kode' => 'A5', 'kriteria_kode' => 'C6', 'nilai_mentah' => 80],

            // A6 - Shakila Sopiyah Maulidia (C1=5->100, C2=5->100, C3=5->100, C4=4->80, C5=5->100, C6=5->100)
            ['siswa_kode' => 'A6', 'kriteria_kode' => 'C1', 'nilai_mentah' => 100],
            ['siswa_kode' => 'A6', 'kriteria_kode' => 'C2', 'nilai_mentah' => 100],
            ['siswa_kode' => 'A6', 'kriteria_kode' => 'C3', 'nilai_mentah' => 100],
            ['siswa_kode' => 'A6', 'kriteria_kode' => 'C4', 'nilai_mentah' => 80],
            ['siswa_kode' => 'A6', 'kriteria_kode' => 'C5', 'nilai_mentah' => 100],
            ['siswa_kode' => 'A6', 'kriteria_kode' => 'C6', 'nilai_mentah' => 100],

            // A7 - Safa Namira Hidayat (C1=4->80, C2=4->80, C3=3->60, C4=4->80, C5=4->80, C6=4->80)
            ['siswa_kode' => 'A7', 'kriteria_kode' => 'C1', 'nilai_mentah' => 80],
            ['siswa_kode' => 'A7', 'kriteria_kode' => 'C2', 'nilai_mentah' => 80],
            ['siswa_kode' => 'A7', 'kriteria_kode' => 'C3', 'nilai_mentah' => 60],
            ['siswa_kode' => 'A7', 'kriteria_kode' => 'C4', 'nilai_mentah' => 80],
            ['siswa_kode' => 'A7', 'kriteria_kode' => 'C5', 'nilai_mentah' => 80],
            ['siswa_kode' => 'A7', 'kriteria_kode' => 'C6', 'nilai_mentah' => 80],

            // A8 - Reysa Rismawati (C1=3->60, C2=5->100, C3=4->80, C4=4->80, C5=4->80, C6=3->60)
            ['siswa_kode' => 'A8', 'kriteria_kode' => 'C1', 'nilai_mentah' => 60],
            ['siswa_kode' => 'A8', 'kriteria_kode' => 'C2', 'nilai_mentah' => 100],
            ['siswa_kode' => 'A8', 'kriteria_kode' => 'C3', 'nilai_mentah' => 80],
            ['siswa_kode' => 'A8', 'kriteria_kode' => 'C4', 'nilai_mentah' => 80],
            ['siswa_kode' => 'A8', 'kriteria_kode' => 'C5', 'nilai_mentah' => 80],
            ['siswa_kode' => 'A8', 'kriteria_kode' => 'C6', 'nilai_mentah' => 60],
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
