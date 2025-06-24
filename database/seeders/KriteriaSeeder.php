<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kriteria;

class KriteriaSeeder extends Seeder
{
    public function run()
    {
        $kriteria = [
            [
                'kode' => 'C1',
                'nama' => 'Keterampilan Sosial-Emosional',
                'tren' => 'Positif',
                'bobot' => 0.200,
                'keterangan' => 'Kemampuan anak dalam berinteraksi sosial dan mengelola emosi'
            ],
            [
                'kode' => 'C2',
                'nama' => 'Keterampilan Kognitif',
                'tren' => 'Positif',
                'bobot' => 0.200,
                'keterangan' => 'Kemampuan berpikir, memecahkan masalah, dan memahami konsep dasar'
            ],
            [
                'kode' => 'C3',
                'nama' => 'Keterampilan Psikomotorik',
                'tren' => 'Positif',
                'bobot' => 0.150,
                'keterangan' => 'Kemampuan motorik halus dan kasar anak'
            ],
            [
                'kode' => 'C4',
                'nama' => 'Dukungan Orang Tua',
                'tren' => 'Positif',
                'bobot' => 0.150,
                'keterangan' => 'Tingkat dukungan dan keterlibatan orang tua dalam pendidikan anak'
            ],
            [
                'kode' => 'C5',
                'nama' => 'Kemandirian',
                'tren' => 'Positif',
                'bobot' => 0.150,
                'keterangan' => 'Kemampuan anak untuk melakukan aktivitas secara mandiri'
            ],
            [
                'kode' => 'C6',
                'nama' => 'Tingkat Kecemasan',
                'tren' => 'Negatif',
                'bobot' => 0.150,
                'keterangan' => 'Tingkat kecemasan anak dalam menghadapi situasi baru'
            ]
        ];

        foreach ($kriteria as $k) {
            Kriteria::create($k);
        }
    }
}
