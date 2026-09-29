@extends('layouts.app')

@section('content')
<div class="container py-2" style="max-width: 900px;">
    <div class="mb-4">
        <h2 class="fw-bold mb-1" style="color: #1F1F1F;">Friend Requests</h2>
        <p class="text-muted mb-0">Manage incoming requests and track the ones you sent.</p>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: #FFFFFF;">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-3">Incoming <span class="badge rounded-pill ms-1" style="background:#FFE6E3;color:#C55F4E;">{{ $incoming->count() }}</span></h5>
            @forelse($incoming as $request)
                <div class="d-flex align-items-center gap-3 py-3 border-bottom">
                    <img src="{{ $request->display_avatar_url }}" alt="{{ $request->display_name }}" class="rounded-circle border" style="width:52px;height:52px;object-fit:cover;">
                    <div class="flex-grow-1" style="min-width:0;">
                        <div class="fw-bold text-dark">{{ $request->requester?->name ?? $request->display_name }}</div>
                        <div class="text-muted small text-truncate">{{ $request->display_email ?? 'No email yet' }}</div>
                        <div class="text-muted small">Wants to add you as a friend.</div>
                    </div>
                    <div class="d-flex gap-2 flex-shrink-0">
                        <form action="{{ route('friends.accept', $request->id) }}" method="POST" style="margin:0;">
                            @csrf
                            <button type="submit" class="btn btn-sm rounded-pill px-3 text-white" style="background-color:#C55F4E;border-color:#C55F4E;">Accept</button>
                        </form>
                        <form action="{{ route('friends.decline', $request->id) }}" method="POST" style="margin:0;">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-secondary rounded-pill px-3">Decline</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-4">
                    <div class="fs-1 mb-2">📭</div>
                    <p class="text-muted small mb-0">No incoming requests.</p>
                </div>
            @endforelse
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4" style="background: #FFFFFF;">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-3">Sent <span class="badge rounded-pill ms-1" style="background:#E8F0FE;color:#1A56DB;">{{ $outgoing->count() }}</span></h5>
            @forelse($outgoing as $request)
                <div class="d-flex align-items-center gap-3 py-3 border-bottom">
                    <img src="{{ $request->display_avatar_url }}" alt="{{ $request->display_name }}" class="rounded-circle border" style="width:52px;height:52px;object-fit:cover;">
                    <div class="flex-grow-1" style="min-width:0;">
                        <div class="fw-bold text-dark">{{ $request->display_name }}</div>
                        <div class="text-muted small text-truncate">{{ $request->display_email ?? 'No email yet' }}</div>
                        <span class="badge rounded-pill mt-1" style="font-size:10px;background:#FFF7E6;color:#B7791F;border:1px solid #F5D67B;">⏳ Pending confirmation</span>
                    </div>
                    <form action="{{ route('friends.destroy', $request->id) }}" method="POST" style="margin:0;" class="flex-shrink-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">Cancel</button>
                    </form>
                </div>
            @empty
                <div class="text-center py-4">
                    <div class="fs-1 mb-2">📤</div>
                    <p class="text-muted small mb-0">No sent requests yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
