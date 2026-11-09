@extends('layouts.app')
@section('content')
    <style>
        .page-title h2,
        .page-title p {
            paint-order: stroke fill;
            -webkit-text-stroke: 6px #fff;
            text-shadow: 0 0 12px rgba(255, 255, 255, .9);
        }

        .page-title h2 {
            color: var(--text, #333333);
            -webkit-text-stroke-width: 8px;
        }

        .page-title p {
            color: var(--primary-dark, #B95569);
            -webkit-text-stroke-width: 5px;
        }

        .card-flat {
            background: var(--white, #fff);
            border: 1.5px solid var(--border, #F0C9C9) !important;
        }
    </style>
    
    <div class="container py-2" style="max-width: 900px;">
        <div class="mb-4 page-title">
            <h2 class="fw-bold mb-1">Friend Requests</h2>
            <p class="mb-0 fw-medium">Manage incoming requests and track the ones you sent.</p>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: var(--white, #FFFFFF);">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3" style="color: var(--text, #333333);">Incoming <span class="badge rounded-pill ms-1"
                        style="background:var(--primary-soft, #FCE4E6);color:var(--primary-dark, #B95569);border:1px solid var(--border, #F0C9C9);">{{ $incoming->count() }}</span></h5>
                @forelse($incoming as $request)
                    <div class="d-flex align-items-center gap-3 py-3 border-bottom">
                        <img src="{{ $request->display_avatar_url }}" alt="{{ $request->display_name }}"
                            class="rounded-circle border" style="width:52px;height:52px;object-fit:cover;border-color:var(--border, #F0C9C9) !important;">
                        <div class="flex-grow-1" style="min-width:0;">
                            <div class="fw-bold" style="color: var(--text, #333333);">{{ $request->requester?->name ?? $request->display_name }}</div>
                            <div class="text-muted small text-truncate">{{ $request->display_email ?? 'No email yet' }}
                            </div>
                            <div class="text-muted small">Wants to add you as a friend.</div>
                        </div>
                        <div class="d-flex gap-2 flex-shrink-0">
                            <form action="{{ route('friends.accept', $request->id) }}" method="POST" style="margin:0;">
                                @csrf
                                <button type="submit" class="btn btn-sm rounded-pill px-3 text-white"
                                    style="background-color:var(--primary, #E88F9B);border-color:var(--primary, #E88F9B);">Accept</button>
                            </form>
                            <form action="{{ route('friends.decline', $request->id) }}" method="POST" style="margin:0;">
                                @csrf
                                <button type="submit"
                                    class="btn btn-sm btn-outline-secondary rounded-pill px-3">Decline</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <p class="text-muted small mb-0">No incoming requests.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4" style="background: var(--white, #FFFFFF);">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3" style="color: var(--text, #333333);">Sent <span class="badge rounded-pill ms-1"
                        style="background:var(--secondary-soft, #E9ECF4);color:var(--secondary-dark, #3F4766);border:1px solid var(--secondary, #5D688A);">{{ $outgoing->count() }}</span></h5>
                @forelse($outgoing as $request)
                    <div class="d-flex align-items-center gap-3 py-3 border-bottom">
                        <img src="{{ $request->display_avatar_url }}" alt="{{ $request->display_name }}"
                            class="rounded-circle border" style="width:52px;height:52px;object-fit:cover;border-color:var(--border, #F0C9C9) !important;">
                        <div class="flex-grow-1" style="min-width:0;">
                            <div class="fw-bold" style="color: var(--text, #333333);">{{ $request->display_name }}</div>
                            <div class="text-muted small text-truncate">{{ $request->display_email ?? 'No email yet' }}
                            </div>
                            <span class="badge rounded-pill mt-1"
                                style="font-size:10px;background:var(--accent, #FFDBB6);color:var(--text, #333333);border:1px solid var(--accent-dark, #E8A765);">Pending
                                confirmation</span>
                        </div>
                        <form action="{{ route('friends.destroy', $request->id) }}" method="POST" style="margin:0;"
                            class="flex-shrink-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-primary rounded-pill px-3">Cancel</button>
                        </form>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <p class="text-muted small mb-0">No sent requests yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
