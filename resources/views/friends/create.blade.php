@extends('layouts.dashboard')
@section('content')

<style>
    :root { --primary: #5D688A; --secondary: #F7A5A5; --accent: #FFDBB6; --background: #FFF2EF; --text: #333333; --white: #FFFFFF; }
    .container.py-4 { max-width: 800px !important; margin: 0 auto; min-height: 100vh; display: flex; flex-direction: column; justify-content: center; }
    h2.fw-bold { color: #2C2023; font-size: 24px; }
    p.text-muted { color: #8E7C7E; font-size: 13px; }
    .card.shadow-sm { border-radius: 24px; border: 1px solid #FFF1F1; box-shadow: 0 12px 36px rgba(217, 122, 133, 0.08); background: #FFFFFF; }
    .card-body { padding: 36px 40px; }
    .form-label { font-size: 13px; font-weight: 700; color: #5C4D50; margin-bottom: 8px; }
    .form-control { background: #FAFAFA; border: 1px solid #EAEAEA; border-radius: 14px; padding: 14px 16px; font-size: 14px; color: #2C2023; box-shadow: none !important; transition: all 0.2s ease; }
    .form-control:focus { background: #FFFFFF; border-color: #D36B77; box-shadow: 0 0 0 4px rgba(211, 107, 119, 0.1) !important; }
    .form-control::placeholder { color: #B8B8B8; }
    .btn { padding: 14px 0; border-radius: 14px; font-size: 14px; font-weight: 700; border: none; }
    .btn-secondary { background: #FFF1F1 !important; color: #D36B77 !important; flex: 1; }
    .btn-secondary:hover { background: #FCEBEB !important; }
    .btn-primary { background: #BB8760 !important; color: #FFFFFF !important; flex: 1; }
    .btn-primary:hover { background: #A3734E !important; }
</style>

<div class="container py-4">
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
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="Masukkan nama teman" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">No. Telepon</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" placeholder="Masukkan nomor telepon">
                </div>
                <div class="mb-3">
                    <label for="birth_date" class="form-label">Tanggal Lahir</label>
                    <input type="date" name="birth_date" id="birth_date" class="form-control" value="{{ old('birth_date') }}" required>
                </div>
                <div class="mb-3">
                    <label for="notes" class="form-label">Catatan</label>
                    <textarea name="notes" id="notes" class="form-control" rows="4" placeholder="Masukkan catatan tentang teman">{{ old('notes') }}</textarea>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('friends.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection