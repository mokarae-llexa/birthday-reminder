@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h4 class="mb-3">Ucapan untukmu</h4>

    @forelse($greetings as $g)
        <div class="card mb-2 p-3 {{ $unreadIds->contains($g->id) ? 'border-danger' : '' }}">
            <div class="d-flex justify-content-between">
                <strong>{{ $g->user->name }}</strong>
                <small class="text-muted">{{ $g->created_at?->diffForHumans() }}</small>
            </div>
            <div class="mt-1">{{ $g->message }}</div>
            @if($unreadIds->contains($g->id))
                <small class="text-danger">Baru</small>
            @endif
        </div>
    @empty
        <p class="text-muted">Belum ada ucapan untukmu.</p>
    @endforelse
</div>
@endsection