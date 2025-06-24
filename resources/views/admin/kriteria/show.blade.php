@extends('layouts.app')

@section('title', 'Detail Kriteria - ' . $kriteria->nama)

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-primary mb-1">Detail Kriteria</h2>
                    <p class="text-muted mb-0">Informasi lengkap kriteria {{ $kriteria->nama }}</p>
                </div>
                <div>
                    <a href="{{ route('admin.kriteria.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <a href="{{ route('admin.kriteria.edit', $kriteria->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Edit Kriteria
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Kriteria Info -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-info-circle text-primary me-2"></i>Informasi Kriteria</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center"
                            style="width: 80px; height: 80px;">
                            <span class="text-white fw-bold fs-3">{{ $kriteria->kode }}</span>
                        </div>
                    </div>

                    <table class="table table-borderless">
                        <tr>
                            <td class="fw-bold text-muted" width="120">Kode:</td>
                            <td><span class="badge bg-primary fs-6">{{ $kriteria->kode }}</span></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">Nama:</td>
                            <td class="fw-bold">{{ $kriteria->nama }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">Tren:</td>
                            <td>
                                <span
                                    class="badge bg-{{ $kriteria->tren === 'Positif' ? 'success' : 'warning' }} px-3 py-2">
                                    <i
                                        class="fas fa-{{ $kriteria->tren === 'Positif' ? 'arrow-up' : 'arrow-down' }} me-1"></i>
                                    {{ $kriteria->tren }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">Bobot:</td>
                            <td>
                                <span
                                    class="fw-bold fs-5 text-primary">{{ number_format($kriteria->bobot * 100, 1) }}%</span>
                                <small class="text-muted">({{ $kriteria->bobot }})</small>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">Keterangan:</td>
                            <td>{{ $kriteria->keterangan ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Statistik Penilaian -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-chart-bar text-success me-2"></i>Statistik Penilaian</h5>
                </div>
                <div class="card-body">
                    @if ($kriteria->penilaian->count() > 0)
                        @php
                            $nilaiMentah = $kriteria->penilaian->pluck('nilai_mentah');
                            $rataRata = $nilaiMentah->avg();
                            $nilaiMin = $nilaiMentah->min();
                            $nilaiMax = $nilaiMentah->max();
                        @endphp

                        <div class="row text-center">
                            <div class="col-6 mb-3">
                                <div class="border rounded p-3">
                                    <h4 class="text-primary mb-1">{{ $kriteria->penilaian->count() }}</h4>
                                    <small class="text-muted">Total Penilaian</small>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="border rounded p-3">
                                    <h4 class="text-success mb-1">{{ number_format($rataRata, 1) }}</h4>
                                    <small class="text-muted">Rata-rata Nilai</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="border rounded p-3">
                                    <h4 class="text-info mb-1">{{ $nilaiMin }}</h4>
                                    <small class="text-muted">Nilai Minimum</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="border rounded p-3">
                                    <h4 class="text-warning mb-1">{{ $nilaiMax }}</h4>
                                    <small class="text-muted">Nilai Maksimum</small>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-chart-bar text-muted fs-1 mb-2"></i>
                            <p class="text-muted mb-0">Belum ada penilaian untuk kriteria ini.</p>
                            <a href="{{ route('admin.penilaian.create') }}?kriteria_id={{ $kriteria->id }}"
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
