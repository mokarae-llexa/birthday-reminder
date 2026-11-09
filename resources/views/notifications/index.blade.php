@extends('layouts.app')

@section('content')
    <style>
        .notif-container {
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
            padding: 40px 20px 60px;
            display: flex;
            flex-direction: column;
        }

        .notif-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .search-box {
            position: relative;
            width: 260px;
        }

        .search-box input {
            width: 100%;
            padding: 10px 16px 10px 40px;
            background: var(--white, #fff);
            border: 1px solid var(--border, #F0C9C9);
            border-radius: 20px;
            font-size: 13px;
            color: var(--text, #333333);
            outline: none;
            transition: all .2s ease;
        }

        .search-box input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(232, 143, 155, .22);
        }

        .search-box input::placeholder {
            color: var(--secondary, #5D688A);
            opacity: 0.65;
        }

        .search-box i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 15px;
            color: var(--secondary);
        }

        .notif-list {
            display: flex;
            flex-direction: column;
        }

        .notif-item {
            border-radius: 14px;
            background: var(--white, #fff);
            border: 1px solid var(--border, #F0C9C9);
            padding: 20px 8px;
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            transition: background-color .2s ease;
        }

        .notif-item:hover {
            background: var(--primary-soft);
        }

        .notif-item.is-read {
            border-color: var(--border, #F0C9C9);
            opacity: 0.85;
        }

        .notif-left {
            display: flex;
            align-items: center;
            gap: 16px;
            min-width: 0;
        }

        .notif-avatar {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            object-fit: cover;
            margin: 10px;
            flex-shrink: 0;
            border: 1.5px solid var(--primary);
            background: var(--primary-soft);
        }

        .notif-text h4 {
            font-size: 15px;
            font-weight: 600;
            color: var(--text, #333333);
            margin: 0 0 3px;
        }

        .notif-text p {
            font-size: 14px;
            color: var(--secondary);
            margin: 0;
            font-weight: 500;
        }

        .notif-date {
            display: inline-block;
            margin-top: 4px;
            font-size: 12px;
            font-weight: 500;
            color: var(--primary-dark);
        }

        .notif-actions {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-shrink: 0;
        }

        .btn-wish {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--primary-soft);
            color: var(--primary-dark) !important;
            font-size: 13px;
            font-weight: 700;
            padding: 8px 14px;
            border: 1px solid var(--border);
            border-radius: 8px;
            cursor: pointer;
            transition: all .2s ease;
        }

        .btn-wish:hover {
            background: var(--primary);
            border-color: var(--primary);
            color: var(--white, #FFFFFF) !important;
        }

        .btn-read {
            font-size: 12px;
            color: var(--secondary);
            background: none;
            border: none;
            cursor: pointer;
            text-decoration: underline;
            padding: 8px 6px;
        }

        .btn-read:hover {
            color: var(--primary-dark);
        }

        .quick-send {
            background: var(--white, #fff);
            border: 1px solid var(--border, #F0C9C9);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 20px;
        }

        #quickMessage {
            border: 1px solid var(--border, #F0C9C9);
            border-right: none;
        }

        #quickMessage:focus {
            border-color: var(--primary);
            box-shadow: none;
        }

        .template-chip {
            cursor: pointer;
            font-size: 12px;
            background: var(--primary-soft);
            border: 1.5px solid var(--border);
            color: var(--primary-dark);
            font-weight: 600;
            border-radius: 20px;
            padding: 4px 12px;
            margin: 0 6px 6px 0;
            display: inline-block;
        }

        .template-chip:hover {
            background: var(--primary);
            border-color: var(--primary-dark);
            color: var(--white, #FFFFFF);
        }

        .greet-thread {
            max-height: 180px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .greet-bubble {
            background: var(--white, #fff);
            border: 1px solid var(--border, #F0C9C9);
            border-radius: 12px;
            padding: 8px 12px;
            font-size: 13px;
        }

        .greet-bubble small {
            display: block;
            color: var(--secondary);
            font-size: 11px;
            margin-top: 4px;
        }

        .end-text {
            background: var(--white, #fff);
            border: 1px solid var(--border, #F0C9C9);
            border-radius: 18px;
            text-align: center;
            padding: 32px 24px;
        }

        .end-text h5 {
            color: var(--text, #333333);
            font-weight: 700;
        }

        .end-text p {
            font-size: 13px;
            color: var(--secondary);
        }

        .sticker {
            color: var(--text, #333333);
            paint-order: stroke fill;
            -webkit-text-stroke: .28em #fff;
            text-shadow: 0 0 10px rgba(255, 255, 255, .9);
        }

        .sticker-soft {
            color: var(--primary-dark);
            font-weight: 600;
        }

        .unread-text {
            font-size: 14px;
            font-weight: 600;
            color: var(--primary-dark);
            paint-order: stroke fill;
            -webkit-text-stroke: 4px #fff;
        }

        .btn-modal {
            font-weight: 700;
            font-size: 14px;
            padding: 10px 24px;
            border-radius: 999px;
            cursor: pointer;
            box-shadow: none;
            transition: background .15s ease;
        }

        .btn-modal-sm {
            padding: 6px 18px;
            font-size: 13px;
            border-radius: 0 10px 10px 0;
        }

        .btn-modal-send {
            background: var(--primary);
            color: var(--white, #FFFFFF);
            border: 1px solid var(--primary-dark);
        }

        .btn-modal-send:hover {
            background: var(--primary-dark);
            color: var(--white, #FFFFFF);
        }

        .btn-modal-cancel {
            background: var(--secondary-soft);
            color: var(--secondary-dark);
            border: 1px solid var(--secondary);
        }

        .btn-modal-cancel:hover {
            background: var(--secondary);
            color: var(--white, #FFFFFF);
        }

        #wishModal .modal-content {
            background: var(--background);
            border: 1px solid var(--border, #F0C9C9) !important;
            box-shadow: none !important;
        }

        #wishModal .modal-title {
            font-weight: 700;
            color: var(--text, #333333);
        }

        #wishModal .modal-title svg {
            color: var(--primary) !important;
        }

        #wishModal input[type="radio"] {
            accent-color: var(--primary);
        }

        #wishModal .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(232, 143, 155, .22);
        }

        #wishAvatar {
            border-color: var(--primary) !important;
        }

        .pick {
            position: relative;
        }

        .pick-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            background: var(--white, #fff);
            color: var(--text, #333333);
            font-size: 14px;
            font-weight: 600;
            padding: 6px 12px;
            border: 1px solid var(--border, #F0C9C9);
            border-radius: 12px;
            cursor: pointer;
            transition: border-color .2s ease, box-shadow .2s ease;
        }

        .pick-btn:hover {
            background: var(--primary-soft);
        }

        .pick.open .pick-btn {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(232, 143, 155, .22);
        }

        .pick-btn svg {
            color: var(--secondary);
            transition: transform .2s ease;
            flex-shrink: 0;
        }

        .pick.open .pick-btn svg {
            transform: rotate(180deg);
        }

        .pick-placeholder {
            color: var(--secondary);
            opacity: 0.7;
            font-weight: 500;
        }

        .pick-panel {
            display: none;
            position: absolute;
            top: calc(100% + 6px);
            left: 0;
            right: 0;
            z-index: 50;
            background: var(--white, #fff);
            border: 1px solid var(--border, #F0C9C9);
            border-radius: 14px;
            overflow: hidden;
        }

        .pick.open .pick-panel {
            display: block;
        }

        .pick-list {
            margin: 0;
            padding: 6px;
            list-style: none;
            max-height: 220px;
            overflow-y: auto;
        }

        .pick-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 10px;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 500;
            color: var(--text, #333333);
            cursor: pointer;
        }

        .pick-item:hover {
            background: var(--primary-soft);
        }

        .pick-item.active {
            background: var(--primary-soft);
            color: var(--primary-dark);
            font-weight: 700;
        }

        .pick-name {
            flex: 1;
        }

        .pick-check {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
            border: 2px solid var(--border, #F0C9C9);
            border-radius: 5px;
            background: var(--white, #fff);
        }

        .pick-item.active .pick-check {
            background: var(--primary) url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='white' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round' d='m3.5 8.5 3 3 6-6.5'/%3e%3c/svg%3e") center/12px no-repeat;
            border-color: var(--primary);
        }

        .pick-tag {
            font-size: 12px;
            font-weight: 500;
            color: var(--primary-dark);
        }

        .pick-foot {
            display: flex;
            justify-content: flex-end;
            padding: 8px 10px;
            border-top: 1px solid var(--background);
        }

        .pick-clear {
            background: var(--secondary-soft);
            color: var(--secondary-dark);
            font-size: 12px;
            font-weight: 700;
            border: 1px solid var(--secondary);
            border-radius: 999px;
            padding: 5px 14px;
            cursor: pointer;
        }

        .pick-clear:hover {
            background: var(--secondary);
            color: var(--white, #FFFFFF);
        }
    </style>

    <div class="notif-container">
        <div class="notif-toolbar">
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <span class="sticker sticker-soft"><span id="unreadCount">{{ $unreadCount }}</span> belum dibaca</span>
                @if (($unreadGreetings ?? 0) > 0)
                    <a href="{{ route('greetings.inbox') }}" class="unread-text" style="text-decoration:none">
                        💌 {{ $unreadGreetings }} ucapan baru
                    </a>
                @endif
            </div>
            <div class="d-flex align-items-center gap-2">
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" id="notifSearch" placeholder="Search Friend...">
                </div>
                <form action="{{ route('notifications.read-all') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-chip rounded-pill">Tandai semua dibaca</button>
                </form>
            </div>
        </div>

        <div class="quick-send">
            <h6 class="fw-bold mb-2">Kirim ucapan</h6>
            <div class="row g-2">
                <div class="col-md-4">
                    <div class="pick" id="pick">
                        <input type="hidden" id="quickFriend" value="">
                        <button type="button" class="pick-btn" id="pickBtn" aria-haspopup="listbox"
                            aria-expanded="false">
                            <span id="pickLabel" class="pick-placeholder">Pilih teman</span>
                            <svg width="14" height="14" viewBox="0 0 16 16" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m2 5 6 6 6-6" />
                            </svg>
                        </button>

                        <div class="pick-panel">
                            <ul class="pick-list" id="pickList" role="listbox">
                                @foreach ($upcomingFriends as $item)
                                    <li class="pick-item" role="option" data-value="{{ $item['friend']->id }}"
                                        data-name="{{ $item['friend']->name }}">
                                        <span class="pick-check"></span>
                                        <span class="pick-name">{{ $item['friend']->name }}</span>
                                        <span
                                            class="pick-tag">{{ $item['days_until'] === 0 ? 'hari ini' : 'H-' . $item['days_until'] }}</span>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="pick-foot">
                                <button type="button" class="pick-clear" id="pickClear">Hapus pilihan</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="input-group input-group-sm">
                        <input type="text" id="quickMessage" class="form-control rounded-start-3"
                            placeholder="Tulis ucapan... 🎂" maxlength="1000">
                        <button type="button" id="quickSendBtn"
                            class="btn-modal btn-modal-send btn-modal-sm">Kirim</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="notif-list" id="notifList">
            @forelse($notifications as $notif)
                <div class="notif-item anim-up {{ $notif->read_at ? 'is-read' : '' }}"
                    style="animation-delay: {{ min($loop->index, 10) * 0.06 }}s" data-id="{{ $notif->id }}"
                    data-search="{{ strtolower($notif->title . ' ' . $notif->message . ' ' . $notif->friend->name) }}">
                    <div class="notif-left">
                        <img class="notif-avatar" src="{{ $notif->friend->avatar_url }}" alt="{{ $notif->friend->name }}">
                        <div class="notif-text">
                            <h4>{{ $notif->title }}</h4>
                            <p>{{ $notif->message }}</p>
                            <span
                                class="notif-date">{{ $notif->notify_date->locale('id')->isoFormat('dddd, D MMM Y') }}</span>
                        </div>
                    </div>
                    <div class="notif-actions">
                        <button type="button" class="btn-wish" data-action="wish"
                            data-friend-id="{{ $notif->friend->id }}" data-friend-name="{{ $notif->friend->name }}"
                            data-friend-avatar="{{ $notif->friend->avatar_url }}"
                            data-friend-phone="{{ $notif->friend->phone }}"
                            data-friend-email="{{ $notif->friend->email }}">
                            <span>Send Wishes</span>
                            <i class="bi bi-arrow-right"></i>
                        </button>
                        @if (!$notif->read_at)
                            <button type="button" class="btn-read" data-action="read"
                                data-id="{{ $notif->id }}">Tandai
                                dibaca</button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="end-text" id="notifEmpty">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
                        style="display:block;margin:0 auto 12px;color:var(--primary, #E88F9B)">
                        <path d="M6 9a6 6 0 0112 0c0 6 2.5 7.5 2.5 7.5h-17S6 15 6 9M10 20a2 2 0 004 0" />
                    </svg>
                    <h5>Belum ada notifikasi</h5>
                    <p>Tambahkan teman beserta tanggal lahirnya untuk mulai menerima pengingat.</p>
                </div>
            @endforelse
        </div>
    </div>

    <div class="modal fade" id="wishModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold d-flex align-items-center gap-2">
                        Kirim Ucapan
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
                            style="color:var(--primary, #E88F9B)">
                            <path d="M12 2.6c.8.7 1 1.4.5 2a1 1 0 01-1.7-.1c-.2-.6 0-1.2 1.2-1.9z" fill="currentColor"
                                stroke-width="1" />
                            <path d="M12 7v3.5" />
                            <rect x="4" y="10.5" width="16" height="9" rx="2" />
                            <path d="M4 14.5c1.3 1.4 2.7 1.4 4 0s2.7-1.4 4 0 2.7 1.4 4 0 2.7-1.4 4 0" />
                            <path d="M2.5 21.5h19" />
                        </svg>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <img id="wishAvatar" src="" alt="Avatar" class="rounded-circle"
                            style="width:52px;height:52px;object-fit:cover;border:2px solid var(--primary, #E88F9B);">
                        <div>
                            <div id="wishName" class="fw-bold"></div>
                            <small class="text-muted" id="wishContact"></small>
                        </div>
                    </div>

                    <div class="mb-2">
                        <span class="template-chip"
                            data-template="Selamat ulang tahun! 🎂 Semoga panjang umur, sehat selalu, dan semua impianmu tercapai!">🎂
                            Formal</span>
                        <span class="template-chip"
                            data-template="HBD! 🥳 Traktirannya jangan lupa ya! Semoga makin sukses dan bahagia selalu!">🥳
                            Santai</span>
                        <span class="template-chip"
                            data-template="Happy birthday! 🎉 Wishing you a wonderful year ahead!">🌍 English</span>
                    </div>

                    <textarea id="wishMessage" class="form-control rounded-3" rows="3" maxlength="1000"
                        placeholder="Tulis ucapanmu di sini..."></textarea>

                    <div class="d-flex gap-3 mt-2 mb-3">
                        <label class="small"><input type="radio" name="wishChannel" value="inapp" checked> Save
                            in
                            App</label>
                        <label class="small"><input type="radio" name="wishChannel" value="whatsapp"> Via
                            WhatsApp</label>
                        <label class="small"><input type="radio" name="wishChannel" value="email"> Via
                            Email</label>
                    </div>

                    <h6 class="fw-bold small text-muted">Riwayat ucapan</h6>
                    <div class="greet-thread" id="wishThread">
                        <p class="text-muted small mb-0">Belum ada ucapan untuk teman ini.</p>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-modal btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn-modal btn-modal-send" id="wishSendBtn">Kirim Ucapan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const feedUrl = @json(route('api.notifications.feed'));
            const notifList = document.getElementById('notifList');
            const notifSearch = document.getElementById('notifSearch');
            const unreadEl = document.getElementById('unreadCount');
            const badge = document.getElementById('notifBadge');
            let lastUnread = parseInt(unreadEl ? unreadEl.textContent : '0', 10) || 0;
            let knownIds = new Set(Array.from(notifList.querySelectorAll('.notif-item')).map(el => el.dataset.id));

            function escapeHtml(s) {
                return String(s == null ? '' : s)
                    .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;').replace(/'/g, '&#039;');
            }

            function updateBadge(count) {
                if (unreadEl) unreadEl.textContent = count;
                if (badge) {
                    badge.textContent = count;
                    badge.style.display = count > 0 ? '' : 'none';
                }
                lastUnread = count;
            }

            function cardHtml(n) {
                const readCls = n.read_at ? ' is-read' : '';
                const readBtn = n.read_at ? '' :
                    '<button type="button" class="btn-read" data-action="read" data-id="' + n.id +
                    '">Tandai dibaca</button>';
                return '<div class="notif-item' + readCls + '" data-id="' + n.id + '" data-search="' + escapeHtml((n
                        .title + ' ' + n.message + ' ' + n.friend.name).toLowerCase()) + '">' +
                    '<div class="notif-left">' +
                    '<img class="notif-avatar" src="' + escapeHtml(n.friend.avatar_url) + '" alt="' + escapeHtml(n
                        .friend.name) + '">' +
                    '<div class="notif-text"><h4>' + escapeHtml(n.title) + '</h4><p>' + escapeHtml(n.message) +
                    '</p>' +
                    '<span class="notif-date">' + escapeHtml(n.notify_date) + '</span></div></div>' +
                    '<div class="notif-actions">' +
                    '<button type="button" class="btn-wish" data-action="wish"' +
                    ' data-friend-id="' + n.friend.id + '"' +
                    ' data-friend-name="' + escapeHtml(n.friend.name) + '"' +
                    ' data-friend-avatar="' + escapeHtml(n.friend.avatar_url) + '"' +
                    ' data-friend-phone="' + escapeHtml(n.friend.phone || '') + '"' +
                    ' data-friend-email="' + escapeHtml(n.friend.email || '') + '">' +
                    '<span>Send Wishes</span><i class="bi bi-arrow-right"></i></button>' +
                    readBtn + '</div></div>';
            }

            function applySearch() {
                const q = (notifSearch.value || '').toLowerCase();
                notifList.querySelectorAll('.notif-item').forEach(el => {
                    el.style.display = (!q || (el.dataset.search || '').includes(q)) ? '' : 'none';
                });
            }

            if (notifSearch) notifSearch.addEventListener('input', applySearch);

            async function pollFeed() {
                try {
                    const res = await fetch(feedUrl, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    });
                    if (!res.ok) return;
                    const data = await res.json();
                    updateBadge(data.unread_count || 0);

                    const freshIds = new Set(data.notifications.map(n => String(n.id)));
                    const newOnes = data.notifications.filter(n => !knownIds.has(String(n.id)) && n.type ===
                        'today');
                    if (newOnes.length > 0 && window.showToast) {
                        const first = newOnes[0];
                        window.showToast({
                            type: 'success',
                            title: 'Ulang tahun hari ini! 🎂',
                            message: first.title + (newOnes.length > 1 ? ' (+' + (newOnes.length - 1) +
                                ' lainnya)' : '')
                        });
                    }
                    knownIds = freshIds;

                    const empty = document.getElementById('notifEmpty');
                    if (empty) empty.remove();
                    notifList.innerHTML = data.notifications.length ?
                        data.notifications.map(cardHtml).join('') :
                        '<div class="end-text"><h5>Belum ada notifikasi 🎈</h5><p>Tambahkan teman beserta tanggal lahirnya.</p></div>';
                    applySearch();
                } catch (e) {

                }
            }

            setInterval(pollFeed, 30000);

            notifList.addEventListener('click', function(e) {
                const wishBtn = e.target.closest('[data-action="wish"]');
                if (wishBtn) {
                    openWishModal({
                        id: wishBtn.dataset.friendId,
                        name: wishBtn.dataset.friendName,
                        avatar: wishBtn.dataset.friendAvatar,
                        phone: wishBtn.dataset.friendPhone,
                        email: wishBtn.dataset.friendEmail
                    });
                    return;
                }
                const readBtn = e.target.closest('[data-action="read"]');
                if (readBtn) {
                    fetch(@json(route('notifications.read-all')).replace('read-all', '') + readBtn.dataset.id +
                        '/read', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrf
                            }
                        }).then(res => res.json()).then(() => {
                        const card = notifList.querySelector('.notif-item[data-id="' + readBtn
                            .dataset.id + '"]');
                        if (card) {
                            card.classList.add('is-read');
                            readBtn.remove();
                        }
                        pollBadgeOnly();
                    });
                }
            });

            function pollBadgeOnly() {
                fetch(feedUrl, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => updateBadge(data.unread_count || 0))
                    .catch(() => {});
            }

            let wishModal = null;
            let currentFriendId = null;
            const wishModalEl = document.getElementById('wishModal');
            if (typeof bootstrap !== 'undefined' && wishModalEl) {
                wishModal = new bootstrap.Modal(wishModalEl);
            }

            function openWishModal(f) {
                currentFriendId = f.id;
                document.getElementById('wishAvatar').src = f.avatar || '';
                document.getElementById('wishName').textContent = f.name || '';
                document.getElementById('wishContact').textContent = [f.phone, f.email].filter(Boolean).join(' · ');
                document.getElementById('wishMessage').value = '';
                loadThread(f.id);
                if (wishModal) wishModal.show();
            }

            function threadHtml(g) {
                return '<div class="greet-bubble">' + escapeHtml(g.message) +
                    '<small>' + escapeHtml(g.sender || '') + ' · ' + escapeHtml(g.channel) + ' · ' + escapeHtml(g
                        .created_at || '') + '</small></div>';
            }

            function loadThread(friendId) {
                const thread = document.getElementById('wishThread');
                fetch('/friends/' + friendId + '/greetings', {
                        headers: {
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        thread.innerHTML = data.greetings.length ?
                            data.greetings.map(threadHtml).join('') :
                            '<p class="text-muted small mb-0">Belum ada ucapan untuk teman ini.</p>';
                    })
                    .catch(() => {});
            }

            document.querySelectorAll('.template-chip').forEach(chip => {
                chip.addEventListener('click', function() {
                    document.getElementById('wishMessage').value = this.dataset.template;
                });
            });

            function sendGreeting(friendId, message, channel) {
                return fetch('/friends/' + friendId + '/greetings', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf
                    },
                    body: JSON.stringify({
                        message: message,
                        channel: channel
                    })
                }).then(async res => {
                    const data = await res.json();
                    if (!res.ok) throw data;
                    return data;
                });
            }

            document.getElementById('wishSendBtn').addEventListener('click', function() {
                const message = document.getElementById('wishMessage').value.trim();
                const channel = (document.querySelector('input[name="wishChannel"]:checked') || {}).value ||
                    'inapp';
                if (!message) {
                    if (window.showToast) window.showToast({
                        type: 'error',
                        title: 'Belum ada pesan',
                        message: 'Tulis ucapan dulu ya.'
                    });
                    return;
                }
                sendGreeting(currentFriendId, message, channel).then(data => {
                    if (window.showToast) window.showToast({
                        type: 'success',
                        title: 'Terkirim! 🎉',
                        message: 'Ucapanmu untuk ' + document.getElementById('wishName')
                            .textContent + ' tersimpan.'
                    });
                    loadThread(currentFriendId);
                    document.getElementById('wishMessage').value = '';
                    if (data.whatsapp_url) window.open(data.whatsapp_url, '_blank');
                    if (data.mailto_url) window.location.href = data.mailto_url;
                }).catch(err => {
                    const msg = (err && err.errors) ? Object.values(err.errors).flat().join(' ') :
                        'Gagal mengirim ucapan.';
                    if (window.showToast) window.showToast({
                        type: 'error',
                        title: 'Gagal',
                        message: msg
                    });
                });
            });
            const pick = document.getElementById('pick');
            const pickBtn = document.getElementById('pickBtn');
            const pickLabel = document.getElementById('pickLabel');
            const quickFriend = document.getElementById('quickFriend');

            function setPick(value, name) {
                quickFriend.value = value;
                pickLabel.textContent = name || 'Pilih teman';
                pickLabel.classList.toggle('pick-placeholder', !value);
                document.querySelectorAll('.pick-item').forEach(i =>
                    i.classList.toggle('active', value && i.dataset.value === value));
            }

            pickBtn.addEventListener('click', () => {
                const open = pick.classList.toggle('open');
                pickBtn.setAttribute('aria-expanded', open);
            });

            document.getElementById('pickList').addEventListener('click', e => {
                const item = e.target.closest('.pick-item');
                if (!item) return;
                setPick(item.dataset.value, item.dataset.name);
                pick.classList.remove('open');
            });

            document.getElementById('pickClear').addEventListener('click', () => {
                setPick('', '');
                pick.classList.remove('open');
            });

            document.addEventListener('click', e => {
                if (!pick.contains(e.target)) pick.classList.remove('open');
            });

            document.getElementById('quickSendBtn').addEventListener('click', function() {
                const friendId = document.getElementById('quickFriend').value;
                const message = document.getElementById('quickMessage').value.trim();
                if (!friendId || !message) {
                    if (window.showToast) window.showToast({
                        type: 'error',
                        title: 'Belum lengkap',
                        message: 'Pilih teman dan tulis ucapan dulu.'
                    });
                    return;
                }
                sendGreeting(friendId, message, 'inapp').then(() => {
                    if (window.showToast) window.showToast({
                        type: 'success',
                        title: 'Terkirim! 🎉',
                        message: 'Ucapan cepatmu tersimpan.'
                    });
                    document.getElementById('quickMessage').value = '';
                    pollFeed();
                }).catch(() => {
                    if (window.showToast) window.showToast({
                        type: 'error',
                        title: 'Gagal',
                        message: 'Gagal mengirim ucapan cepat.'
                    });
                });
            });
        });
    </script>
@endpush
