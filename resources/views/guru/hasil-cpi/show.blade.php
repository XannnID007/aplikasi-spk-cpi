@extends('layouts.app')

@section('title', 'Detail Hasil CPI - ' . $hasil->siswa->nama)

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-primary mb-1">Detail Hasil CPI</h2>
                    <p class="text-muted mb-0">{{ $hasil->siswa->nama }} ({{ $hasil->siswa->kode }})</p>
                </div>
                <div>
                    <a href="{{ route('guru.hasil-cpi.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <button onclick="window.print()" class="btn btn-success">
                        <i class="fas fa-print me-2"></i>Cetak
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Informasi Siswa -->
        <div class="col-lg-4 mb-4">
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
                            <td class="fw-bold text-muted">Nama:</td>
                            <td>{{ $hasil->siswa->nama }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">Kode:</td>
                            <td><span class="badge bg-primary">{{ $hasil->siswa->kode }}</span></td>
                        </tr>
                        @if ($hasil->siswa->jenis_kelamin)
                            <tr>
                                <td class="fw-bold text-muted">Jenis Kelamin:</td>
                                <td>{{ $hasil->siswa->jenis_kelamin }}</td>
                            </tr>
                        @endif
                        @if ($hasil->siswa->tanggal_lahir)
                            <tr>
                                <td class="fw-bold text-muted">Tanggal Lahir:</td>
                                <td>{{ $hasil->siswa->tanggal_lahir->format('d F Y') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">Umur:</td>
                                <td>{{ $hasil->siswa->umur }} tahun</td>
                            </tr>
                        @endif
                        @if ($hasil->siswa->nama_orang_tua)
                            <tr>
                                <td class="fw-bold text-muted">Orang Tua:</td>
                                <td>{{ $hasil->siswa->nama_orang_tua }}</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>

        <!-- Hasil CPI -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-chart-line text-success me-2"></i>Hasil Perhitungan CPI</h5>
                </div>
                <div class="card-body">
                    <!-- Ringkasan Hasil -->
                    <div class="row mb-4">
                        <div class="col-md-3 text-center">
                            <div class="border rounded p-3">
                                <h4 class="fw-bold text-primary mb-1">{{ $hasil->peringkat }}</h4>
                                <small class="text-muted">Peringkat</small>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="border rounded p-3">
                                <h4 class="fw-bold text-info mb-1">{{ number_format($hasil->skor_total, 2) }}</h4>
                                <small class="text-muted">Skor Total</small>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="border rounded p-3">
                                <h4 class="fw-bold text-warning mb-1">{{ number_format($hasil->persentase, 1) }}%</h4>
                                <small class="text-muted">Persentase</small>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="border rounded p-3">
                                <span
                                    class="badge bg-{{ $hasil->warna_kategori }} fs-6 px-2 py-1">{{ $hasil->kategori_kesiapan }}</span>
                                <br><small class="text-muted">Kategori</small>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Penilaian per Kriteria -->
                    <h6 class="fw-bold mb-3">Detail Penilaian per Kriteria:</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Kode</th>
                                    <th>Kriteria</th>
                                    <th width="80" class="text-center">Bobot</th>
                                    <th width="100" class="text-center">Nilai Mentah</th>
                                    <th width="120" class="text-center">Nilai Normalisasi</th>
                                    <th width="120" class="text-center">Nilai Terbobot</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hasil->siswa->penilaian as $penilaian)
                                    <tr>
                                        <td><span class="badge bg-secondary">{{ $penilaian->kriteria->kode }}</span></td>
                                        <td>
                                            <div>
                                                <strong>{{ $penilaian->kriteria->nama }}</strong>
                                                <br><small class="text-muted">Tren:
                                                    {{ $penilaian->kriteria->tren }}</small>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ number_format($penilaian->kriteria->bobot * 100, 1) }}%
                                        </td>
                                        <td class="text-center">
                                            <span class="fw-bold">{{ number_format($penilaian->nilai_mentah, 0) }}</span>
                                        </td>
                                        <td class="text-center">
                                            @if ($penilaian->nilai_normalisasi)
                                                {{ number_format($penilaian->nilai_normalisasi, 2) }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($penilaian->nilai_terbobot)
                                                <span
                                                    class="fw-bold text-primary">{{ number_format($penilaian->nilai_terbobot, 2) }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="5" class="text-end">Total Skor CPI:</th>
                                    <th class="text-center">
                                        <span
                                            class="fw-bold text-success fs-5">{{ number_format($hasil->skor_total, 2) }}</span>
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rekomendasi -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-lightbulb text-warning me-2"></i>Rekomendasi</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-{{ $hasil->warna_kategori }}" role="alert">
                        <h6 class="alert-heading">
                            <i class="fas fa-info-circle me-2"></i>Kategori: {{ $hasil->kategori_kesiapan }}
                        </h6>
                        <p class="mb-0">{{ $hasil->rekomendasi }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <style>
        @media print {

            .btn,
            .card-header,
            nav,
            .sidebar {
                display: none !important;
            }

            .main-content {
                margin-left: 0 !important;
                margin-top: 0 !important;
            }

            .card {
                border: 1px solid #ddd !important;
                box-shadow: none !important;
            }
        }
    </style>
@endpush
