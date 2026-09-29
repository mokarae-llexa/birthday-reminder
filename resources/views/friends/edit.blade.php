@extends('layouts.app')

@section('content')
@php
    $isLinked = !empty($friend->linked_user_id) && $friend->linkedUser;
@endphp
<div class="container py-2" style="max-width: 800px;">
    <div class="mb-4">
        <h2 class="fw-bold mb-1" style="color: #1F1F1F;">Edit Friend's Data</h2>
        <p class="text-muted mb-0">Update your friend's information and profile picture</p>
    </div>

    @if($isLinked)
        <div class="alert border-0 shadow-sm rounded-4 mb-3" style="background: #EAF1FE; color: #1A3A7A;" role="alert">
            <strong>🔗 Linked to {{ $friend->linkedUser->name }}'s account</strong><br>
            <span class="small">Name, Email & Birth Date sync automatically from their profile and cannot be edited manually.
            Phone, Notes & Photo can still be managed by you. Check the option below to unlink.</span>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4" style="background: #FFFFFF;">
        <div class="card-body p-4">
            <form action="{{ route('friends.update', $friend->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <x-avatar-picker :currentAvatar="old('avatar_base64', $friend->display_avatar_url)" :defaultName="$friend->display_name" />

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Friend's Name @if($isLinked)<span class="badge rounded-pill ms-1" style="background:#E8F0FE;color:#1A56DB;font-size:10px;">🔗 synced</span>@endif</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="form-control rounded-3"
                        value="{{ old('name', $friend->display_name) }}"
                        required
                        @if($isLinked) readonly @endif
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
                            value="{{ old('phone', $friend->phone) }}"
                            placeholder="Enter phone number (Optional)"
                        >
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label fw-semibold">Email @if($isLinked)<span class="badge rounded-pill ms-1" style="background:#E8F0FE;color:#1A56DB;font-size:10px;">🔗 synced</span>@endif</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="form-control rounded-3"
                            value="{{ old('email', $friend->display_email) }}"
                            placeholder="Enter email address (Optional)"
                            @if($isLinked) readonly @endif
                        >
                    </div>
                </div>
                <div class="mb-3">
                    <label for="birth_date" class="form-label fw-semibold">Birth Date @if($isLinked)<span class="badge rounded-pill ms-1" style="background:#E8F0FE;color:#1A56DB;font-size:10px;">🔗 synced</span>@endif</label>
                    <input
                        type="date"
                        name="birth_date"
                        id="birth_date"
                        class="form-control rounded-3"
                        value="{{ old('birth_date', $friend->display_birth_date) }}"
                        required
                        @if($isLinked) readonly @endif
                    >
                </div>
                <div class="mb-4">
                    <label for="notes" class="form-label fw-semibold">Notes</label>
                    <textarea
                        name="notes"
                        id="notes"
                        class="form-control rounded-3"
                        rows="4"
                    >{{ old('notes', $friend->notes) }}</textarea>
                </div>
                @if($isLinked)
                    <div class="form-check mb-4 p-3 rounded-3" style="background: #FFF8F6; border: 1px solid #FFE0DB;">
                        <input class="form-check-input" type="checkbox" name="unlink" id="unlink" value="1" {{ old('unlink') ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="unlink">
                            Unlink account
                        </label>
                        <div class="form-text">Data becomes manual (no longer synced) and all fields become editable.</div>
                    </div>
                @endif
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('friends.index') }}" class="btn btn-secondary rounded-pill px-4">
                        Back
                    </a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4" style="background-color: #C55F4E; border-color: #C55F4E;">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@if($isLinked)
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const unlink = document.getElementById('unlink');
    const synced = ['name', 'email', 'birth_date'].map(function (id) {
        return document.getElementById(id);
    });
    if (!unlink) return;
    function toggle() {
        synced.forEach(function (input) {
            if (input) input.readOnly = !unlink.checked;
        });
    }
    unlink.addEventListener('change', toggle);
    toggle();
});
</script>
@endpush
@endif
