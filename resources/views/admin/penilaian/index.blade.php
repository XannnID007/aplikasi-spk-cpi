@extends('layouts.app')

@section('title', 'Data Penilaian - SPK CPI')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-primary mb-1">Data Penilaian</h2>
                    <p class="text-muted mb-0">Manajemen data penilaian siswa per kriteria</p>
                </div>
                <div>
                    <a href="{{ route('admin.penilaian.create') }}" class="btn btn-primary me-2">
                        <i class="fas fa-plus me-2"></i>Tambah Penilaian
                    </a>
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

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-edit text-primary me-2"></i>Daftar Penilaian</h5>
        </div>
        <div class="card-body">
            @if ($penilaian->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
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
                            @foreach ($penilaian as $p)
                                <tr>
                                    <td>
                                        <div>
                                            <span class="badge bg-primary me-2">{{ $p->siswa->kode }}</span>
                                            <strong>{{ $p->siswa->nama }}</strong>
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
                                        <span class="fw-bold fs-6">{{ number_format($p->nilai_mentah, 0) }}</span>
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
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
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
                        <li><i class="fas fa-circle text-success me-2"></i>61-80: Baik</li>
                        <li><i class="fas fa-circle text-primary me-2"></i>81-100: Sangat Baik</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold text-success">Catatan Penting:</h6>
                    <ul class="list-unstyled text-muted small">
                        <li><i class="fas fa-check text-success me-2"></i>Setiap siswa harus dinilai di semua kriteria</li>
                        <li><i class="fas fa-check text-success me-2"></i>Nilai normalisasi dan terbobot dihitung otomatis
                        </li>
                        <li><i class="fas fa-check text-success me-2"></i>Gunakan tombol "Hitung CPI" setelah input selesai
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

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
    </style>
@endpush
