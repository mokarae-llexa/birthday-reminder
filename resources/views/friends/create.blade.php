@extends('layouts.app')

@section('content')
@php
    $isLinked = !empty($prefillIsLinked ?? false) || !empty(old('linked_user_id', $prefill['linked_user_id'] ?? null));
@endphp
<div class="container py-2" style="max-width: 800px;">
    <div class="mb-4 d-flex justify-content-between align-items-start gap-3 flex-wrap">
        <div>
            <h2 class="fw-bold mb-1" style="color: #1F1F1F;">Add New Friend</h2>
            <p class="text-muted mb-0">Fill out the form below to add a friend to the birthday reminder list.</p>
        </div>
        <button type="button" class="btn btn-outline-secondary rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#databasePickerModal">
            🔍 Search from Database
        </button>
    </div>

    <div id="prefillNotice" class="alert alert-dismissible fade show border-0 shadow-sm rounded-4 mb-3 {{ empty($prefillSourceLabel) && empty($prefill['name']) ? 'd-none' : '' }}" style="background: #FFF4F2; color: #7A3A30;" role="alert">
        <strong id="prefillNoticeTitle">{{ $isLinked ? '🔗 Linked to user account' : 'Auto-filled data' }}</strong>
        from <span id="prefillNoticeLabel">{{ $prefillSourceLabel ?? 'Database' }}</span>.
        <span id="prefillNoticeHint">{{ $isLinked ? 'Name, Email & Birth Date sync automatically from their profile. Just complete Phone & Notes.' : 'Please complete the remaining fields before saving.' }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div class="card border-0 shadow-sm rounded-4" style="background: #FFFFFF;">
        <div class="card-body p-4">
            <form action="{{ route('friends.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <x-avatar-picker :currentAvatar="old('avatar_base64', $prefill['avatar'] ?? null)" :defaultName="old('name', $prefill['name'] ?? 'New Friend')" />
                <input type="hidden" name="avatar_url" id="avatarUrlInput" value="{{ old('avatar_url', $prefill['avatar'] ?? '') }}">
                <input type="hidden" name="linked_user_id" id="linkedUserIdInput" value="{{ old('linked_user_id', $prefill['linked_user_id'] ?? '') }}">
                @error('linked_user_id')
                    <div class="alert alert-warning rounded-3 py-2 small">{{ $message }}</div>
                @enderror

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Friend's Name @if($isLinked)<span class="badge rounded-pill ms-1" style="background:#E8F0FE;color:#1A56DB;font-size:10px;">🔗 synced</span>@endif</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="form-control rounded-3 @error('name') is-invalid @enderror"
                        value="{{ old('name', $prefill['name'] ?? '') }}"
                        placeholder="Enter friend's name"
                        required
                        @if($isLinked) readonly @endif
                    >
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label fw-semibold">Phone Number</label>
                        <input
                            type="text"
                            name="phone"
                            id="phone"
                            class="form-control rounded-3 @error('phone') is-invalid @enderror"
                            value="{{ old('phone', $prefill['phone'] ?? '') }}"
                            placeholder="Enter phone number (Optional)"
                        >
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label fw-semibold">Email @if($isLinked)<span class="badge rounded-pill ms-1" style="background:#E8F0FE;color:#1A56DB;font-size:10px;">🔗 synced</span>@endif</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="form-control rounded-3 @error('email') is-invalid @enderror"
                            value="{{ old('email', $prefill['email'] ?? '') }}"
                            placeholder="Enter email address (Optional)"
                            @if($isLinked) readonly @endif
                        >
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="birth_date" class="form-label fw-semibold">Birth Date @if($isLinked)<span class="badge rounded-pill ms-1" style="background:#E8F0FE;color:#1A56DB;font-size:10px;">🔗 synced</span>@endif</label>
                    <input
                        type="date"
                        name="birth_date"
                        id="birth_date"
                        class="form-control rounded-3 @error('birth_date') is-invalid @enderror"
                        value="{{ old('birth_date', $prefill['birth_date'] ?? '') }}"
                        required
                        @if($isLinked) readonly @endif
                    >
                    @error('birth_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="notes" class="form-label fw-semibold">Notes</label>
                    <textarea
                        name="notes"
                        id="notes"
                        class="form-control rounded-3 @error('notes') is-invalid @enderror"
                        rows="4"
                        placeholder="Add a note about a friend (Optional)">{{ old('notes', $prefill['notes'] ?? '') }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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

@include('friends._database-picker-modal', ['mode' => 'autofill', 'modalId' => 'databasePickerModal'])
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById('avatarFileInput');
    const urlInput = document.getElementById('avatarUrlInput');
    if (fileInput && urlInput) {
        fileInput.addEventListener('change', function () {
            if (fileInput.files && fileInput.files.length > 0) {
                urlInput.value = '';
            }
        });
    }
    document.querySelectorAll('.preset-emoji-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            if (urlInput) urlInput.value = '';
        });
    });
});
</script>
@endpush
