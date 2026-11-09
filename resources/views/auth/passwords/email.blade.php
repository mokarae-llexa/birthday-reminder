@extends('layouts.guest')

@section('content')
<div class="login-content">
    <div class="auth-page forgot-page">
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
</div>

<style>
    .forgot-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        font-family: inherit;
        padding: 20px;
    }
    .forgot-page * { box-sizing: border-box; }

    .forgot-card {
        width: 100%;
        max-width: 840px;
        min-height: 480px;
        background: var(--white, #fff);
        border-radius: 28px;
        box-shadow: 0 20px 50px rgba(93, 104, 138, 0.25);
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
        font-family: var(--font-heading, 'Fraunces', Georgia, serif);
        font-weight: 700;
        font-size: 1.8rem;
        color: var(--primary-dark, #B95569);
        margin-bottom: 8px;
    }
    .forgot-subtitle {
        font-size: 0.9rem;
        color: var(--secondary, #5D688A);
        opacity: 0.9;
        line-height: 1.5;
        margin-bottom: 28px;
    }

    .forgot-page form { text-align: left; }

    .forgot-page label {
        display: block;
        font-weight: 700;
        font-size: 0.85rem;
        color: var(--primary-dark, #B95569);
        margin-bottom: 8px;
    }
    .forgot-page input[type="email"] {
        width: 100%;
        padding: 13px 20px;
        border: 1px solid var(--border, #F0C9C9);
        border-radius: 50px;
        background: var(--background, #FFF2EF);
        color: var(--text, #333);
        font-size: 0.95rem;
        outline: none;
        transition: border-color .2s, box-shadow .2s, background .2s;
    }
    .forgot-page input[type="email"]::placeholder { color: var(--secondary, #5D688A); opacity: 0.6; }
    .forgot-page input[type="email"]:focus {
        border-color: var(--primary, #E88F9B);
        background: var(--white, #fff);
        box-shadow: 0 0 0 4px rgba(232, 143, 155, 0.25);
    }
    .forgot-page input.is-invalid { border-color: var(--primary-dark, #B95569); }

    .error-text {
        color: var(--primary-dark, #B95569);
        font-size: 0.8rem;
        margin-top: 6px;
        padding-left: 8px;
    }
    .alert-success {
        background: var(--primary-soft, #FCE4E6);
        border: 1px solid var(--border, #F0C9C9);
        color: var(--primary-dark, #B95569);
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
        background: var(--primary, #E88F9B);
        color: var(--white, #fff);
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: background .2s;
    }
    .btn-submit:hover { background: var(--primary-dark, #B95569); }

    .forgot-back {
        display: inline-block;
        margin-top: 22px;
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--secondary, #5D688A);
        text-decoration: none;
    }
    .forgot-back:hover { color: var(--primary-dark, #B95569); text-decoration: underline; }
</style>
@endsection