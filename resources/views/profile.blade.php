@extends('layouts.dashboard')

@section('content')
<style>
  .profile-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px 20px;
    width: 100%;
  }

  .profile-card {
    width: 100%;
    max-width: 780px;
    background: #ffffff;
    border-radius: 24px;
    border: 1.2px solid #e2e8f0;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
    font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
  }

  .profile-banner {
    height: 160px;
    background:  #ffa0a6;
    border-bottom: 1.5px solid #FECDD3;
  }

  .profile-header {
    display: flex;
    align-items: flex-end;
    gap: 20px;
    padding: 0 45px;
    margin-top: -65px;
  }

  .avatar-container {
    position: relative;
    width: 130px;
    height: 130px;
    border-radius: 50%;
    background: #ffffff;
    padding: 4px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    flex-shrink: 0;
  }

  .avatar-img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
    display: block;
  }

  .status-dot {
    position: absolute;
    bottom: 6px;
    right: 8px;
    width: 18px;
    height: 18px;
    background-color: #10B981;
    border: 3px solid #ffffff;
    border-radius: 50%;
  }

  .user-meta {
    padding-bottom: 12px;
  }

  .user-meta h2 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #0F172A;
    margin: 0;
    line-height: 1.2;
  }

  .user-meta p {
    font-size: 0.95rem;
    color: #64748B;
    margin: 4px 0 0 0;
  }

  .profile-body {
    padding: 30px 45px 40px;
  }

  .section-divider {
    display: flex;
    align-items: center;
    gap: 12px;
    padding-bottom: 16px;
    border-bottom: 1.5px solid #F1F5F9;
    margin-bottom: 24px;
  }

  .icon-wrapper {
    width: 36px;
    height: 36px;
    background-color: #FFF1F2;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #E11D48;
  }

  .section-title {
    font-size: 0.85rem;
    font-weight: 800;
    color: #0F172A;
    letter-spacing: 0.05em;
  }

  .info-table {
    display: flex;
    flex-direction: column;
    gap: 18px;
    margin-bottom: 32px;
  }

  .info-item {
    display: grid;
    grid-template-columns: 140px 24px 1fr;
    align-items: center;
    font-size: 0.98rem;
  }

  .info-key {
    color: #64748B;
    font-weight: 500;
  }

  .info-sep {
    color: #94A3B8;
    font-weight: 600;
  }

  .info-val {
    color: #1E293B;
    font-weight: 600;
  }

  .action-container {
    display: flex;
    justify-content: flex-end;
  }

  .btn-edit-profile {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background-color: #EA8A8A;
    color: #ffffff;
    border: none;
    padding: 10px 22px;
    font-size: 0.95rem;
    font-weight: 600;
    border-radius: 12px;
    text-decoration: none;
    transition: all 0.2s ease;
  }

  .btn-edit-profile:hover {
    background-color: #e07474;
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(234, 138, 138, 0.4);
  }
</style>

<div class="profile-wrapper">
  <div class="profile-card">
    <div class="profile-banner"></div>

    <div class="profile-header">
      <div class="avatar-container">
        @if($user->avatar)
          <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="avatar-img">
        @else
          <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=ea8a8a&color=fff&size=150" alt="Avatar" class="avatar-img">
        @endif
        <span class="status-dot"></span>
      </div>
      <div class="user-meta">
        <h2>{{ $user->name }}</h2>
        <p>{{ $user->email }}</p>
      </div>
    </div>

    <div class="profile-body">
      <div class="section-divider">
        <div class="icon-wrapper">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
          </svg>
        </div>
        <span class="section-title">ACCOUNT INFORMATION</span>
      </div>

      <div class="info-table">
        <div class="info-item">
          <span class="info-key">Name</span>
          <span class="info-sep">:</span>
          <span class="info-val">{{ $user->name }}</span>
        </div>
        <div class="info-item">
          <span class="info-key">Email</span>
          <span class="info-sep">:</span>
          <span class="info-val">{{ $user->email }}</span>
        </div>
        <div class="info-item">
          <span class="info-key">Birth Date</span>
          <span class="info-sep">:</span>
          <span class="info-val">
            {{ $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->translatedFormat('d F Y') : '-' }}
          </span>
        </div>
      </div>

      <div class="action-container">
        <a href="{{ route('profile.edit') }}" class="btn-edit-profile">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
          </svg>
          Edit Profile
        </a>
      </div>
    </div>
  </div>
</div>
@endsection