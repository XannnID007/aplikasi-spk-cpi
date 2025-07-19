@extends('layouts.app')

@section('title', 'Proses Normalisasi - SPK CPI')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-primary mb-1">Proses Normalisasi CPI</h2>
                    <p class="text-muted mb-0">Detail proses normalisasi nilai per kriteria dengan rumus yang digunakan</p>
                </div>
                <div>
                    <a href="{{ route('admin.perhitungan.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <button onclick="window.print()" class="btn btn-success">
                        <i class="fas fa-print me-2"></i>Cetak Normalisasi
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Rumus Normalisasi -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-formula text-info me-2"></i>Rumus Normalisasi CPI</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="alert alert-success">
                                <h6 class="fw-bold mb-2">
                                    <i class="fas fa-arrow-up me-2"></i>Tren Positif (Benefit)
                                </h6>
                                <div class="text-center mb-2">
                                    <code class="fs-6">Normalisasi = (Nilai Alternatif / Nilai Minimum) × 100</code>
                                </div>
                                <small class="text-muted">
                                    Semakin tinggi nilai semakin baik. Nilai minimum dijadikan pembanding untuk menghasilkan
                                    nilai ≥ 100.
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="alert alert-warning">
                                <h6 class="fw-bold mb-2">
                                    <i class="fas fa-arrow-down me-2"></i>Tren Negatif (Cost)
                                </h6>
                                <div class="text-center mb-2">
                                    <code class="fs-6">Normalisasi = (Nilai Minimum / Nilai Alternatif) × 100</code>
                                </div>
                                <small class="text-muted">
                                    Semakin rendah nilai semakin baik. Nilai minimum mendapat skor tertinggi.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Normalisasi per Kriteria -->
    @foreach ($normalisasiData as $kode => $data)
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <span class="badge bg-secondary me-2">{{ $data['kriteria']->kode }}</span>
                        {{ $data['kriteria']->nama }}
                    </h5>
                    <div>
                        <span
                            class="badge bg-{{ $data['kriteria']->tren === 'Positif' ? 'success' : 'warning' }} px-3 py-2">
                            <i
                                class="fas fa-{{ $data['kriteria']->tren === 'Positif' ? 'arrow-up' : 'arrow-down' }} me-1"></i>
                            {{ $data['kriteria']->tren }}
                        </span>
                        <span class="badge bg-primary px-3 py-2 ms-1">
                            Bobot: {{ number_format($data['kriteria']->bobot * 100, 1) }}%
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- Statistik Kriteria -->
                <div class="row mb-3">
                    <div class="col-md-3 text-center">
                        <div class="border rounded p-2">
                            <h6 class="text-info fw-bold mb-1">{{ number_format($data['nilai_min'], 0) }}</h6>
                            <small class="text-muted">Nilai Minimum</small>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="border rounded p-2">
                            <h6 class="text-success fw-bold mb-1">{{ number_format($data['nilai_max'], 0) }}</h6>
                            <small class="text-muted">Nilai Maksimum</small>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="border rounded p-2">
                            <h6 class="text-primary fw-bold mb-1">{{ number_format($data['rata_rata'], 1) }}</h6>
                            <small class="text-muted">Rata-rata</small>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="border rounded p-2">
                            <h6 class="text-warning fw-bold mb-1">{{ $data['data_penilaian']->count() }}</h6>
                            <small class="text-muted">Jumlah Data</small>
                        </div>
                    </div>
                </div>

                <!-- Tabel Normalisasi -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Siswa</th>
                                <th width="100" class="text-center">Nilai Mentah</th>
                                <th width="200">Rumus Normalisasi</th>
                                <th width="120" class="text-center">Hasil Normalisasi</th>
                                <th width="120" class="text-center">Nilai Terbobot</th>
                                <th width="100" class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['data_penilaian'] as $penilaian)
                                <tr>
                                    <td>
                                        <div>
                                            <span class="badge bg-primary me-2">{{ $penilaian['siswa']->kode }}</span>
                                            <strong>{{ $penilaian['siswa']->nama }}</strong>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="fw-bold fs-6">{{ number_format($penilaian['nilai_mentah'], 0) }}</span>
                                    </td>
                                    <td>
                                        @if ($data['kriteria']->tren === 'Positif')
                                            <code class="small">
                                                ({{ number_format($penilaian['nilai_mentah'], 0) }} /
                                                {{ number_format($data['nilai_min'], 0) }})
                                                × 100
                                            </code>
                                        @else
                                            <code class="small">
                                                ({{ number_format($data['nilai_min'], 0) }} /
                                                {{ number_format($penilaian['nilai_mentah'], 0) }}) × 100
                                            </code>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="fw-bold text-primary">{{ number_format($penilaian['nilai_normalisasi_calculated'], 2) }}</span>
                                        @if ($penilaian['nilai_normalisasi_stored'])
                                            <br><small class="text-muted">(DB:
                                                {{ number_format($penilaian['nilai_normalisasi_stored'], 2) }})</small>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="fw-bold text-success">{{ number_format($penilaian['nilai_terbobot'], 2) }}</span>
                                        <br><small class="text-muted">
                                            {{ number_format($penilaian['nilai_normalisasi_calculated'], 2) }} ×
                                            {{ number_format($data['kriteria']->bobot, 3) }}
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $selisih = abs(
                                                $penilaian['nilai_normalisasi_calculated'] -
                                                    ($penilaian['nilai_normalisasi_stored'] ?? 0),
                                            );
                                        @endphp
                                        @if ($penilaian['nilai_normalisasi_stored'] && $selisih < 0.01)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check"></i> Valid
                                            </span>
                                        @elseif($penilaian['nilai_normalisasi_stored'])
                                            <span class="badge bg-warning">
                                                <i class="fas fa-exclamation-triangle"></i> Beda
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-minus"></i> Kosong
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th>Total Kontribusi:</th>
                                <th class="text-center">-</th>
                                <th>-</th>
                                <th class="text-center">
                                    <span class="fw-bold text-primary">
                                        {{ number_format($data['data_penilaian']->sum('nilai_normalisasi_calculated'), 2) }}
                                    </span>
                                </th>
                                <th class="text-center">
                                    <span class="fw-bold text-success">
                                        {{ number_format($data['data_penilaian']->sum('nilai_terbobot'), 2) }}
                                    </span>
                                </th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Analisis per Kriteria -->
                <div class="mt-3">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold text-primary">Analisis Distribusi:</h6>
                            @php
                                $nilaiTertinggi = $data['data_penilaian']->max('nilai_normalisasi_calculated');
                                $nilaiTerendah = $data['data_penilaian']->min('nilai_normalisasi_calculated');
                                $rataRataNormalisasi = $data['data_penilaian']->avg('nilai_normalisasi_calculated');
                            @endphp
                            <ul class="small mb-0">
                                <li>Normalisasi tertinggi: <strong>{{ number_format($nilaiTertinggi, 2) }}</strong></li>
                                <li>Normalisasi terendah: <strong>{{ number_format($nilaiTerendah, 2) }}</strong></li>
                                <li>Rata-rata normalisasi: <strong>{{ number_format($rataRataNormalisasi, 2) }}</strong>
                                </li>
                                <li>Range: <strong>{{ number_format($nilaiTertinggi - $nilaiTerendah, 2) }}</strong></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold text-success">Kontribusi terhadap CPI:</h6>
                            @php
                                $kontribusiTertinggi = $data['data_penilaian']->max('nilai_terbobot');
                                $kontribusiTerendah = $data['data_penilaian']->min('nilai_terbobot');
                                $rataRataKontribusi = $data['data_penilaian']->avg('nilai_terbobot');
                            @endphp
                            <ul class="small mb-0">
                                <li>Kontribusi tertinggi: <strong>{{ number_format($kontribusiTertinggi, 2) }}</strong>
                                </li>
                                <li>Kontribusi terendah: <strong>{{ number_format($kontribusiTerendah, 2) }}</strong></li>
                                <li>Rata-rata kontribusi: <strong>{{ number_format($rataRataKontribusi, 2) }}</strong></li>
                                <li>Bobot kriteria:
                                    <strong>{{ number_format($data['kriteria']->bobot * 100, 1) }}%</strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @if (count($normalisasiData) == 0)
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-calculator text-muted" style="font-size: 4rem;"></i>
                <h4 class="mt-3 text-muted">Belum Ada Data Normalisasi</h4>
                <p class="text-muted">Data normalisasi belum tersedia. Pastikan sudah ada data penilaian untuk setiap
                    kriteria.</p>
                <a href="{{ route('admin.penilaian.index') }}" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i>Kelola Penilaian
                </a>
            </div>
        </div>
    @endif

    <!-- Ringkasan Normalisasi -->
    @if (count($normalisasiData) > 0)
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-bar text-info me-2"></i>Ringkasan Proses Normalisasi</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <h6 class="fw-bold text-primary">Statistik Umum:</h6>
                        @php
                            $totalKriteria = count($normalisasiData);
                            $totalPenilaian = collect($normalisasiData)->sum(function ($data) {
                                return $data['data_penilaian']->count();
                            });
                            $kriteriaPositif = collect($normalisasiData)
                                ->filter(function ($data) {
                                    return $data['kriteria']->tren === 'Positif';
                                })
                                ->count();
                            $kriteriaNegatif = $totalKriteria - $kriteriaPositif;
                        @endphp
                        <ul class="small">
                            <li>Total kriteria dinormalisasi: <strong>{{ $totalKriteria }}</strong></li>
                            <li>Total data penilaian: <strong>{{ $totalPenilaian }}</strong></li>
                            <li>Kriteria tren positif: <strong>{{ $kriteriaPositif }}</strong></li>
                            <li>Kriteria tren negatif: <strong>{{ $kriteriaNegatif }}</strong></li>
                        </ul>
                    </div>

                    <div class="col-md-4">
                        <h6 class="fw-bold text-success">Validasi Data:</h6>
                        @php
                            $totalBobot = collect($normalisasiData)->sum(function ($data) {
                                return $data['kriteria']->bobot;
                            });
                            $validasiBobot = abs($totalBobot - 1.0) < 0.001;
                        @endphp
                        <ul class="small">
                            <li>Total bobot kriteria:
                                <strong class="text-{{ $validasiBobot ? 'success' : 'danger' }}">
                                    {{ number_format($totalBobot * 100, 1) }}%
                                </strong>
                            </li>
                            <li>Status validasi bobot:
                                <span class="badge bg-{{ $validasiBobot ? 'success' : 'danger' }}">
                                    {{ $validasiBobot ? 'Valid' : 'Tidak Valid' }}
                                </span>
                            </li>
                            <li>Metode normalisasi: <strong>CPI Standard</strong></li>
                        </ul>
                    </div>

                    <div class="col-md-4">
                        <h6 class="fw-bold text-warning">Langkah Selanjutnya:</h6>
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.hitung-cpi') }}" class="btn btn-sm btn-warning"
                                onclick="return confirm('Yakin ingin menghitung ulang CPI?')">
                                <i class="fas fa-calculator me-1"></i>Hitung Ulang CPI
                            </a>
                            <a href="{{ route('admin.hasil-cpi.index') }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-chart-line me-1"></i>Lihat Hasil Final
                            </a>
                            <a href="{{ route('admin.perhitungan.matrix') }}" class="btn btn-sm btn-info">
                                <i class="fas fa-table me-1"></i>Matrix Data
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    <style>
        @media print {

            .btn,
            .card-header,
            nav,
            .sidebar {
                display: none !important;
            }

            .main-content {
                margin-left: 0 !important;
                margin-top: 0 !important;
            }

            .card {
                border: 1px solid #ddd !important;
                box-shadow: none !important;
                break-inside: avoid;
            }

            .table {
                font-size: 10px;
            }
        }
    </style>
@endpush
