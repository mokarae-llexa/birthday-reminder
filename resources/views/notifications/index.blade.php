@extends('layouts.app')

@section('content')
<style>
    .notif-container {
        width: 100%;
        max-width: 900px; 
        margin: 0 auto;
        padding: 40px 20px 60px 20px;
        display: flex;
        flex-direction: column;
    }

    .search-wrapper {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 28px;

    }

    .search-box {
        position: relative;
        width: 260px;
    }

    .search-box input {
        width: 100%;
        padding: 10px 16px 10px 40px;
        background-color: #FFFFFF;
        border: 1px solid #E8E8E8;
        border-radius: 20px;
        font-size: 13px;
        color: #333333;
        outline: none;
        transition: all 0.2s ease;
    }
    .search-box input:focus {
        border-color: #FFB6C1;
        box-shadow: 0 0 0 3px rgba(255, 182, 193, 0.2);
    }

    .search-box input::placeholder {
        color: #A0A0A0;
    }

    .search-box i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 15px;
        color: #888888;
    }

    .notif-list {
        display: flex;
        flex-direction: column;
    }

    .notif-item {
        border-radius: 12px;
        background-color: #F9F6C4;
        border-bottom: 1px solid #EEEEEE;
        border: 4px solid #FFB6C1;
        padding: 20px 8px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: background-color 0.2s ease;
    }

    .notif-item:hover {
        background-color: rgba(255, 255, 255, 0.5);
    }

    .notif-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .notif-avatar {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        background-color: #FFEAEB;
        color: #D87093;
        margin: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
        border: 1px solid #FFB6C1;
    }

    .notif-text h4 {
        font-size: 15px;
        text-align: justify;
        font-weight: 600;
        color: #222222;
        margin: 0 0 3px 0;
    }

    .notif-text p {
        font-size: 16px;
        color: #666666;
        margin: 3;
        text-align: center;
        font-weight: 500;
    }

    .btn-wish {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background-color: transparent;
        color: #BB8760 !important;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        padding: 8px 14px;
        border-radius: 8px;
        text-align: center;
        transition: all 0.2s ease;
    }

    .btn-wish:hover {
        background-color: #FFF2EB;
        color: #9A6843 !important;
    }

    .btn-wish i {
        font-size: 14px;
        transition: transform 0.2s ease;
    }

    .btn-wish:hover i {
        transform: translateX(3px);
    }

    .end-text {
        text-align: center;
        margin-top: 40px;
        padding: 20px;
    }

    .end-text h5 {
        font-size: 13px;
        font-weight: 600;
        color: #888888;
        margin: 0 0 4px 0;
        text-align: center;
    }

    .end-text p {
        font-size: 12px;
        color: #B0B0B0;
        margin: 0;
    }
</style>

<div class="notif-container">
    <div class="search-wrapper">
        <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" placeholder="Search Friend...">
        </div>
    </div>

    <div class="notif-list">
        @foreach($notification as $notif)
            <div class="notif-item">
                <div class="notif-left">
                    <div class="notif-avatar">
                        <i class="bi bi-cake2"></i>
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
</div>
@endsection