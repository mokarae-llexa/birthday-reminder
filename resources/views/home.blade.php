@extends('layouts.dashboard')
@section('content')

<style>
* {
    box-sizing: border-box;
}
body {
    margin: 0;
    background: #FFF6F4;
    font-family: 'Poppins', Arial, sans-serif;
    color: #1f1f1f;
}
.birthday-dashboard {
    min-height: 100vh;
    display: flex;
    background: #FFF6F4;
    position: relative;
    overflow: hidden;
}

.main-content {
    flex: 1;
    min-width: 0;
    background: #FFF6F4;
    overflow-y: auto;
    position: relative;
    z-index: 1;
}
.dashboard-wrapper {
    padding: 16px 36px 24px 36px; 
    position: relative;
    z-index: 3;
}
.topbar {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}
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

.header-banner-container {
    width: 100%;
    max-width: 700px;
    height: 150px;              /* naikkan dikit dari 90px */
    margin-bottom: 12px;
    overflow: hidden;
    margin-left: auto;
    display: flex;
    align-items: center;
    justify-content: flex-end;  /* rata kanan, sesuai posisi kue di gambar asli */
}
.header-banner-img {
    width: 100%;
    height: auto;
    display: block;
    object-fit: contain;
}

.greeting {
    margin-bottom: 24px;
    position: relative;
    z-index: 2;
}
.greeting h2 {
    font-size: 56px;
    font-weight: 900;
    color: #000000;
    margin: 0;
}

.birthday-area {
    display: grid;
    grid-template-columns: 320px 1fr;
    gap: 32px;
    position: relative;
    z-index: 2;
}

.today-card {
    background: #FFFFFF;
    border-radius: 24px;
    padding: 40px 24px;
    text-align: center;
    box-shadow: 0 10px 30px rgba(197, 95, 78, 0.05);
    border: 1px solid #FFE0DE;
    display: flex;
    flex-direction: column;
    align-items: center;
}
.today-card .birthday-avatar-wrap {
    width: 160px;
    height: 160px;
    margin-bottom: 24px;
    border-radius: 50%;
    border: 2.5px solid #000000;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #FFE6E3;
}
.today-card .birthday-avatar-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.today-card h3 {
    margin: 0 0 8px 0;
    color: #000000;
    font-size: 20px;
    font-weight: 800;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}
.today-card p {
    margin: 0;
    color: #4A4A4A;
    font-size: 14px;
    font-weight: 600;
}
.today-card .divider {
    width: 100%;
    border-bottom: 1.5px solid #E2E8F0;
    margin-top: 24px;
}

.upcoming-card {
    border: 1.5px solid #000000;
    background: #FFF5F4;
    display: flex;
    flex-direction: column;
}
.upcoming-header {
    background: #B68962;
    padding: 16px 20px;
    color: #000000;
    font-size: 18px;
    font-weight: 700;
    border-bottom: 1.5px solid #000000;
}
.upcoming-list {
    display: flex;
    flex-direction: column;
}
.upcoming-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1px solid #E2E8F0;
}
.upcoming-item:last-child {
    border-bottom: none;
}
.friend-info {
    display: flex;
    align-items: center;
    gap: 16px;
}
.friend-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    border: 1.5px solid #000000;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #FFE6E3;
}
.friend-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.friend-details {
    display: flex;
    flex-direction: column;
}
.friend-name {
    font-size: 15px;
    font-weight: 700;
    color: #000000;
    margin: 0 0 2px 0;
}
.friend-date {
    color: #718096;
    font-size: 12px;
    margin: 0;
}
.days-left {
    color: #718096;
    font-size: 12px;
    font-weight: 500;
    text-align: right;
    line-height: 1.4;
}

.bottom-wavy-bg {
    position: absolute;
    bottom: -10px;
    left: 0;
    width: 100%;
    height: 200px;
    z-index: 1;
    pointer-events: none;
}

@media (max-width: 992px) {
    .birthday-area {
        grid-template-columns: 1fr;
    }
}
@media (max-width: 768px) {
    .birthday-dashboard {
        flex-direction: column;
    }
}
</style>

<div class="birthday-dashboard">
    <div class="main-content">
        <svg class="bottom-wavy-bg" viewBox="0 0 1440 200" preserveAspectRatio="none">
            <path d="M 0,140 C 350,110 750,180 1440,110 L 1440,200 L 0,200 Z" fill="#FFDADA" />
        </svg>

        <div class="dashboard-wrapper">
            <div class="topbar">
                <div class="search-box">
                    <span>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                    <input type="text" placeholder="Search">
                </div>
            </div>

            <div class="header-banner-container">
                <img class="header-banner-img" src="{{ asset('assets/header.webp') }}" alt="Birthday Celebration Banner">
            </div>

            <div class="greeting">
                <h2>Halo! 👋</h2>
            </div>

            <div class="birthday-area">
                <div class="today-card">
                    @if ($highlightFriend)
                        @php
                            $highlightAvatar = 'https://ui-avatars.com/api/?name=' . urlencode($highlightFriend->name) . '&background=FFE1DD&color=C55F4E&size=160&bold=true';
                        @endphp
                        <div class="birthday-avatar-wrap">
                            <img src="{{ $highlightAvatar }}" alt="{{ $highlightFriend->name }}">
                        </div>
                        <h3>{{ $highlightFriend->name }}</h3>
                        <p>{{ Carbon\Carbon::parse($highlightFriend->birth_date)->translatedFormat('j F') }}</p>
                        <div class="divider"></div>
                    @else
                        <div class="birthday-avatar-wrap">
                            <span style="font-size: 48px;">🎂</span>
                        </div>
                        <h3>Belum Ada Teman</h3>
                        <p>Tambahkan data teman untuk melihat ulang tahun di sini</p>
                        <div class="divider"></div>
                    @endif
                </div>

                <div class="upcoming-card">
                    <div class="upcoming-header">
                        Coming Up Next 🎈
                    </div>
                    <div class="upcoming-list">
                        @forelse ($upcomingFriends as $friend)
                            @php
                                $friendAvatar = 'https://ui-avatars.com/api/?name=' . urlencode($friend->name) . '&background=FFE1DD&color=C55F4E&size=48&bold=true';
                            @endphp
                            <div class="upcoming-item">
                                <div class="friend-info">
                                    <div class="friend-avatar">
                                        <img src="{{ $friendAvatar }}" alt="{{ $friend->name }}">
                                    </div>
                                    <div class="friend-details">
                                        <h4 class="friend-name">{{ $friend->name }}</h4>
                                        <p class="friend-date">{{ Carbon\Carbon::parse($friend->birth_date)->translatedFormat('j F') }}</p>
                                    </div>
                                </div>
                                <div class="days-left">
                                    {{ $friend->days_left }} days<br>to go!
                                </div>
                            </div>
                        @empty
                            <div style="padding: 24px; text-align: center; color: #718096;">
                                Tidak ada ulang tahun terdekat lainnya
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection