@extends('layouts.app')

@section('title', 'Penilaian per Siswa - SPK CPI')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-primary mb-1">Penilaian Dikelompokkan per Siswa</h2>
                    <p class="text-muted mb-0">Tampilan penilaian yang diorganisir berdasarkan siswa untuk memudahkan
                        tracking progress</p>
                </div>
                <div>
                    <a href="{{ route('admin.penilaian.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-list me-2"></i>View List
                    </a>
                    <a href="{{ route('admin.penilaian.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Penilaian
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Overview -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="fw-bold mb-1">{{ $siswaWithPenilaian->count() }}</h3>
                        <p class="mb-0 opacity-75">Total Siswa</p>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card success">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="fw-bold mb-1">{{ $totalKriteria }}</h3>
                        <p class="mb-0 opacity-75">Total Kriteria</p>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="fas fa-list-check"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card warning">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        @php
                            $siswaLengkap = $siswaWithPenilaian
                                ->filter(function ($siswa) use ($totalKriteria) {
                                    return $siswa->penilaian->count() >= $totalKriteria;
                                })
                                ->count();
                        @endphp
                        <h3 class="fw-bold mb-1">{{ $siswaLengkap }}</h3>
                        <p class="mb-0 opacity-75">Siswa Lengkap</p>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card danger">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        @php
                            $totalPenilaian = $siswaWithPenilaian->sum(function ($siswa) {
                                return $siswa->penilaian->count();
                            });
                        @endphp
                        <h3 class="fw-bold mb-1">{{ $totalPenilaian }}</h3>
                        <p class="mb-0 opacity-75">Total Penilaian</p>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-bolt text-warning me-2"></i>Aksi Cepat</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="d-grid">
                        <a href="{{ route('admin.penilaian.missing') }}" class="btn btn-outline-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>Lihat yang Belum Dinilai
                        </a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-grid">
                        <button class="btn btn-outline-info" onclick="expandAllCards()">
                            <i class="fas fa-expand-arrows-alt me-2"></i>Buka Semua Card
                        </button>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-grid">
                        <button class="btn btn-outline-secondary" onclick="collapseAllCards()">
                            <i class="fas fa-compress-arrows-alt me-2"></i>Tutup Semua Card
                        </button>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-grid">
                        <form action="{{ route('admin.hitung-cpi') }}" method="POST" class="d-inline w-100">
                            @csrf
                            <button type="submit" class="btn btn-success w-100"
                                onclick="return confirm('Yakin ingin menghitung CPI?')">
                                <i class="fas fa-calculator me-2"></i>Hitung CPI
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Siswa Cards -->
    <div class="row" id="siswaCards">
        @foreach ($siswaWithPenilaian as $siswa)
            @php
                $penilaianCount = $siswa->penilaian->count();
                $progressPercentage = $totalKriteria > 0 ? ($penilaianCount / $totalKriteria) * 100 : 0;
                $isComplete = $penilaianCount >= $totalKriteria;
                $averageScore = $siswa->penilaian->avg('nilai_mentah') ?? 0;

                // Tentukan warna card berdasarkan progress
                if ($progressPercentage >= 100) {
                    $cardBorderClass = 'border-success';
                    $headerClass = 'bg-success text-white';
                } elseif ($progressPercentage >= 75) {
                    $cardBorderClass = 'border-warning';
                    $headerClass = 'bg-warning text-dark';
                } elseif ($progressPercentage >= 50) {
                    $cardBorderClass = 'border-info';
                    $headerClass = 'bg-info text-white';
                } else {
                    $cardBorderClass = 'border-danger';
                    $headerClass = 'bg-danger text-white';
                }
            @endphp

            <div class="col-lg-6 col-xl-4 mb-4">
                <div class="card {{ $cardBorderClass }} h-100 siswa-card">
                    <div class="card-header {{ $headerClass }} d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-light text-dark me-2">{{ $siswa->kode }}</span>
                            <strong>{{ $siswa->nama }}</strong>
                        </div>
                        <div>
                            <span class="badge bg-light text-dark">
                                {{ number_format($progressPercentage, 0) }}%
                            </span>
                            <button class="btn btn-sm btn-light ms-1 toggle-card"
                                data-target="#collapse{{ $siswa->id }}">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body p-3">
                        <!-- Progress Bar -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between small mb-1">
                                <span class="text-muted">Progress Penilaian</span>
                                <span class="fw-bold">{{ $penilaianCount }} / {{ $totalKriteria }}</span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-{{ $progressPercentage >= 100 ? 'success' : ($progressPercentage >= 75 ? 'warning' : 'primary') }}"
                                    style="width: {{ min(100, $progressPercentage) }}%"></div>
                            </div>
                        </div>

                        <!-- Student Info -->
                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="text-center">
                                    <div class="fw-bold text-primary">{{ number_format($averageScore, 1) }}</div>
                                    <small class="text-muted">Rata-rata Nilai</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center">
                                    <div class="fw-bold text-{{ $isComplete ? 'success' : 'warning' }}">
                                        {{ $isComplete ? 'Lengkap' : 'Perlu ' . ($totalKriteria - $penilaianCount) }}
                                    </div>
                                    <small class="text-muted">Status</small>
                                </div>
                            </div>
                        </div>

                        <!-- Collapsible Content -->
                        <div class="collapse" id="collapse{{ $siswa->id }}">
                            @if ($siswa->penilaian->count() > 0)
                                <!-- Penilaian List -->
                                <div class="table-responsive">
                                    <table class="table table-sm table-borderless">
                                        <thead>
                                            <tr class="small text-muted">
                                                <th>Kriteria</th>
                                                <th width="60" class="text-center">Nilai</th>
                                                <th width="40"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($siswa->penilaian->sortBy('kriteria.kode') as $penilaian)
                                                <tr>
                                                    <td>
                                                        <span
                                                            class="badge bg-secondary badge-sm me-1">{{ $penilaian->kriteria->kode }}</span>
                                                        <small>{{ Str::limit($penilaian->kriteria->nama, 25) }}</small>
                                                    </td>
                                                    <td class="text-center">
                                                        @php
                                                            $nilai = $penilaian->nilai_mentah;
                                                            if ($nilai >= 81) {
                                                                $badgeClass = 'success';
                                                            } elseif ($nilai >= 61) {
                                                                $badgeClass = 'primary';
                                                            } elseif ($nilai >= 41) {
                                                                $badgeClass = 'info';
                                                            } elseif ($nilai >= 21) {
                                                                $badgeClass = 'warning';
                                                            } else {
                                                                $badgeClass = 'danger';
                                                            }
                                                        @endphp
                                                        <span
                                                            class="badge bg-{{ $badgeClass }} badge-sm">{{ $nilai }}</span>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.penilaian.edit', $penilaian->id) }}"
                                                            class="btn btn-sm btn-outline-primary" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Missing Criteria -->
                                @php
                                    $existingKriteriaIds = $siswa->penilaian->pluck('kriteria_id')->toArray();
                                    $missingKriteria = \App\Models\Kriteria::whereNotIn('id', $existingKriteriaIds)
                                        ->orderBy('kode')
                                        ->get();
                                @endphp

                                @if ($missingKriteria->count() > 0)
                                    <div class="border-top pt-2 mt-2">
                                        <small class="text-muted fw-bold">Belum Dinilai:</small>
                                        <div class="mt-1">
                                            @foreach ($missingKriteria as $kriteria)
                                                <a href="{{ route('admin.penilaian.create', ['siswa_id' => $siswa->id, 'kriteria_id' => $kriteria->id]) }}"
                                                    class="badge bg-light text-dark border me-1 mb-1 text-decoration-none"
                                                    title="Klik untuk menilai {{ $kriteria->nama }}">
                                                    {{ $kriteria->kode }} <i class="fas fa-plus small"></i>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @else
                                <!-- No Assessment Yet -->
                                <div class="text-center py-3">
                                    <i class="fas fa-star text-muted fs-2 mb-2"></i>
                                    <p class="text-muted small mb-2">Belum ada penilaian</p>
                                    <a href="{{ route('admin.penilaian.create', ['siswa_id' => $siswa->id]) }}"
                                        class="btn btn-sm btn-primary">
                                        <i class="fas fa-plus me-1"></i>Mulai Penilaian
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2 mt-3">
                            @if ($siswa->penilaian->count() > 0)
                                <a href="{{ route('admin.siswa.show', $siswa->id) }}"
                                    class="btn btn-sm btn-outline-info flex-fill">
                                    <i class="fas fa-user me-1"></i>Detail
                                </a>
                            @endif
                            @if (!$isComplete)
                                <a href="{{ route('admin.penilaian.create', ['siswa_id' => $siswa->id]) }}"
                                    class="btn btn-sm btn-primary flex-fill">
                                    <i class="fas fa-plus me-1"></i>Tambah Nilai
                                </a>
                            @else
                                <button class="btn btn-sm btn-success flex-fill" disabled>
                                    <i class="fas fa-check me-1"></i>Lengkap
                                </button>
                            @endif
                        </div>
                    </div>

                    @if ($isComplete)
                        <div class="card-footer bg-light text-center py-2">
                            <small class="text-success fw-bold">
                                <i class="fas fa-check-circle me-1"></i>Penilaian Lengkap
                            </small>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    @if ($siswaWithPenilaian->count() == 0)
        <!-- No Data -->
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-users text-muted" style="font-size: 4rem;"></i>
                <h4 class="mt-3 text-muted">Belum Ada Data Siswa</h4>
                <p class="text-muted">Silakan tambahkan data siswa terlebih dahulu.</p>
                <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Siswa
                </a>
            </div>
        </div>
    @endif

    <!-- Summary Card -->
    @if ($siswaWithPenilaian->count() > 0)
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-pie text-info me-2"></i>Ringkasan Status Penilaian</h5>
            </div>
            <div class="card-body">
                @php
                    $statusDistribution = [
                        'complete' => $siswaWithPenilaian
                            ->filter(function ($siswa) use ($totalKriteria) {
                                return $siswa->penilaian->count() >= $totalKriteria;
                            })
                            ->count(),
                        'almost' => $siswaWithPenilaian
                            ->filter(function ($siswa) use ($totalKriteria) {
                                $count = $siswa->penilaian->count();
                                return $count >= $totalKriteria * 0.75 && $count < $totalKriteria;
                            })
                            ->count(),
                        'partial' => $siswaWithPenilaian
                            ->filter(function ($siswa) use ($totalKriteria) {
                                $count = $siswa->penilaian->count();
                                return $count > 0 && $count < $totalKriteria * 0.75;
                            })
                            ->count(),
                        'empty' => $siswaWithPenilaian
                            ->filter(function ($siswa) {
                                return $siswa->penilaian->count() == 0;
                            })
                            ->count(),
                    ];
                @endphp

                <div class="row">
                    <div class="col-md-3 text-center">
                        <div class="border rounded p-3">
                            <h4 class="text-success mb-1">{{ $statusDistribution['complete'] }}</h4>
                            <small class="text-muted">Penilaian Lengkap</small>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="border rounded p-3">
                            <h4 class="text-warning mb-1">{{ $statusDistribution['almost'] }}</h4>
                            <small class="text-muted">Hampir Selesai (≥75%)</small>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="border rounded p-3">
                            <h4 class="text-info mb-1">{{ $statusDistribution['partial'] }}</h4>
                            <small class="text-muted">Sebagian (<75%)< /small>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="border rounded p-3">
                            <h4 class="text-danger mb-1">{{ $statusDistribution['empty'] }}</h4>
                            <small class="text-muted">Belum Dinilai</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle individual cards
            document.querySelectorAll('.toggle-card').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const targetId = this.dataset.target;
                    const target = document.querySelector(targetId);
                    const icon = this.querySelector('i');

                    if (target.classList.contains('show')) {
                        target.classList.remove('show');
                        icon.classList.remove('fa-chevron-up');
                        icon.classList.add('fa-chevron-down');
                    } else {
                        target.classList.add('show');
                        icon.classList.remove('fa-chevron-down');
                        icon.classList.add('fa-chevron-up');
                    }
                });
            });
        });

        // Expand all cards
        function expandAllCards() {
            document.querySelectorAll('.collapse').forEach(function(collapse) {
                collapse.classList.add('show');
            });
            document.querySelectorAll('.toggle-card i').forEach(function(icon) {
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            });
        }

        // Collapse all cards
        function collapseAllCards() {
            document.querySelectorAll('.collapse').forEach(function(collapse) {
                collapse.classList.remove('show');
            });
            document.querySelectorAll('.toggle-card i').forEach(function(icon) {
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
            });
        }

        // Auto-highlight incomplete assessments
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.badge.bg-light.text-dark.border').forEach(function(badge) {
                badge.addEventListener('mouseenter', function() {
                    this.classList.add('bg-primary', 'text-white');
                    this.classList.remove('bg-light', 'text-dark');
                });

                badge.addEventListener('mouseleave', function() {
                    this.classList.remove('bg-primary', 'text-white');
                    this.classList.add('bg-light', 'text-dark');
                });
            });
        });

        // Progress animation on load
        window.addEventListener('load', function() {
            document.querySelectorAll('.progress-bar').forEach(function(bar) {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(function() {
                    bar.style.transition = 'width 1s ease-in-out';
                    bar.style.width = width;
                }, 100);
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        .siswa-card {
            transition: all 0.3s ease;
        }

        .siswa-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .badge-sm {
            font-size: 0.7rem;
            padding: 0.2rem 0.4rem;
        }

        .card-header.bg-success,
        .card-header.bg-warning,
        .card-header.bg-info,
        .card-header.bg-danger {
            border: none;
        }

        .progress {
            border-radius: 6px;
            overflow: hidden;
        }

        .toggle-card {
            border: none !important;
            padding: 0.2rem 0.4rem;
        }

        .toggle-card:hover {
            background-color: rgba(255, 255, 255, 0.2) !important;
        }

        .table-sm td {
            padding: 0.3rem;
            vertical-align: middle;
        }

        .collapse {
            transition: all 0.3s ease;
        }

        .collapse.show {
            display: block !important;
        }

        /* Custom animation for progress bars */
        @keyframes progressAnimation {
            from {
                width: 0%;
            }

            to {
                width: var(--progress-width);
            }
        }

        .progress-bar {
            animation: progressAnimation 1s ease-in-out;
        }

        /* Hover effects for missing criteria badges */
        .badge.bg-light.text-dark.border {
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .badge.bg-light.text-dark.border:hover {
            transform: scale(1.05);
            text-decoration: none !important;
        }
    </style>
@endpush
