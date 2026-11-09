@extends('layouts.guest')

@section('content')
<style>
    .verify-card {
        width: 100%;
        max-width: 520px;
        margin: 0 auto;
        background: var(--white, #fff);
        border-radius: 24px;
        padding: 52px 52px 44px;
        box-shadow: 0 18px 50px rgba(93, 104, 138, .18);
        text-align: left;
    }

    .verify-logo img {
        display: block;
        width: 72px;
        height: auto;
        margin-bottom: 28px;
    }

    .verify-card h2 {
        margin: 0 0 10px;
        font-family: var(--font-heading, 'Fraunces', Georgia, serif);
        font-weight: 700;
        font-size: 2.1rem;
        line-height: 1.2;
        color: var(--primary-dark, #B95569);
    }

    .verify-card .verify-subtitle {
        margin: 0;
        font-size: 1rem;
        line-height: 1.6;
        color: var(--secondary, #5D688A);
        opacity: 0.9;
    }

    .verify-alert {
        margin-top: 20px;
        padding: 10px 14px;
        border-radius: 12px;
        background: var(--primary-soft, #FCE4E6);
        border: 1px solid var(--border, #F0C9C9);
        color: var(--primary-dark, #B95569);
        font-size: .9rem;
        line-height: 1.5;
    }

    .verify-mail {
        width: 96px;
        height: 96px;
        margin: 40px auto;
        border-radius: 24px;
        background: var(--primary-soft, #FCE4E6);
        display: grid;
        place-items: center;
    }
    .verify-mail svg { width: 50px; height: 50px; }

    .verify-resend {
        text-align: center;
        font-size: .95rem;
        color: var(--secondary, #5D688A);
    }
    .verify-resend form { display: inline; }
    .verify-resend button {
        background: none;
        border: 0;
        padding: 0;
        margin: 0;
        font: inherit;
        font-weight: 700;
        color: var(--primary-dark, #B95569);
        cursor: pointer;
        text-decoration: underline;
        text-underline-offset: 3px;
    }
    .verify-resend button:hover { color: var(--secondary, #5D688A); }
    .verify-resend button:focus-visible {
        outline: 2px solid var(--primary, #E88F9B);
        outline-offset: 3px;
        border-radius: 3px;
    }

    @media (max-width: 480px) {
        .verify-card { padding: 34px 26px 30px; }
    }
</style>

<div class="login-content">
    <div class="auth-page">
        <div class="verify-card">

            <div class="verify-logo">
                <img src="{{ asset('assets/icon-kue.webp') }}" alt="Birthday Reminder Logo">
            </div>

            <h2>Verify your account</h2>
            <p class="verify-subtitle">
                Account activation link has been sent to the e-mail address you provided.
            </p>

            @if (session('resent'))
                <div class="verify-alert" role="alert">
                    A fresh verification link has been sent to your email address.
                </div>
            @endif

            <div class="verify-mail" aria-hidden="true">
                <svg viewBox="0 0 40 40" fill="none" stroke="var(--primary-dark, #B95569)" stroke-width="1.6" stroke-linejoin="round" stroke-linecap="round">
                    <rect x="3" y="7" width="34" height="26" rx="2"/>
                    <path d="M3 8l17 14L37 8"/>
                    <path d="M3 32l12-12M37 32L25 20"/>
                </svg>
            </div>

            <div class="verify-resend">
                Didn't get the mail?
                <form method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit">Send it again</button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection