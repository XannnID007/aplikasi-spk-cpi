@extends('layouts.app')

@section('title', 'Detail Perhitungan - ' . $siswa->nama)

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-primary mb-1">Detail Perhitungan CPI</h2>
                    <p class="text-muted mb-0">{{ $siswa->nama }} ({{ $siswa->kode }})</p>
                </div>
                <div>
                    <a href="{{ route('admin.perhitungan.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <button onclick="window.print()" class="btn btn-success">
                        <i class="fas fa-print me-2"></i>Cetak Detail
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Info Siswa -->
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
                            <td>{{ $siswa->nama }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">Kode:</td>
                            <td><span class="badge bg-primary">{{ $siswa->kode }}</span></td>
                        </tr>
                        @if ($siswa->jenis_kelamin)
                            <tr>
                                <td class="fw-bold text-muted">Jenis Kelamin:</td>
                                <td>{{ $siswa->jenis_kelamin }}</td>
                            </tr>
                        @endif
                        @if ($siswa->umur)
                            <tr>
                                <td class="fw-bold text-muted">Umur:</td>
                                <td>{{ $siswa->umur }} tahun</td>
                            </tr>
                        @endif
                    </table>

                    @if ($siswa->hasilCpi)
                        <hr>
                        <div class="text-center">
                            <h6 class="fw-bold text-success">Hasil CPI</h6>
                            <h4 class="text-primary">{{ number_format($siswa->hasilCpi->skor_total, 2) }}</h4>
                            <p class="mb-2">Peringkat {{ $siswa->hasilCpi->peringkat }}</p>
                            <span class="badge bg-{{ $siswa->hasilCpi->warna_kategori }} px-3 py-2">
                                {{ $siswa->hasilCpi->kategori_kesiapan }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Detail Perhitungan -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-calculator text-success me-2"></i>Proses Perhitungan Step by Step
                    </h5>
                </div>
                <div class="card-body">
                    @if (count($perhitunganDetail) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kriteria</th>
                                        <th width="80" class="text-center">Nilai Mentah</th>
                                        <th width="80" class="text-center">Nilai Min</th>
                                        <th width="150">Rumus Normalisasi</th>
                                        <th width="100" class="text-center">Normalisasi</th>
                                        <th width="120">Rumus Terbobot</th>
                                        <th width="100" class="text-center">Terbobot</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($perhitunganDetail as $detail)
                                        <tr>
                                            <td>
                                                <div>
                                                    <span
                                                        class="badge bg-secondary me-2">{{ $detail['kriteria']->kode }}</span>
                                                    <strong>{{ $detail['kriteria']->nama }}</strong>
                                                    <br><small class="text-muted">
                                                        Tren: {{ $detail['kriteria']->tren }} |
                                                        Bobot: {{ number_format($detail['kriteria']->bobot * 100, 1) }}%
                                                    </small>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    class="fw-bold fs-6">{{ number_format($detail['penilaian']->nilai_mentah, 0) }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    class="text-info">{{ number_format($detail['nilai_min_kriteria'], 0) }}</span>
                                            </td>
                                            <td>
                                                <code class="small">{{ $detail['rumus_normalisasi'] }}</code>
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    class="fw-bold text-primary">{{ number_format($detail['normalisasi_calculated'], 2) }}</span>
                                                @if ($detail['penilaian']->nilai_normalisasi)
                                                    <br><small class="text-muted">(Stored:
                                                        {{ number_format($detail['penilaian']->nilai_normalisasi, 2) }})</small>
                                                @endif
                                            </td>
                                            <td>
                                                <code class="small">{{ $detail['rumus_terbobot'] }}</code>
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    class="fw-bold text-success">{{ number_format($detail['terbobot_calculated'], 2) }}</span>
                                                @if ($detail['penilaian']->nilai_terbobot)
                                                    <br><small class="text-muted">(Stored:
                                                        {{ number_format($detail['penilaian']->nilai_terbobot, 2) }})</small>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="6" class="text-end">Total Skor CPI:</th>
                                        <th class="text-center">
                                            <span
                                                class="fw-bold text-success fs-5">{{ number_format(collect($perhitunganDetail)->sum('terbobot_calculated'), 2) }}</span>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Penjelasan Perhitungan -->
                        <div class="mt-4">
                            <h6 class="fw-bold text-primary">Penjelasan Perhitungan:</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="alert alert-info">
                                        <h6 class="fw-bold mb-2">Langkah 1: Normalisasi</h6>
                                        <ul class="small mb-0">
                                            <li><strong>Tren Positif:</strong> Semakin tinggi nilai semakin baik</li>
                                            <li><strong>Tren Negatif:</strong> Semakin rendah nilai semakin baik</li>
                                            <li>Normalisasi menggunakan nilai minimum sebagai pembanding</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="alert alert-success">
                                        <h6 class="fw-bold mb-2">Langkah 2: Pembobotan</h6>
                                        <ul class="small mb-0">
                                            <li>Nilai normalisasi dikalikan dengan bobot kriteria</li>
                                            <li>Total semua bobot = 100% (1.0)</li>
                                            <li>Hasil akhir adalah jumlah semua nilai terbobot</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-exclamation-triangle text-warning fs-1 mb-3"></i>
                            <h5 class="text-warning">Data Penilaian Belum Lengkap</h5>
                            <p class="text-muted">Siswa ini belum memiliki penilaian untuk semua kriteria.</p>
                            <a href="{{ route('admin.penilaian.create') }}?siswa_id={{ $siswa->id }}"
                                class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Tambah Penilaian
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Radar Perbandingan -->
    @if (count($perhitunganDetail) > 0)
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-chart-radar text-info me-2"></i>Visualisasi Nilai per Kriteria
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($perhitunganDetail as $detail)
                                <div class="col-lg-2 col-md-4 col-6 mb-3 text-center">
                                    <div class="border rounded p-3">
                                        <div class="progress mb-2" style="height: 20px;">
                                            <div class="progress-bar bg-primary"
                                                style="width: {{ $detail['penilaian']->nilai_mentah }}%">
                                                {{ $detail['penilaian']->nilai_mentah }}
                                            </div>
                                        </div>
                                        <h6 class="fw-bold text-primary mb-1">{{ $detail['kriteria']->kode }}</h6>
                                        <small class="text-muted">{{ Str::limit($detail['kriteria']->nama, 20) }}</small>
                                        <div class="mt-2">
                                            <small class="text-success fw-bold">
                                                Terbobot: {{ number_format($detail['terbobot_calculated'], 2) }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Perbandingan dengan Siswa Lain -->
    @if ($siswa->hasilCpi)
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-users text-warning me-2"></i>Perbandingan dengan Siswa Lain
                        </h5>
                    </div>
                    <div class="card-body">
                        @php
                            $siswaTerdekat = \App\Models\HasilCpi::with('siswa')
                                ->where('id', '!=', $siswa->hasilCpi->id)
                                ->orderByRaw('ABS(skor_total - ?)', [$siswa->hasilCpi->skor_total])
                                ->take(5)
                                ->get();
                        @endphp

                        @if ($siswaTerdekat->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Peringkat</th>
                                            <th>Nama Siswa</th>
                                            <th class="text-center">Skor CPI</th>
                                            <th class="text-center">Selisih</th>
                                            <th class="text-center">Kategori</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="table-primary">
                                            <td><strong>{{ $siswa->hasilCpi->peringkat }}</strong></td>
                                            <td><strong>{{ $siswa->nama }} (Siswa Ini)</strong></td>
                                            <td class="text-center">
                                                <strong>{{ number_format($siswa->hasilCpi->skor_total, 2) }}</strong></td>
                                            <td class="text-center">-</td>
                                            <td class="text-center">
                                                <span class="badge bg-{{ $siswa->hasilCpi->warna_kategori }}">
                                                    {{ $siswa->hasilCpi->kategori_kesiapan }}
                                                </span>
                                            </td>
                                        </tr>
                                        @foreach ($siswaTerdekat as $pembanding)
                                            <tr>
                                                <td>{{ $pembanding->peringkat }}</td>
                                                <td>{{ $pembanding->siswa->nama }}</td>
                                                <td class="text-center">{{ number_format($pembanding->skor_total, 2) }}
                                                </td>
                                                <td class="text-center">
                                                    @php
                                                        $selisih =
                                                            $pembanding->skor_total - $siswa->hasilCpi->skor_total;
                                                    @endphp
                                                    <span class="text-{{ $selisih > 0 ? 'success' : 'danger' }}">
                                                        {{ $selisih > 0 ? '+' : '' }}{{ number_format($selisih, 2) }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-{{ $pembanding->warna_kategori }}">
                                                        {{ $pembanding->kategori_kesiapan }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
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
