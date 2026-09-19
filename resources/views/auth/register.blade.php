@extends('layouts.guest')
@section('content')
<div class="register-content">
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
                <h2>Form Register</h2>
                <p class="auth-subtitle">Create an account to get started with Birthday Reminder.</p>

                @if ($errors->any())
                    <div class="alert alert-danger py-2 mb-3">
                        <p class="mb-0 small text-center">
                            {{ $errors->first() }}
                        </p>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="auth-label">Name</label>
                        <input
                            id="name"
                            type="text"
                            class="form-control auth-input @error('name') is-invalid @enderror"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Enter your full name"
                            required
                            autocomplete="name"
                            autofocus
                        >
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="auth-label">Email Address</label>
                        <input
                            id="email"
                            type="email"
                            class="form-control auth-input @error('email') is-invalid @enderror"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Drop your email here"
                            required
                            autocomplete="email"
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
                            autocomplete="new-password"
                        >
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

<<<<<<< HEAD
                        <div class="mb-3">
                            <label for="password-confirm" class="auth-label">Confirm Password</label>
                            <input id="password-confirm" type="password" class="form-control auth-input"
                                name="password_confirmation" placeholder="Confirm your password" required
                                autocomplete="new-password">
                        </div>
                        <button type="submit" class="auth-button">
                            Register
                        </button>
=======
                    <div class="mb-4">
                        <label for="password-confirm" class="auth-label">Confirm Password</label>
                        <input
                            id="password-confirm"
                            type="password"
                            class="form-control auth-input"
                            name="password_confirmation"
                            placeholder="Confirm your password"
                            required
                            autocomplete="new-password"
                        >
                    </div>

                    <button type="submit" class="auth-button">
                        Register →
                    </button>
                </form>

                <div class="text-center mt-4">
                    <span>Already have an account? </span>
                    <a class="auth-link" href="{{ route('login') }}">
                        <b>Log in</b>
                    </a>
>>>>>>> fdfe99c6b779f08c5f9c3ce957f80471c5fd0930
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
