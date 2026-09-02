@extends('layouts.dashboard')

@section('content')
<style>
    /* Container utama agar lebih lebar dan mengisi layar secara seimbang */
    .notif-container {
        width: 100%;
        max-width: 95%; /* Melebar proporsional mengikuti layar */
        margin: 0 auto;
        padding: 30px 20px 50px 20px;
        display: flex;
        flex-direction: column;
    }

    /* Search Bar lebih pas dan proporsional */
    .search-wrapper {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 24px;
    }

    .search-box {
        position: relative;
        width: 240px;
    }

    .search-box input {
        width: 100%;
        padding: 10px 16px 10px 42px;
        background-color: #FFDADA;
        border: 1.5px solid #222;
        border-radius: 12px;
        font-size: 13px;
        color: #222;
        outline: none;
        font-weight: 500;
    }

    .search-box input::placeholder {
        color: #666;
    }

    .search-box i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 16px;
        color: #444;
    }

    /* List Kartu Notifikasi */
    .notif-list {
        display: flex;
        flex-direction: column;
        gap: 20px; /* Jarak antar kartu yang pas */
    }

    /* Kartu Notifikasi lebih tebal, tinggi, dan kokoh */
    .notif-card {
        background-color: #FFDADA;
        border: 2px solid #222222;
        border-radius: 16px;
        padding: 18px 32px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        min-height: 105px; /* Lebih tinggi agar tidak terlihat gepeng */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        transition: transform 0.15s ease;
    }

    .notif-card:hover {
        transform: translateY(-2px);
    }

    .notif-left {
        display: flex;
        align-items: center;
        gap: 24px;
    }

    /* Ukuran Avatar diperbesar */
    .avatar-frame {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        border: 2px solid #222;
        overflow: hidden;
        box-shadow: 3px 3px 6px rgba(0, 0, 0, 0.25);
        flex-shrink: 0;
        background-color: #fff;
    }

    .avatar-frame img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Teks detail */
    .notif-text h4 {
        font-size: 18px; /* Judul lebih tegas */
        font-weight: 700;
        color: #111;
        margin: 0 0 4px 0;
        letter-spacing: -0.2px;
    }

    .notif-text p {
        font-size: 13px;
        color: #333;
        margin: 0;
        font-weight: 500;
    }

    /* Tombol Aksi */
    .btn-wish {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        background-color: #BB8760;
        color: #FFFFFF !important;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        padding: 12px 28px;
        border-radius: 8px;
        min-width: 150px;
        border: 1px solid rgba(0,0,0,0.1);
        transition: background-color 0.2s;
    }

    .btn-wish:hover {
        background-color: #a4724d;
    }

    .btn-wish i {
        font-size: 15px;
    }

    /* Pesan Penutup Bawah */
    .end-text {
        text-align: center;
        margin-top: 45px;
        padding: 12px 20px;
        background-color: rgba(255, 255, 255, 0.7); /* Biar lebih terbaca di atas background motif */
        border-radius: 12px;
        width: fit-content;
        margin-left: auto;
        margin-right: auto;
        backdrop-filter: blur(4px);
    }

    .end-text h5 {
        font-size: 13px;
        font-weight: 700;
        color: #111;
        margin: 0 0 2px 0;
    }

    .end-text p {
        font-size: 12px;
        color: #444;
        margin: 0;
    }
</style>

<div class="notif-container">
    <!-- Search Bar -->
    <div class="search-wrapper">
        <div class="search-box">
            <i class="bi bi-person"></i>
            <input type="text" placeholder="Search Friend...">
        </div>
    </div>

    <!-- Notification Cards List -->
    <div class="notif-list">
        @foreach($notifications as $notif)
            <div class="notif-card">
                <div class="notif-left">
                    <div class="avatar-frame">
                        <img src="{{ $notif['avatar'] }}" alt="Avatar">
                    </div>
                    <div class="notif-text">
                        <h4>{{ $notif['title'] }}</h4>
                        <p>{{ $notif['message'] }}</p>
                    </div>
                </div>

                <div>
                    <a href="{{ $notif['url'] }}" class="btn-wish">
                        <span>{{ $notif['button_text'] }}</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <!-- End of list note -->
    <div class="end-text">
        <h5>You've reached the end!</h5>
        <p>We'll notify you when there's something new.</p>
    </div>
</div>
@endsection