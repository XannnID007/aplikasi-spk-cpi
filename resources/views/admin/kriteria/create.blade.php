@extends('layouts.app')

@section('title', 'Tambah Kriteria - SPK CPI')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-primary mb-1">Tambah Kriteria Baru</h2>
                    <p class="text-muted mb-0">Tambahkan kriteria penilaian baru ke sistem</p>
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
                    <h5 class="mb-0"><i class="fas fa-list-check text-primary me-2"></i>Form Tambah Kriteria</h5>
                </div>
                <div class="card-body">
                    <!-- Form Guidelines -->
                    <div class="alert alert-info mb-4">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-info-circle me-2 mt-1"></i>
                            <div>
                                <h6 class="fw-bold mb-2">Panduan Pengisian Kriteria:</h6>
                                <ul class="mb-0 small">
                                    <li><strong>Tren Positif:</strong> Semakin tinggi nilai semakin baik (Keterampilan,
                                        Kemandirian)</li>
                                    <li><strong>Tren Negatif:</strong> Semakin rendah nilai semakin baik (Kecemasan,
                                        Kesulitan)</li>
                                    <li><strong>Total Bobot:</strong> Semua kriteria harus berjumlah 100% (1.0)</li>
                                    <li>Kode kriteria harus unik dan mudah diingat</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Current Criteria Summary -->
                    <div class="alert alert-light border mb-4" id="criteriaSummary">
                        <h6 class="fw-bold mb-2">
                            <i class="fas fa-balance-scale me-2"></i>Ringkasan Kriteria Saat Ini
                        </h6>
                        <div class="row text-center">
                            <div class="col-4">
                                <small class="text-muted">Total Kriteria</small>
                                <div class="fw-bold text-primary" id="totalCriteria">{{ \App\Models\Kriteria::count() }}
                                </div>
                            </div>
                            <div class="col-4">
                                <small class="text-muted">Total Bobot</small>
                                <div class="fw-bold" id="totalBobot">
                                    {{ number_format(\App\Models\Kriteria::sum('bobot') * 100, 1) }}%
                                </div>
                            </div>
                            <div class="col-4">
                                <small class="text-muted">Sisa Bobot</small>
                                <div class="fw-bold text-success" id="sisaBobot">
                                    {{ number_format((1 - \App\Models\Kriteria::sum('bobot')) * 100, 1) }}%
                                </div>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('admin.kriteria.store') }}" method="POST" class="needs-validation-modal"
                        id="kriteriaCreateForm">
                        @csrf

                        <div class="row">
                            <!-- Kode Kriteria -->
                            <div class="col-md-6 mb-3">
                                <label for="kode" class="form-label fw-bold">
                                    Kode Kriteria <span class="text-danger">*</span>
                                    <i class="fas fa-question-circle text-muted ms-1" data-bs-toggle="tooltip"
                                        title="Kode unik untuk identifikasi kriteria (contoh: C7, C8)"></i>
                                </label>
                                <input type="text" class="form-control @error('kode') is-invalid @enderror"
                                    id="kode" name="kode" value="{{ old('kode') }}" required
                                    placeholder="C7, C8, dst." maxlength="10">
                                <div class="form-text">
                                    <span id="kodeStatus" class="small"></span>
                                </div>
                                @error('kode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tren -->
                            <div class="col-md-6 mb-3">
                                <label for="tren" class="form-label fw-bold">
                                    Tren <span class="text-danger">*</span>
                                    <i class="fas fa-question-circle text-muted ms-1" data-bs-toggle="tooltip"
                                        title="Positif: nilai tinggi = baik | Negatif: nilai rendah = baik"></i>
                                </label>
                                <select class="form-select @error('tren') is-invalid @enderror" id="tren"
                                    name="tren" required>
                                    <option value="">Pilih Tren</option>
                                    <option value="Positif" {{ old('tren') === 'Positif' ? 'selected' : '' }}>
                                        📈 Positif (Semakin tinggi semakin baik)
                                    </option>
                                    <option value="Negatif" {{ old('tren') === 'Negatif' ? 'selected' : '' }}>
                                        📉 Negatif (Semakin rendah semakin baik)
                                    </option>
                                </select>
                                <div class="form-text">
                                    <span id="trenExplanation" class="small text-muted"></span>
                                </div>
                                @error('tren')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Nama Kriteria -->
                            <div class="col-12 mb-3">
                                <label for="nama" class="form-label fw-bold">
                                    Nama Kriteria <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    id="nama" name="nama" value="{{ old('nama') }}" required
                                    placeholder="Contoh: Kemampuan Komunikasi">
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Bobot -->
                            <div class="col-12 mb-3">
                                <label for="bobot" class="form-label fw-bold">
                                    Bobot Kriteria <span class="text-danger">*</span>
                                    <i class="fas fa-question-circle text-muted ms-1" data-bs-toggle="tooltip"
                                        title="Bobot menunjukkan tingkat kepentingan kriteria (0.001 - 1.000)"></i>
                                </label>
                                <div class="input-group">
                                    <input type="number" step="0.001" min="0.001" max="1"
                                        class="form-control @error('bobot') is-invalid @enderror" id="bobot"
                                        name="bobot" value="{{ old('bobot') }}" required>
                                    <span class="input-group-text">
                                        <span id="bobot-persen">0.0</span>%
                                    </span>
                                </div>
                                <div class="form-text">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <small class="text-muted">Sisa bobot tersedia:
                                                <span id="sisaBobotInput" class="fw-bold text-success">
                                                    {{ number_format((1 - \App\Models\Kriteria::sum('bobot')) * 100, 1) }}%
                                                </span>
                                            </small>
                                        </div>
                                        <div class="col-md-6">
                                            <div id="bobotSlider" class="mt-2"></div>
                                        </div>
                                    </div>
                                </div>
                                @error('bobot')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Bobot Suggestions -->
                            <div class="col-12 mb-3">
                                <div class="card bg-light">
                                    <div class="card-body py-2">
                                        <small class="fw-bold text-muted">Saran Bobot:</small>
                                        <div class="btn-group btn-group-sm mt-1" role="group">
                                            <button type="button" class="btn btn-outline-secondary bobot-suggestion"
                                                data-bobot="0.050">5%</button>
                                            <button type="button" class="btn btn-outline-secondary bobot-suggestion"
                                                data-bobot="0.100">10%</button>
                                            <button type="button" class="btn btn-outline-secondary bobot-suggestion"
                                                data-bobot="0.150">15%</button>
                                            <button type="button" class="btn btn-outline-secondary bobot-suggestion"
                                                data-bobot="0.200">20%</button>
                                            <button type="button" class="btn btn-outline-secondary bobot-suggestion"
                                                data-bobot="0.250">25%</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Keterangan -->
                            <div class="col-12 mb-3">
                                <label for="keterangan" class="form-label fw-bold">Keterangan</label>
                                <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan"
                                    rows="3" placeholder="Jelaskan detail tentang kriteria ini...">{{ old('keterangan') }}</textarea>
                                <div class="form-text">
                                    <span id="charCount" class="small text-muted">0 karakter</span>
                                </div>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Preview Kriteria -->
                            <div class="col-12 mb-3">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-3">
                                            <i class="fas fa-preview me-2"></i>Preview Kriteria
                                        </h6>
                                        <div id="previewKriteria">
                                            <div class="text-muted text-center">Isi form untuk melihat preview kriteria
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-12">
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Perhatian:</strong> Kriteria yang sudah disimpan akan mempengaruhi
                                    perhitungan CPI. Pastikan bobot dan tren sudah benar.
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.kriteria.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-2"></i>Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary" id="submitBtn">
                                        <i class="fas fa-save me-2"></i>Simpan Kriteria
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
        document.addEventListener('DOMContentLoaded', function() {
            const currentTotalBobot = {{ \App\Models\Kriteria::sum('bobot') }};
            const sisaBobot = 1 - currentTotalBobot;

            // Initialize tooltips
            const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            tooltips.forEach(tooltip => {
                new bootstrap.Tooltip(tooltip);
            });

            // Check kode availability
            document.getElementById('kode').addEventListener('input', function() {
                const kode = this.value.trim().toUpperCase();
                this.value = kode;
                const statusSpan = document.getElementById('kodeStatus');

                if (kode.length >= 2) {
                    if (kode.match(/^[A-Z]\d+$/)) {
                        statusSpan.innerHTML =
                            '<i class="fas fa-check text-success me-1"></i>Format kode valid';
                        statusSpan.className = 'small text-success';
                    } else {
                        statusSpan.innerHTML =
                            '<i class="fas fa-times text-danger me-1"></i>Format: huruf diikuti angka (C7, C8)';
                        statusSpan.className = 'small text-danger';
                    }
                } else {
                    statusSpan.textContent = '';
                }
                updatePreview();
            });

            // Tren explanation
            document.getElementById('tren').addEventListener('change', function() {
                const trenExplanation = document.getElementById('trenExplanation');
                const submitBtn = document.getElementById('submitBtn');

                if (this.value === 'Positif') {
                    trenExplanation.innerHTML =
                        '<i class="fas fa-arrow-up text-success me-1"></i>Contoh: Keterampilan, Kemampuan, Kemandirian';
                    submitBtn.innerHTML = '<i class="fas fa-arrow-up me-2"></i>Simpan Kriteria Positif';
                } else if (this.value === 'Negatif') {
                    trenExplanation.innerHTML =
                        '<i class="fas fa-arrow-down text-warning me-1"></i>Contoh: Kecemasan, Kesulitan, Hambatan';
                    submitBtn.innerHTML = '<i class="fas fa-arrow-down me-2"></i>Simpan Kriteria Negatif';
                } else {
                    trenExplanation.textContent = '';
                    submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Simpan Kriteria';
                }
                updatePreview();
            });

            // Update persentase bobot secara real-time
            document.getElementById('bobot').addEventListener('input', function() {
                const bobotValue = parseFloat(this.value) || 0;
                const persentase = (bobotValue * 100).toFixed(1);
                const sisaBobotElement = document.getElementById('sisaBobotInput');
                const newSisa = (sisaBobot - bobotValue) * 100;

                document.getElementById('bobot-persen').textContent = persentase;

                if (newSisa < 0) {
                    sisaBobotElement.textContent = '0.0%';
                    sisaBobotElement.className = 'fw-bold text-danger';
                    this.classList.add('is-invalid');
                } else {
                    sisaBobotElement.textContent = newSisa.toFixed(1) + '%';
                    sisaBobotElement.className = 'fw-bold text-success';
                    this.classList.remove('is-invalid');
                }

                updatePreview();
            });

            // Bobot suggestions
            document.querySelectorAll('.bobot-suggestion').forEach(btn => {
                btn.addEventListener('click', function() {
                    const bobot = parseFloat(this.dataset.bobot);
                    document.getElementById('bobot').value = bobot;
                    document.getElementById('bobot').dispatchEvent(new Event('input'));
                });
            });

            // Character count for keterangan
            document.getElementById('keterangan').addEventListener('input', function() {
                const charCount = this.value.length;
                document.getElementById('charCount').textContent = charCount + ' karakter';
                updatePreview();
            });

            // Update preview when form changes
            function updatePreview() {
                const previewDiv = document.getElementById('previewKriteria');
                const formData = {
                    kode: document.getElementById('kode').value,
                    nama: document.getElementById('nama').value,
                    tren: document.getElementById('tren').value,
                    bobot: document.getElementById('bobot').value,
                    keterangan: document.getElementById('keterangan').value
                };

                if (!formData.kode && !formData.nama) {
                    previewDiv.innerHTML =
                        '<div class="text-muted text-center">Isi form untuk melihat preview kriteria</div>';
                    return;
                }

                let previewHTML = '<div class="row">';

                if (formData.kode) {
                    previewHTML += `
                <div class="col-md-6 mb-2">
                    <span class="badge bg-secondary me-2">${formData.kode}</span>
                    <strong class="text-primary">Kode Kriteria</strong>
                </div>`;
                }

                if (formData.nama) {
                    previewHTML += `
                <div class="col-md-6 mb-2">
                    <strong class="text-primary">Nama:</strong> ${formData.nama}
                </div>`;
                }

                if (formData.tren) {
                    const trenIcon = formData.tren === 'Positif' ? '📈' : '📉';
                    const trenColor = formData.tren === 'Positif' ? 'success' : 'warning';
                    previewHTML += `
                <div class="col-md-6 mb-2">
                    <span class="badge bg-${trenColor} me-2">${trenIcon} ${formData.tren}</span>
                    <strong class="text-primary">Tren</strong>
                </div>`;
                }

                if (formData.bobot) {
                    const bobotPersen = (parseFloat(formData.bobot) * 100).toFixed(1);
                    previewHTML += `
                <div class="col-md-6 mb-2">
                    <span class="badge bg-primary me-2">${bobotPersen}%</span>
                    <strong class="text-primary">Bobot</strong>
                </div>`;
                }

                if (formData.keterangan) {
                    previewHTML += `
                <div class="col-12 mb-2">
                    <strong class="text-primary">Keterangan:</strong><br>
                    <small class="text-muted">${formData.keterangan}</small>
                </div>`;
                }

                previewHTML += '</div>';
                previewDiv.innerHTML = previewHTML;
            }

            // Add event listeners for preview update
            ['kode', 'nama', 'keterangan'].forEach(field => {
                document.getElementById(field).addEventListener('input', updatePreview);
            });

            // Validation before submit
            document.getElementById('kriteriaCreateForm').addEventListener('submit', function(e) {
                const bobot = parseFloat(document.getElementById('bobot').value) || 0;
                const newTotal = currentTotalBobot + bobot;

                if (newTotal > 1.001) { // Small tolerance for floating point
                    e.preventDefault();
                    alert('Total bobot melebihi 100%! Silakan kurangi bobot kriteria ini.');
                    return false;
                }

                if (bobot < 0.001) {
                    e.preventDefault();
                    alert('Bobot kriteria minimal 0.1%');
                    return false;
                }
            });

            // Auto-suggest nama kriteria based on kode
            document.getElementById('kode').addEventListener('blur', function() {
                const kode = this.value.trim();
                const namaField = document.getElementById('nama');

                if (kode && !namaField.value) {
                    const suggestions = {
                        'C7': 'Kemampuan Komunikasi',
                        'C8': 'Kreativitas dan Imajinasi',
                        'C9': 'Kemampuan Adaptasi',
                        'C10': 'Koordinasi Motorik'
                    };

                    if (suggestions[kode]) {
                        namaField.value = suggestions[kode];
                        namaField.focus();
                        updatePreview();
                    }
                }
            });

            // Real-time bobot validation warning
            document.getElementById('bobot').addEventListener('input', function() {
                const bobot = parseFloat(this.value) || 0;
                const newTotal = currentTotalBobot + bobot;
                const alertDiv = document.querySelector('.alert-warning');

                if (newTotal > 0.95 && newTotal <= 1) {
                    alertDiv.className = 'alert alert-success';
                    alertDiv.innerHTML =
                        '<i class="fas fa-check-circle me-2"></i><strong>Bagus!</strong> Total bobot akan mendekati 100% setelah kriteria ini disimpan.';
                } else if (newTotal > 1) {
                    alertDiv.className = 'alert alert-danger';
                    alertDiv.innerHTML =
                        '<i class="fas fa-exclamation-circle me-2"></i><strong>Peringatan!</strong> Total bobot akan melebihi 100%. Kurangi bobot kriteria ini.';
                } else {
                    alertDiv.className = 'alert alert-warning';
                    alertDiv.innerHTML =
                        '<i class="fas fa-exclamation-triangle me-2"></i><strong>Perhatian:</strong> Kriteria yang sudah disimpan akan mempengaruhi perhitungan CPI. Pastikan bobot dan tren sudah benar.';
                }
            });
        });
    </script>
@endpush
