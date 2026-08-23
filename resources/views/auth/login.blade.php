@extends('layouts.app')

@section('content')
<div class="login-content">
    <div class="auth-page">
        <div class="auth-card">

            <div class="auth-left">
                <div class="auth-logo">
                    <img src="{{ asset("assets/icon-kue.webp") }}" alt="icon kue" class="img-fluid" width=64>
                </div>
                <h1>Birthday<br>Reminder</h1>
            </div>

            <div class="auth-right">
                <h2>FROM LOGIN</h2>

                @if ($errors->any())
                    <div class="alert alert-danger py-2">
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
                        >
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
                    </div>

                    <div class="form-check mb-4">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="remember"
                            id="remember"
                        >
                        <label class="form-check-label" for="remember">
                            Remember me
                        </label>
                    </div>

                    <button type="submit" class="auth-button">
                        Here w go →
                    </button>
                </form>

                <div class="text-center mt-4">
                    <span>New here?</span>
                    <a class="auth-link" href="{{ route('register') }}">
                        <b>Create an account</b>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection