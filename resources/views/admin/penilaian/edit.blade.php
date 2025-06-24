@extends('layouts.app')

@section('title', 'Edit Penilaian - SPK CPI')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-primary mb-1">Edit Penilaian</h2>
                    <p class="text-muted mb-0">Edit penilaian {{ $penilaian->siswa->nama }} -
                        {{ $penilaian->kriteria->nama }}</p>
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
                    <h5 class="mb-0"><i class="fas fa-edit text-primary me-2"></i>Form Edit Penilaian</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.penilaian.update', $penilaian->id) }}" method="POST">
                        @csrf
                        @method('PUT')

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
                                            {{ old('siswa_id', $penilaian->siswa_id) == $s->id ? 'selected' : '' }}>
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
                                            {{ old('kriteria_id', $penilaian->kriteria_id) == $k->id ? 'selected' : '' }}
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
                            <div class="col-12 mb-3">
                                <div class="alert alert-info">
                                    <h6 class="fw-bold mb-2">Informasi Kriteria Saat Ini:</h6>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <small><strong>Kode:</strong> {{ $penilaian->kriteria->kode }}</small>
                                        </div>
                                        <div class="col-md-4">
                                            <small><strong>Tren:</strong> {{ $penilaian->kriteria->tren }}</small>
                                        </div>
                                        <div class="col-md-4">
                                            <small><strong>Bobot:</strong>
                                                {{ number_format($penilaian->kriteria->bobot * 100, 1) }}%</small>
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
                                    name="nilai_mentah" value="{{ old('nilai_mentah', $penilaian->nilai_mentah) }}"
                                    required>
                                <div class="form-text">
                                    Masukkan nilai antara 0-100. Nilai normalisasi dan terbobot akan dihitung ulang saat
                                    perhitungan CPI.
                                </div>
                                @error('nilai_mentah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Info Nilai Sebelumnya -->
                            <div class="col-12 mb-3">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-2">Nilai Sebelumnya:</h6>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <small><strong>Nilai Mentah:</strong>
                                                    {{ number_format($penilaian->nilai_mentah, 0) }}</small>
                                            </div>
                                            <div class="col-md-4">
                                                <small><strong>Nilai Normalisasi:</strong>
                                                    {{ $penilaian->nilai_normalisasi ? number_format($penilaian->nilai_normalisasi, 2) : 'Belum dihitung' }}</small>
                                            </div>
                                            <div class="col-md-4">
                                                <small><strong>Nilai Terbobot:</strong>
                                                    {{ $penilaian->nilai_terbobot ? number_format($penilaian->nilai_terbobot, 2) : 'Belum dihitung' }}</small>
                                            </div>
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
                                        <i class="fas fa-save me-2"></i>Update Penilaian
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
