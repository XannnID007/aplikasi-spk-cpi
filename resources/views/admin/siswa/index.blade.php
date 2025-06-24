@extends('layouts.app')

@section('title', 'Data Siswa - SPK CPI')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-primary mb-1">Data Siswa</h2>
                    <p class="text-muted mb-0">Manajemen data siswa PAUDQU QURROTA A'YUN</p>
                </div>
                <div>
                    <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Siswa Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-child text-primary me-2"></i>Daftar Siswa</h5>
        </div>
        <div class="card-body">
            @if ($siswa->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="80">Kode</th>
                                <th>Nama Siswa</th>
                                <th>Jenis Kelamin</th>
                                <th>Tanggal Lahir</th>
                                <th>Umur</th>
                                <th>Nama Orang Tua</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($siswa as $s)
                                <tr>
                                    <td>
                                        <span class="badge bg-primary fs-6">{{ $s->kode }}</span>
                                    </td>
                                    <td>
                                        <div>
                                            <h6 class="mb-1 fw-bold">{{ $s->nama }}</h6>
                                            @if ($s->alamat)
                                                <small class="text-muted">{{ Str::limit($s->alamat, 30) }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if ($s->jenis_kelamin)
                                            @if ($s->jenis_kelamin === 'Laki-laki')
                                                <span class="badge bg-info">
                                                    <i class="fas fa-mars me-1"></i>{{ $s->jenis_kelamin }}
                                                </span>
                                            @else
                                                <span class="badge" style="background-color: #ec4899; color: white;">
                                                    <i class="fas fa-venus me-1"></i>{{ $s->jenis_kelamin }}
                                                </span>
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $s->tanggal_lahir ? $s->tanggal_lahir->format('d M Y') : '-' }}
                                    </td>
                                    <td>
                                        {{ $s->umur ? $s->umur . ' tahun' : '-' }}
                                    </td>
                                    <td>{{ $s->nama_orang_tua ?? '-' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.siswa.show', $s->id) }}"
                                                class="btn btn-sm btn-outline-info" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.siswa.edit', $s->id) }}"
                                                class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.siswa.destroy', $s->id) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus siswa ini? Data penilaian juga akan terhapus.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $siswa->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-child text-muted" style="font-size: 3rem;"></i>
                    <h5 class="mt-3 text-muted">Belum Ada Data Siswa</h5>
                    <p class="text-muted">Klik tombol "Tambah Siswa Baru" untuk menambahkan siswa pertama.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
