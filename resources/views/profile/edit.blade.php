@extends('layouts.app')

@section('content')
    <style>
        .sticker {
            color: #2B1F22;
            paint-order: stroke fill;
            -webkit-text-stroke: 0.28em #fff;
            text-shadow: 0 0 10px rgba(255, 255, 255, .9);
        }

        .sticker-soft {
            color: #6B3F49;
            font-weight: 500;
        }
    </style>
    <div class="container-fluid py-2">
        <div class="mb-4">
            <h2 class="fw-bold mb-1 sticker">Manage My Profile</h2>
            <p class="mb-0 sticker sticker-soft">Manage your profile picture, name, email, and password.</p>
        </div>
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm rounded-4 h-100" style="background: #FFFFFF;">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                        <h5 class="fw-bold mb-0" style="color: #C55F4E;">
                            <i class="bi bi-person-circle me-2"></i>Profile Information & Avatar
                        </h5>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <x-avatar-picker :currentAvatar="old('avatar_base64', $user->avatar_url)" :defaultName="$user->name" />

                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">Full Name</label>
                                <input type="text" name="name" id="name" class="form-control rounded-3"
                                    value="{{ old('name', $user->name) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email Address</label>
                                <input type="email" name="email" id="email" class="form-control rounded-3"
                                    value="{{ old('email', $user->email) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label fw-semibold">Phone Number</label>
                                <input type="text" name="phone" id="phone" class="form-control rounded-3"
                                    value="{{ old('phone', $user->phone) }}" placeholder="Enter phone number (Optional)">
                            </div>

                            <div class="mb-4">
                                <label for="class_name" class="form-label fw-semibold">Class Name</label>
                                <input type="text" name="class_name" id="class_name"
                                    class="form-control rounded-3 @error('class_name') is-invalid @enderror"
                                    value="{{ old('class_name', $user->class_name) }}" max="{{ now()->format('Y-m-d') }}">
                                @error('class_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-4">
                                <label for="birth_date" class="form-label fw-semibold">Birth Date</label>
                                <input type="date" name="birth_date" id="birth_date"
                                    class="form-control rounded-3 @error('birth_date') is-invalid @enderror"
                                    value="{{ old('birth_date', $user->birth_date?->format('Y-m-d')) }}"
                                    max="{{ now()->format('Y-m-d') }}">
                                @error('birth_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary rounded-pill px-4"
                                    style="background-color: #C55F4E; border-color: #C55F4E;">
                                    Save Profile Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm rounded-4 h-100" style="background: #FFFFFF;">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                        <h5 class="fw-bold mb-0" style="color: #C55F4E;">
                            <i class="bi bi-key-fill me-2"></i>Change Password
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('profile.update-password') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="current_password" class="form-label fw-semibold">Current Password</label>
                                <input type="password" name="current_password" id="current_password"
                                    class="form-control rounded-3" placeholder="Enter current password" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label fw-semibold">New Password</label>
                                    <input type="password" name="password" id="password" class="form-control rounded-3"
                                        placeholder="Enter new password" required>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="password_confirmation" class="form-label fw-semibold">Confirm New
                                        Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control rounded-3" placeholder="Re-enter new password" required>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-outline-danger rounded-pill px-4">
                                    Change Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4" style="background: #FFFFFF;">
                    <div class="card-body p-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div>
                            <h6 class="fw-bold mb-1 text-danger">Logout</h6>
                            <p class="text-muted small mb-0">Logout from your Birthday Reminder account</p>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger rounded-pill px-4">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
