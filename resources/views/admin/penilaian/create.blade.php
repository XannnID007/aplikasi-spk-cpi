@extends('layouts.app')

@section('title', 'Tambah Penilaian - SPK CPI')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-primary mb-1">Tambah Penilaian Baru</h2>
                    <p class="text-muted mb-0">Input nilai penilaian siswa untuk kriteria tertentu</p>
                </div>
                <div>
                    <a href="{{ route('admin.penilaian.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-star text-primary me-2"></i>Form Tambah Penilaian</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.penilaian.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <!-- Siswa -->
                            <div class="col-md-6 mb-3">
                                <label for="siswa_id" class="form-label fw-bold">Pilih Siswa <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('siswa_id') is-invalid @enderror" id="siswa_id"
                                    name="siswa_id" required>
                                    <option value="">Pilih Siswa</option>
                                    @foreach ($siswa as $s)
                                        <option value="{{ $s->id }}"
                                            {{ old('siswa_id', request('siswa_id')) == $s->id ? 'selected' : '' }}>
                                            {{ $s->kode }} - {{ $s->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('siswa_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Kriteria -->
                            <div class="col-md-6 mb-3">
                                <label for="kriteria_id" class="form-label fw-bold">Pilih Kriteria <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('kriteria_id') is-invalid @enderror" id="kriteria_id"
                                    name="kriteria_id" required>
                                    <option value="">Pilih Kriteria</option>
                                    @foreach ($kriteria as $k)
                                        <option value="{{ $k->id }}"
                                            {{ old('kriteria_id', request('kriteria_id')) == $k->id ? 'selected' : '' }}
                                            data-tren="{{ $k->tren }}"
                                            data-bobot="{{ number_format($k->bobot * 100, 1) }}">
                                            {{ $k->kode }} - {{ $k->nama }}
                                            ({{ number_format($k->bobot * 100, 1) }}%)
                                        </option>
                                    @endforeach
                                </select>
                                @error('kriteria_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Info Kriteria -->
                            <div class="col-12 mb-3" id="kriteria-info" style="display: none;">
                                <div class="alert alert-info">
                                    <h6 class="fw-bold mb-2">Informasi Kriteria:</h6>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <small><strong>Tren:</strong> <span id="info-tren"></span></small>
                                        </div>
                                        <div class="col-md-4">
                                            <small><strong>Bobot:</strong> <span id="info-bobot"></span>%</small>
                                        </div>
                                        <div class="col-md-4">
                                            <small><strong>Keterangan:</strong> <span id="info-keterangan"></span></small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Nilai Mentah -->
                            <div class="col-12 mb-3">
                                <label for="nilai_mentah" class="form-label fw-bold">Nilai Mentah <span
                                        class="text-danger">*</span></label>
                                <input type="number" min="0" max="100"
                                    class="form-control @error('nilai_mentah') is-invalid @enderror" id="nilai_mentah"
                                    name="nilai_mentah" value="{{ old('nilai_mentah') }}" required>
                                <div class="form-text">
                                    Masukkan nilai antara 0-100. Nilai ini akan dinormalisasi otomatis saat perhitungan CPI.
                                </div>
                                @error('nilai_mentah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Preview Nilai -->
                            <div class="col-12 mb-3">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-2">Preview Kategori Nilai:</h6>
                                        <div id="nilai-preview">
                                            <span class="text-muted">Masukkan nilai untuk melihat kategori</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.penilaian.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-2"></i>Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Simpan Penilaian
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Data kriteria untuk info dinamis
        const kriteriaData = @json(
            $kriteria->map(function ($k) {
                return [
                    'id' => $k->id,
                    'kode' => $k->kode,
                    'nama' => $k->nama,
                    'tren' => $k->tren,
                    'bobot' => $k->bobot,
                    'keterangan' => $k->keterangan,
                ];
            }));

        // Update info kriteria
        document.getElementById('kriteria_id').addEventListener('change', function() {
            const kriteriaId = this.value;
            const infoDiv = document.getElementById('kriteria-info');

            if (kriteriaId) {
                const kriteria = kriteriaData.find(k => k.id == kriteriaId);
                if (kriteria) {
                    document.getElementById('info-tren').textContent = kriteria.tren;
                    document.getElementById('info-bobot').textContent = (kriteria.bobot * 100).toFixed(1);
                    document.getElementById('info-keterangan').textContent = kriteria.keterangan ||
                        'Tidak ada keterangan';
                    infoDiv.style.display = 'block';
                }
            } else {
                infoDiv.style.display = 'none';
            }
        });

        // Preview kategori nilai
        document.getElementById('nilai_mentah').addEventListener('input', function() {
            const nilai = parseFloat(this.value);
            const previewDiv = document.getElementById('nilai-preview');

            if (nilai >= 0 && nilai <= 100) {
                let kategori, badgeClass;

                if (nilai >= 81) {
                    kategori = 'Sangat Baik';
                    badgeClass = 'bg-primary';
                } else if (nilai >= 61) {
                    kategori = 'Baik';
                    badgeClass = 'bg-success';
                } else if (nilai >= 41) {
                    kategori = 'Cukup';
                    badgeClass = 'bg-info';
                } else if (nilai >= 21) {
                    kategori = 'Kurang';
                    badgeClass = 'bg-warning';
                } else {
                    kategori = 'Sangat Kurang';
                    badgeClass = 'bg-danger';
                }

                previewDiv.innerHTML = `<span class="badge ${badgeClass} px-3 py-2">${kategori} (${nilai})</span>`;
            } else {
                previewDiv.innerHTML = '<span class="text-muted">Masukkan nilai 0-100</span>';
            }
        });

        // Trigger events jika ada nilai default
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('kriteria_id').dispatchEvent(new Event('change'));
            document.getElementById('nilai_mentah').dispatchEvent(new Event('input'));
        });
    </script>
@endpush
