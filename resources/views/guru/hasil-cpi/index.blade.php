@extends('layouts.app')

@section('title', 'Hasil Penilaian CPI - SPK CPI')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-primary mb-1">Hasil Penilaian CPI</h2>
                <p class="text-muted mb-0">Hasil perhitungan kesiapan siswa menggunakan metode Composite Performance Index</p>
            </div>
            <div>
                <a href="{{ route('guru.cetak-hasil') }}" target="_blank" class="btn btn-success">
                    <i class="fas fa-print me-2"></i>Cetak Laporan
                </a>
            </div>
        </div>
    </div>
</div>

@if($hasilCpi->count() > 0)
    <!-- Statistik Ringkas -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 bg-primary text-white">
                <div class="card-body text-center">
                    <i class="fas fa-users fs-1 mb-2 opacity-75"></i>
                    <h4 class="fw-bold">{{ $hasilCpi->total() }}</h4>
                    <p class="mb-0">Total Siswa</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 bg-success text-white">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fs-1 mb-2 opacity-75"></i>
                    <h4 class="fw-bold">{{ $hasilCpi->where('persentase', '>=', 70)->count() }}</h4>
                    <p class="mb-0">Siswa Siap</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 bg-warning text-white">
                <div class="card-body text-center">
                    <i class="fas fa-exclamation-triangle fs-1 mb-2 opacity-75"></i>
                    <h4 class="fw-bold">{{ $hasilCpi->where('persentase', '<', 70)->count() }}</h4>
                    <p class="mb-0">Perlu Perhatian</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 bg-info text-white">
                <div class="card-body text-center">
                    <i class="fas fa-chart-line fs-1 mb-2 opacity-75"></i>
                    <h4 class="fw-bold">{{ number_format($hasilCpi->avg('persentase'), 1) }}%</h4>
                    <p class="mb-0">Rata-rata Skor</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Hasil -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-trophy text-warning me-2"></i>Peringkat Kesiapan Siswa</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="80" class="text-center">Peringkat</th>
                            <th>Kode Siswa</th>
                            <th>Nama Siswa</th>
                            <th width="120" class="text-center">Skor Total</th>
                            <th width="120" class="text-center">Persentase</th>
                            <th width="150" class="text-center">Kategori Kesiapan</th>
                            <th width="100" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hasilCpi as $hasil)
                            <tr>
                                <td class="text-center">
                                    @if($hasil->peringkat <= 3)
                                        <div class="d-flex align-items-center justify-content-center">
                                            <i class="fas fa-medal fs-4 {{ $hasil->peringkat == 1 ? 'text-warning' : ($hasil->peringkat == 2 ? 'text-secondary' : 'text-danger') }}"></i>
                                            <span class="ms-1 fw-bold">{{ $hasil->peringkat }}</span>
                                        </div>
                                    @else
                                        <span class="badge bg-primary rounded-circle p-2 fs-6">{{ $hasil->peringkat }}</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="fw-bold text-primary">{{ $hasil->siswa->kode }}</span>
                                </td>
                                <td>
                                    <div>
                                        <h6 class="mb-1 fw-bold">{{ $hasil->siswa->nama }}</h6>
                                        <small class="text-muted">
                                            @if($hasil->siswa->jenis_kelamin)
                                                {{ $hasil->siswa->jenis_kelamin }}
                                                @if($hasil->siswa->umur)
                                                    • {{ $hasil->siswa->umur }} tahun
                                                @endif
                                            @endif
                                        </small>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="fw-bold fs-6">{{ number_format($hasil->skor_total, 2) }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="progress" style="height: 25px;">
                                        <div class="progress-bar bg-{{ $hasil->warna_kategori }}" 
                                             style="width: {{ $hasil->persentase }}%">
                                            <span class="fw-bold">{{ number_format($hasil->persentase, 1) }}%</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-{{ $hasil->warna_kategori }} px-3 py-2 fs-6">
                                        {{ $hasil->kategori_kesiapan }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('guru.hasil-cpi.show', $hasil->id) }}" 
                                       class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $hasilCpi->links() }}
            </div>
        </div>
    </div>
@else
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fas fa-info-circle text-muted" style="font-size: 4rem;"></i>
            <h4 class="mt-3 text-muted">Belum Ada Hasil Perhitungan</h4>
            <p class="text-muted">Hasil perhitungan CPI belum tersedia. Silakan hubungi administrator untuk melakukan perhitungan.</p>
        </div>
    </div>
@endif
@endsection