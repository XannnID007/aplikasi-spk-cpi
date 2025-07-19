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
                    <!-- Form Guidelines -->
                    <div class="alert alert-info mb-4">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-info-circle me-2 mt-1"></i>
                            <div>
                                <h6 class="fw-bold mb-2">Panduan Penilaian:</h6>
                                <ul class="mb-0 small">
                                    <li><strong>Skala Nilai:</strong> 0-100 (0=sangat kurang, 100=sangat baik)</li>
                                    <li><strong>Objektif:</strong> Berikan penilaian berdasarkan observasi nyata</li>
                                    <li><strong>Konsisten:</strong> Gunakan standar yang sama untuk semua siswa</li>
                                    <li>Setiap siswa hanya bisa dinilai sekali per kriteria</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="alert alert-light border mb-4">
                        <h6 class="fw-bold mb-2">
                            <i class="fas fa-chart-bar me-2"></i>Statistik Penilaian
                        </h6>
                        <div class="row text-center">
                            <div class="col-4">
                                <small class="text-muted">Total Siswa</small>
                                <div class="fw-bold text-primary">{{ $siswa->count() }}</div>
                            </div>
                            <div class="col-4">
                                <small class="text-muted">Total Kriteria</small>
                                <div class="fw-bold text-success">{{ $kriteria->count() }}</div>
                            </div>
                            <div class="col-4">
                                <small class="text-muted">Penilaian Selesai</small>
                                <div class="fw-bold text-info">{{ \App\Models\Penilaian::count() }}</div>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('admin.penilaian.store') }}" method="POST" class="needs-validation-modal"
                        id="penilaianCreateForm">
                        @csrf

                        <div class="row">
                            <!-- Siswa -->
                            <div class="col-md-6 mb-3">
                                <label for="siswa_id" class="form-label fw-bold">
                                    Pilih Siswa <span class="text-danger">*</span>
                                    <i class="fas fa-question-circle text-muted ms-1" data-bs-toggle="tooltip"
                                        title="Pilih siswa yang akan dinilai"></i>
                                </label>
                                <select class="form-select @error('siswa_id') is-invalid @enderror" id="siswa_id"
                                    name="siswa_id" required>
                                    <option value="">Pilih Siswa</option>
                                    @foreach ($siswa as $s)
                                        <option value="{{ $s->id }}"
                                            {{ old('siswa_id', request('siswa_id')) == $s->id ? 'selected' : '' }}
                                            data-kode="{{ $s->kode }}" data-gender="{{ $s->jenis_kelamin }}"
                                            data-age="{{ $s->umur }}">
                                            {{ $s->kode }} - {{ $s->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text">
                                    <span id="siswaInfo" class="small text-muted"></span>
                                </div>
                                @error('siswa_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Kriteria -->
                            <div class="col-md-6 mb-3">
                                <label for="kriteria_id" class="form-label fw-bold">
                                    Pilih Kriteria <span class="text-danger">*</span>
                                    <i class="fas fa-question-circle text-muted ms-1" data-bs-toggle="tooltip"
                                        title="Pilih kriteria yang akan dinilai"></i>
                                </label>
                                <select class="form-select @error('kriteria_id') is-invalid @enderror" id="kriteria_id"
                                    name="kriteria_id" required>
                                    <option value="">Pilih Kriteria</option>
                                    @foreach ($kriteria as $k)
                                        <option value="{{ $k->id }}"
                                            {{ old('kriteria_id', request('kriteria_id')) == $k->id ? 'selected' : '' }}
                                            data-tren="{{ $k->tren }}"
                                            data-bobot="{{ number_format($k->bobot * 100, 1) }}"
                                            data-keterangan="{{ $k->keterangan }}">
                                            {{ $k->kode }} - {{ $k->nama }}
                                            ({{ number_format($k->bobot * 100, 1) }}%)
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text">
                                    <span id="kriteriaInfo" class="small text-muted"></span>
                                </div>
                                @error('kriteria_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Info Kriteria -->
                            <div class="col-12 mb-3" id="kriteria-detail" style="display: none;">
                                <div class="alert alert-info">
                                    <h6 class="fw-bold mb-2">Informasi Kriteria:</h6>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <small><strong>Tren:</strong> <span id="info-tren"></span></small>
                                        </div>
                                        <div class="col-md-3">
                                            <small><strong>Bobot:</strong> <span id="info-bobot"></span>%</small>
                                        </div>
                                        <div class="col-md-6">
                                            <small><strong>Keterangan:</strong> <span id="info-keterangan"></span></small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Nilai Mentah -->
                            <div class="col-12 mb-3">
                                <label for="nilai_mentah" class="form-label fw-bold">
                                    Nilai Penilaian <span class="text-danger">*</span>
                                    <i class="fas fa-question-circle text-muted ms-1" data-bs-toggle="tooltip"
                                        title="Masukkan nilai 0-100 berdasarkan observasi"></i>
                                </label>
                                <div class="input-group">
                                    <input type="number" min="0" max="100"
                                        class="form-control @error('nilai_mentah') is-invalid @enderror" id="nilai_mentah"
                                        name="nilai_mentah" value="{{ old('nilai_mentah') }}" required
                                        placeholder="0-100">
                                    <span class="input-group-text">
                                        <span id="nilai-persen">0</span>/100
                                    </span>
                                </div>

                                <!-- Nilai Slider -->
                                <div class="mt-3">
                                    <input type="range" class="form-range" id="nilaiSlider" min="0"
                                        max="100" value="0">
                                    <div class="d-flex justify-content-between small text-muted">
                                        <span>0 (Sangat Kurang)</span>
                                        <span>25 (Kurang)</span>
                                        <span>50 (Cukup)</span>
                                        <span>75 (Baik)</span>
                                        <span>100 (Sangat Baik)</span>
                                    </div>
                                </div>

                                <div class="form-text">
                                    Nilai ini akan dinormalisasi otomatis saat perhitungan CPI.
                                </div>
                                @error('nilai_mentah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Preview Kategori Nilai -->
                            <div class="col-12 mb-3">
                                <div class="card bg-light">
                                    <div class="card-body py-3">
                                        <div class="row align-items-center">
                                            <div class="col-md-6">
                                                <h6 class="fw-bold mb-2">Kategori Penilaian:</h6>
                                                <div id="nilai-preview">
                                                    <span class="text-muted">Masukkan nilai untuk melihat kategori</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <h6 class="fw-bold mb-2">Progress Visual:</h6>
                                                <div class="progress" style="height: 25px;">
                                                    <div class="progress-bar" id="progress-bar" style="width: 0%">0%
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Panduan Penilaian Dinamis -->
                            <div class="col-12 mb-3" id="panduan-penilaian" style="display: none;">
                                <div class="card border-primary">
                                    <div class="card-body py-3">
                                        <h6 class="fw-bold text-primary mb-2">
                                            <i class="fas fa-lightbulb me-2"></i>Panduan Penilaian untuk Kriteria Ini:
                                        </h6>
                                        <div id="panduan-content" class="small"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Existing Assessment Check -->
                            <div class="col-12 mb-3" id="existing-check" style="display: none;">
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Peringatan:</strong> <span id="existing-message"></span>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-12">
                                <div class="alert alert-success">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Info:</strong> Setelah klik "Simpan Penilaian", sistem akan menampilkan
                                    konfirmasi data sebelum menyimpan ke database.
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.penilaian.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-2"></i>Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary" id="submitBtn">
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
        document.addEventListener('DOMContentLoaded', function() {
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

            // Data siswa untuk info dinamis
            const siswaData = @json(
                $siswa->map(function ($s) {
                    return [
                        'id' => $s->id,
                        'kode' => $s->kode,
                        'nama' => $s->nama,
                        'jenis_kelamin' => $s->jenis_kelamin,
                        'umur' => $s->umur,
                    ];
                }));

            // Initialize tooltips
            const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            tooltips.forEach(tooltip => {
                new bootstrap.Tooltip(tooltip);
            });

            // Update info siswa
            document.getElementById('siswa_id').addEventListener('change', function() {
                const siswaId = this.value;
                const infoSpan = document.getElementById('siswaInfo');

                if (siswaId) {
                    const siswa = siswaData.find(s => s.id == siswaId);
                    if (siswa) {
                        let info = `<i class="fas fa-user text-primary me-1"></i>`;
                        if (siswa.jenis_kelamin) {
                            const icon = siswa.jenis_kelamin === 'Laki-laki' ? '👦' : '👧';
                            info += `${icon} ${siswa.jenis_kelamin}`;
                        }
                        if (siswa.umur) {
                            info += ` | ${siswa.umur} tahun`;
                        }
                        infoSpan.innerHTML = info;
                    }
                } else {
                    infoSpan.textContent = '';
                }
                checkExistingAssessment();
            });

            // Update info kriteria
            document.getElementById('kriteria_id').addEventListener('change', function() {
                const kriteriaId = this.value;
                const infoDiv = document.getElementById('kriteria-detail');
                const infoSpan = document.getElementById('kriteriaInfo');
                const panduanDiv = document.getElementById('panduan-penilaian');

                if (kriteriaId) {
                    const kriteria = kriteriaData.find(k => k.id == kriteriaId);
                    if (kriteria) {
                        // Update basic info
                        document.getElementById('info-tren').textContent = kriteria.tren;
                        document.getElementById('info-bobot').textContent = (kriteria.bobot * 100).toFixed(
                            1);
                        document.getElementById('info-keterangan').textContent = kriteria.keterangan ||
                            'Tidak ada keterangan';
                        infoDiv.style.display = 'block';

                        // Update short info
                        const trenIcon = kriteria.tren === 'Positif' ? '📈' : '📉';
                        infoSpan.innerHTML =
                            `${trenIcon} ${kriteria.tren} | Bobot: ${(kriteria.bobot * 100).toFixed(1)}%`;

                        // Update panduan
                        updatePanduanPenilaian(kriteria);
                        panduanDiv.style.display = 'block';
                    }
                } else {
                    infoDiv.style.display = 'none';
                    infoSpan.textContent = '';
                    panduanDiv.style.display = 'none';
                }
                checkExistingAssessment();
            });

            // Update panduan penilaian berdasarkan kriteria
            function updatePanduanPenilaian(kriteria) {
                const panduanContent = document.getElementById('panduan-content');
                let panduan = '';

                // Panduan umum berdasarkan nama kriteria
                if (kriteria.nama.toLowerCase().includes('sosial') || kriteria.nama.toLowerCase().includes(
                    'emosi')) {
                    panduan = `
                <strong>Amati:</strong> Interaksi dengan teman, kemampuan berbagi, mengontrol emosi<br>
                <strong>100:</strong> Sangat mudah bersosialisasi, stabil emosi | 
                <strong>75:</strong> Baik bersosialisasi | 
                <strong>50:</strong> Cukup | 
                <strong>25:</strong> Kesulitan berinteraksi | 
                <strong>0:</strong> Sangat sulit bersosialisasi
            `;
                } else if (kriteria.nama.toLowerCase().includes('kognitif') || kriteria.nama.toLowerCase().includes(
                        'berpikir')) {
                    panduan = `
                <strong>Amati:</strong> Pemahaman konsep, pemecahan masalah, daya ingat<br>
                <strong>100:</strong> Sangat cepat memahami | 
                <strong>75:</strong> Mudah memahami | 
                <strong>50:</strong> Cukup memahami | 
                <strong>25:</strong> Butuh bantuan | 
                <strong>0:</strong> Sangat sulit memahami
            `;
                } else if (kriteria.nama.toLowerCase().includes('motorik') || kriteria.nama.toLowerCase().includes(
                        'fisik')) {
                    panduan = `
                <strong>Amati:</strong> Koordinasi gerak, keseimbangan, keterampilan tangan<br>
                <strong>100:</strong> Sangat terampil | 
                <strong>75:</strong> Terampil | 
                <strong>50:</strong> Cukup terampil | 
                <strong>25:</strong> Kurang terampil | 
                <strong>0:</strong> Sangat kurang terampil
            `;
                } else if (kriteria.nama.toLowerCase().includes('kemandirian')) {
                    panduan = `
                <strong>Amati:</strong> Kemampuan melakukan tugas sendiri, inisiatif, tanggung jawab<br>
                <strong>100:</strong> Sangat mandiri | 
                <strong>75:</strong> Mandiri | 
                <strong>50:</strong> Cukup mandiri | 
                <strong>25:</strong> Perlu bantuan | 
                <strong>0:</strong> Sangat bergantung
            `;
                } else if (kriteria.nama.toLowerCase().includes('cemas') || kriteria.nama.toLowerCase().includes(
                        'takut')) {
                    panduan = `
                <strong>Amati:</strong> Tingkat kecemasan dalam situasi baru atau tantangan<br>
                <strong>0:</strong> Sangat cemas/takut | 
                <strong>25:</strong> Cemas | 
                <strong>50:</strong> Cukup tenang | 
                <strong>75:</strong> Tenang | 
                <strong>100:</strong> Sangat tenang dan percaya diri
            `;
                } else {
                    panduan = `
                <strong>Panduan Umum:</strong><br>
                <strong>100:</strong> Sangat baik/optimal | 
                <strong>75:</strong> Baik | 
                <strong>50:</strong> Cukup/rata-rata | 
                <strong>25:</strong> Kurang | 
                <strong>0:</strong> Sangat kurang
            `;
                }

                // Tambahan untuk tren negatif
                if (kriteria.tren === 'Negatif') {
                    panduan +=
                        `<br><br><span class="text-warning"><strong>⚠️ Tren Negatif:</strong> Semakin rendah nilai semakin baik untuk kriteria ini.</span>`;
                }

                panduanContent.innerHTML = panduan;
            }

            // Sinkronisasi slider dan input nilai
            const nilaiInput = document.getElementById('nilai_mentah');
            const nilaiSlider = document.getElementById('nilaiSlider');
            const nilaiPersen = document.getElementById('nilai-persen');

            function updateNilai(value) {
                nilaiInput.value = value;
                nilaiSlider.value = value;
                nilaiPersen.textContent = value;
                updatePreviewKategori(value);
            }

            nilaiInput.addEventListener('input', function() {
                updateNilai(this.value);
            });

            nilaiSlider.addEventListener('input', function() {
                updateNilai(this.value);
            });

            // Preview kategori nilai
            function updatePreviewKategori(nilai) {
                const previewDiv = document.getElementById('nilai-preview');
                const progressBar = document.getElementById('progress-bar');
                nilai = parseInt(nilai) || 0;

                let kategori, badgeClass, description;

                if (nilai >= 81) {
                    kategori = 'Sangat Baik';
                    badgeClass = 'bg-success';
                    description = 'Kemampuan sangat optimal';
                } else if (nilai >= 61) {
                    kategori = 'Baik';
                    badgeClass = 'bg-primary';
                    description = 'Kemampuan baik';
                } else if (nilai >= 41) {
                    kategori = 'Cukup';
                    badgeClass = 'bg-info';
                    description = 'Kemampuan rata-rata';
                } else if (nilai >= 21) {
                    kategori = 'Kurang';
                    badgeClass = 'bg-warning';
                    description = 'Perlu perbaikan';
                } else if (nilai > 0) {
                    kategori = 'Sangat Kurang';
                    badgeClass = 'bg-danger';
                    description = 'Perlu perhatian khusus';
                } else {
                    kategori = 'Belum Dinilai';
                    badgeClass = 'bg-secondary';
                    description = 'Masukkan nilai penilaian';
                }

                previewDiv.innerHTML = `
            <span class="badge ${badgeClass} px-3 py-2 fs-6">${kategori} (${nilai})</span>
            <br><small class="text-muted mt-1">${description}</small>
        `;

                // Update progress bar
                progressBar.style.width = nilai + '%';
                progressBar.textContent = nilai + '%';
                progressBar.className = 'progress-bar ' + badgeClass.replace('bg-', '');
            }

            // Check existing assessment
            function checkExistingAssessment() {
                const siswaId = document.getElementById('siswa_id').value;
                const kriteriaId = document.getElementById('kriteria_id').value;
                const existingDiv = document.getElementById('existing-check');
                const existingMessage = document.getElementById('existing-message');

                if (siswaId && kriteriaId) {
                    // Simulasi pengecekan - dalam implementasi nyata gunakan AJAX
                    // Untuk demo, kita anggap tidak ada duplikat
                    existingDiv.style.display = 'none';

                    // Aktifkan tombol submit
                    document.getElementById('submitBtn').disabled = false;
                } else {
                    existingDiv.style.display = 'none';
                }
            }

            // Form validation sebelum submit
            document.getElementById('penilaianCreateForm').addEventListener('submit', function(e) {
                const siswaId = document.getElementById('siswa_id').value;
                const kriteriaId = document.getElementById('kriteria_id').value;
                const nilai = document.getElementById('nilai_mentah').value;

                if (!siswaId || !kriteriaId || !nilai) {
                    e.preventDefault();
                    alert('Mohon lengkapi semua field yang wajib diisi!');
                    return false;
                }

                if (nilai < 0 || nilai > 100) {
                    e.preventDefault();
                    alert('Nilai harus antara 0-100!');
                    return false;
                }
            });

            // Auto-save draft (opsional)
            let autoSaveTimer;

            function autoSaveDraft() {
                clearTimeout(autoSaveTimer);
                autoSaveTimer = setTimeout(() => {
                    const formData = {
                        siswa_id: document.getElementById('siswa_id').value,
                        kriteria_id: document.getElementById('kriteria_id').value,
                        nilai_mentah: document.getElementById('nilai_mentah').value
                    };

                    if (formData.siswa_id && formData.kriteria_id && formData.nilai_mentah) {
                        localStorage.setItem('penilaian_draft', JSON.stringify(formData));
                        console.log('Draft tersimpan otomatis');
                    }
                }, 2000);
            }

            // Load draft jika ada
            function loadDraft() {
                const draft = localStorage.getItem('penilaian_draft');
                if (draft) {
                    try {
                        const data = JSON.parse(draft);
                        if (data.siswa_id) document.getElementById('siswa_id').value = data.siswa_id;
                        if (data.kriteria_id) document.getElementById('kriteria_id').value = data.kriteria_id;
                        if (data.nilai_mentah) {
                            document.getElementById('nilai_mentah').value = data.nilai_mentah;
                            updateNilai(data.nilai_mentah);
                        }

                        // Trigger change events
                        document.getElementById('siswa_id').dispatchEvent(new Event('change'));
                        document.getElementById('kriteria_id').dispatchEvent(new Event('change'));

                        console.log('Draft dimuat');
                    } catch (e) {
                        console.error('Error loading draft:', e);
                    }
                }
            }

            // Bind auto-save events
            ['siswa_id', 'kriteria_id', 'nilai_mentah'].forEach(fieldId => {
                document.getElementById(fieldId).addEventListener('change', autoSaveDraft);
                document.getElementById(fieldId).addEventListener('input', autoSaveDraft);
            });

            // Clear draft setelah submit berhasil
            document.getElementById('penilaianCreateForm').addEventListener('submit', function() {
                localStorage.removeItem('penilaian_draft');
            });

            // Load draft saat halaman dimuat
            loadDraft();

            // Trigger events untuk form yang sudah ada nilai default
            document.getElementById('siswa_id').dispatchEvent(new Event('change'));
            document.getElementById('kriteria_id').dispatchEvent(new Event('change'));

            // Update nilai awal jika ada
            const initialValue = document.getElementById('nilai_mentah').value;
            if (initialValue) {
                updateNilai(initialValue);
            }

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Ctrl + Enter untuk submit
                if (e.ctrlKey && e.key === 'Enter') {
                    e.preventDefault();
                    document.getElementById('submitBtn').click();
                }

                // Arrow keys untuk mengubah nilai
                if (document.activeElement === nilaiInput) {
                    if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        const newValue = Math.min(100, parseInt(nilaiInput.value || 0) + 5);
                        updateNilai(newValue);
                    } else if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        const newValue = Math.max(0, parseInt(nilaiInput.value || 0) - 5);
                        updateNilai(newValue);
                    }
                }
            });

            // Quick assessment buttons
            function addQuickAssessmentButtons() {
                const nilaiContainer = nilaiInput.parentElement.parentElement;
                const quickButtons = document.createElement('div');
                quickButtons.className = 'mt-2';
                quickButtons.innerHTML = `
            <small class="text-muted fw-bold d-block mb-1">Penilaian Cepat:</small>
            <div class="btn-group btn-group-sm" role="group">
                <button type="button" class="btn btn-outline-danger quick-assess" data-nilai="10">Sangat Kurang</button>
                <button type="button" class="btn btn-outline-warning quick-assess" data-nilai="30">Kurang</button>
                <button type="button" class="btn btn-outline-info quick-assess" data-nilai="50">Cukup</button>
                <button type="button" class="btn btn-outline-primary quick-assess" data-nilai="75">Baik</button>
                <button type="button" class="btn btn-outline-success quick-assess" data-nilai="90">Sangat Baik</button>
            </div>
        `;

                nilaiContainer.appendChild(quickButtons);

                // Event listeners untuk quick buttons
                document.querySelectorAll('.quick-assess').forEach(btn => {
                    btn.addEventListener('click', function() {
                        updateNilai(this.dataset.nilai);

                        // Visual feedback
                        document.querySelectorAll('.quick-assess').forEach(b => b.classList.remove(
                            'active'));
                        this.classList.add('active');
                    });
                });
            }

            addQuickAssessmentButtons();
        });
    </script>
@endpush
