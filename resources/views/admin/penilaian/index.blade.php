@extends('layouts.app')

@section('title', 'Data Penilaian - SPK CPI')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-primary mb-1">Data Penilaian</h2>
                    <p class="text-muted mb-0">Manajemen data penilaian siswa</p>
                </div>
                <div>
                    <div class="btn-group me-2">
                        <a href="{{ route('admin.penilaian.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Tambah Penilaian
                        </a>
                        <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.penilaian.missing') }}">
                                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>Penilaian Belum Lengkap
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.penilaian.grouped') }}">
                                    <i class="fas fa-users text-info me-2"></i>Grup per Siswa
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.perhitungan.matrix') }}">
                                    <i class="fas fa-table text-secondary me-2"></i>Matrix Data
                                </a>
                            </li>
                        </ul>
                    </div>

                    <form action="{{ route('admin.hitung-cpi') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success"
                            onclick="return confirm('Yakin ingin menghitung ulang CPI? Hasil sebelumnya akan dihapus.')">
                            <i class="fas fa-calculator me-2"></i>Hitung CPI
                        </button>
                    </form>
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
                        <h3 class="fw-bold mb-1">{{ $penilaian->total() }}</h3>
                        <p class="mb-0 opacity-75">Total Penilaian</p>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card success">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="fw-bold mb-1">{{ \App\Models\Siswa::count() }}</h3>
                        <p class="mb-0 opacity-75">Total Siswa</p>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="fas fa-child"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card warning">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="fw-bold mb-1">{{ \App\Models\Kriteria::count() }}</h3>
                        <p class="mb-0 opacity-75">Total Kriteria</p>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="fas fa-list-check"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card danger">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="fw-bold mb-1">{{ number_format($penilaian->avg('nilai_mentah'), 1) }}</h3>
                        <p class="mb-0 opacity-75">Rata-rata Nilai</p>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Overview -->
    @php
        $totalSiswa = \App\Models\Siswa::count();
        $totalKriteria = \App\Models\Kriteria::count();
        $totalPossible = $totalSiswa * $totalKriteria;
        $currentTotal = $penilaian->total();
        $progressPercentage = $totalPossible > 0 ? ($currentTotal / $totalPossible) * 100 : 0;
    @endphp

    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-chart-pie text-info me-2"></i>Progress Penilaian Keseluruhan</h5>
                <span
                    class="badge bg-{{ $progressPercentage >= 100 ? 'success' : ($progressPercentage >= 75 ? 'warning' : 'danger') }} px-3 py-2">
                    {{ number_format($progressPercentage, 1) }}% Selesai
                </span>
            </div>
        </div>
        <div class="card-body">
            <div class="progress mb-3" style="height: 25px;">
                <div class="progress-bar bg-{{ $progressPercentage >= 100 ? 'success' : ($progressPercentage >= 75 ? 'warning' : 'primary') }}"
                    style="width: {{ min(100, $progressPercentage) }}%">
                    {{ $currentTotal }} / {{ $totalPossible }}
                </div>
            </div>
            <div class="row text-center">
                <div class="col-md-3">
                    <small class="text-muted">Total Siswa</small>
                    <div class="fw-bold text-primary">{{ $totalSiswa }}</div>
                </div>
                <div class="col-md-3">
                    <small class="text-muted">Total Kriteria</small>
                    <div class="fw-bold text-success">{{ $totalKriteria }}</div>
                </div>
                <div class="col-md-3">
                    <small class="text-muted">Penilaian Selesai</small>
                    <div class="fw-bold text-info">{{ $currentTotal }}</div>
                </div>
                <div class="col-md-3">
                    <small class="text-muted">Penilaian Tersisa</small>
                    <div class="fw-bold text-warning">{{ $totalPossible - $currentTotal }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-edit text-primary me-2"></i>Daftar Penilaian (Terurut)</h5>
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-outline-info" data-bs-toggle="modal"
                        data-bs-target="#sortingInfoModal">
                        <i class="fas fa-info-circle me-1"></i>Info Urutan
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if ($penilaian->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="50">No</th>
                                <th>Siswa</th>
                                <th>Kriteria</th>
                                <th width="100">Nilai Mentah</th>
                                <th width="120">Nilai Normalisasi</th>
                                <th width="120">Nilai Terbobot</th>
                                <th width="120">Tanggal Input</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $currentSiswa = null;
                                $rowNumber = 0;
                            @endphp
                            @foreach ($penilaian as $index => $p)
                                @php
                                    $rowNumber++;
                                    $isNewSiswa = $currentSiswa !== $p->siswa->kode;
                                    if ($isNewSiswa) {
                                        $currentSiswa = $p->siswa->kode;
                                    }
                                @endphp
                                <tr class="{{ $isNewSiswa ? 'border-top border-primary border-3' : '' }}">
                                    <td class="text-center">
                                        <span
                                            class="badge bg-secondary">{{ $rowNumber + ($penilaian->currentPage() - 1) * $penilaian->perPage() }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if ($isNewSiswa)
                                                <div class="bg-primary rounded-circle me-2 d-flex align-items-center justify-content-center"
                                                    style="width: 8px; height: 8px; min-width: 8px;"></div>
                                            @else
                                                <div class="me-2" style="width: 8px;"></div>
                                            @endif
                                            <div>
                                                <span class="badge bg-primary me-2">{{ $p->siswa->kode }}</span>
                                                <strong
                                                    class="{{ $isNewSiswa ? 'text-primary' : '' }}">{{ $p->siswa->nama }}</strong>
                                                @if ($isNewSiswa)
                                                    <br><small class="text-muted">
                                                        <i class="fas fa-arrow-right me-1"></i>Mulai penilaian untuk siswa
                                                        ini
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="badge bg-secondary me-2">{{ $p->kriteria->kode }}</span>
                                            {{ $p->kriteria->nama }}
                                            <br><small class="text-muted">
                                                Tren: {{ $p->kriteria->tren }} | Bobot:
                                                {{ number_format($p->kriteria->bobot * 100, 1) }}%
                                            </small>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $nilai = $p->nilai_mentah;
                                            $badgeClass = '';
                                            if ($nilai >= 81) {
                                                $badgeClass = 'success';
                                            } elseif ($nilai >= 61) {
                                                $badgeClass = 'primary';
                                            } elseif ($nilai >= 41) {
                                                $badgeClass = 'info';
                                            } elseif ($nilai >= 21) {
                                                $badgeClass = 'warning';
                                            } else {
                                                $badgeClass = 'danger';
                                            }
                                        @endphp
                                        <span
                                            class="badge bg-{{ $badgeClass }} fs-6">{{ number_format($p->nilai_mentah, 0) }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if ($p->nilai_normalisasi)
                                            <span
                                                class="text-info fw-bold">{{ number_format($p->nilai_normalisasi, 2) }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($p->nilai_terbobot)
                                            <span
                                                class="text-success fw-bold">{{ number_format($p->nilai_terbobot, 2) }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{ $p->created_at->format('d M Y') }}
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.penilaian.show', $p->id) }}"
                                                class="btn btn-sm btn-outline-info" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.penilaian.edit', $p->id) }}"
                                                class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.penilaian.destroy', $p->id) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus penilaian ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Custom Pagination dengan styling yang diperbaiki -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="pagination-info">
                        <span class="text-muted small">
                            Menampilkan {{ $penilaian->firstItem() }} - {{ $penilaian->lastItem() }}
                            dari {{ $penilaian->total() }} hasil
                        </span>
                    </div>

                    @if ($penilaian->hasPages())
                        <nav aria-label="Pagination Navigation">
                            <ul class="pagination pagination-sm mb-0">
                                {{-- Previous Page Link --}}
                                @if ($penilaian->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">
                                            <i class="fas fa-chevron-left"></i>
                                            <span class="d-none d-sm-inline ms-1">Sebelumnya</span>
                                        </span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $penilaian->previousPageUrl() }}" rel="prev">
                                            <i class="fas fa-chevron-left"></i>
                                            <span class="d-none d-sm-inline ms-1">Sebelumnya</span>
                                        </a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($penilaian->getUrlRange(1, $penilaian->lastPage()) as $page => $url)
                                    @if ($page == $penilaian->currentPage())
                                        <li class="page-item active">
                                            <span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($penilaian->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $penilaian->nextPageUrl() }}" rel="next">
                                            <span class="d-none d-sm-inline me-1">Selanjutnya</span>
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link">
                                            <span class="d-none d-sm-inline me-1">Selanjutnya</span>
                                            <i class="fas fa-chevron-right"></i>
                                        </span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    @endif
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-edit text-muted" style="font-size: 3rem;"></i>
                    <h5 class="mt-3 text-muted">Belum Ada Data Penilaian</h5>
                    <p class="text-muted">Klik tombol "Tambah Penilaian" untuk menambahkan penilaian pertama.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Info Panel -->
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-info-circle text-info me-2"></i>Panduan Penilaian</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="fw-bold text-primary">Rentang Nilai:</h6>
                    <ul class="list-unstyled text-muted small">
                        <li><i class="fas fa-circle text-danger me-2"></i>0-20: Sangat Kurang</li>
                        <li><i class="fas fa-circle text-warning me-2"></i>21-40: Kurang</li>
                        <li><i class="fas fa-circle text-info me-2"></i>41-60: Cukup</li>
                        <li><i class="fas fa-circle text-primary me-2"></i>61-80: Baik</li>
                        <li><i class="fas fa-circle text-success me-2"></i>81-100: Sangat Baik</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold text-success">Urutan Data:</h6>
                    <ul class="list-unstyled text-muted small">
                        <li><i class="fas fa-sort-alpha-down text-primary me-2"></i>Siswa diurutkan berdasarkan kode (A1,
                            A2, A3...)</li>
                        <li><i class="fas fa-sort-numeric-down text-success me-2"></i>Kriteria diurutkan per siswa (C1, C2,
                            C3...)</li>
                        <li><i class="fas fa-circle text-primary me-2"></i>Indikator biru menandai siswa baru</li>
                        <li><i class="fas fa-check text-success me-2"></i>Gunakan tombol "Hitung CPI" setelah input selesai
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- Modal Info Urutan -->
<div class="modal fade" id="sortingInfoModal" tabindex="-1" aria-labelledby="sortingInfoModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sortingInfoModalLabel">
                    <i class="fas fa-sort me-2"></i>Informasi Urutan Data Penilaian
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="fw-bold text-primary mb-3">Cara Pengurutan:</h6>
                        <div class="border rounded p-3 mb-3">
                            <h6 class="text-success">1. Urutan Siswa (Primary)</h6>
                            <p class="small mb-2">Data diurutkan berdasarkan kode siswa secara alfabetis dan numerik:
                            </p>
                            <div class="bg-light rounded p-2">
                                <code>A1 → A2 → A3 → A10 → B1 → B2...</code>
                            </div>
                        </div>

                        <div class="border rounded p-3">
                            <h6 class="text-info">2. Urutan Kriteria (Secondary)</h6>
                            <p class="small mb-2">Untuk setiap siswa, kriteria diurutkan dari yang terkecil:</p>
                            <div class="bg-light rounded p-2">
                                <code>C1 → C2 → C3 → C4 → C5 → C6</code>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h6 class="fw-bold text-success mb-3">Contoh Urutan Hasil:</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Siswa</th>
                                        <th>Kriteria</th>
                                    </tr>
                                </thead>
                                <tbody class="small">
                                    <tr class="border-primary border-top border-3">
                                        <td>1</td>
                                        <td><span class="badge bg-primary">A1</span> Andi</td>
                                        <td><span class="badge bg-secondary">C1</span></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td><span class="badge bg-primary">A1</span> Andi</td>
                                        <td><span class="badge bg-secondary">C2</span></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td><span class="badge bg-primary">A1</span> Andi</td>
                                        <td><span class="badge bg-secondary">C3</span></td>
                                    </tr>
                                    <tr class="border-primary border-top border-3">
                                        <td>4</td>
                                        <td><span class="badge bg-primary">A2</span> Siti</td>
                                        <td><span class="badge bg-secondary">C1</span></td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td><span class="badge bg-primary">A2</span> Siti</td>
                                        <td><span class="badge bg-secondary">C2</span></td>
                                    </tr>
                                    <tr>
                                        <td>...</td>
                                        <td colspan="2" class="text-muted text-center">dan seterusnya</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-12">
                        <h6 class="fw-bold text-warning mb-3">Indikator Visual:</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="border rounded p-2 text-center">
                                    <div class="bg-primary rounded-circle mx-auto mb-2"
                                        style="width: 12px; height: 12px;"></div>
                                    <small><strong>Titik Biru</strong><br>Siswa Baru</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-2 text-center">
                                    <div class="border-top border-primary border-3 p-1 mb-2"></div>
                                    <small><strong>Garis Biru</strong><br>Batas Siswa</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-2 text-center">
                                    <span class="badge bg-success">81-100</span>
                                    <span class="badge bg-warning">21-40</span><br>
                                    <small><strong>Warna Badge</strong><br>Kategori Nilai</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Tutup
                </button>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
        .pagination-info {
            font-size: 0.875rem;
        }

        .pagination .page-link {
            border-radius: 6px;
            margin: 0 2px;
            border: 1px solid #dee2e6;
            color: #6c757d;
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            transition: all 0.2s ease-in-out;
        }

        .pagination .page-link:hover {
            background-color: #e9ecef;
            border-color: #adb5bd;
            color: #495057;
        }

        .pagination .page-item.active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: #fff;
        }

        .pagination .page-item.disabled .page-link {
            color: #adb5bd;
            background-color: transparent;
            border-color: #dee2e6;
            cursor: not-allowed;
        }

        .border-top.border-primary.border-3 {
            border-top-width: 3px !important;
            border-top-color: var(--bs-primary) !important;
        }

        .table tbody tr.border-top.border-primary.border-3 td:first-child {
            position: relative;
        }

        .table tbody tr.border-top.border-primary.border-3 td:first-child::before {
            content: '👆';
            position: absolute;
            left: -15px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 12px;
        }

        @media (max-width: 576px) {
            .pagination-info {
                margin-bottom: 1rem;
            }

            .d-flex.justify-content-between {
                flex-direction: column;
            }

            .pagination {
                justify-content: center;
            }
        }

        /* Animasi untuk baris siswa baru */
        @keyframes highlight {
            0% {
                background-color: rgba(13, 110, 253, 0.1);
            }

            100% {
                background-color: transparent;
            }
        }

        .border-top.border-primary.border-3 {
            animation: highlight 2s ease-in-out;
        }

        /* Hover effect untuk grup siswa */
        .table tbody tr:hover {
            background-color: rgba(13, 110, 253, 0.05);
        }

        /* Styling untuk progress bar yang lebih menarik */
        .progress {
            border-radius: 10px;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .progress-bar {
            border-radius: 10px;
            transition: width 0.6s ease;
        }
    </style>
@endpush
