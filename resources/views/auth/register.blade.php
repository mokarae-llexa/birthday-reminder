@extends('layouts.app')

@section('content')
    <div class="register-content">
        <div class="auth-page">
            <div class="auth-card">
                <div class="auth-left"
                    style="background-color: #B2704E; border-color:black; border-radius: 5px; padding:10px;">
                    <div class="auth-logo">🎂</div>
                    <h1>Birthday<br>Reminder</h1>
                </div>

                <div class="auth-right">
                    <h2>Hey, Please register! </h2>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf


                        <div class="mb-3">
                            <label for="name" class="auth-label">Name</label>
                            <input id="name" type="text"
                                class="form-control auth-input @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name') }}" placeholder="Enter your name" required autocomplete="name"
                                autofocus>
                            @error('name')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="auth-label">Email Address</label>
                            <input id="email" type="email"
                                class="form-control auth-input @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" placeholder="Drop your email here" required
                                autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="auth-label">Password</label>
                            <input id="password" type="password"
                                class="form-control auth-input @error('password') is-invalid @enderror" name="password"
                                placeholder="Enter your password" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password-confirm" class="auth-label">Confirm Password</label>
                            <input id="password-confirm" type="password" class="form-control auth-input"
                                name="password_confirmation" placeholder="Confirm your password" required
                                autocomplete="new-password">
                        </div>
                        <button type="submit" class="btn-register">
                            Register
                        </button>
                </div>
            </div>
        </div>
    </div>
