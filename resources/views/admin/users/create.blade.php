@extends('layouts.app')

@section('title', 'Tambah User - SPK CPI')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-primary mb-1">Tambah User Baru</h2>
                    <p class="text-muted mb-0">Buat akun admin atau guru baru</p>
                </div>
                <div>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
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
                    <h5 class="mb-0"><i class="fas fa-user-plus text-primary me-2"></i>Form Tambah User</h5>
                </div>
                <div class="card-body">
                    <!-- Form Guidelines -->
                    <div class="alert alert-info mb-4">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-info-circle me-2 mt-1"></i>
                            <div>
                                <h6 class="fw-bold mb-2">Panduan Pengisian Form:</h6>
                                <ul class="mb-0 small">
                                    <li>Pastikan email belum pernah digunakan sebelumnya</li>
                                    <li>Password minimal 6 karakter untuk keamanan</li>
                                    <li>NIP dapat dikosongkan jika belum ada</li>
                                    <li>Foto profil bersifat opsional (maksimal 2MB)</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data"
                        class="needs-validation-modal" id="userCreateForm">
                        @csrf

                        <div class="row">
                            <!-- Nama -->
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-bold">
                                    Nama Lengkap <span class="text-danger">*</span>
                                    <i class="fas fa-question-circle text-muted ms-1" data-bs-toggle="tooltip"
                                        title="Masukkan nama lengkap sesuai identitas resmi"></i>
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}" required
                                    placeholder="Contoh: Siti Nurhaliza, S.Pd">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-bold">
                                    Email <span class="text-danger">*</span>
                                    <i class="fas fa-question-circle text-muted ms-1" data-bs-toggle="tooltip"
                                        title="Email akan digunakan untuk login ke sistem"></i>
                                </label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}" required
                                    placeholder="contoh@paudqu.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Role -->
                            <div class="col-md-6 mb-3">
                                <label for="role" class="form-label fw-bold">
                                    Role <span class="text-danger">*</span>
                                    <i class="fas fa-question-circle text-muted ms-1" data-bs-toggle="tooltip"
                                        title="Admin: akses penuh sistem | Guru: akses terbatas untuk melihat hasil"></i>
                                </label>
                                <select class="form-select @error('role') is-invalid @enderror" id="role"
                                    name="role" required>
                                    <option value="">Pilih Role</option>
                                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>
                                        <i class="fas fa-user-shield"></i> Administrator
                                    </option>
                                    <option value="guru" {{ old('role') === 'guru' ? 'selected' : '' }}>
                                        <i class="fas fa-chalkboard-teacher"></i> Guru
                                    </option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- NIP -->
                            <div class="col-md-6 mb-3">
                                <label for="nip" class="form-label fw-bold">NIP</label>
                                <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip"
                                    name="nip" value="{{ old('nip') }}" placeholder="Nomor Induk Pegawai">
                                @error('nip')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Telepon -->
                            <div class="col-md-6 mb-3">
                                <label for="telepon" class="form-label fw-bold">Telepon</label>
                                <input type="text" class="form-control @error('telepon') is-invalid @enderror"
                                    id="telepon" name="telepon" value="{{ old('telepon') }}" placeholder="08xxxxxxxxxx">
                                @error('telepon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Alamat -->
                            <div class="col-12 mb-3">
                                <label for="alamat" class="form-label fw-bold">Alamat</label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3"
                                    placeholder="Alamat lengkap">{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Foto -->
                            <div class="col-12 mb-3">
                                <label for="foto" class="form-label fw-bold">Foto Profil</label>
                                <input type="file" class="form-control @error('foto') is-invalid @enderror"
                                    id="foto" name="foto" accept="image/*">
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Format: JPG, JPEG, PNG. Maksimal 2MB. Akan digunakan untuk foto profil.
                                </div>
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <!-- Preview foto -->
                                <div id="fotoPreview" class="mt-2" style="display: none;">
                                    <img id="previewImg" src="" alt="Preview" class="img-thumbnail"
                                        style="max-width: 150px; max-height: 150px;">
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- Password Section -->
                            <div class="col-12 mb-3">
                                <h6 class="fw-bold text-primary">
                                    <i class="fas fa-lock me-2"></i>Keamanan Akun
                                </h6>
                            </div>

                            <!-- Password -->
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label fw-bold">
                                    Password <span class="text-danger">*</span>
                                </label>
                                <div class="position-relative">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" required placeholder="Minimal 6 karakter">
                                    <button type="button"
                                        class="btn btn-outline-secondary position-absolute top-0 end-0 h-100 px-3"
                                        id="togglePassword" style="border-left: none;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="form-text">
                                    <div id="passwordStrength" class="mt-2">
                                        <div class="progress" style="height: 4px;">
                                            <div class="progress-bar" id="strengthBar" style="width: 0%;"></div>
                                        </div>
                                        <small id="strengthText" class="text-muted">Masukkan password</small>
                                    </div>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Konfirmasi Password -->
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label fw-bold">
                                    Konfirmasi Password <span class="text-danger">*</span>
                                </label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" required placeholder="Ulangi password">
                                <div class="form-text">
                                    <span id="passwordMatch" class="small"></span>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-12">
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Perhatian:</strong> Setelah mengklik "Simpan User", sistem akan menampilkan
                                    konfirmasi
                                    data sebelum menyimpan ke database.
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-2"></i>Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary" id="submitBtn">
                                        <i class="fas fa-save me-2"></i>Simpan User
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

            // Foto preview
            document.getElementById('foto').addEventListener('change', function(e) {
                const file = e.target.files[0];
                const preview = document.getElementById('fotoPreview');
                const previewImg = document.getElementById('previewImg');

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        preview.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                } else {
                    preview.style.display = 'none';
                }
            });

            // Toggle password visibility
            document.getElementById('togglePassword').addEventListener('click', function() {
                const password = document.getElementById('password');
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });

            // Password strength indicator
            document.getElementById('password').addEventListener('input', function() {
                const password = this.value;
                const strengthBar = document.getElementById('strengthBar');
                const strengthText = document.getElementById('strengthText');

                let strength = 0;
                let text = '';
                let color = '';

                if (password.length >= 6) strength += 25;
                if (password.match(/[a-z]/)) strength += 25;
                if (password.match(/[A-Z]/)) strength += 25;
                if (password.match(/[0-9]/)) strength += 25;

                if (strength === 0) {
                    text = 'Masukkan password';
                    color = 'bg-secondary';
                } else if (strength === 25) {
                    text = 'Lemah';
                    color = 'bg-danger';
                } else if (strength === 50) {
                    text = 'Sedang';
                    color = 'bg-warning';
                } else if (strength === 75) {
                    text = 'Baik';
                    color = 'bg-info';
                } else {
                    text = 'Kuat';
                    color = 'bg-success';
                }

                strengthBar.style.width = strength + '%';
                strengthBar.className = 'progress-bar ' + color;
                strengthText.textContent = text;
            });

            // Password confirmation check
            function checkPasswordMatch() {
                const password = document.getElementById('password').value;
                const confirmation = document.getElementById('password_confirmation').value;
                const matchText = document.getElementById('passwordMatch');

                if (confirmation === '') {
                    matchText.textContent = '';
                    return;
                }

                if (password === confirmation) {
                    matchText.innerHTML = '<i class="fas fa-check text-success me-1"></i>Password cocok';
                    matchText.className = 'small text-success';
                } else {
                    matchText.innerHTML = '<i class="fas fa-times text-danger me-1"></i>Password tidak cocok';
                    matchText.className = 'small text-danger';
                }
            }

            document.getElementById('password').addEventListener('input', checkPasswordMatch);
            document.getElementById('password_confirmation').addEventListener('input', checkPasswordMatch);

            // Role change handler
            document.getElementById('role').addEventListener('change', function() {
                const submitBtn = document.getElementById('submitBtn');
                if (this.value === 'admin') {
                    submitBtn.innerHTML = '<i class="fas fa-user-shield me-2"></i>Simpan Administrator';
                } else if (this.value === 'guru') {
                    submitBtn.innerHTML = '<i class="fas fa-chalkboard-teacher me-2"></i>Simpan Guru';
                } else {
                    submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Simpan User';
                }
            });
        });
    </script>
@endpush
