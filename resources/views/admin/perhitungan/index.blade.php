@extends('layouts.app')

@section('title', 'Data Perhitungan CPI - SPK CPI')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-primary mb-1">Data Perhitungan CPI</h2>
                    <p class="text-muted mb-0">Detail proses perhitungan Composite Performance Index</p>
                </div>
                <div>
                    <div class="btn-group">
                        <a href="{{ route('admin.perhitungan.matrix') }}" class="btn btn-outline-info">
                            <i class="fas fa-table me-2"></i>Matrix Data
                        </a>
                        <a href="{{ route('admin.perhitungan.normalisasi') }}" class="btn btn-outline-success">
                            <i class="fas fa-calculator me-2"></i>Normalisasi
                        </a>
                        <a href="{{ route('admin.hasil-cpi.index') }}" class="btn btn-primary">
                            <i class="fas fa-chart-line me-2"></i>Lihat Hasil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="fw-bold mb-1">{{ $statistik['total_siswa'] }}</h3>
                        <p class="mb-0 opacity-75">Total Siswa</p>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card success">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="fw-bold mb-1">{{ $statistik['penilaian_lengkap'] }}</h3>
                        <p class="mb-0 opacity-75">Penilaian Lengkap</p>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card warning">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="fw-bold mb-1">{{ $statistik['total_penilaian'] }}</h3>
                        <p class="mb-0 opacity-75">Total Penilaian</p>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="fas fa-edit"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card {{ $statistik['has_hasil_cpi'] ? 'success' : 'danger' }}">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="fw-bold mb-1">
                            @if ($statistik['has_hasil_cpi'])
                                <i class="fas fa-check"></i>
                            @else
                                <i class="fas fa-times"></i>
                            @endif
                        </h3>
                        <p class="mb-0 opacity-75">Status CPI</p>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="fas fa-calculator"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Navigation -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-compass text-info me-2"></i>Navigasi Perhitungan</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="d-grid">
                                <a href="{{ route('admin.perhitungan.matrix') }}" class="btn btn-outline-info">
                                    <i class="fas fa-table fs-3 mb-2"></i><br>
                                    <strong>Matrix Data</strong><br>
                                    <small>Lihat matrix nilai mentah semua siswa</small>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-grid">
                                <a href="{{ route('admin.perhitungan.normalisasi') }}" class="btn btn-outline-success">
                                    <i class="fas fa-calculator fs-3 mb-2"></i><br>
                                    <strong>Proses Normalisasi</strong><br>
                                    <small>Detail normalisasi per kriteria</small>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-grid">
                                <a href="{{ route('admin.hasil-cpi.index') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-chart-line fs-3 mb-2"></i><br>
                                    <strong>Hasil Akhir</strong><br>
                                    <small>Peringkat dan skor CPI final</small>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Siswa dengan Status Perhitungan -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-list text-primary me-2"></i>Status Perhitungan per Siswa</h5>
        </div>
        <div class="card-body">
            @if ($siswa->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Kode</th>
                                <th>Nama Siswa</th>
                                <th class="text-center">Jumlah Penilaian</th>
                                <th class="text-center">Status Lengkap</th>
                                <th class="text-center">Skor CPI</th>
                                <th class="text-center">Peringkat</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($siswa as $s)
                                <tr>
                                    <td>
                                        <span class="badge bg-primary">{{ $s->kode }}</span>
                                    </td>
                                    <td>
                                        <div>
                                            <h6 class="mb-1 fw-bold">{{ $s->nama }}</h6>
                                            @if ($s->jenis_kelamin)
                                                <small class="text-muted">{{ $s->jenis_kelamin }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="fw-bold">{{ $s->penilaian->count() }}</span> /
                                        {{ $kriteria->count() }}
                                    </td>
                                    <td class="text-center">
                                        @if ($s->penilaian->count() == $kriteria->count())
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i>Lengkap
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="fas fa-exclamation-triangle me-1"></i>Belum Lengkap
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($s->hasilCpi)
                                            <span
                                                class="fw-bold text-success">{{ number_format($s->hasilCpi->skor_total, 2) }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($s->hasilCpi)
                                            @if ($s->hasilCpi->peringkat <= 3)
                                                <i
                                                    class="fas fa-medal {{ $s->hasilCpi->peringkat == 1 ? 'text-warning' : ($s->hasilCpi->peringkat == 2 ? 'text-secondary' : 'text-danger') }}"></i>
                                                <span class="fw-bold">{{ $s->hasilCpi->peringkat }}</span>
                                            @else
                                                <span class="badge bg-primary">{{ $s->hasilCpi->peringkat }}</span>
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.perhitungan.show', $s->id) }}"
                                                class="btn btn-sm btn-outline-primary" title="Detail Perhitungan">
                                                <i class="fas fa-calculator"></i>
                                            </a>
                                            <a href="{{ route('admin.siswa.show', $s->id) }}"
                                                class="btn btn-sm btn-outline-info" title="Detail Siswa">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if ($s->penilaian->count() < $kriteria->count())
                                                <a href="{{ route('admin.penilaian.create') }}?siswa_id={{ $s->id }}"
                                                    class="btn btn-sm btn-outline-success" title="Tambah Penilaian">
                                                    <i class="fas fa-plus"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-database text-muted" style="font-size: 3rem;"></i>
                    <h5 class="mt-3 text-muted">Belum Ada Data Siswa</h5>
                    <p class="text-muted">Tambahkan data siswa terlebih dahulu untuk mulai perhitungan.</p>
                    <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Siswa
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Info Metode CPI -->
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-info-circle text-info me-2"></i>Tentang Metode CPI</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="fw-bold text-primary">Langkah Perhitungan CPI:</h6>
                    <ol class="small text-muted">
                        <li><strong>Input Nilai Mentah:</strong> Memasukkan nilai 0-100 untuk setiap kriteria</li>
                        <li><strong>Normalisasi:</strong> Mengubah nilai mentah menjadi nilai yang comparable</li>
                        <li><strong>Pembobotan:</strong> Mengalikan nilai normalisasi dengan bobot kriteria</li>
                        <li><strong>Agregasi:</strong> Menjumlahkan semua nilai terbobot</li>
                        <li><strong>Perankingan:</strong> Mengurutkan berdasarkan skor total</li>
                    </ol>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold text-success">Rumus Normalisasi:</h6>
                    <div class="small text-muted">
                        <p><strong>Tren Positif:</strong> (Nilai / Nilai_Min) × 100</p>
                        <p><strong>Tren Negatif:</strong> (Nilai_Min / Nilai) × 100</p>
                        <p><strong>Nilai Terbobot:</strong> Nilai_Normalisasi × Bobot</p>
                        <p><strong>Skor CPI:</strong> Σ(Nilai_Terbobot)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
