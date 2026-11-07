<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,800&display=swap">
<style>
    .sidebar {
        width: 260px;
        height: 100vh;
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        align-self: flex-start;
        padding: 24px 16px;
        display: flex;
        flex-direction: column;
        flex-shrink: 0;
        background: #FFFFFF;
        border-right: 1px solid #F0C9C9;
        z-index: 1000;
        transition: width 0.3s ease, padding 0.3s ease, transform 0.3s ease, margin-left 0.3s ease;
    }


    @media (max-width: 768px) {
        .sidebar.closed {
            transform: translateX(-100%);
        }
    }

    .main-content {
        flex: 1;
        min-width: 0;
        padding: 30px;
        margin-left: 260px;
        transition: margin-left 0.3s ease;
    }

    .sidebar.closed~.main-content {
        margin-left: 0;
    }

    @media (min-width: 769px) {
        .sidebar.closed {
            width: 76px;
            padding: 24px 12px;
            transform: none;
            margin-left: 0;
        }

        .sidebar.closed~.main-content {
            margin-left: 76px;
        }

        .sidebar.closed .brand {
            justify-content: center;
            padding-left: 0;
        }

        .sidebar.closed .brand h1,
        .sidebar.closed .menu-label,
        .sidebar.closed .user-info,
        .sidebar.closed .user-actions {
            max-width: 0;
            opacity: 0;
        }

        .sidebar.closed .brand,
        .sidebar.closed .menu a,
        .sidebar.closed .sidebar-user {
            gap: 0;
        }

        .sidebar.closed .sidebar-animation {
            display: none;
        }

        .sidebar.closed .menu-icon svg {
            width: 20px;
            height: 20px;
        }

        .sidebar.closed .menu a {
            justify-content: center;
            padding: 12px 0;
            position: relative;
        }

        .sidebar.closed .badge-count {
            position: absolute;
            top: 2px;
            right: 8px;
            margin: 0;
            padding: 1px 6px;
            font-size: 10px;
            line-height: 1.3;
        }

        .sidebar.closed .sidebar-user {
            justify-content: center;
            padding: 10px 0;
        }

        .sidebar.closed .sidebar-cake-mini {
            animation: cakeIn 0.35s ease 0.15s backwards;
            display: flex;
            justify-content: center;
            margin-top: auto;
            margin-bottom: 14px;
        }
    }

    .brand {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 32px;
        padding-left: 4px;
        transition: gap 0.3s ease, padding 0.3s ease;
    }

    .brand img {
        width: 44px;
        height: 44px;
        object-fit: contain;
    }


    .brand h1 {
        margin: 0;
        font-family: 'Fraunces', Georgia, serif;
        color: var(--primary, #5D688A);
        font-size: 18px;
        font-weight: 800;
        white-space: nowrap;
        letter-spacing: -0.4px;
    }

    .brand h1 span {
        color: var(--secondary, #F7A5A5);
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
        color: var(--primary);
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        border-radius: 10px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .menu a:hover {
        background: var(--background);
        color: #3F4766;
    }

    .menu a.active {
        background: var(--background);
        color: #3F4766;
        font-weight: 700;
    }

    .menu-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        color: currentColor;
        flex-shrink: 0;
    }

    .menu-icon svg {
        width: 18px;
        height: 18px;
    }

    .badge-count {
        margin-left: auto;
        background: #E27D7D;
        color: white;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
    }

    .sidebar-user {
        margin-top: auto;
        background: var(--background);
        border: 1px solid #F0C9C9;
        border-radius: 16px;
        padding: 10px 14px;
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .sidebar-user:hover {
        background: #fff;
        border-color: var(--secondary);
    }

    .brand h1,
    .menu-label,
    .user-info,
    .user-actions {
        overflow: hidden;
        transition: opacity 0.2s ease, max-width 0.3s ease;
    }

    .brand h1 {
        max-width: 200px;
    }

    .menu-label {
        max-width: 160px;
        white-space: nowrap;
    }

    .user-info {
        max-width: 160px;
    }

    .user-actions {
        max-width: 24px;
    }


    .sidebar-animation {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        margin-top: auto;
        margin-bottom: 10px;
    }

    @keyframes cakeIn {
        from {
            opacity: 0;
            transform: translateY(6px);
        }

        to {
            opacity: 1;
            transform: none;
        }
    }


    .sidebar-cake-mini {
        display: none;
    }

    #sidebar-birthday-animation {
        width: 100%;
        max-width: 228px;
        height: 260px;
        transform: scale(1.5);
        transform-origin: center bottom;
        pointer-events: none;
    }

    .sidebar-user {
        margin-top: 0;
    }

    .sidebar-user img {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        border: 1px solid var(--secondary);
        flex-shrink: 0;
    }

    .user-info {
        flex: 1;
        min-width: 0;
    }

    .user-info .name {
        font-size: 12px;
        font-weight: 700;
        color: #3F4766;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .user-info .email {
        font-size: 9.5px;
        color: var(--primary);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .user-actions {
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    @media (max-width: 992px) {
        .sidebar {
            background: #FFFFFF;
            border-right: 1px solid #F0C9C9;
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
            border-bottom: 1px solid #F0C9C9;
            position: relative;
        }

        .sidebar-user {
            margin-top: 16px;
        }
    }

    .sidebar-backdrop {
        display: none;
    }

    @media (max-width: 768px) {
        .sidebar-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.35);
            z-index: 998;
        }

        .sidebar-backdrop.show {
            display: block;
        }

        .sidebar-toggle.sidebar-open {
            left: 280px;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 260px;
            height: 100vh;
            z-index: 999;
        }

        .sidebar-toggle.sidebar-open {
            left: 280px;
        }

    }
</style>
<div class="sidebar">
    <div class="brand">
        <img src="{{ asset('assets/icon-kue.webp') }}" alt="Cake Icon">
        <h1><span>Birthday</span> Reminder</h1>
    </div>

    <div class="menu">
        <a href="{{ route('home') }}" class="{{ Route::currentRouteName() == 'home' ? 'active' : '' }}" title="Dashboard">
            <span class="menu-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
            </span>
            <span class="menu-label">Dashboard</span>
        </a>
        <a href="{{ route('friends.index') }}"
            class="{{ Route::currentRouteName() == 'friends.index' ? 'active' : '' }}" title="Friend">
            <span class="menu-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                    </path>
                </svg>
            </span>
            <span class="menu-label">Friend</span>
            <span class="badge-count">{{ $totalFriendsCount ?? 0 }}</span>
        </a>
        <a href="{{ route('friends.requests') }}"
            class="{{ Route::currentRouteName() == 'friends.requests' ? 'active' : '' }}" title="Requests">
            <span class="menu-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                    </path>
                </svg>
            </span>
            <span class="menu-label">Requests</span>
            @if (($pendingFriendRequestsCount ?? 0) > 0)
                <span class="badge-count">{{ $pendingFriendRequestsCount }}</span>
            @endif
        </a>
        <a href="{{ Route::has('notifications.index') ? route('notifications.index') : '#' }}"
            class="{{ Route::currentRouteName() == 'notifications.index' ? 'active' : '' }}" title="Notification">
            <span class="menu-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                    </path>
                </svg>
            </span>
            <span class="menu-label">Notification</span>
            <span class="badge-count" id="notifBadge"
                style="{{ ($unreadNotificationsCount ?? 0) > 0 ? '' : 'display:none;' }}">{{ $unreadNotificationsCount ?? 0 }}</span>
        </a>
        <a href="{{ route('calendar') }}" class="{{ Route::currentRouteName() == 'calendar' ? 'active' : '' }}"
            title="Calendar">
            <span class="menu-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
            </span>
            <span class="menu-label">Calendar</span>
        </a>
    </div>
    <div class="sidebar-animation">
        <div id="sidebar-birthday-animation"></div>
    </div>
    <div class="sidebar-cake-mini" aria-hidden="true">
        <svg width="44" height="44" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="10" y="34" width="44" height="20" rx="5" fill="#F7A5A5" />
            <path d="M10 40c4 5 8 5 11 0s7 5 11 0 7 5 11 0 7 5 11 0v-3a5 5 0 00-5-5H15a5 5 0 00-5 5z" fill="#FFF2EF" />
            <rect x="18" y="20" width="28" height="14" rx="4" fill="#FFDBB6" />
            <path d="M32 8v12" stroke="#5D688A" stroke-width="3" stroke-linecap="round" />
            <path d="M32 2c3 3 3 5 0 6-3-1-3-3 0-6z" fill="#F7A5A5" />
            <rect x="6" y="54" width="52" height="4" rx="2" fill="#EEE6E6" />
        </svg>
    </div>
    <a href="{{ route('profile.edit') }}" class="sidebar-user text-decoration-none" title="Profile"
        style="cursor: pointer;">
        @if (Auth::check())
            <img src="{{ Auth::user()->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}"
                alt="{{ Auth::user()->name }}">
        @endif
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
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 18l6-6-6-6"></path>
            </svg>
        </div>
    </a>
</div>
