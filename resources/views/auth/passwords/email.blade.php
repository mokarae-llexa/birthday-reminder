@extends('layouts.guest')

@section('content')
<div class="forgot-page">
    <div class="forgot-card">
        <div class="forgot-content">

            <img src="{{ asset('assets/icon-kue.webp') }}" alt="Cake" class="forgot-icon">

            <h2 class="forgot-title">{{ __('Forgot your password?') }}</h2>
            <p class="forgot-subtitle">
                {{ __('Enter your email so that we can send you password reset link') }}
            </p>

            @if (session('status'))
                <div class="alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <label for="email">{{ __('Email') }}</label>
                <input id="email" type="email" name="email"
                       class="@error('email') is-invalid @enderror"
                       value="{{ old('email') }}"
                       placeholder="e.g. username@gmail.com"
                       required autocomplete="email" autofocus>

                @error('email')
                    <div class="error-text">{{ $message }}</div>
                @enderror

                <button type="submit" class="btn-submit">{{ __('Send Email') }}</button>
            </form>

            <a href="{{ route('login') }}" class="forgot-back">
                &#8592; {{ __('Back to Login') }}
            </a>

        </div>
    </div>
</div>

<style>
    .forgot-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff0ee;
        font-family: Arial, Helvetica, sans-serif;
        padding: 20px;
    }
    .forgot-page * { box-sizing: border-box; }

    .forgot-card {
        width: 100%;
        max-width: 840px;
        min-height: 480px;
        background: #fff;
        border-radius: 28px;
        box-shadow: 0 20px 50px rgba(95, 106, 141, 0.25);
        padding: 48px 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .forgot-content {
        width: 100%;
        max-width: 400px;
    }

    .forgot-icon {
        width: 100px;
        height: 100px;
        object-fit: contain;
        margin-bottom: 16px;
    }
    .forgot-title {
        font-weight: 700;
        font-size: 1.8rem;
        color: #5f6a8d;
        margin-bottom: 8px;
    }
    .forgot-subtitle {
        font-size: 0.9rem;
        color: #777;
        line-height: 1.5;
        margin-bottom: 28px;
    }

    .forgot-page form { text-align: left; }

    .forgot-page label {
        display: block;
        font-weight: 700;
        font-size: 0.85rem;
        color: #5f6a8d;
        margin-bottom: 8px;
    }
    .forgot-page input[type="email"] {
        width: 100%;
        padding: 13px 20px;
        border: 1px solid #e6e0e0;
        border-radius: 50px;
        background: #fffafa;
        color: #333;
        font-size: 0.95rem;
        outline: none;
        transition: border-color .2s, box-shadow .2s, background .2s;
    }
    .forgot-page input[type="email"]::placeholder { color: #999; }
    .forgot-page input[type="email"]:focus {
        border-color: #f7a3a6;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(247, 163, 166, 0.25);
    }
    .forgot-page input.is-invalid { border-color: #e55353; }

    .error-text {
        color: #e55353;
        font-size: 0.8rem;
        margin-top: 6px;
        padding-left: 8px;
    }
    .alert-success {
        background: #e8f7ee;
        color: #1f7a45;
        border-radius: 12px;
        padding: 12px 14px;
        font-size: 0.85rem;
        margin-bottom: 18px;
        text-align: left;
    }

    .btn-submit {
        width: 100%;
        margin-top: 18px;
        padding: 14px;
        border: none;
        border-radius: 50px;
        background: #f7a3a6;
        color: #fff;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: background .2s;
    }
    .btn-submit:hover { background: #f28b8f; }

    .forgot-back {
        display: inline-block;
        margin-top: 22px;
        font-size: 0.9rem;
        font-weight: 700;
        color: #5f6a8d;
        text-decoration: none;
    }
    .forgot-back:hover { text-decoration: underline; }
</style>
@endsection     