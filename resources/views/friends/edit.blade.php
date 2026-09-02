@extends('layouts.app')

@section('content')
<div class="birthday-dashboard" style="display: flex; min-height: 100vh; background: #FFF6F4;">
    @include('layouts.sidebar')

    <div class="main-content flex-grow-1 p-4" style="overflow-y: auto;">
        <div class="container py-2" style="max-width: 800px;">
            <div class="mb-4">
                <h2 class="fw-bold mb-1" style="color: #1F1F1F;">Edit Data Teman</h2>
                <p class="text-muted mb-0">Perbarui informasi dan foto profil teman Anda</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger rounded-3 mb-4">
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0 mt-2 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card border-0 shadow-sm rounded-4" style="background: #FFFFFF;">
                <div class="card-body p-4">
                    <form action="{{ route('friends.update', $friend->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <x-avatar-picker :currentAvatar="old('avatar_base64', $friend->avatar_url)" :defaultName="$friend->name" />

                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Nama Teman</label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control rounded-3"
                                value="{{ old('name', $friend->name) }}"
                                required
                            >
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label fw-semibold">No. Telepon</label>
                                <input
                                    type="text"
                                    name="phone"
                                    id="phone"
                                    class="form-control rounded-3"
                                    value="{{ old('phone', $friend->phone) }}"
                                    placeholder="Masukkan nomor telepon (Opsional)"
                                >
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    class="form-control rounded-3"
                                    value="{{ old('email', $friend->email) }}"
                                    placeholder="Masukkan alamat email (Opsional)"
                                >
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="birth_date" class="form-label fw-semibold">Tanggal Lahir</label>
                            <input
                                type="date"
                                name="birth_date"
                                id="birth_date"
                                class="form-control rounded-3"
                                value="{{ old('birth_date', $friend->birth_date) }}"
                                required
                            >
                        </div>
                        <div class="mb-4">
                            <label for="notes" class="form-label fw-semibold">Catatan</label>
                            <textarea
                                name="notes"
                                id="notes"
                                class="form-control rounded-3"
                                rows="4"
                            >{{ old('notes', $friend->notes) }}</textarea>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('friends.index') }}" class="btn btn-secondary rounded-pill px-4">
                                Kembali
                            </a>
                            <button type="submit" class="btn btn-primary rounded-pill px-4" style="background-color: #C55F4E; border-color: #C55F4E;">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection