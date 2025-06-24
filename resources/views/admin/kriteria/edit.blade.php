@extends('layouts.app')

@section('title', 'Edit Kriteria - SPK CPI')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-primary mb-1">Edit Kriteria</h2>
                    <p class="text-muted mb-0">Edit kriteria {{ $kriteria->nama }}</p>
                </div>
                <div>
                    <a href="{{ route('admin.kriteria.index') }}" class="btn btn-outline-secondary">
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
                    <h5 class="mb-0"><i class="fas fa-edit text-primary me-2"></i>Form Edit Kriteria</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.kriteria.update', $kriteria->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Kode Kriteria -->
                            <div class="col-md-6 mb-3">
                                <label for="kode" class="form-label fw-bold">Kode Kriteria <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('kode') is-invalid @enderror"
                                    id="kode" name="kode" value="{{ old('kode', $kriteria->kode) }}" required>
                                @error('kode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tren -->
                            <div class="col-md-6 mb-3">
                                <label for="tren" class="form-label fw-bold">Tren <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('tren') is-invalid @enderror" id="tren"
                                    name="tren" required>
                                    <option value="">Pilih Tren</option>
                                    <option value="Positif"
                                        {{ old('tren', $kriteria->tren) === 'Positif' ? 'selected' : '' }}>
                                        Positif (Semakin tinggi semakin baik)
                                    </option>
                                    <option value="Negatif"
                                        {{ old('tren', $kriteria->tren) === 'Negatif' ? 'selected' : '' }}>
                                        Negatif (Semakin rendah semakin baik)
                                    </option>
                                </select>
                                @error('tren')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Nama Kriteria -->
                            <div class="col-12 mb-3">
                                <label for="nama" class="form-label fw-bold">Nama Kriteria <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    id="nama" name="nama" value="{{ old('nama', $kriteria->nama) }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Bobot -->
                            <div class="col-12 mb-3">
                                <label for="bobot" class="form-label fw-bold">Bobot Kriteria <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" step="0.001" min="0" max="1"
                                        class="form-control @error('bobot') is-invalid @enderror" id="bobot"
                                        name="bobot" value="{{ old('bobot', $kriteria->bobot) }}" required>
                                    <span class="input-group-text">
                                        <span id="bobot-persen">{{ number_format($kriteria->bobot * 100, 1) }}</span>%
                                    </span>
                                </div>
                                <div class="form-text">
                                    Masukkan nilai antara 0 dan 1 (contoh: 0.2 untuk 20%).
                                    Total semua bobot kriteria harus sama dengan 1.0 (100%).
                                </div>
                                @error('bobot')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Keterangan -->
                            <div class="col-12 mb-3">
                                <label for="keterangan" class="form-label fw-bold">Keterangan</label>
                                <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan"
                                    rows="3">{{ old('keterangan', $kriteria->keterangan) }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.kriteria.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-2"></i>Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Update Kriteria
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
        // Update persentase bobot secara real-time
        document.getElementById('bobot').addEventListener('input', function() {
            const bobotValue = parseFloat(this.value) || 0;
            const persentase = (bobotValue * 100).toFixed(1);
            document.getElementById('bobot-persen').textContent = persentase;
        });
    </script>
@endpush
