<?php

namespace App\Services;

use App\Models\Siswa;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\HasilCpi;

class CpiService
{
     public function hitungCpi()
     {
          $siswa = Siswa::all();
          $kriteria = Kriteria::all();

          // Reset hasil sebelumnya
          HasilCpi::truncate();

          // Hitung normalisasi untuk setiap kriteria
          foreach ($kriteria as $k) {
               $nilaiKriteria = Penilaian::where('kriteria_id', $k->id)->pluck('nilai_mentah');

               if ($k->tren == 'Positif') {
                    $nilaiMin = $nilaiKriteria->min();
                    foreach ($siswa as $s) {
                         $penilaian = Penilaian::where('siswa_id', $s->id)
                              ->where('kriteria_id', $k->id)
                              ->first();
                         if ($penilaian) {
                              $normalisasi = ($penilaian->nilai_mentah / $nilaiMin) * 100;
                              $terbobot = $normalisasi * $k->bobot;

                              $penilaian->update([
                                   'nilai_normalisasi' => $normalisasi,
                                   'nilai_terbobot' => $terbobot
                              ]);
                         }
                    }
               } else { // Negatif
                    $nilaiMin = $nilaiKriteria->min();
                    foreach ($siswa as $s) {
                         $penilaian = Penilaian::where('siswa_id', $s->id)
                              ->where('kriteria_id', $k->id)
                              ->first();
                         if ($penilaian) {
                              $normalisasi = ($nilaiMin / $penilaian->nilai_mentah) * 100;
                              $terbobot = $normalisasi * $k->bobot;

                              $penilaian->update([
                                   'nilai_normalisasi' => $normalisasi,
                                   'nilai_terbobot' => $terbobot
                              ]);
                         }
                    }
               }
          }

          // Hitung total skor CPI untuk setiap siswa
          $hasilCpi = [];
          foreach ($siswa as $s) {
               $totalSkor = Penilaian::where('siswa_id', $s->id)->sum('nilai_terbobot');
               $hasilCpi[] = [
                    'siswa_id' => $s->id,
                    'skor_total' => $totalSkor
               ];
          }

          // Urutkan berdasarkan skor dan beri peringkat
          usort($hasilCpi, function ($a, $b) {
               return $b['skor_total'] <=> $a['skor_total'];
          });

          // PERBAIKAN: Gunakan nilai referensi 150 (nilai maksimum teoritis) 
          // seperti yang digunakan di Excel, bukan nilai tertinggi aktual
          $nilaiReferensi = 150; // Nilai maksimum teoritis CPI

          foreach ($hasilCpi as $index => $hasil) {
               // Hitung persentase berdasarkan nilai referensi 150
               $persentase = ($hasil['skor_total'] / $nilaiReferensi) * 100;
               $rekomendasi = $this->buatRekomendasi($persentase);

               HasilCpi::create([
                    'siswa_id' => $hasil['siswa_id'],
                    'skor_total' => $hasil['skor_total'],
                    'peringkat' => $index + 1,
                    'persentase' => $persentase,
                    'rekomendasi' => $rekomendasi
               ]);
          }
     }

     private function buatRekomendasi($persentase)
     {
          if ($persentase >= 90) {
               return 'Anak sudah sangat siap untuk transisi ke sekolah dasar. Pertahankan pencapaian dan berikan tantangan yang lebih tinggi.';
          } elseif ($persentase >= 80) {
               return 'Anak siap untuk transisi ke sekolah dasar. Lakukan pemantauan berkala untuk memastikan kesiapan tetap optimal.';
          } elseif ($persentase >= 70) {
               return 'Anak cukup siap untuk transisi ke sekolah dasar. Perlu bimbingan tambahan di beberapa aspek.';
          } elseif ($persentase >= 60) {
               return 'Anak kurang siap untuk transisi ke sekolah dasar. Perlu perhatian khusus dan program persiapan intensif.';
          } else {
               return 'Anak belum siap untuk transisi ke sekolah dasar. Perlu program persiapan komprehensif dan waktu tambahan.';
          }
     }
}
