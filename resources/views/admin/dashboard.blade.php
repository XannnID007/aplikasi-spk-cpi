@extends('layouts.app')

@section('title', 'Dashboard Admin - SPK CPI')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-primary mb-1">Dashboard Admin</h2>
                    <p class="text-muted mb-0">Selamat datang di Sistem Pendukung Keputusan CPI</p>
                </div>
                <div>
                    <span class="badge bg-primary fs-6 px-3 py-2">
                        <i class="fas fa-calendar me-2"></i>{{ date('d F Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="fw-bold mb-1">{{ $totalSiswa }}</h3>
                        <p class="mb-0 opacity-75">Total Siswa</p>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="fas fa-child"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card success">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="fw-bold mb-1">{{ $totalKriteria }}</h3>
                        <p class="mb-0 opacity-75">Total Kriteria</p>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="fas fa-list-check"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card warning">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="fw-bold mb-1">{{ $totalPenilaian }}</h3>
                        <p class="mb-0 opacity-75">Total Penilaian</p>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="fas fa-edit"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card danger">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="fw-bold mb-1">{{ number_format($rataRataSkor, 1) }}%</h3>
                        <p class="mb-0 opacity-75">Rata-rata Skor</p>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Siswa Terbaik -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-trophy text-warning me-2"></i>Siswa Terbaik</h5>
                </div>
                <div class="card-body">
                    @if ($siswaTebaik)
                        <div class="text-center">
                            <div class="mb-3">
                                <i class="fas fa-medal text-warning" style="font-size: 3rem;"></i>
                            </div>
                            <h5 class="fw-bold text-primary">{{ $siswaTebaik->siswa->nama }}</h5>
                            <p class="text-muted mb-2">{{ $siswaTebaik->siswa->kode }}</p>
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="border-end">
                                        <h6 class="text-primary fw-bold">{{ number_format($siswaTebaik->skor_total, 2) }}
                                        </h6>
                                        <small class="text-muted">Skor Total</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="border-end">
                                        <h6 class="text-success fw-bold">{{ $siswaTebaik->peringkat }}</h6>
                                        <small class="text-muted">Peringkat</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <h6 class="text-warning fw-bold">{{ number_format($siswaTebaik->persentase, 1) }}%</h6>
                                    <small class="text-muted">Persentase</small>
                                </div>
                            </div>
                            <div class="mt-3">
                                <span class="badge bg-{{ $siswaTebaik->warna_kategori }} fs-6 px-3 py-2">
                                    {{ $siswaTebaik->kategori_kesiapan }}
                                </span>
                            </div>
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-info-circle fs-1 mb-3"></i>
                            <p>Belum ada hasil perhitungan CPI</p>
                            <a href="{{ route('admin.penilaian.index') }}" class="btn btn-primary btn-sm">
                                Input Penilaian
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-bolt text-primary me-2"></i>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.siswa.create') }}" class="btn btn-outline-primary">
                            <i class="fas fa-plus me-2"></i>Tambah Siswa Baru
                        </a>
                        <a href="{{ route('admin.penilaian.create') }}" class="btn btn-outline-success">
                            <i class="fas fa-edit me-2"></i>Input Penilaian
                        </a>
                        <form action="{{ route('admin.hitung-cpi') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-warning w-100"
                                onclick="return confirm('Yakin ingin menghitung ulang CPI? Data hasil sebelumnya akan dihapus.')">
                                <i class="fas fa-calculator me-2"></i>Hitung CPI
                            </button>
                        </form>
                        <a href="{{ route('admin.cetak-hasil') }}" target="_blank" class="btn btn-outline-info">
                            <i class="fas fa-print me-2"></i>Cetak Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top 5 Peringkat -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-ranking-star text-success me-2"></i>Top 5 Peringkat</h5>
                </div>
                <div class="card-body">
                    @if ($grafikPeringkat->count() > 0)
                        @foreach ($grafikPeringkat as $index => $hasil)
                            <div class="d-flex align-items-center mb-3 {{ $index < 4 ? 'border-bottom pb-3' : '' }}">
                                <div class="me-3">
                                    @if ($hasil->peringkat == 1)
                                        <i class="fas fa-medal text-warning fs-4"></i>
                                    @elseif($hasil->peringkat == 2)
                                        <i class="fas fa-medal text-secondary fs-4"></i>
                                    @elseif($hasil->peringkat == 3)
                                        <i class="fas fa-medal text-danger fs-4"></i>
                                    @else
                                        <span class="badge bg-primary rounded-circle"
                                            style="width: 30px; height: 30px; line-height: 20px;">{{ $hasil->peringkat }}</span>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $hasil->siswa->nama }}</h6>
                                    <small class="text-muted">{{ number_format($hasil->persentase, 1) }}% -
                                        {{ $hasil->kategori_kesiapan }}</small>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center text-muted py-3">
                            <i class="fas fa-chart-line fs-1 mb-2"></i>
                            <p class="mb-0">Belum ada data peringkat</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Distribusi Kategori Kesiapan -->
    @if ($distribusiKategori->count() > 0)
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-chart-pie text-info me-2"></i>Distribusi Kategori Kesiapan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($distribusiKategori as $kategori)
                                <div class="col-lg-2 col-md-4 col-6 mb-3 text-center">
                                    <div class="p-3 border rounded">
                                        <h4 class="fw-bold text-primary mb-1">{{ $kategori->total }}</h4>
                                        <p class="mb-1 small">{{ $kategori->kategori_kesiapan }}</p>
                                        <small
                                            class="text-muted">{{ number_format(($kategori->total / $totalSiswa) * 100, 1) }}%</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
