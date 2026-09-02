@extends('layouts.app')

@section('content')
<style>
.search-box {
    width: 320px;
    height: 38px;
    display: flex;
    align-items: center;
    padding: 0 16px;
    background: #FFE6E3;
    border-radius: 20px;
}
.search-box span {
    margin-right: 8px;
    color: #B58F86;
    display: flex;
    align-items: center;
}
.search-box span svg {
    width: 16px;
    height: 16px;
}
.search-box input {
    width: 100%;
    border: none;
    outline: none;
    background: transparent;
    font-size: 13px;
    color: #1f1f1f;
}
.search-box input::placeholder {
    color: #B58F86;
}
</style>

<div class="birthday-dashboard" style="display: flex; min-height: 100vh; background: #FFF6F4;">
    @include('layouts.sidebar')

    <div class="main-content flex-grow-1 p-4" style="overflow-y: auto;">
        <div class="container py-2">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <div>
                    <h2 class="fw-bold mb-1" style="color: #1F1F1F;">Daftar Teman</h2>
                    <p class="text-muted mb-0">Kelola data teman dan pengingat ulang tahun</p>
                </div>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <form action="{{ route('friends.index') }}" method="GET" style="margin: 0;">
                        <div class="search-box">
                            <span>
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </span>
                            <input type="text" name="search" placeholder="Search" value="{{ request('search') }}">
                            @if(request('search'))
                                <a href="{{ route('friends.index') }}" style="color: #B58F86; text-decoration: none; font-size: 14px; margin-left: 6px;" title="Reset">✕</a>
                            @endif
                        </div>
                    </form>
                    <a href="{{ route('friends.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm" style="background-color: #C55F4E; border-color: #C55F4E;">
                        + Tambah Teman
                    </a>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: #FFFFFF;">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead style="background-color: #FFE6E3; color: #C55F4E;">
                                <tr>
                                    <th class="py-3 px-4 text-center" style="width: 70px;">No</th>
                                    <th class="py-3 px-3">Avatar</th>
                                    <th class="py-3 px-3">Nama Teman</th>
                                    <th class="py-3 px-3">No. Telepon</th>
                                    <th class="py-3 px-3">Email</th>
                                    <th class="py-3 px-3">Tanggal Lahir</th>
                                    <th class="py-3 px-3">Catatan</th>
                                    <th class="py-3 px-4 text-center" style="width: 150px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($friends as $friend)
                                    <tr>
                                        <td class="text-center fw-bold text-muted py-3 px-4">{{ $loop->iteration }}</td>
                                        <td class="py-3 px-3">
                                            <img src="{{ $friend->avatar_url }}" alt="{{ $friend->name }}" class="rounded-circle shadow-sm border" style="width: 44px; height: 44px; object-fit: cover; border-color: #FFE6E3 !important;">
                                        </td>
                                        <td class="py-3 px-3">
                                            <span class="fw-bold d-block text-dark" style="font-size: 15px;">{{ $friend->name }}</span>
                                        </td>
                                        <td class="py-3 px-3">
                                            @if($friend->phone)
                                                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-normal" style="font-size: 12px;">
                                                    📞 {{ $friend->phone }}
                                                </span>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-3">
                                            @if($friend->email)
                                                <span class="text-secondary small d-block" style="font-size: 12.5px;">
                                                    ✉️ {{ $friend->email }}
                                                </span>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-3">
                                            <span class="fw-semibold text-secondary" style="font-size: 14px;">
                                                🎂 {{ \Carbon\Carbon::parse($friend->birth_date)->translatedFormat('d F Y') }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-3 text-muted small" style="max-width: 220px;">
                                            <div class="text-truncate" title="{{ $friend->notes }}">
                                                {{ $friend->notes ?? '-' }}
                                            </div>
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('friends.edit', $friend->id) }}"
                                                   class="btn btn-sm btn-outline-warning rounded-pill px-3"
                                                   title="Edit Data">
                                                    Edit
                                                </a>
                                                <button type="button"
                                                        class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                                        title="Hapus Data"
                                                        onclick="openDeleteModal('{{ route('friends.destroy', $friend->id) }}', '{{ addslashes($friend->name) }}')">
                                                    Hapus
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <div class="my-3">
                                                <div class="fs-1 mb-2">{{ request('search') ? '🔍' : '🎈' }}</div>
                                                <h5 class="fw-bold text-dark mb-1">
                                                    {{ request('search') ? 'Hasil Tidak Ditemukan' : 'Belum Ada Data Teman' }}
                                                </h5>
                                                <p class="text-muted small mb-3">
                                                    {{ request('search') ? 'Tidak ada data teman yang cocok dengan kata kunci "' . request('search') . '".' : 'Mulai tambahkan teman untuk mendapatkan pengingat ulang tahun.' }}
                                                </p>
                                                @if(request('search'))
                                                    <a href="{{ route('friends.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-4">
                                                        Reset Pencarian
                                                    </a>
                                                @else
                                                    <a href="{{ route('friends.create') }}" class="btn btn-sm btn-primary rounded-pill px-4" style="background-color: #C55F4E; border-color: #C55F4E;">
                                                        + Tambah Teman Pertama
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<x-delete-confirm-modal />
@endsection