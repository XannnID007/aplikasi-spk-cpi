@extends('layouts.app')

@section('title', 'Detail Penilaian - SPK CPI')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-primary mb-1">Detail Penilaian</h2>
                    <p class="text-muted mb-0">{{ $penilaian->siswa->nama }} - {{ $penilaian->kriteria->nama }}</p>
                </div>
                <div>
                    <a href="{{ route('admin.penilaian.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <a href="{{ route('admin.penilaian.edit', $penilaian->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Edit Penilaian
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Info Siswa -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-user text-primary me-2"></i>Informasi Siswa</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center"
                            style="width: 80px; height: 80px;">
                            <i class="fas fa-child text-white fs-1"></i>
                        </div>
                    </div>

                    <table class="table table-borderless">
                        <tr>
                            <td class="fw-bold text-muted" width="120">Kode:</td>
                            <td><span class="badge bg-primary">{{ $penilaian->siswa->kode }}</span></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">Nama:</td>
                            <td class="fw-bold">{{ $penilaian->siswa->nama }}</td>
                        </tr>
                        @if ($penilaian->siswa->jenis_kelamin)
                            <tr>
                                <td class="fw-bold text-muted">Jenis Kelamin:</td>
                                <td>{{ $penilaian->siswa->jenis_kelamin }}</td>
                            </tr>
                        @endif
                        @if ($penilaian->siswa->umur)
                            <tr>
                                <td class="fw-bold text-muted">Umur:</td>
                                <td>{{ $penilaian->siswa->umur }} tahun</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>

        <!-- Info Kriteria -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-list-check text-success me-2"></i>Informasi Kriteria</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="bg-success rounded-circle d-inline-flex align-items-center justify-content-center"
                            style="width: 80px; height: 80px;">
                            <span class="text-white fw-bold fs-3">{{ $penilaian->kriteria->kode }}</span>
                        </div>
                    </div>

                    <table class="table table-borderless">
                        <tr>
                            <td class="fw-bold text-muted" width="120">Kode:</td>
                            <td><span class="badge bg-secondary">{{ $penilaian->kriteria->kode }}</span></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">Nama:</td>
                            <td class="fw-bold">{{ $penilaian->kriteria->nama }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">Tren:</td>
                            <td>
                                <span
                                    class="badge bg-{{ $penilaian->kriteria->tren === 'Positif' ? 'success' : 'warning' }}">
                                    {{ $penilaian->kriteria->tren }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">Bobot:</td>
                            <td class="fw-bold">{{ number_format($penilaian->kriteria->bobot * 100, 1) }}%</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Penilaian -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-star text-warning me-2"></i>Detail Penilaian</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3 text-center">
                            <div class="border rounded p-3">
                                <h3 class="text-primary mb-1">{{ number_format($penilaian->nilai_mentah, 0) }}</h3>
                                <small class="text-muted">Nilai Mentah</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3 text-center">
                            <div class="border rounded p-3">
                                <h3 class="text-info mb-1">
                                    {{ $penilaian->nilai_normalisasi ? number_format($penilaian->nilai_normalisasi, 2) : '-' }}
                                </h3>
                                <small class="text-muted">Nilai Normalisasi</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3 text-center">
                            <div class="border rounded p-3">
                                <h3 class="text-success mb-1">
                                    {{ $penilaian->nilai_terbobot ? number_format($penilaian->nilai_terbobot, 2) : '-' }}
                                </h3>
                                <small class="text-muted">Nilai Terbobot</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3 text-center">
                            <div class="border rounded p-3">
                                <h3 class="text-warning mb-1">{{ $penilaian->created_at->format('d M Y') }}</h3>
                                <small class="text-muted">Tanggal Input</small>
                            </div>
                        </div>
                    </div>

                    <!-- Kategori Nilai -->
                    <hr>
                    <div class="text-center">
                        <h6 class="fw-bold mb-2">Kategori Nilai:</h6>
                        @php
                            $nilai = $penilaian->nilai_mentah;
                            if ($nilai >= 81) {
                                $kategori = 'Sangat Baik';
                                $badgeClass = 'bg-primary';
                            } elseif ($nilai >= 61) {
                                $kategori = 'Baik';
                                $badgeClass = 'bg-success';
                            } elseif ($nilai >= 41) {
                                $kategori = 'Cukup';
                                $badgeClass = 'bg-info';
                            } elseif ($nilai >= 21) {
                                $kategori = 'Kurang';
                                $badgeClass = 'bg-warning';
                            } else {
                                $kategori = 'Sangat Kurang';
                                $badgeClass = 'bg-danger';
                            }
                        @endphp
                        <span class="badge {{ $badgeClass }} px-4 py-2 fs-6">{{ $kategori }}</span>
                    </div>

                    @if (!$penilaian->nilai_normalisasi)
                        <div class="alert alert-info mt-3">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Catatan:</strong> Nilai normalisasi dan terbobot belum dihitung.
                            Lakukan perhitungan CPI untuk mendapatkan nilai yang sudah dinormalisasi.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Penjelasan Perhitungan -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-calculator text-info me-2"></i>Penjelasan Perhitungan</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold text-primary">Normalisasi Tren {{ $penilaian->kriteria->tren }}:</h6>
                            @if ($penilaian->kriteria->tren === 'Positif')
                                <p class="text-muted small">
                                    Rumus: (Nilai Alternatif / Nilai Minimum) × 100<br>
                                    Semakin tinggi nilai semakin baik
                                </p>
                            @else
                                <p class="text-muted small">
                                    Rumus: (Nilai Minimum / Nilai Alternatif) × 100<br>
                                    Semakin rendah nilai semakin baik
                                </p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold text-success">Nilai Terbobot:</h6>
                            <p class="text-muted small">
                                Rumus: Nilai Normalisasi × Bobot Kriteria<br>
                                Bobot kriteria ini: {{ number_format($penilaian->kriteria->bobot * 100, 1) }}%
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
