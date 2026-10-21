@extends('layouts.app')
@section('content')
    @php
        $sortUrl = function ($key) {
            $dir = request('sort') === $key && request('dir', 'asc') === 'asc' ? 'desc' : 'asc';
            return request()->fullUrlWithQuery(['sort' => $key, 'dir' => $dir]);
        };
        $sortIcon = function ($key) {
            if (request('sort') !== $key) {
                return '⇅';
            }
            return request('dir') === 'desc' ? '▼' : '▲';
        };
    @endphp
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

        .search-box {
            width: 320px;
            height: 38px;
            display: flex;
            align-items: center;
            padding: 0 16px;
            background: #FFFFFF;
            border-radius: 20px;
        }

        .search-box span {
            margin-right: 8px;
            color: #B58F86;
            display: flex;
            align-items: center;
        }

        .search-box span svg {
            width: 16px;
            height: 16px;
        }

        .search-box input {
            width: 100%;
            border: none;
            outline: none;
            background: transparent;
            font-size: 13px;
            color: #1f1f1f;
        }

        .search-box input::placeholder {
            color: #B58F86;
        }

        .search-box:focus-within {
            border-color: #C55F4E;
        }

        .btn-chip {
            background: #fff;
            border: 1.5px solid #D9B8B2;
            color: #6B3F49;
            font-weight: 600;
        }


        .btn-chip:hover {
            background: #FFE6E3;
            border-color: #C55F4E;
            color: #C55F4E;
        }


        .card-flat {
            background: #fff;
            border: 1.5px solid #F3DDD8 !important;
        }
    </style>

    <div class="container-fluid px-4 py-2">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div>
                <h2 class="fw-bold mb-1 sticker">Friends List</h2>
                <p class="mb-0 sticker sticker-soft">Manage friends' data and birthday reminders.</p>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <form action="{{ route('friends.index') }}" method="GET" style="margin: 0;">
                    @foreach (['class', 'sort', 'dir'] as $keep)
                        @if (request($keep))
                            <input type="hidden" name="{{ $keep }}" value="{{ request($keep) }}">
                        @endif
                    @endforeach
                    <div class="search-box">
                        <span>
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </span>
                        <input type="text" name="search" placeholder="Search" value="{{ request('search') }}">
                        @if (request('search'))
                            <a href="{{ route('friends.index') }}"
                                style="color: #B58F86; text-decoration: none; font-size: 14px; margin-left: 6px;"
                                title="Reset">✕</a>
                        @endif
                    </div>
                </form>
                <a href="{{ route('friends.create') }}" class="btn btn-primary rounded-pill px-4"
                    style="background-color: #C55F4E; border-color: #C55F4E;">
                    + Add Friend
                </a>
                <button type="button" class="btn btn-chip rounded-pill px-4" data-bs-toggle="modal"
                    data-bs-target="#databasePickerIndexModal">
                    Search Online
                </button>
            </div>
        </div>
        @if ($classList->isNotEmpty())
            <div class="d-flex align-items-center gap-2 flex-wrap mb-3">
                <span class="text-muted small">Class</span>
                <a href="{{ request()->fullUrlWithQuery(['class' => null]) }}"
                    class="btn btn-sm rounded-pill {{ request('class') ? 'btn-outline-secondary' : 'text-white' }}"
                    style="{{ request('class') ? '' : 'background-color:#C55F4E;border-color:#C55F4E;' }}">All</a>
                @foreach ($classList as $c)
                    <a href="{{ request()->fullUrlWithQuery(['class' => $c]) }}"
                        class="btn btn-sm rounded-pill {{ request('class') === $c ? 'text-white' : 'btn-outline-secondary' }}"
                        style="{{ request('class') === $c ? 'background-color:#C55F4E;border-color:#C55F4E;' : '' }}">{{ $c }}</a>
                @endforeach
            </div>
        @endif
        <div class="card card-flat rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background-color: #FFE6E3; color: #C55F4E;">
                            <tr>
                                <th class="py-3 px-4 text-center" style="width: 70px;">No</th>
                                <th class="py-3 px-3">Avatar</th>
                                <th class="py-3 px-3">
                                    <a href="{{ $sortUrl('name') }}" class="text-decoration-none"
                                        style="color: inherit;">Friend's Name {{ $sortIcon('name') }}</a>
                                </th>
                                <th class="py-3 px-3">Phone Number</th>
                                <th class="py-3 px-3">Email</th>
                                <th class="py-3 px-3">
                                    <a href="{{ $sortUrl('dob') }}" class="text-decoration-none"
                                        style="color: inherit;">Date Of Birth {{ $sortIcon('dob') }}</a>
                                </th>
                                <th class="py-3 px-3">
                                    <a href="{{ $sortUrl('class') }}" class="text-decoration-none"
                                        style="color: inherit;">Class {{ $sortIcon('class') }}</a>
                                </th>
                                <th class="py-3 px-3">Notes</th>
                                <th class="py-3 px-4 text-center" style="width: 150px;">action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($friends as $friend)
                                <tr>
                                    <td class="text-center fw-bold text-muted py-3 px-4">{{ $loop->iteration }}</td>
                                    <td class="py-3 px-3">
                                        <img src="{{ $friend->display_avatar_url }}" alt="{{ $friend->display_name }}"
                                            class="rounded-circle shadow-sm border"
                                            style="width: 44px; height: 44px; object-fit: cover; border-color: #FFE6E3 !important;">
                                    </td>
                                    <td class="py-3 px-3">
                                        <span class="fw-bold d-block text-dark"
                                            style="font-size: 15px;">{{ $friend->display_name }}</span>
                                        @if ($friend->is_linked)
                                            <span class="badge rounded-pill mt-1"
                                                style="font-size:10px;background:#E8F0FE;color:#1A56DB;border:1px solid #C7DBFF;"
                                                title="Auto-synced from {{ $friend->linkedUser?->name }}'s profile">🔗
                                                Linked</span>
                                        @endif
                                        @if ($friend->isPending())
                                            <span class="badge rounded-pill mt-1"
                                                style="font-size:10px;background:#FFF7E6;color:#B7791F;border:1px solid #F5D67B;">⏳
                                                Pending confirmation</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-3">
                                        @if ($friend->phone)
                                            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-normal"
                                                style="font-size: 12px;">
                                                📞 {{ $friend->phone }}
                                            </span>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-3">
                                        @if ($friend->display_email)
                                            <span class="text-secondary small d-block" style="font-size: 12.5px;">
                                                ✉️ {{ $friend->display_email }}
                                            </span>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-3">
                                        <span class="fw-semibold text-secondary" style="font-size: 14px;">
                                            🎂
                                            {{ \Carbon\Carbon::parse($friend->display_birth_date)->translatedFormat('d F Y') }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-3">
                                        @if ($friend->class_name)
                                            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-normal"
                                                style="font-size: 12px;">
                                                {{ $friend->class_name }}
                                            </span>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-3 text-muted small" style="max-width: 220px;">
                                        <div class="text-truncate" style="max-width: 200px;" title="{{ $friend->notes }}">
                                            {{ $friend->notes ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        @if (
                                            $friend->isPending() &&
                                                (int) $friend->linked_user_id === (int) auth()->id() &&
                                                (int) $friend->created_by !== (int) auth()->id())
                                            <a href="{{ route('friends.requests') }}"
                                                class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                Respond
                                            </a>
                                        @else
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('friends.edit', $friend->id) }}"
                                                    class="btn btn-sm btn-outline-warning rounded-pill px-3"
                                                    title="Edit Data">
                                                    Edit
                                                </a>
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                                    title="Delete Data"
                                                    onclick="openDeleteModal('{{ route('friends.destroy', $friend->id) }}', '{{ addslashes($friend->display_name) }}')">
                                                    Delete
                                                </button>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-5">
                                        <div class="my-3">
                                            <div class="fs-1 mb-2">
                                                {{ request('search') || request('class') ? '🔍' : '🎈' }}</div>
                                            <h5 class="fw-bold text-dark mb-1">
                                                {{ request('search') || request('class') ? 'No Results Found' : 'No Friends Yet' }}
                                            </h5>
                                            <p class="text-muted small mb-3">
                                                @if (request('search'))
                                                    No friend matches the keyword "{{ request('search') }}".
                                                @elseif (request('class'))
                                                    No friends found in class "{{ request('class') }}".
                                                @else
                                                    Start adding friends to get birthday reminders.
                                                @endif
                                            </p>
                                            @if (request('search') || request('class'))
                                                <a href="{{ route('friends.index') }}"
                                                    class="btn btn-sm btn-chip rounded-pill px-4">
                                                    Reset Filter
                                                </a>
                                            @else
                                                <a href="{{ route('friends.create') }}"
                                                    class="btn btn-sm btn-primary rounded-pill px-4"
                                                    style="background-color: #C55F4E; border-color: #C55F4E;">
                                                    + Add First Friend
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <x-delete-confirm-modal />

    @include('friends._database-picker-modal', [
        'mode' => 'redirect',
        'modalId' => 'databasePickerIndexModal',
    ])
@endsection
