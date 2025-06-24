@extends('layouts.app')

@section('title', 'Dashboard Guru - SPK CPI')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-primary mb-1">Dashboard Guru</h2>
                    <p class="text-muted mb-0">Selamat datang, {{ auth()->user()->name }}</p>
                </div>
                <div>
                    <span class="badge bg-success fs-6 px-3 py-2">
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
                        <h3 class="fw-bold mb-1">{{ $siswaLulus }}</h3>
                        <p class="mb-0 opacity-75">Siswa Siap</p>
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
                        <h3 class="fw-bold mb-1">{{ $siswaBelumLulus }}</h3>
                        <p class="mb-0 opacity-75">Siswa Belum Siap</p>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="fas fa-exclamation-triangle"></i>
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
        <!-- Top 10 Siswa -->
        <div class="col-lg-8 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-trophy text-warning me-2"></i>Peringkat Siswa</h5>
                    <a href="{{ route('guru.hasil-cpi.index') }}" class="btn btn-sm btn-outline-primary">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    @if ($grafikHasil->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th width="80">Peringkat</th>
                                        <th>Nama Siswa</th>
                                        <th width="100">Skor</th>
                                        <th width="100">Persentase</th>
                                        <th width="150">Kategori</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($grafikHasil as $hasil)
                                        <tr>
                                            <td>
                                                @if ($hasil->peringkat <= 3)
                                                    <i
                                                        class="fas fa-medal {{ $hasil->peringkat == 1 ? 'text-warning' : ($hasil->peringkat == 2 ? 'text-secondary' : 'text-danger') }} fs-5"></i>
                                                @else
                                                    <span
                                                        class="badge bg-primary rounded-circle">{{ $hasil->peringkat }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div>
                                                    <h6 class="mb-1">{{ $hasil->siswa->nama }}</h6>
                                                    <small class="text-muted">{{ $hasil->siswa->kode }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="fw-bold">{{ number_format($hasil->skor_total, 2) }}</span>
                                            </td>
                                            <td>
                                                <span
                                                    class="fw-bold text-primary">{{ number_format($hasil->persentase, 1) }}%</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $hasil->warna_kategori }} px-2 py-1">
                                                    {{ $hasil->kategori_kesiapan }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-info-circle fs-1 mb-3"></i>
                            <h5>Belum Ada Data Hasil</h5>
                            <p>Belum ada hasil perhitungan CPI yang tersedia</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Menu Akses Cepat -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-bolt text-primary me-2"></i>Menu Akses Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="{{ route('guru.hasil-cpi.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-chart-line me-2"></i>Lihat Hasil CPI
                        </a>
                        <a href="{{ route('guru.cetak-hasil') }}" target="_blank" class="btn btn-outline-success">
                            <i class="fas fa-print me-2"></i>Cetak Laporan
                        </a>
                        <a href="{{ route('guru.profil.index') }}" class="btn btn-outline-info">
                            <i class="fas fa-user-edit me-2"></i>Edit Profil
                        </a>
                    </div>

                    <hr class="my-4">

                    <div class="text-center">
                        <h6 class="text-muted mb-3">Informasi Akun</h6>
                        <div class="mb-2">
                            <img src="{{ auth()->user()->foto ? asset('uploads/users/' . auth()->user()->foto) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=e2e8f0&color=2563eb' }}"
                                class="rounded-circle mb-2" width="80" height="80" alt="Profile">
                        </div>
                        <h6 class="fw-bold text-primary">{{ auth()->user()->name }}</h6>
                        <p class="text-muted small mb-1">{{ auth()->user()->email }}</p>
                        @if (auth()->user()->nip)
                            <p class="text-muted small mb-0">NIP: {{ auth()->user()->nip }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Informasi Sistem -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-info-circle text-info me-2"></i>Tentang Sistem</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h6 class="fw-bold text-primary mb-2">Sistem Pendukung Keputusan CPI</h6>
                            <p class="text-muted mb-3">
                                Sistem ini menggunakan metode Composite Performance Index (CPI) untuk menilai kesiapan anak
                                didik
                                dalam transisi ke sekolah dasar di PAUDQU QURROTA A'YUN. Sistem mengevaluasi 6 kriteria
                                utama
                                dengan bobot yang telah ditentukan untuk memberikan rekomendasi kesiapan setiap siswa.
                            </p>

                            <div class="row">
                                <div class="col-sm-6">
                                    <h6 class="fw-bold mb-2">Kriteria Penilaian:</h6>
                                    <ul class="list-unstyled text-muted small">
                                        <li><i class="fas fa-check text-success me-2"></i>Keterampilan Sosial-Emosional
                                            (20%)</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Keterampilan Kognitif (20%)</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Keterampilan Psikomotorik (15%)
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-sm-6">
                                    <h6 class="fw-bold mb-2">&nbsp;</h6>
                                    <ul class="list-unstyled text-muted small">
                                        <li><i class="fas fa-check text-success me-2"></i>Dukungan Orang Tua (15%)</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Kemandirian (15%)</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Tingkat Kecemasan (15%)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <div class="bg-light rounded p-3">
                                    <i class="fas fa-graduation-cap text-primary" style="font-size: 3rem;"></i>
                                    <h6 class="mt-2 mb-1 fw-bold">PAUDQU QURROTA A'YUN</h6>
                                    <small class="text-muted">Banjar, Jawa Barat</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
