@extends('layouts.app')

@section('content')
<div class="birthday-dashboard" style="display: flex; min-height: 100vh; background: #FFF6F4;">
    @include('layouts.sidebar')

    <div class="main-content flex-grow-1 p-4" style="overflow-y: auto;">
        <div class="container py-2" style="max-width: 800px;">
            <div class="mb-4">
                <h2 class="fw-bold mb-1" style="color: #1F1F1F;">Kelola Profil Saya</h2>
                <p class="text-muted mb-0">Atur foto profil, nama, email, dan password Anda</p>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                    <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger rounded-3 mb-4">
                    <strong><i class="bi bi-exclamation-triangle me-2"></i>Terjadi kesalahan:</strong>
                    <ul class="mb-0 mt-2 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: #FFFFFF;">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold mb-0" style="color: #C55F4E;">
                        <i class="bi bi-person-circle me-2"></i>Informasi Profil & Avatar
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <x-avatar-picker :currentAvatar="old('avatar_base64', $user->avatar_url)" :defaultName="$user->name" />

                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control rounded-3"
                                value="{{ old('name', $user->name) }}"
                                required
                            >
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">Alamat Email</label>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                class="form-control rounded-3"
                                value="{{ old('email', $user->email) }}"
                                required
                            >
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary rounded-pill px-4" style="background-color: #C55F4E; border-color: #C55F4E;">
                                Simpan Perubahan Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: #FFFFFF;">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold mb-0" style="color: #C55F4E;">
                        <i class="bi bi-key-fill me-2"></i>Ubah Password
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('profile.update-password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-semibold">Password Saat Ini</label>
                            <input
                                type="password"
                                name="current_password"
                                id="current_password"
                                class="form-control rounded-3"
                                placeholder="Masukkan password lama"
                                required
                            >
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label fw-semibold">Password Baru</label>
                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    class="form-control rounded-3"
                                    placeholder="Masukkan password baru"
                                    required
                                >
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password Baru</label>
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    id="password_confirmation"
                                    class="form-control rounded-3"
                                    placeholder="Ulangi password baru"
                                    required
                                >
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-outline-danger rounded-pill px-4">
                                Ubah Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: #FFFFFF;">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="fw-bold mb-1 text-danger">Keluar Sesi</h6>
                        <p class="text-muted small mb-0">Keluar dari akun Birthday Reminder Anda</p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger rounded-pill px-4">
                            Logout
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
