@extends('layouts.dashboard')

@section('content')
<style>
  .edit-profile-wrapper {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 30px 20px;
    width: 100%;
  }

  .edit-card {
    width: 100%;
    max-width: 600px;
    background: #ffffff;
    border-radius: 24px;
    border: 1.2px solid #F3F4F6;
    padding: 35px 40px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
    font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
  }

  .edit-header {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 25px;
  }

  .btn-back {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: 1.5px solid #E2E8F0;
    color: #475569;
    text-decoration: none;
    transition: all 0.2s ease;
  }

  .btn-back:hover {
    background: #F8FAFC;
    color: #0F172A;
  }

  .edit-title {
    font-size: 1.35rem;
    font-weight: 700;
    color: #0F172A;
    margin: 0;
  }

  /* Upload Avatar */
  .avatar-upload-section {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 28px;
  }

  .avatar-preview-box {
    position: relative;
    width: 110px;
    height: 110px;
    border-radius: 50%;
    padding: 3px;
    border: 2.5px solid #EA8A8A;
    margin-bottom: 8px;
  }

  .avatar-preview-img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
    display: block;
  }

  .camera-btn {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 32px;
    height: 32px;
    background: #ffffff;
    border-radius: 50%;
    border: 1px solid #E2E8F0;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    color: #64748B;
    transition: all 0.2s ease;
  }

  .camera-btn:hover {
    background: #FFF1F2;
    color: #EA8A8A;
  }

  .upload-hint {
    font-size: 0.8rem;
    color: #64748B;
  }

  /* Form Groups */
  .form-group-custom {
    margin-bottom: 20px;
  }

  .form-label-custom {
    display: block;
    font-size: 0.9rem;
    font-weight: 600;
    color: #334155;
    margin-bottom: 8px;
  }

  .input-with-icon {
    position: relative;
    display: flex;
    align-items: center;
  }

  .input-icon {
    position: absolute;
    left: 14px;
    color: #94A3B8;
    display: flex;
    align-items: center;
    pointer-events: none;
  }

  .form-control-custom {
    width: 100%;
    padding: 11px 14px 11px 42px;
    border: 1.5px solid #E2E8F0;
    border-radius: 12px;
    font-size: 0.95rem;
    color: #0F172A;
    background: #F8FAFC;
    outline: none;
    transition: all 0.2s ease;
  }

  .form-control-custom:focus {
    background: #ffffff;
    border-color: #EA8A8A;
    box-shadow: 0 0 0 3px rgba(234, 138, 138, 0.15);
  }

  .error-text {
    font-size: 0.8rem;
    color: #EF4444;
    margin-top: 5px;
  }

  /* Buttons */
  .action-buttons {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 30px;
  }

  .btn-cancel {
    padding: 10px 22px;
    border-radius: 12px;
    border: 1px solid #E2E8F0;
    background: #ffffff;
    color: #64748B;
    font-weight: 600;
    font-size: 0.95rem;
    text-decoration: none;
    transition: all 0.2s ease;
  }

  .btn-cancel:hover {
    background: #F1F5F9;
    color: #0F172A;
  }

  .btn-save {
    padding: 10px 24px;
    border-radius: 12px;
    border: none;
    background: #EA8A8A;
    color: #ffffff;
    font-weight: 600;
    font-size: 0.95rem;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .btn-save:hover {
    background: #e07474;
    box-shadow: 0 4px 12px rgba(234, 138, 138, 0.4);
  }
</style>

<div class="edit-profile-wrapper">
  <div class="edit-card">
    
    <div class="edit-header">
      <a href="{{ route('profile.show') }}" class="btn-back">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <line x1="19" y1="12" x2="5" y2="12"></line>
          <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
      </a>
      <h2 class="edit-title">Edit Profile</h2>
    </div>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="avatar-upload-section">
        <div class="avatar-preview-box">
          @if($user->avatar)
            <img id="preview-img" src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="avatar-preview-img">
          @else
            <img id="preview-img" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=ea8a8a&color=fff&size=150" alt="Avatar" class="avatar-preview-img">
          @endif

          <label for="avatar-input" class="camera-btn">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
              <circle cx="12" cy="13" r="4"></circle>
            </svg>
          </label>
        </div>
        <input type="file" name="avatar" id="avatar-input" accept="image/*" style="display: none;">
        <span class="upload-hint">Ganti Foto Profil (JPG, PNG, Maks 2MB)</span>
        @error('avatar')
          <div class="error-text">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group-custom">
        <label class="form-label-custom">Nama Lengkap</label>
        <div class="input-with-icon">
          <span class="input-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
              <circle cx="12" cy="7" r="4"></circle>
            </svg>
          </span>
          <input type="text" name="name" class="form-control-custom" value="{{ old('name', $user->name) }}" required>
        </div>
        @error('name')
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
          <input type="date" name="birth_date" class="form-control-custom" value="{{ old('birth_date', $user->birth_date) }}">
        </div>
        @error('birth_date')
          <div class="error-text">{{ $message }}</div>
        @enderror
      </div>

      <div class="action-buttons">
        <a href="{{ route('profile.show') }}" class="btn-cancel">Batal</a>
        <button type="submit" class="btn-save">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

<script>
  document.getElementById('avatar-input').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(event) {
        document.getElementById('preview-img').src = event.target.result;
      };
      reader.readAsDataURL(file);
    }
  });
</script>
@endsection