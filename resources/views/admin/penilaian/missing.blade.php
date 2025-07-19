@extends('layouts.app')

@section('title', 'Penilaian yang Belum Dilakukan - SPK CPI')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-primary mb-1">Penilaian yang Belum Dilakukan</h2>
                    <p class="text-muted mb-0">Daftar kombinasi siswa dan kriteria yang belum dinilai</p>
                </div>
                <div>
                    <a href="{{ route('admin.penilaian.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Penilaian
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if (count($missingAssessments) > 0)
        <!-- Summary -->
        <div class="alert alert-warning">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle fs-3 me-3"></i>
                <div>
                    <h5 class="mb-1">{{ count($missingAssessments) }} Penilaian Belum Dilakukan</h5>
                    <p class="mb-0">Silakan klik tombol "Nilai Sekarang" untuk melengkapi penilaian yang masih kosong.</p>
                </div>
            </div>
        </div>

        <!-- Quick Action Buttons -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-bolt text-warning me-2"></i>Aksi Cepat</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.penilaian.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Tambah Penilaian Baru
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-success" onclick="markAllAsComplete()">
                                <i class="fas fa-magic me-2"></i>Tandai Progress Lengkap
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Missing Assessments Table -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-clipboard-list text-danger me-2"></i>Daftar yang Belum Dinilai</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="50">No</th>
                                <th>Siswa</th>
                                <th>Kriteria</th>
                                <th>Bobot Kriteria</th>
                                <th>Prioritas</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $currentSiswa = null;
                            @endphp
                            @foreach ($missingAssessments as $index => $missing)
                                @php
                                    $isNewSiswa = $currentSiswa !== $missing['siswa']->kode;
                                    if ($isNewSiswa) {
                                        $currentSiswa = $missing['siswa']->kode;
                                    }

                                    // Tentukan prioritas berdasarkan bobot kriteria
                                    $bobot = $missing['kriteria']->bobot * 100;
                                    if ($bobot >= 20) {
                                        $prioritas = 'Tinggi';
                                        $prioritasClass = 'danger';
                                    } elseif ($bobot >= 15) {
                                        $prioritas = 'Sedang';
                                        $prioritasClass = 'warning';
                                    } else {
                                        $prioritas = 'Rendah';
                                        $prioritasClass = 'info';
                                    }
                                @endphp
                                <tr class="{{ $isNewSiswa ? 'border-top border-primary border-3' : '' }}">
                                    <td class="text-center">
                                        <span class="badge bg-secondary">{{ $index + 1 }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if ($isNewSiswa)
                                                <div class="bg-primary rounded-circle me-2 d-flex align-items-center justify-content-center"
                                                    style="width: 8px; height: 8px; min-width: 8px;"></div>
                                            @else
                                                <div class="me-2" style="width: 8px;"></div>
                                            @endif
                                            <div>
                                                <span class="badge bg-primary me-2">{{ $missing['siswa']->kode }}</span>
                                                <strong
                                                    class="{{ $isNewSiswa ? 'text-primary' : '' }}">{{ $missing['siswa']->nama }}</strong>
                                                @if ($isNewSiswa)
                                                    <br><small class="text-muted">
                                                        @php
                                                            $totalMissingForSiswa = collect($missingAssessments)
                                                                ->where('siswa.id', $missing['siswa']->id)
                                                                ->count();
                                                        @endphp
                                                        <i
                                                            class="fas fa-exclamation-circle me-1"></i>{{ $totalMissingForSiswa }}
                                                        kriteria belum dinilai
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="badge bg-secondary me-2">{{ $missing['kriteria']->kode }}</span>
                                            {{ $missing['kriteria']->nama }}
                                            <br><small class="text-muted">
                                                Tren: {{ $missing['kriteria']->tren }}
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        <span
                                            class="fw-bold text-primary">{{ number_format($missing['kriteria']->bobot * 100, 1) }}%</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $prioritasClass }}">{{ $prioritas }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ $missing['link'] }}" class="btn btn-sm btn-success">
                                            <i class="fas fa-star me-1"></i>Nilai Sekarang
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Summary by Student -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-user-clock text-info me-2"></i>Ringkasan per Siswa</h5>
            </div>
            <div class="card-body">
                @php
                    $siswaGroups = collect($missingAssessments)->groupBy('siswa.id');
                    $totalKriteria = \App\Models\Kriteria::count();
                @endphp
                <div class="row">
                    @foreach ($siswaGroups as $siswaId => $group)
                        @php
                            $siswa = $group->first()['siswa'];
                            $missingCount = $group->count();
                            $completedCount = $totalKriteria - $missingCount;
                            $progressPercentage = ($completedCount / $totalKriteria) * 100;
                        @endphp
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="border rounded p-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <span class="badge bg-primary">{{ $siswa->kode }}</span>
                                        <div class="fw-bold">{{ $siswa->nama }}</div>
                                    </div>
                                    <span
                                        class="badge bg-{{ $progressPercentage >= 100 ? 'success' : ($progressPercentage >= 50 ? 'warning' : 'danger') }}">
                                        {{ number_format($progressPercentage, 0) }}%
                                    </span>
                                </div>
                                <div class="progress mb-2" style="height: 8px;">
                                    <div class="progress-bar bg-{{ $progressPercentage >= 100 ? 'success' : ($progressPercentage >= 50 ? 'warning' : 'primary') }}"
                                        style="width: {{ $progressPercentage }}%"></div>
                                </div>
                                <div class="small text-muted">
                                    {{ $completedCount }} / {{ $totalKriteria }} kriteria selesai
                                    @if ($missingCount > 0)
                                        <br><span class="text-danger">{{ $missingCount }} belum dinilai</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <!-- All Complete -->
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                <h3 class="mt-3 text-success">Semua Penilaian Sudah Lengkap!</h3>
                <p class="text-muted">Selamat! Semua siswa sudah dinilai untuk semua kriteria.</p>

                <div class="mt-4">
                    <a href="{{ route('admin.penilaian.index') }}" class="btn btn-primary me-2">
                        <i class="fas fa-list me-2"></i>Lihat Daftar Penilaian
                    </a>
                    <form action="{{ route('admin.hitung-cpi') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success"
                            onclick="return confirm('Yakin ingin menghitung CPI? Pastikan semua data sudah benar.')">
                            <i class="fas fa-calculator me-2"></i>Hitung CPI Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        function markAllAsComplete() {
            const missingCount = {{ count($missingAssessments) }};

            if (missingCount === 0) {
                alert('Semua penilaian sudah lengkap!');
                return;
            }

            const result = confirm(`Anda akan melakukan ${missingCount} penilaian sekaligus. Lanjutkan?`);

            if (result) {
                // Redirect ke halaman create dengan batch mode
                window.location.href = '{{ route('admin.penilaian.create') }}?batch=true&total=' + missingCount;
            }
        }

        // Auto refresh setiap 30 detik untuk update real-time
        setInterval(function() {
            if (document.visibilityState === 'visible') {
                location.reload();
            }
        }, 30000);

        // Highlight prioritas tinggi
        document.addEventListener('DOMContentLoaded', function() {
            const prioritasTinggi = document.querySelectorAll('.badge.bg-danger');
            prioritasTinggi.forEach(function(badge) {
                if (badge.textContent === 'Tinggi') {
                    badge.parentElement.parentElement.style.backgroundColor = 'rgba(220, 53, 69, 0.05)';
                }
            });
        });
    </script>
@endpush
