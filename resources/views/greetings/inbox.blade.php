@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width: 900px;">
    <h4 class="fw-bold mb-3 sticker">Ucapan untukmu</h4>

    @forelse($greetings as $g)
        <div class="card card-flat rounded-4 mb-3 p-3" style="{{ $unreadIds->contains($g->id) ? 'border-color: var(--primary, #E88F9B) !important;' : '' }}">
            <div class="d-flex justify-content-between align-items-center">
                <strong style="color: var(--text, #333333);">{{ $g->user->name }}</strong>
                <small style="color: var(--secondary, #5D688A);">{{ $g->created_at?->diffForHumans() }}</small>
            </div>
            <div class="mt-1" style="color: var(--text, #333333);">{{ $g->message }}</div>
            @if($unreadIds->contains($g->id))
                <small class="fw-semibold mt-1 d-inline-block" style="color: var(--primary-dark, #B95569);">Baru</small>
            @endif
        </div>
    @empty
        <div class="card card-flat rounded-4 p-4 text-center">
            <p class="mb-0" style="color: var(--secondary, #5D688A);">Belum ada ucapan untukmu.</p>
        </div>
    @endforelse
</div>
@endsection