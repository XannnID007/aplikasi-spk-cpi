<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Hasil CPI - PAUDQU QURROTA A'YUN</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 12px;
            line-height: 1.4;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }

        .header h2 {
            margin: 5px 0;
            font-size: 16px;
            color: #666;
        }

        .header p {
            margin: 5px 0;
            color: #888;
        }

        .info-laporan {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
            text-align: center;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            color: white;
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-primary {
            background-color: #007bff;
        }

        .badge-info {
            background-color: #17a2b8;
        }

        .badge-warning {
            background-color: #ffc107;
            color: #333;
        }

        .badge-danger {
            background-color: #dc3545;
        }

        .summary {
            display: flex;
            justify-content: space-around;
            margin: 30px 0;
            text-align: center;
        }

        .summary-item {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
            background-color: #f8f9fa;
        }

        .summary-number {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }

        .footer {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }

        .signature {
            text-align: center;
            width: 200px;
        }

        .signature-line {
            border-top: 1px solid #333;
            margin-top: 60px;
            padding-top: 5px;
        }

        @media print {
            body {
                margin: 0;
                font-size: 11px;
            }

            .no-print {
                display: none;
            }

            .page-break {
                page-break-before: always;
            }
        }

        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .print-button:hover {
            background: #0056b3;
        }
    </style>
</head>

<body>
    <!-- Print Button -->
    <button class="print-button no-print" onclick="window.print()">
        🖨️ Cetak Laporan
    </button>

    <!-- Header -->
    <div class="header">
        <h1>LAPORAN HASIL PENILAIAN KESIAPAN SISWA</h1>
        <h2>METODE COMPOSITE PERFORMANCE INDEX (CPI)</h2>
        <p>PAUDQU QURROTA A'YUN</p>
        <p>Banjar, Jawa Barat</p>
    </div>

    <!-- Info Laporan -->
    <div class="info-laporan">
        <div>Tanggal Cetak: {{ $tanggalCetak }}</div>
        <div>Total Siswa: {{ $hasilCpi->count() }} siswa</div>
    </div>

    @if ($hasilCpi->count() > 0)
        <!-- Ringkasan Statistik -->
        <div class="summary">
            <div class="summary-item">
                <div class="summary-number">{{ $hasilCpi->where('persentase', '>=', 90)->count() }}</div>
                <div>Sangat Siap</div>
            </div>
            <div class="summary-item">
                <div class="summary-number">
                    {{ $hasilCpi->where('persentase', '>=', 80)->where('persentase', '<', 90)->count() }}</div>
                <div>Siap</div>
            </div>
            <div class="summary-item">
                <div class="summary-number">
                    {{ $hasilCpi->where('persentase', '>=', 70)->where('persentase', '<', 80)->count() }}</div>
                <div>Cukup Siap</div>
            </div>
            <div class="summary-item">
                <div class="summary-number">
                    {{ $hasilCpi->where('persentase', '>=', 60)->where('persentase', '<', 70)->count() }}</div>
                <div>Kurang Siap</div>
            </div>
            <div class="summary-item">
                <div class="summary-number">{{ $hasilCpi->where('persentase', '<', 60)->count() }}</div>
                <div>Belum Siap</div>
            </div>
        </div>

        <!-- Tabel Hasil -->
        <table class="table">
            <thead>
                <tr>
                    <th width="40">No</th>
                    <th width="60">Peringkat</th>
                    <th width="80">Kode Siswa</th>
                    <th>Nama Siswa</th>
                    <th width="80">Jenis Kelamin</th>
                    <th width="80">Skor Total</th>
                    <th width="80">Persentase</th>
                    <th width="100">Kategori Kesiapan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($hasilCpi as $index => $hasil)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="text-center">
                            @if ($hasil->peringkat <= 3)
                                <strong>🏅 {{ $hasil->peringkat }}</strong>
                            @else
                                {{ $hasil->peringkat }}
                            @endif
                        </td>
                        <td class="text-center">{{ $hasil->siswa->kode }}</td>
                        <td>{{ $hasil->siswa->nama }}</td>
                        <td class="text-center">{{ $hasil->siswa->jenis_kelamin ?? '-' }}</td>
                        <td class="text-center">{{ number_format($hasil->skor_total, 2) }}</td>
                        <td class="text-center">{{ number_format($hasil->persentase, 1) }}%</td>
                        <td class="text-center">
                            <span class="badge badge-{{ $hasil->warna_kategori }}">
                                {{ $hasil->kategori_kesiapan }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Analisis Hasil -->
        <div style="margin-top: 30px;">
            <h3 style="color: #333; border-bottom: 1px solid #ddd; padding-bottom: 10px;">Analisis Hasil</h3>

            <table class="table" style="margin-top: 20px;">
                <tr>
                    <td><strong>Rata-rata Skor CPI:</strong></td>
                    <td>{{ number_format($hasilCpi->avg('skor_total'), 2) }}</td>
                </tr>
                <tr>
                    <td><strong>Rata-rata Persentase:</strong></td>
                    <td>{{ number_format($hasilCpi->avg('persentase'), 1) }}%</td>
                </tr>
                <tr>
                    <td><strong>Skor Tertinggi:</strong></td>
                    <td>{{ number_format($hasilCpi->max('skor_total'), 2) }}
                        ({{ $hasilCpi->where('peringkat', 1)->first()->siswa->nama }})</td>
                </tr>
                <tr>
                    <td><strong>Skor Terendah:</strong></td>
                    <td>{{ number_format($hasilCpi->min('skor_total'), 2) }}
                        ({{ $hasilCpi->sortByDesc('peringkat')->first()->siswa->nama }})</td>
                </tr>
                <tr>
                    <td><strong>Persentase Siswa Siap (≥70%):</strong></td>
                    <td>{{ number_format(($hasilCpi->where('persentase', '>=', 70)->count() / $hasilCpi->count()) * 100, 1) }}%
                    </td>
                </tr>
            </table>
        </div>

        <!-- Kesimpulan -->
        <div style="margin-top: 30px;">
            <h3 style="color: #333; border-bottom: 1px solid #ddd; padding-bottom: 10px;">Kesimpulan dan Rekomendasi
            </h3>

            <div style="margin-top: 20px; padding: 20px; background-color: #f8f9fa; border-left: 4px solid #007bff;">
                @php
                    $siswaSiap = $hasilCpi->where('persentase', '>=', 70)->count();
                    $totalSiswa = $hasilCpi->count();
                    $persentaseSiap = ($siswaSiap / $totalSiswa) * 100;
                @endphp

                <p><strong>Berdasarkan hasil penilaian menggunakan metode Composite Performance Index (CPI):</strong>
                </p>

                <ul style="margin: 15px 0; padding-left: 20px;">
                    <li>Dari {{ $totalSiswa }} siswa yang dinilai, {{ $siswaSiap }} siswa
                        ({{ number_format($persentaseSiap, 1) }}%) dinyatakan siap untuk transisi ke sekolah dasar.
                    </li>
                    <li>Rata-rata skor CPI adalah {{ number_format($hasilCpi->avg('skor_total'), 2) }} dengan
                        persentase {{ number_format($hasilCpi->avg('persentase'), 1) }}%.</li>
                    <li>Siswa dengan kesiapan terbaik adalah
                        <strong>{{ $hasilCpi->where('peringkat', 1)->first()->siswa->nama }}</strong> dengan skor
                        {{ number_format($hasilCpi->max('skor_total'), 2) }}.</li>
                </ul>

                <p><strong>Rekomendasi:</strong></p>
                <ul style="margin: 15px 0; padding-left: 20px;">
                    @if ($persentaseSiap >= 80)
                        <li>Secara keseluruhan, mayoritas siswa sudah siap untuk transisi ke sekolah dasar.</li>
                        <li>Pertahankan program pembelajaran yang sudah berjalan dengan baik.</li>
                        <li>Berikan perhatian khusus pada siswa yang masih memerlukan bimbingan tambahan.</li>
                    @elseif($persentaseSiap >= 60)
                        <li>Sebagian besar siswa sudah menunjukkan kesiapan yang cukup baik.</li>
                        <li>Perlu program tambahan untuk meningkatkan kesiapan siswa yang masih kurang.</li>
                        <li>Evaluasi dan perbaikan program pembelajaran di beberapa aspek kriteria.</li>
                    @else
                        <li>Perlu program persiapan intensif untuk meningkatkan kesiapan siswa secara keseluruhan.</li>
                        <li>Evaluasi menyeluruh terhadap kurikulum dan metode pembelajaran.</li>
                        <li>Kerjasama yang lebih erat dengan orang tua dalam mendukung perkembangan anak.</li>
                    @endif
                </ul>
            </div>
        </div>

        <!-- Kriteria Penilaian -->
        <div class="page-break" style="margin-top: 40px;">
            <h3 style="color: #333; border-bottom: 1px solid #ddd; padding-bottom: 10px;">Kriteria Penilaian CPI</h3>

            <table class="table" style="margin-top: 20px;">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Kriteria</th>
                        <th>Bobot</th>
                        <th>Tren</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>C1</td>
                        <td>Keterampilan Sosial-Emosional</td>
                        <td>20%</td>
                        <td>Positif</td>
                        <td>Kemampuan anak dalam berinteraksi sosial dan mengelola emosi</td>
                    </tr>
                    <tr>
                        <td>C2</td>
                        <td>Keterampilan Kognitif</td>
                        <td>20%</td>
                        <td>Positif</td>
                        <td>Kemampuan berpikir, memecahkan masalah, dan memahami konsep dasar</td>
                    </tr>
                    <tr>
                        <td>C3</td>
                        <td>Keterampilan Psikomotorik</td>
                        <td>15%</td>
                        <td>Positif</td>
                        <td>Kemampuan motorik halus dan kasar anak</td>
                    </tr>
                    <tr>
                        <td>C4</td>
                        <td>Dukungan Orang Tua</td>
                        <td>15%</td>
                        <td>Positif</td>
                        <td>Tingkat dukungan dan keterlibatan orang tua dalam pendidikan anak</td>
                    </tr>
                    <tr>
                        <td>C5</td>
                        <td>Kemandirian</td>
                        <td>15%</td>
                        <td>Positif</td>
                        <td>Kemampuan anak untuk melakukan aktivitas secara mandiri</td>
                    </tr>
                    <tr>
                        <td>C6</td>
                        <td>Tingkat Kecemasan</td>
                        <td>15%</td>
                        <td>Negatif</td>
                        <td>Tingkat kecemasan anak dalam menghadapi situasi baru</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Kategori Kesiapan -->
        <div style="margin-top: 30px;">
            <h3 style="color: #333; border-bottom: 1px solid #ddd; padding-bottom: 10px;">Kategori Kesiapan</h3>

            <table class="table" style="margin-top: 20px;">
                <thead>
                    <tr>
                        <th>Rentang Persentase</th>
                        <th>Kategori</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>≥ 90%</td>
                        <td><span class="badge badge-success">Sangat Siap</span></td>
                        <td>Anak sudah sangat siap untuk transisi ke sekolah dasar</td>
                    </tr>
                    <tr>
                        <td>80% - 89%</td>
                        <td><span class="badge badge-primary">Siap</span></td>
                        <td>Anak siap untuk transisi ke sekolah dasar</td>
                    </tr>
                    <tr>
                        <td>70% - 79%</td>
                        <td><span class="badge badge-info">Cukup Siap</span></td>
                        <td>Anak cukup siap dengan beberapa bimbingan tambahan</td>
                    </tr>
                    <tr>
                        <td>60% - 69%</td>
                        <td><span class="badge badge-warning">Kurang Siap</span></td>
                        <td>Anak perlu perhatian khusus dan program persiapan intensif</td>
                    </tr>
                    <tr>
                        <td>
                            < 60%</td>
                        <td><span class="badge badge-danger">Belum Siap</span></td>
                        <td>Anak belum siap dan memerlukan program persiapan komprehensif</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @else
        <div style="text-align: center; margin: 50px 0;">
            <h3 style="color: #666;">Belum Ada Data Hasil Penilaian</h3>
            <p>Laporan tidak dapat dibuat karena belum ada hasil perhitungan CPI.</p>
        </div>
    @endif

    <!-- Footer & Tanda Tangan -->
    <div class="footer">
        <div class="signature">
            <p>Mengetahui,</p>
            <p><strong>Kepala PAUDQU QURROTA A'YUN</strong></p>
            <div class="signature-line">
                <strong>(.............................)</strong>
            </div>
        </div>

        <div class="signature">
            <p>Banjar, {{ $tanggalCetak }}</p>
            <p><strong>Yang Membuat Laporan</strong></p>
            <div class="signature-line">
                <strong>{{ auth()->user()->name }}</strong>
            </div>
        </div>
    </div>

    <!-- Footer Info -->
    <div
        style="margin-top: 40px; text-align: center; font-size: 10px; color: #666; border-top: 1px solid #ddd; padding-top: 10px;">
        <p>Laporan ini dibuat secara otomatis oleh Sistem Pendukung Keputusan CPI - PAUDQU QURROTA A'YUN</p>
        <p>Dicetak pada: {{ now()->format('d F Y H:i:s') }}</p>
    </div>

</body>

</html>
