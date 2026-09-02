<style>
    .sidebar {
        width: 260px;
        height: 100vh;
        padding: 24px 16px;
        display: flex;
        flex-direction: column;
        flex-shrink: 0;
        background: #FFFFFF;
        border-right: 1.5px solid #FFD6D2;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .brand {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 32px;
        padding-left: 4px;
    }

    .brand img {
        width: 44px;
        height: 44px;
        object-fit: contain;
    }

    .brand h1 {
        margin: 0;
        color: #1F1F1F;
        font-size: 15px;
        font-weight: 500;
        white-space: nowrap;
        letter-spacing: -0.2px;
    }

    .brand h1 strong {
        font-weight: 800;
    }

    .menu {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .menu a {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 14px;
        color: #4A4A4A;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        border-radius: 10px;
        transition: all 0.2s ease;
    }

    .menu a:hover {
        background: #FFF0EE;
        color: #C55F4E;
    }

    .menu a.active {
        background: #FFE6E3;
        color: #C55F4E;
        font-weight: 700;
    }

    .menu-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        color: currentColor;
    }

    .menu-icon svg {
        width: 18px;
        height: 18px;
    }

    .badge-count {
        margin-left: auto;
        background: #F87171;
        color: white;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
    }

    .sidebar-user {
        margin-top: auto;
        background: #FFE6E3;
        border-radius: 16px;
        padding: 10px 14px;
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .sidebar-user:hover {
        background: #ffd8d3;
    }

    .sidebar-user.active {
        outline: 2px solid #F87171;
    }

    .sidebar-user img {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
        border: 1.5px solid #FFFFFF;
        flex-shrink: 0;
    }

    .user-info {
        flex: 1;
        min-width: 0;
    }

    .user-info .name {
        font-size: 12px;
        font-weight: 700;
        color: #1f1f1f;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .user-info .email {
        font-size: 9.5px;
        color: #718096;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .user-actions {
        color: #A0AEC0;
        display: flex;
        align-items: center;
    }

    @media (max-width: 992px) {
        .sidebar {
            width: 220px;
        }

        .brand h1 {
            font-size: 13px;
        }
    }

    @media (max-width: 768px) {
        .sidebar {
            width: 100%;
            height: auto;
            border-right: none;
            border-bottom: 1.5px solid #FFD6D2;
            position: relative;
        }

        .sidebar-user {
            margin-top: 16px;
        }
    }
</style>

<div class="sidebar">
    <div class="brand">
        <img src="{{ asset('assets/icon-kue.webp') }}" alt="Cake Icon">
        <h1><strong>BIRTHDAY</strong> Reminder</h1>
    </div>

    <div class="menu">
        <a href="{{ route('home') }}" class="{{ Route::currentRouteName() == 'home' ? 'active' : '' }}">
            <span class="menu-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
            </span>
            Dashboard
        </a>
        <a href="{{ route('friends.index') }}"
            class="{{ Route::currentRouteName() == 'friends.index' ? 'active' : '' }}">
            <span class="menu-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                    </path>
                </svg>
            </span>
            Friend
            <span class="badge-count">{{ $totalFriendsCount ?? 0 }}</span>
        </a>
        <a href="notifications" 
            class="{{ Route::currentRouteName() == 'notifications' ? 'active' : '' }}">
            <span class="menu-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                    </path>
                </svg>
            </span>
            Notification
        </a>
        <a href="{{ route('calendar') }}" class="{{ Route::currentRouteName() == 'calendar' ? 'active' : '' }}">
            <span class="menu-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
            </span>
            Calendar
        </a>
    </div>

    <a href="{{ route('profile.show') }}"
        class="sidebar-user {{ Route::currentRouteName() == 'profile.show' ? 'active' : '' }}">

        @php
            if (Auth::check() && Auth::user()->avatar) {
                $userAvatar = asset('storage/' . Auth::user()->avatar);
            } else {
                $userAvatar = asset('images/default-avatar.png');
            }
        @endphp

        <img src="{{ $userAvatar }}" alt="User Avatar">

        <div class="user-info">
            @auth
                <div class="name">{{ Auth::user()->name }}</div>
                <div class="email">{{ Auth::user()->email }}</div>
            @else
                <div class="name">Guest</div>
                <div class="email">-</div>
            @endauth
        </div>

        <div class="user-actions">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="8 9 12 5 16 9"></polyline>
                <polyline points="16 15 12 19 8 15"></polyline>
            </svg>
        </div>
    </a>
</div>
