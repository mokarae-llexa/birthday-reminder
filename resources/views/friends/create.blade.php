@extends('layouts.app')

@section('content')
<div class="container py-2" style="max-width: 800px;">
    <div class="mb-4">
        <h2 class="fw-bold mb-1" style="color: #1F1F1F;">Add New Friend</h2>
        <p class="text-muted mb-0">Fill out the form below to add a friend to the birthday reminder list.</p>
    </div>

    <div class="card border-0 shadow-sm rounded-4" style="background: #FFFFFF;">
        <div class="card-body p-4">
            <form action="{{ route('friends.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <x-avatar-picker :currentAvatar="old('avatar_base64')" defaultName="Teman Baru" />

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Friend's Name</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="form-control rounded-3"
                        value="{{ old('name') }}"
                        placeholder="Enter friend's name"
                        required
                    >
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label fw-semibold">Phone Number</label>
                        <input
                            type="text"
                            name="phone"
                            id="phone"
                            class="form-control rounded-3"
                            value="{{ old('phone') }}"
                            placeholder="Enter phone number (Optional)"
                        >
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="form-control rounded-3"
                            value="{{ old('email') }}"
                            placeholder="Enter email address (Optional)"
                        >
                    </div>
                </div>
                <div class="mb-3">
                    <label for="birth_date" class="form-label fw-semibold">Birth Date</label>
                    <input
                        type="date"
                        name="birth_date"
                        id="birth_date"
                        class="form-control rounded-3"
                        value="{{ old('birth_date') }}"
                        required
                    >
                </div>
                <div class="mb-4">
                    <label for="notes" class="form-label fw-semibold">Notes</label>
                    <textarea
                        name="notes"
                        id="notes"
                        class="form-control rounded-3"
                        rows="4"
                        placeholder="Add a note about a friend (Optional)">{{ old('notes') }}</textarea>
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('friends.index') }}" class="btn btn-secondary rounded-pill px-4">
                        Back
                    </a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4" style="background-color: #C55F4E; border-color: #C55F4E;">
                        Save Friend Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection