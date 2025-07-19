@extends('layouts.app')

@section('title', 'Tambah Siswa - SPK CPI')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-primary mb-1">Tambah Siswa Baru</h2>
                    <p class="text-muted mb-0">Tambahkan data siswa baru ke sistem</p>
                </div>
                <div>
                    <a href="{{ route('admin.siswa.index') }}" class="btn btn-outline-secondary">
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
                    <h5 class="mb-0"><i class="fas fa-child text-primary me-2"></i>Form Tambah Siswa</h5>
                </div>
                <div class="card-body">
                    <!-- Form Guidelines -->
                    <div class="alert alert-info mb-4">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-info-circle me-2 mt-1"></i>
                            <div>
                                <h6 class="fw-bold mb-2">Panduan Pengisian Data Siswa:</h6>
                                <ul class="mb-0 small">
                                    <li>Kode siswa harus unik (contoh: A9, A10, dst.)</li>
                                    <li>Nama lengkap sesuai dengan identitas anak</li>
                                    <li>Data kelahiran dan orang tua membantu identifikasi</li>
                                    <li>Semua field bersifat opsional kecuali kode dan nama</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('admin.siswa.store') }}" method="POST" class="needs-validation-modal"
                        id="siswaCreateForm">
                        @csrf

                        <div class="row">
                            <!-- Kode Siswa -->
                            <div class="col-md-6 mb-3">
                                <label for="kode" class="form-label fw-bold">
                                    Kode Siswa <span class="text-danger">*</span>
                                    <i class="fas fa-question-circle text-muted ms-1" data-bs-toggle="tooltip"
                                        title="Kode unik untuk identifikasi siswa (contoh: A9, A10)"></i>
                                </label>
                                <input type="text" class="form-control @error('kode') is-invalid @enderror"
                                    id="kode" name="kode" value="{{ old('kode') }}" required
                                    placeholder="A9, A10, dst." maxlength="10">
                                <div class="form-text">
                                    <span id="kodeStatus" class="small"></span>
                                </div>
                                @error('kode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Nama Siswa -->
                            <div class="col-md-6 mb-3">
                                <label for="nama" class="form-label fw-bold">
                                    Nama Lengkap <span class="text-danger">*</span>
                                    <i class="fas fa-question-circle text-muted ms-1" data-bs-toggle="tooltip"
                                        title="Nama lengkap anak sesuai identitas"></i>
                                </label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    id="nama" name="nama" value="{{ old('nama') }}" required
                                    placeholder="Contoh: Andi Pratama">
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Jenis Kelamin -->
                            <div class="col-md-6 mb-3">
                                <label for="jenis_kelamin" class="form-label fw-bold">Jenis Kelamin</label>
                                <select class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin"
                                    name="jenis_kelamin">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin') === 'Laki-laki' ? 'selected' : '' }}>
                                        👦 Laki-laki
                                    </option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') === 'Perempuan' ? 'selected' : '' }}>
                                        👧 Perempuan
                                    </option>
                                </select>
                                @error('jenis_kelamin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tanggal Lahir -->
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_lahir" class="form-label fw-bold">
                                    Tanggal Lahir
                                    <i class="fas fa-question-circle text-muted ms-1" data-bs-toggle="tooltip"
                                        title="Akan dihitung otomatis untuk menentukan umur anak"></i>
                                </label>
                                <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                    id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                                    max="{{ date('Y-m-d') }}">
                                <div class="form-text">
                                    <span id="umurCalculated" class="small text-muted"></span>
                                </div>
                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Nama Orang Tua -->
                            <div class="col-12 mb-3">
                                <label for="nama_orang_tua" class="form-label fw-bold">Nama Orang Tua/Wali</label>
                                <input type="text" class="form-control @error('nama_orang_tua') is-invalid @enderror"
                                    id="nama_orang_tua" name="nama_orang_tua" value="{{ old('nama_orang_tua') }}"
                                    placeholder="Nama lengkap orang tua atau wali">
                                @error('nama_orang_tua')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Alamat -->
                            <div class="col-12 mb-3">
                                <label for="alamat" class="form-label fw-bold">Alamat</label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3"
                                    placeholder="Alamat lengkap tempat tinggal">{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Preview Data -->
                            <div class="col-12 mb-3">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-3">
                                            <i class="fas fa-preview me-2"></i>Preview Data Siswa
                                        </h6>
                                        <div class="row" id="previewData">
                                            <div class="col-12 text-muted text-center">
                                                Isi form untuk melihat preview data
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-12">
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Perhatian:</strong> Data siswa akan digunakan untuk perhitungan CPI.
                                    Pastikan data sudah benar sebelum menyimpan.
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.siswa.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-2"></i>Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary" id="submitBtn">
                                        <i class="fas fa-save me-2"></i>Simpan Siswa
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
            // Initialize tooltips
            const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            tooltips.forEach(tooltip => {
                new bootstrap.Tooltip(tooltip);
            });

            // Check kode availability (simulated)
            document.getElementById('kode').addEventListener('input', function() {
                const kode = this.value.trim();
                const statusSpan = document.getElementById('kodeStatus');

                if (kode.length >= 2) {
                    // Simulate checking - in real implementation, use AJAX
                    setTimeout(() => {
                        if (kode.match(/^[A-Z]\d+$/)) {
                            statusSpan.innerHTML =
                                '<i class="fas fa-check text-success me-1"></i>Format kode valid';
                            statusSpan.className = 'small text-success';
                        } else {
                            statusSpan.innerHTML =
                                '<i class="fas fa-times text-danger me-1"></i>Format: huruf diikuti angka (A9, B10)';
                            statusSpan.className = 'small text-danger';
                        }
                    }, 500);
                } else {
                    statusSpan.textContent = '';
                }
            });

            // Calculate age from birth date
            document.getElementById('tanggal_lahir').addEventListener('change', function() {
                const birthDate = new Date(this.value);
                const today = new Date();
                const umurSpan = document.getElementById('umurCalculated');

                if (this.value) {
                    const age = Math.floor((today - birthDate) / (365.25 * 24 * 60 * 60 * 1000));

                    if (age >= 0 && age <= 10) {
                        umurSpan.innerHTML =
                            `<i class="fas fa-birthday-cake text-success me-1"></i>Umur: ${age} tahun`;
                        umurSpan.className = 'small text-success';

                        if (age < 4 || age > 7) {
                            umurSpan.innerHTML +=
                                ` <i class="fas fa-exclamation-triangle text-warning ms-2"></i>`;
                            umurSpan.title = 'Umur di luar rentang normal PAUD (4-7 tahun)';
                        }
                    } else {
                        umurSpan.innerHTML =
                            '<i class="fas fa-exclamation text-danger me-1"></i>Tanggal lahir tidak valid';
                        umurSpan.className = 'small text-danger';
                    }
                } else {
                    umurSpan.textContent = '';
                }

                updatePreview();
            });

            // Update preview when form changes
            function updatePreview() {
                const previewDiv = document.getElementById('previewData');
                const formData = {
                    kode: document.getElementById('kode').value,
                    nama: document.getElementById('nama').value,
                    jenis_kelamin: document.getElementById('jenis_kelamin').value,
                    tanggal_lahir: document.getElementById('tanggal_lahir').value,
                    nama_orang_tua: document.getElementById('nama_orang_tua').value,
                    alamat: document.getElementById('alamat').value
                };

                if (!formData.kode && !formData.nama) {
                    previewDiv.innerHTML =
                        '<div class="col-12 text-muted text-center">Isi form untuk melihat preview data</div>';
                    return;
                }

                let previewHTML = '<div class="row">';

                if (formData.kode) {
                    previewHTML += `
                <div class="col-md-6 mb-2">
                    <strong class="text-primary">Kode:</strong> ${formData.kode}
                </div>`;
                }

                if (formData.nama) {
                    previewHTML += `
                <div class="col-md-6 mb-2">
                    <strong class="text-primary">Nama:</strong> ${formData.nama}
                </div>`;
                }

                if (formData.jenis_kelamin) {
                    const icon = formData.jenis_kelamin === 'Laki-laki' ? '👦' : '👧';
                    previewHTML += `
                <div class="col-md-6 mb-2">
                    <strong class="text-primary">Jenis Kelamin:</strong> ${icon} ${formData.jenis_kelamin}
                </div>`;
                }

                if (formData.tanggal_lahir) {
                    const date = new Date(formData.tanggal_lahir);
                    const options = {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    };
                    const formattedDate = date.toLocaleDateString('id-ID', options);
                    previewHTML += `
                <div class="col-md-6 mb-2">
                    <strong class="text-primary">Tanggal Lahir:</strong> ${formattedDate}
                </div>`;
                }

                if (formData.nama_orang_tua) {
                    previewHTML += `
                <div class="col-12 mb-2">
                    <strong class="text-primary">Orang Tua:</strong> ${formData.nama_orang_tua}
                </div>`;
                }

                if (formData.alamat) {
                    previewHTML += `
                <div class="col-12 mb-2">
                    <strong class="text-primary">Alamat:</strong> ${formData.alamat}
                </div>`;
                }

                previewHTML += '</div>';
                previewDiv.innerHTML = previewHTML;
            }

            // Add event listeners for preview update
            ['kode', 'nama', 'jenis_kelamin', 'nama_orang_tua', 'alamat'].forEach(field => {
                document.getElementById(field).addEventListener('input', updatePreview);
            });

            document.getElementById('jenis_kelamin').addEventListener('change', updatePreview);

            // Gender-based styling
            document.getElementById('jenis_kelamin').addEventListener('change', function() {
                const submitBtn = document.getElementById('submitBtn');
                if (this.value === 'Laki-laki') {
                    submitBtn.innerHTML = '<i class="fas fa-mars me-2"></i>Simpan Data Siswa';
                } else if (this.value === 'Perempuan') {
                    submitBtn.innerHTML = '<i class="fas fa-venus me-2"></i>Simpan Data Siswa';
                } else {
                    submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Simpan Siswa';
                }
            });

            // Auto-format kode input
            document.getElementById('kode').addEventListener('input', function() {
                this.value = this.value.toUpperCase();
            });
        });
    </script>
@endpush
