@extends('layouts.dashboard')

@section('content')
<style>
    .edit-friend-wrapper { display: flex; justify-content: center; align-items: flex-start; padding: 30px 20px; width: 100%; }
    .edit-friend-card { width: 100%; max-width: 650px; background: #ffffff; border-radius: 24px; border: 1.2px solid #F3F4F6; padding: 35px 40px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03); font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif; }
    .edit-friend-header { display: flex; align-items: center; gap: 14px; margin-bottom: 28px; padding-bottom: 16px; border-bottom: 1.5px solid #F1F5F9; }
    .btn-back { display: flex; align-items: center; justify-content: center; width: 38px; height: 38px; border-radius: 50%; border: 1.5px solid #E2E8F0; color: #475569; text-decoration: none; transition: all 0.2s ease; }
    .btn-back:hover { background: #F8FAFC; color: #0F172A; }
    .header-text h2 { font-size: 1.35rem; font-weight: 700; color: #0F172A; margin: 0; }
    .header-text p { font-size: 0.85rem; color: #64748B; margin: 2px 0 0 0; }
    .form-group-custom { margin-bottom: 20px; }
    .form-label-custom { display: block; font-size: 0.88rem; font-weight: 600; color: #334155; margin-bottom: 8px; }
    .input-with-icon { position: relative; display: flex; align-items: center; }
    .input-icon { position: absolute; left: 14px; color: #94A3B8; display: flex; align-items: center; pointer-events: none; }
    .form-control-custom { width: 100%; padding: 11px 14px 11px 42px; border: 1.5px solid #E2E8F0; border-radius: 12px; font-size: 0.95rem; color: #0F172A; background: #F8FAFC; outline: none; transition: all 0.2s ease; }
    .form-control-custom:focus, .textarea-custom:focus { background: #ffffff; border-color: #EA8A8A; box-shadow: 0 0 0 3px rgba(234, 138, 138, 0.15); }
    .textarea-custom { width: 100%; padding: 12px 14px; border: 1.5px solid #E2E8F0; border-radius: 12px; font-size: 0.95rem; color: #0F172A; background: #F8FAFC; outline: none; resize: vertical; min-height: 95px; transition: all 0.2s ease; }
    .error-text { font-size: 0.8rem; color: #EF4444; margin-top: 5px; }
    .action-buttons { display: flex; justify-content: flex-end; gap: 12px; margin-top: 30px; }
    .btn-cancel { padding: 10px 22px; border-radius: 12px; border: 1px solid #E2E8F0; background: #ffffff; color: #64748B; font-weight: 600; font-size: 0.95rem; text-decoration: none; transition: all 0.2s ease; }
    .btn-cancel:hover { background: #F1F5F9; color: #0F172A; }
    .btn-save { padding: 10px 24px; border-radius: 12px; border: none; background: #EA8A8A; color: #ffffff; font-weight: 600; font-size: 0.95rem; cursor: pointer; transition: all 0.2s ease; }
    .btn-save:hover { background: #e07474; box-shadow: 0 4px 12px rgba(234, 138, 138, 0.4); }
</style>

<div class="edit-friend-wrapper">
    <div class="edit-friend-card">
        <div class="edit-friend-header">
            <a href="{{ route('friends.index') }}" class="btn-back">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
            </a>
            <div class="header-text">
                <h2>Edit Data Teman</h2>
                <p>Perbarui informasi detail teman</p>
            </div>
        </div>

        <form action="{{ route('friends.update', $friend->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group-custom">
                <label class="form-label-custom">Nama Teman</label>
                <div class="input-with-icon">
                    <span class="input-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </span>
                    <input type="text" name="name" class="form-control-custom" value="{{ old('name', $friend->name) }}" placeholder="Masukkan nama teman" required>
                </div>
                @error('name')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group-custom">
                <label class="form-label-custom">No. Telepon</label>
                <div class="input-with-icon">
                    <span class="input-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                    </span>
                    <input type="text" name="phone" class="form-control-custom" value="{{ old('phone', $friend->phone ?? '') }}" placeholder="08xxxxxxxxxx">
                </div>
                @error('phone')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group-custom">
                <label class="form-label-custom">Tanggal Lahir</label>
                <div class="input-with-icon">
                    <span class="input-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </span>
                    <input type="date" name="birth_date" class="form-control-custom" value="{{ old('birth_date', $friend->birth_date ? \Carbon\Carbon::parse($friend->birth_date)->format('Y-m-d') : '') }}" required>
                </div>
                @error('birth_date')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group-custom">
                <label class="form-label-custom">Catatan (Opsional)</label>
                <textarea name="notes" class="textarea-custom" placeholder="Contoh: Suka warna biru, alergi kacang...">{{ old('notes', $friend->notes ?? '') }}</textarea>
                @error('notes')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="action-buttons">
                <a href="{{ route('friends.index') }}" class="btn-cancel">Kembali</a>
                <button type="submit" class="btn-save">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection