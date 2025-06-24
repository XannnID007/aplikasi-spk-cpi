@extends('layouts.app')

@section('title', 'Detail Siswa - ' . $siswa->nama)

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-primary mb-1">Detail Siswa</h2>
                    <p class="text-muted mb-0">Informasi lengkap {{ $siswa->nama }}</p>
                </div>
                <div>
                    <a href="{{ route('admin.siswa.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <a href="{{ route('admin.siswa.edit', $siswa->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Edit Siswa
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Profile Card -->
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center"
                            style="width: 120px; height: 120px;">
                            <i class="fas fa-child text-white" style="font-size: 3rem;"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold text-primary">{{ $siswa->nama }}</h5>
                    <p class="text-muted mb-2">Kode: {{ $siswa->kode }}</p>
                    @if ($siswa->jenis_kelamin)
                        <span class="badge bg-{{ $siswa->jenis_kelamin === 'Laki-laki' ? 'info' : 'pink' }} px-3 py-2">
                            <i class="fas fa-{{ $siswa->jenis_kelamin === 'Laki-laki' ? 'mars' : 'venus' }} me-1"></i>
                            {{ $siswa->jenis_kelamin }}
                        </span>
                    @endif
                    @if ($siswa->umur)
                        <span class="badge bg-success px-3 py-2 ms-1">
                            <i class="fas fa-birthday-cake me-1"></i>{{ $siswa->umur }} tahun
                        </span>
                    @endif
                </div>
            </div>

            <!-- Status Card -->
            @if ($siswa->hasilCpi)
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-chart-line text-success me-2"></i>Status Penilaian CPI</h6>
                    </div>
                    <div class="card-body text-center">
                        <h3 class="text-primary mb-2">Peringkat {{ $siswa->hasilCpi->peringkat }}</h3>
                        <div class="progress mb-3" style="height: 20px;">
                            <div class="progress-bar bg-{{ $siswa->hasilCpi->warna_kategori }}"
                                style="width: {{ $siswa->hasilCpi->persentase }}%">
                                {{ number_format($siswa->hasilCpi->persentase, 1) }}%
                            </div>
                        </div>
                        <span class="badge bg-{{ $siswa->hasilCpi->warna_kategori }} px-3 py-2 fs-6">
                            {{ $siswa->hasilCpi->kategori_kesiapan }}
                        </span>
                    </div>
                </div>
            @endif
        </div>

        <!-- Information Card -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-info-circle text-primary me-2"></i>Informasi Personal</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold text-muted" width="150">Nama Lengkap:</td>
                                    <td>{{ $siswa->nama }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Kode Siswa:</td>
                                    <td><span class="badge bg-primary">{{ $siswa->kode }}</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Jenis Kelamin:</td>
                                    <td>{{ $siswa->jenis_kelamin ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold text-muted" width="150">Tanggal Lahir:</td>
                                    <td>{{ $siswa->tanggal_lahir ? $siswa->tanggal_lahir->format('d F Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Umur:</td>
                                    <td>{{ $siswa->umur ? $siswa->umur . ' tahun' : '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Orang Tua:</td>
                                    <td>{{ $siswa->nama_orang_tua ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    @if ($siswa->alamat)
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <strong class="text-muted">Alamat:</strong><br>
                                {{ $siswa->alamat }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Penilaian Card -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-star text-warning me-2"></i>Data Penilaian</h5>
                    @if ($siswa->penilaian->count() < 6)
                        <a href="{{ route('admin.penilaian.create') }}?siswa_id={{ $siswa->id }}"
                            class="btn btn-sm btn-primary">
                            <i class="fas fa-plus me-1"></i>Tambah Penilaian
                        </a>
                    @endif
                </div>
                <div class="card-body">
                    @if ($siswa->penilaian->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Kriteria</th>
                                        <th>Nilai</th>
                                        <th>Normalisasi</th>
                                        <th>Terbobot</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($siswa->penilaian as $p)
                                        <tr>
                                            <td><span class="badge bg-secondary">{{ $p->kriteria->kode }}</span></td>
                                            <td>{{ $p->kriteria->nama }}</td>
                                            <td><span class="fw-bold">{{ number_format($p->nilai_mentah, 0) }}</span></td>
                                            <td>{{ $p->nilai_normalisasi ? number_format($p->nilai_normalisasi, 2) : '-' }}
                                            </td>
                                            <td>{{ $p->nilai_terbobot ? number_format($p->nilai_terbobot, 2) : '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-star text-muted fs-1 mb-2"></i>
                            <p class="text-muted mb-0">Belum ada data penilaian untuk siswa ini.</p>
                            <a href="{{ route('admin.penilaian.create') }}?siswa_id={{ $siswa->id }}"
                                class="btn btn-sm btn-primary mt-2">
                                <i class="fas fa-plus me-1"></i>Tambah Penilaian Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
