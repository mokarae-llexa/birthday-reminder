@extends('layouts.guest')

@section('content')
<div class="login-content">
    <div class="auth-page">
        <div class="auth-card">

            <div class="auth-left">
                <div class="auth-logo">
                    <img src="{{ asset('assets/icon-kue.webp') }}" alt="Birthday Reminder Logo" width="64" class="img-fluid">
                </div>
                <h1>Birthday<br>Reminder</h1>
                <p>Make every birthday special. Reset your password and never miss a celebration.</p>
            </div>

            <div class="auth-right">
                <h2>Reset Password</h2>
                <p class="auth-subtitle">Create a new password for your account.</p>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-3">
                        <label for="email" class="auth-label">Email Address</label>
                        <input
                            id="email"
                            type="email"
                            class="form-control auth-input @error('email') is-invalid @enderror"
                            name="email"
                            placeholder="Drop your email here"
                            value="{{ $email ?? old('email') }}"
                            required
                            autocomplete="email"
                            autofocus
                        >
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="auth-label">New Password</label>
                        <input
                            id="password"
                            type="password"
                            class="form-control auth-input @error('password') is-invalid @enderror"
                            name="password"
                            placeholder="Enter a new password"
                            required
                            autocomplete="new-password"
                        >
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password-confirm" class="auth-label">Confirm Password</label>
                        <input
                            id="password-confirm"
                            type="password"
                            class="form-control auth-input"
                            name="password_confirmation"
                            placeholder="Repeat your new password"
                            required
                            autocomplete="new-password"
                        >
                    </div>

                    <button type="submit" class="auth-button">
                        Reset Password →
                    </button>
                </form>

                <div class="text-center mt-4">
                    <span>Remembered it? </span>
                    <a class="auth-link" href="{{ route('login') }}">
                        <b>Back to login</b>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection