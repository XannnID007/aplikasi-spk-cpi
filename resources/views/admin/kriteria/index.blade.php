@extends('layouts.app')

@section('title', 'Data Kriteria - SPK CPI')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-primary mb-1">Data Kriteria</h2>
                    <p class="text-muted mb-0">Manajemen kriteria penilaian CPI</p>
                </div>
                <div>
                    <a href="{{ route('admin.kriteria.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Kriteria Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-list-check text-primary me-2"></i>Daftar Kriteria Penilaian</h5>
        </div>
        <div class="card-body">
            @if ($kriteria->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="80">Kode</th>
                                <th>Nama Kriteria</th>
                                <th width="100">Tren</th>
                                <th width="100">Bobot</th>
                                <th>Keterangan</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kriteria as $k)
                                <tr>
                                    <td>
                                        <span class="badge bg-secondary fs-6">{{ $k->kode }}</span>
                                    </td>
                                    <td>
                                        <div>
                                            <h6 class="mb-1 fw-bold">{{ $k->nama }}</h6>
                                        </div>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $k->tren === 'Positif' ? 'success' : 'warning' }} px-2 py-1">
                                            <i
                                                class="fas fa-{{ $k->tren === 'Positif' ? 'arrow-up' : 'arrow-down' }} me-1"></i>
                                            {{ $k->tren }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="fw-bold fs-6">{{ number_format($k->bobot * 100, 1) }}%</span>
                                    </td>
                                    <td>
                                        {{ $k->keterangan ? Str::limit($k->keterangan, 50) : '-' }}
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.kriteria.show', $k->id) }}"
                                                class="btn btn-sm btn-outline-info" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.kriteria.edit', $k->id) }}"
                                                class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.kriteria.destroy', $k->id) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus kriteria ini? Data penilaian terkait juga akan terhapus.')">
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
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="3" class="text-end">Total Bobot:</th>
                                <th>
                                    <span class="fw-bold text-primary fs-6">
                                        {{ number_format($kriteria->sum('bobot') * 100, 1) }}%
                                    </span>
                                </th>
                                <th colspan="2"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                @if ($kriteria->sum('bobot') != 1.0)
                    <div class="alert alert-warning mt-3" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Peringatan:</strong> Total bobot kriteria harus sama dengan 100% (1.0).
                        Saat ini total bobot adalah {{ number_format($kriteria->sum('bobot') * 100, 1) }}%.
                    </div>
                @endif
            @else
                <div class="text-center py-4">
                    <i class="fas fa-list-check text-muted" style="font-size: 3rem;"></i>
                    <h5 class="mt-3 text-muted">Belum Ada Data Kriteria</h5>
                    <p class="text-muted">Klik tombol "Tambah Kriteria Baru" untuk menambahkan kriteria pertama.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Info Metode CPI -->
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-info-circle text-info me-2"></i>Tentang Kriteria CPI</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="fw-bold text-primary">Tren Positif:</h6>
                    <p class="text-muted small">Semakin tinggi nilai semakin baik. Normalisasi: (nilai/nilai_min) × 100</p>

                    <h6 class="fw-bold text-warning">Tren Negatif:</h6>
                    <p class="text-muted small">Semakin rendah nilai semakin baik. Normalisasi: (nilai_min/nilai) × 100</p>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold text-success">Bobot Kriteria:</h6>
                    <p class="text-muted small">Menunjukkan tingkat kepentingan kriteria. Total semua bobot harus = 100%
                        (1.0)</p>

                    <h6 class="fw-bold text-info">Perhitungan CPI:</h6>
                    <p class="text-muted small">Skor CPI = Σ (Nilai Normalisasi × Bobot Kriteria)</p>
                </div>
            </div>
        </div>
    </div>
@endsection
