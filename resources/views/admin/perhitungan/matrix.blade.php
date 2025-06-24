@extends('layouts.app')

@section('title', 'Matrix Data Perhitungan - SPK CPI')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-primary mb-1">Matrix Data Perhitungan</h2>
                    <p class="text-muted mb-0">Tabel matrix nilai mentah semua siswa untuk semua kriteria</p>
                </div>
                <div>
                    <a href="{{ route('admin.perhitungan.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <button onclick="window.print()" class="btn btn-success">
                        <i class="fas fa-print me-2"></i>Cetak Matrix
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Kriteria -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-info-circle text-info me-2"></i>Informasi Kriteria</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($kriteria as $k)
                            <div class="col-lg-2 col-md-4 col-6 mb-2">
                                <div class="border rounded p-2 text-center">
                                    <span class="badge bg-secondary mb-1">{{ $k->kode }}</span>
                                    <div class="small">
                                        <strong>{{ $k->nama }}</strong><br>
                                        <span class="text-muted">{{ $k->tren }} |
                                            {{ number_format($k->bobot * 100, 1) }}%</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Matrix Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-table text-primary me-2"></i>Matrix Nilai Mentah</h5>
        </div>
        <div class="card-body">
            @if (count($matrixData) > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th width="50" class="text-center">No</th>
                                <th width="80">Kode</th>
                                <th>Nama Siswa</th>
                                @foreach ($kriteria as $k)
                                    <th width="80" class="text-center">
                                        <div>{{ $k->kode }}</div>
                                        <small class="opacity-75">({{ number_format($k->bobot * 100, 1) }}%)</small>
                                    </th>
                                @endforeach
                                <th width="80" class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($matrixData as $index => $row)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $row['siswa']->kode }}</span>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $row['siswa']->nama }}</strong>
                                            @if ($row['siswa']->jenis_kelamin)
                                                <br><small class="text-muted">{{ $row['siswa']->jenis_kelamin }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    @foreach ($kriteria as $k)
                                        <td class="text-center">
                                            @if (isset($row['kriteria_data'][$k->kode]) && $row['kriteria_data'][$k->kode] !== null)
                                                @php
                                                    $nilai = $row['kriteria_data'][$k->kode];
                                                    $colorClass = '';
                                                    if ($nilai >= 81) {
                                                        $colorClass = 'text-success fw-bold';
                                                    } elseif ($nilai >= 61) {
                                                        $colorClass = 'text-primary fw-bold';
                                                    } elseif ($nilai >= 41) {
                                                        $colorClass = 'text-info fw-bold';
                                                    } elseif ($nilai >= 21) {
                                                        $colorClass = 'text-warning fw-bold';
                                                    } else {
                                                        $colorClass = 'text-danger fw-bold';
                                                    }
                                                @endphp
                                                <span class="{{ $colorClass }}">{{ number_format($nilai, 0) }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    @endforeach
                                    <td class="text-center">
                                        @php
                                            $nilaiTerisi = collect($row['kriteria_data'])
                                                ->filter(function ($nilai) {
                                                    return $nilai !== null;
                                                })
                                                ->count();
                                            $totalKriteria = $kriteria->count();
                                        @endphp
                                        @if ($nilaiTerisi == $totalKriteria)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check"></i> Lengkap
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                {{ $nilaiTerisi }}/{{ $totalKriteria }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="3" class="text-end">Statistik:</th>
                                @foreach ($kriteria as $k)
                                    @php
                                        $nilaiKriteria = collect($matrixData)
                                            ->pluck('kriteria_data.' . $k->kode)
                                            ->filter();
                                        $min = $nilaiKriteria->min();
                                        $max = $nilaiKriteria->max();
                                        $avg = $nilaiKriteria->avg();
                                    @endphp
                                    <th class="text-center">
                                        <div class="small">
                                            <div>Min: {{ $min ? number_format($min, 0) : '-' }}</div>
                                            <div>Max: {{ $max ? number_format($max, 0) : '-' }}</div>
                                            <div>Avg: {{ $avg ? number_format($avg, 1) : '-' }}</div>
                                        </div>
                                    </th>
                                @endforeach
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Legend -->
                <div class="mt-3">
                    <h6 class="fw-bold">Keterangan Warna Nilai:</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-1">
                                <span class="badge bg-success me-2">81-100</span>
                                <span class="small">Sangat Baik</span>
                            </div>
                            <div class="d-flex align-items-center mb-1">
                                <span class="badge bg-primary me-2">61-80</span>
                                <span class="small">Baik</span>
                            </div>
                            <div class="d-flex align-items-center mb-1">
                                <span class="badge bg-info me-2">41-60</span>
                                <span class="small">Cukup</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-1">
                                <span class="badge bg-warning me-2">21-40</span>
                                <span class="small">Kurang</span>
                            </div>
                            <div class="d-flex align-items-center mb-1">
                                <span class="badge bg-danger me-2">0-20</span>
                                <span class="small">Sangat Kurang</span>
                            </div>
                            <div class="d-flex align-items-center mb-1">
                                <span class="badge bg-secondary me-2">-</span>
                                <span class="small">Belum Dinilai</span>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-table text-muted" style="font-size: 3rem;"></i>
                    <h5 class="mt-3 text-muted">Belum Ada Data</h5>
                    <p class="text-muted">Matrix tidak dapat ditampilkan karena belum ada data siswa atau kriteria.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Analisis Matrix -->
    @if (count($matrixData) > 0)
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-bar text-success me-2"></i>Analisis Matrix</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <h6 class="fw-bold text-primary">Kelengkapan Data:</h6>
                        @php
                            $totalSiswa = count($matrixData);
                            $siswaLengkap = collect($matrixData)
                                ->filter(function ($row) use ($kriteria) {
                                    $nilaiTerisi = collect($row['kriteria_data'])
                                        ->filter(function ($nilai) {
                                            return $nilai !== null;
                                        })
                                        ->count();
                                    return $nilaiTerisi == $kriteria->count();
                                })
                                ->count();
                            $persentaseLengkap = $totalSiswa > 0 ? ($siswaLengkap / $totalSiswa) * 100 : 0;
                        @endphp
                        <div class="progress mb-2" style="height: 25px;">
                            <div class="progress-bar bg-success" style="width: {{ $persentaseLengkap }}%">
                                {{ number_format($persentaseLengkap, 1) }}%
                            </div>
                        </div>
                        <p class="small text-muted">{{ $siswaLengkap }} dari {{ $totalSiswa }} siswa memiliki data
                            lengkap</p>
                    </div>

                    <div class="col-md-4">
                        <h6 class="fw-bold text-success">Kriteria Terlengkap:</h6>
                        @php
                            $kriteriaStats = [];
                            foreach ($kriteria as $k) {
                                $nilaiTerisi = collect($matrixData)
                                    ->pluck('kriteria_data.' . $k->kode)
                                    ->filter()
                                    ->count();
                                $kriteriaStats[] = [
                                    'kode' => $k->kode,
                                    'nama' => $k->nama,
                                    'terisi' => $nilaiTerisi,
                                    'persentase' => ($nilaiTerisi / $totalSiswa) * 100,
                                ];
                            }
                            $kriteriaStats = collect($kriteriaStats)->sortByDesc('terisi')->take(3);
                        @endphp
                        @foreach ($kriteriaStats as $stat)
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small">{{ $stat['kode'] }}</span>
                                <span class="small fw-bold text-success">{{ $stat['terisi'] }}/{{ $totalSiswa }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="col-md-4">
                        <h6 class="fw-bold text-warning">Perlu Perhatian:</h6>
                        @php
                            $siswaKurang = collect($matrixData)
                                ->filter(function ($row) use ($kriteria) {
                                    $nilaiTerisi = collect($row['kriteria_data'])
                                        ->filter(function ($nilai) {
                                            return $nilai !== null;
                                        })
                                        ->count();
                                    return $nilaiTerisi < $kriteria->count();
                                })
                                ->take(3);
                        @endphp
                        @foreach ($siswaKurang as $siswa)
                            @php
                                $nilaiTerisi = collect($siswa['kriteria_data'])
                                    ->filter(function ($nilai) {
                                        return $nilai !== null;
                                    })
                                    ->count();
                            @endphp
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small">{{ $siswa['siswa']->kode }}</span>
                                <span
                                    class="small fw-bold text-warning">{{ $nilaiTerisi }}/{{ $kriteria->count() }}</span>
                            </div>
                        @endforeach
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
            }

            .table {
                font-size: 10px;
            }
        }
    </style>
@endpush
