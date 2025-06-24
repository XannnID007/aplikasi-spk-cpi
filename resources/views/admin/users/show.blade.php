@extends('layouts.app')

@section('title', 'Detail User - ' . $user->name)

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-primary mb-1">Detail User</h2>
                    <p class="text-muted mb-0">Informasi lengkap {{ $user->name }}</p>
                </div>
                <div>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Edit User
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Profile Card -->
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <img src="{{ $user->foto ? asset('uploads/users/' . $user->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=e2e8f0&color=2563eb&size=150' }}"
                            class="rounded-circle mb-3" width="150" height="150" alt="Profile">
                    </div>
                    <h5 class="fw-bold text-primary">{{ $user->name }}</h5>
                    <p class="text-muted mb-2">{{ $user->email }}</p>
                    @if ($user->nip)
                        <p class="text-muted small mb-3">NIP: {{ $user->nip }}</p>
                    @endif
                    <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'success' }} px-3 py-2 me-2">
                        <i class="fas fa-{{ $user->role === 'admin' ? 'user-shield' : 'chalkboard-teacher' }} me-1"></i>
                        {{ ucfirst($user->role) }}
                    </span>
                    <span class="badge bg-{{ $user->is_active ? 'success' : 'secondary' }} px-3 py-2">
                        <i class="fas fa-{{ $user->is_active ? 'check-circle' : 'times-circle' }} me-1"></i>
                        {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Information Card -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-info-circle text-primary me-2"></i>Informasi Detail</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold text-muted" width="120">Nama:</td>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Email:</td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Role:</td>
                                    <td>
                                        <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'success' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">NIP:</td>
                                    <td>{{ $user->nip ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Telepon:</td>
                                    <td>{{ $user->telepon ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Status:</td>
                                    <td>
                                        <span class="badge bg-{{ $user->is_active ? 'success' : 'secondary' }}">
                                            {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold text-muted" width="120">Bergabung:</td>
                                    <td>{{ $user->created_at->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Terakhir Update:</td>
                                    <td>{{ $user->updated_at->format('d F Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Alamat:</td>
                                    <td>{{ $user->alamat ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity Card -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-chart-line text-success me-2"></i>Aktivitas Akun</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="border rounded p-3">
                                <h5 class="text-primary mb-1">{{ $user->created_at->diffInDays(now()) }}</h5>
                                <small class="text-muted">Hari Bergabung</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded p-3">
                                <h5 class="text-success mb-1">{{ $user->updated_at->diffInDays(now()) }}</h5>
                                <small class="text-muted">Hari Update Terakhir</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded p-3">
                                <h5 class="text-info mb-1">{{ $user->is_active ? 'Ya' : 'Tidak' }}</h5>
                                <small class="text-muted">Status Aktif</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded p-3">
                                <h5 class="text-warning mb-1">{{ ucfirst($user->role) }}</h5>
                                <small class="text-muted">Level Akses</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
