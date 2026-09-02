@extends('layouts.app')

@section('content')
<div class="login-content">
    <div class="auth-page">
        <div class="auth-card">

            <div class="auth-left">
                <div class="auth-logo">
                    <img src="{{ asset('assets/icon-kue.webp') }}" alt="Birthday Reminder Logo" width="64" class="img-fluid">
                </div>
                <h1>Birthday<br>Reminder</h1>
                <p>Never miss a special day. Track and celebrate birthdays with your friends and family.</p>
            </div>

            <div class="auth-right">
                <h2>Form Login</h2>
                <p class="auth-subtitle">Please enter your credentials to log in.</p>

                @if ($errors->any())
                    <div class="alert alert-danger py-2 mb-3">
                        <p class="mb-0 small text-center">
                            {{ $errors->first() }}
                        </p>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="auth-label">Email Address</label>
                        <input
                            id="email"
                            type="email"
                            class="form-control auth-input @error('email') is-invalid @enderror"
                            name="email"
                            placeholder="Drop your email here"
                            value="{{ old('email') }}"
                            required
                            autofocus
                        >
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="auth-label">Password</label>
                        <input
                            id="password"
                            type="password"
                            class="form-control auth-input @error('password') is-invalid @enderror"
                            name="password"
                            placeholder="Enter your password"
                            required
                        >
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check mb-0">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="remember"
                                id="remember"
                                {{ old('remember') ? 'checked' : '' }}
                            >
                            <label class="form-check-label" for="remember">
                                Remember me
                            </label>
                        </div>
                        @if (Route::has('password.request'))
                            <a class="auth-link small" href="{{ route('password.request') }}">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="auth-button">
                        Here we go →
                    </button>
                </form>

                <div class="text-center mt-4">
                    <span>New here? </span>
                    <a class="auth-link" href="{{ route('register') }}">
                        <b>Create an account</b>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection