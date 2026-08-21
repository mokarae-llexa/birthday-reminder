@extends('layouts.app')
@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h2 class="fw-bold mb-1">Tambah Teman</h2>
        <p class="text-muted mb-0">Tambahkan data teman baru</p>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan!</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('friends.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Teman</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="form-control"
                        value="{{ old('name') }}"
                        placeholder="Masukkan nama teman"
                        required
                    >
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">No. Telepon</label>
                    <input
                        type="text"
                        name="phone"
                        id="phone"
                        class="form-control"
                        value="{{ old('phone') }}"
                        placeholder="Masukkan nomor telepon"
                    >
                </div>
                <div class="mb-3">
                    <label for="birth_date" class="form-label">Tanggal Lahir</label>
                    <input
                        type="date"
                        name="birth_date"
                        id="birth_date"
                        class="form-control"
                        value="{{ old('birth_date') }}"
                        required
                    >
                </div>
                <div class="mb-3">
                    <label for="notes" class="form-label">Catatan</label>
                    <textarea
                        name="notes"
                        id="notes"
                        class="form-control"
                        rows="4"
                        placeholder="Masukkan catatan tentang teman">{{ old('notes') }}</textarea>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('friends.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection