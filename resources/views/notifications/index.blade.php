@extends('layouts.app')

@section('content')
<style>
    .notif-container {
        width: 100%;
        max-width: 900px;
        margin: 0 auto;
        padding: 40px 20px 60px 20px;
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

    .live-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        font-weight: 600;
        color: #0E8A70;
        background: #D9F5EC;
        border-radius: 20px;
        padding: 6px 12px;
    }

    .live-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #0E8A70;
        animation: livePulse 1.6s ease-in-out infinite;
    }

    @keyframes livePulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.4; transform: scale(0.75); }
    }

    .search-box {
        position: relative;
        width: 260px;
    }

    .search-box input {
        width: 100%;
        padding: 10px 16px 10px 40px;
        background-color: #FFFFFF;
        border: 1px solid #E8E8E8;
        border-radius: 20px;
        font-size: 13px;
        color: #333333;
        outline: none;
        transition: all 0.2s ease;
    }
    .search-box input:focus {
        border-color: #FFB6C1;
        box-shadow: 0 0 0 3px rgba(255, 182, 193, 0.2);
    }

    .search-box input::placeholder {
        color: #A0A0A0;
    }

    .search-box i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 15px;
        color: #888888;
    }

    .notif-list {
        display: flex;
        flex-direction: column;
    }

    .notif-item {
        border-radius: 12px;
        background-color: #F9F6C4;
        border: 4px solid #FFB6C1;
        padding: 20px 8px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        transition: background-color 0.2s ease;
    }

    .notif-item:hover {
        background-color: rgba(255, 255, 255, 0.5);
    }

    .notif-item.is-read {
        opacity: 0.72;
        background-color: #FFFFFF;
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
        border: 1px solid #FFB6C1;
        background-color: #FFEAEB;
    }

    .notif-text h4 {
        font-size: 15px;
        font-weight: 600;
        color: #222222;
        margin: 0 0 3px 0;
    }

    .notif-text p {
        font-size: 14px;
        color: #666666;
        margin: 0;
        font-weight: 500;
    }

    .notif-date {
        display: inline-block;
        font-size: 11px;
        font-weight: 700;
        color: #C55F4E;
        background: #FFE6E3;
        border-radius: 12px;
        padding: 2px 10px;
        margin-top: 6px;
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
        background-color: transparent;
        color: #BB8760 !important;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        padding: 8px 14px;
        border: none;
        border-radius: 8px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-wish:hover {
        background-color: #FFF2EB;
        color: #9A6843 !important;
    }

    .btn-read {
        font-size: 12px;
        color: #888;
        background: none;
        border: none;
        cursor: pointer;
        text-decoration: underline;
        padding: 8px 6px;
    }

    .btn-read:hover {
        color: #333;
    }

    .quick-send {
        background: #FFFFFF;
        border: 1.5px solid #FFD6D2;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .template-chip {
        cursor: pointer;
        font-size: 12px;
        background: #FFF2EB;
        border: 1px solid #FFD6D2;
        border-radius: 20px;
        padding: 4px 12px;
        margin: 0 6px 6px 0;
        display: inline-block;
    }

    .template-chip:hover {
        background: #FFE6E3;
    }

    .greet-thread {
        max-height: 180px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .greet-bubble {
        background: #FFF7F6;
        border: 1px solid #FFE6E3;
        border-radius: 12px;
        padding: 8px 12px;
        font-size: 13px;
    }

    .greet-bubble small {
        display: block;
        color: #A0707A;
        font-size: 11px;
        margin-top: 4px;
    }

    .end-text {
        text-align: center;
        margin-top: 40px;
        padding: 20px;
    }

    .end-text h5 {
        font-size: 13px;
        font-weight: 600;
        color: #888888;
        margin: 0 0 4px 0;
    }

    .end-text p {
        font-size: 12px;
        color: #B0B0B0;
        margin: 0;
    }
</style>

<div class="notif-container">
    <div class="notif-toolbar">
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <span class="text-muted small"><span id="unreadCount">{{ $unreadCount }}</span> belum dibaca</span>
        </div>
        <div class="d-flex align-items-center gap-2">
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" id="notifSearch" placeholder="Search Friend...">
            </div>
            <form action="{{ route('notifications.read-all') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-secondary rounded-pill">Tandai semua dibaca</button>
            </form>
        </div>
    </div>

    <div class="quick-send">
        <h6 class="fw-bold mb-2">Kirim ucapan</h6>
        <div class="row g-2">
            <div class="col-md-4">
                <select id="quickFriend" class="form-select form-select-sm rounded-3">
                    <option value="">— Pilih teman —</option>
                    @foreach($upcomingFriends as $item)
                        <option value="{{ $item['friend']->id }}">{{ $item['friend']->name }} ({{ $item['days_until'] === 0 ? 'hari ini' : 'H-'.$item['days_until'] }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-8">
                <div class="input-group input-group-sm">
                    <input type="text" id="quickMessage" class="form-control rounded-start-3" placeholder="Tulis ucapan... 🎂" maxlength="1000">
                    <button type="button" id="quickSendBtn" class="btn btn-sm px-3 text-white" style="background-color:#C55F4E;">Kirim</button>
                </div>
            </div>
        </div>
    </div>

    <div class="notif-list" id="notifList">
        @forelse($notifications as $notif)
            <div class="notif-item {{ $notif->read_at ? 'is-read' : '' }}" data-id="{{ $notif->id }}" data-search="{{ strtolower($notif->title.' '.$notif->message.' '.$notif->friend->name) }}">
                <div class="notif-left">
                    <img class="notif-avatar" src="{{ $notif->friend->avatar_url }}" alt="{{ $notif->friend->name }}">
                    <div class="notif-text">
                        <h4>{{ $notif->title }}</h4>
                        <p>{{ $notif->message }}</p>
                        <span class="notif-date">{{ $notif->notify_date->locale('id')->isoFormat('dddd, D MMM Y') }}</span>
                    </div>
                </div>
                <div class="notif-actions">
                    <button type="button" class="btn-wish" data-action="wish"
                        data-friend-id="{{ $notif->friend->id }}"
                        data-friend-name="{{ $notif->friend->name }}"
                        data-friend-avatar="{{ $notif->friend->avatar_url }}"
                        data-friend-phone="{{ $notif->friend->phone }}"
                        data-friend-email="{{ $notif->friend->email }}">
                        <span>Send Wishes</span>
                        <i class="bi bi-arrow-right"></i>
                    </button>
                    @if(!$notif->read_at)
                        <button type="button" class="btn-read" data-action="read" data-id="{{ $notif->id }}">Tandai dibaca</button>
                    @endif
                </div>
            </div>
        @empty
            <div class="end-text" id="notifEmpty">
                <h5>Belum ada notifikasi 🎈</h5>
                <p>Tambahkan teman beserta tanggal lahirnya untuk mulai menerima pengingat.</p>
            </div>
        @endforelse
    </div>
</div>

<div class="modal fade" id="wishModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Kirim Ucapan 🎂</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <img id="wishAvatar" src="" alt="Avatar" class="rounded-circle" style="width:52px;height:52px;object-fit:cover;border:2px solid #FFE6E3;">
                    <div>
                        <div id="wishName" class="fw-bold"></div>
                        <small class="text-muted" id="wishContact"></small>
                    </div>
                </div>

                <div class="mb-2">
                    <span class="template-chip" data-template="Selamat ulang tahun! 🎂 Semoga panjang umur, sehat selalu, dan semua impianmu tercapai!">🎂 Formal</span>
                    <span class="template-chip" data-template="HBD! 🥳 Traktirannya jangan lupa ya! Semoga makin sukses dan bahagia selalu!">🥳 Santai</span>
                    <span class="template-chip" data-template="Barakallah fii umrik! Semoga berkah usianya dan dilancarkan rezekinya. 🤲">🤲 Islami</span>
                </div>

                <textarea id="wishMessage" class="form-control rounded-3" rows="3" maxlength="1000" placeholder="Tulis ucapanmu di sini..."></textarea>

                <div class="d-flex gap-3 mt-2 mb-3">
                    <label class="small"><input type="radio" name="wishChannel" value="inapp" checked> Save in App</label>
                    <label class="small"><input type="radio" name="wishChannel" value="whatsapp"> Via WhatsApp</label>
                    <label class="small"><input type="radio" name="wishChannel" value="email"> Via Email</label>
                </div>

                <h6 class="fw-bold small text-muted">Riwayat ucapan</h6>
                <div class="greet-thread" id="wishThread">
                    <p class="text-muted small mb-0">Belum ada ucapan untuk teman ini.</p>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn rounded-pill px-4 text-white" id="wishSendBtn" style="background-color:#C55F4E;">Kirim Ucapan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
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
        const readBtn = n.read_at ? '' : '<button type="button" class="btn-read" data-action="read" data-id="' + n.id + '">Tandai dibaca</button>';
        return '<div class="notif-item' + readCls + '" data-id="' + n.id + '" data-search="' + escapeHtml((n.title + ' ' + n.message + ' ' + n.friend.name).toLowerCase()) + '">'
            + '<div class="notif-left">'
            + '<img class="notif-avatar" src="' + escapeHtml(n.friend.avatar_url) + '" alt="' + escapeHtml(n.friend.name) + '">'
            + '<div class="notif-text"><h4>' + escapeHtml(n.title) + '</h4><p>' + escapeHtml(n.message) + '</p>'
            + '<span class="notif-date">' + escapeHtml(n.notify_date) + '</span></div></div>'
            + '<div class="notif-actions">'
            + '<button type="button" class="btn-wish" data-action="wish"'
            + ' data-friend-id="' + n.friend.id + '"'
            + ' data-friend-name="' + escapeHtml(n.friend.name) + '"'
            + ' data-friend-avatar="' + escapeHtml(n.friend.avatar_url) + '"'
            + ' data-friend-phone="' + escapeHtml(n.friend.phone || '') + '"'
            + ' data-friend-email="' + escapeHtml(n.friend.email || '') + '">'
            + '<span>Send Wishes</span><i class="bi bi-arrow-right"></i></button>'
            + readBtn + '</div></div>';
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
            const res = await fetch(feedUrl, { headers: { 'Accept': 'application/json' } });
            if (!res.ok) return;
            const data = await res.json();
            updateBadge(data.unread_count || 0);

            const freshIds = new Set(data.notifications.map(n => String(n.id)));
            const newOnes = data.notifications.filter(n => !knownIds.has(String(n.id)) && n.type === 'today');
            if (newOnes.length > 0 && window.showToast) {
                const first = newOnes[0];
                window.showToast({
                    type: 'success',
                    title: 'Ulang tahun hari ini! 🎂',
                    message: first.title + (newOnes.length > 1 ? ' (+' + (newOnes.length - 1) + ' lainnya)' : '')
                });
            }
            knownIds = freshIds;

            const empty = document.getElementById('notifEmpty');
            if (empty) empty.remove();
            notifList.innerHTML = data.notifications.length
                ? data.notifications.map(cardHtml).join('')
                : '<div class="end-text"><h5>Belum ada notifikasi 🎈</h5><p>Tambahkan teman beserta tanggal lahirnya.</p></div>';
            applySearch();
        } catch (e) { /* polling gagal diam-diam, coba lagi periode berikut */ }
    }

    setInterval(pollFeed, 30000);

    // ---- Tandai dibaca (event delegation, berlaku juga untuk hasil polling) ----
    notifList.addEventListener('click', function (e) {
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
            fetch(@json(route('notifications.read-all')).replace('read-all', '') + readBtn.dataset.id + '/read', {
                method: 'POST',
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf }
            }).then(res => res.json()).then(() => {
                const card = notifList.querySelector('.notif-item[data-id="' + readBtn.dataset.id + '"]');
                if (card) {
                    card.classList.add('is-read');
                    readBtn.remove();
                }
                pollBadgeOnly();
            });
        }
    });

    function pollBadgeOnly() {
        fetch(feedUrl, { headers: { 'Accept': 'application/json' } })
            .then(res => res.json())
            .then(data => updateBadge(data.unread_count || 0))
            .catch(() => {});
    }

    // ---- Modal kirim ucapan ----
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
        return '<div class="greet-bubble">' + escapeHtml(g.message)
            + '<small>' + escapeHtml(g.sender || '') + ' · ' + escapeHtml(g.channel) + ' · ' + escapeHtml(g.created_at || '') + '</small></div>';
    }

    function loadThread(friendId) {
        const thread = document.getElementById('wishThread');
        fetch('/friends/' + friendId + '/greetings', { headers: { 'Accept': 'application/json' } })
            .then(res => res.json())
            .then(data => {
                thread.innerHTML = data.greetings.length
                    ? data.greetings.map(threadHtml).join('')
                    : '<p class="text-muted small mb-0">Belum ada ucapan untuk teman ini.</p>';
            })
            .catch(() => {});
    }

    document.querySelectorAll('.template-chip').forEach(chip => {
        chip.addEventListener('click', function () {
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
            body: JSON.stringify({ message: message, channel: channel })
        }).then(async res => {
            const data = await res.json();
            if (!res.ok) throw data;
            return data;
        });
    }

    document.getElementById('wishSendBtn').addEventListener('click', function () {
        const message = document.getElementById('wishMessage').value.trim();
        const channel = (document.querySelector('input[name="wishChannel"]:checked') || {}).value || 'inapp';
        if (!message) {
            if (window.showToast) window.showToast({ type: 'error', title: 'Belum ada pesan', message: 'Tulis ucapan dulu ya.' });
            return;
        }
        sendGreeting(currentFriendId, message, channel).then(data => {
            if (window.showToast) window.showToast({ type: 'success', title: 'Terkirim! 🎉', message: 'Ucapanmu untuk ' + document.getElementById('wishName').textContent + ' tersimpan.' });
            loadThread(currentFriendId);
            document.getElementById('wishMessage').value = '';
            if (data.whatsapp_url) window.open(data.whatsapp_url, '_blank');
            if (data.mailto_url) window.location.href = data.mailto_url;
        }).catch(err => {
            const msg = (err && err.errors) ? Object.values(err.errors).flat().join(' ') : 'Gagal mengirim ucapan.';
            if (window.showToast) window.showToast({ type: 'error', title: 'Gagal', message: msg });
        });
    });

    // ---- Kirim cepat ----
    document.getElementById('quickSendBtn').addEventListener('click', function () {
        const friendId = document.getElementById('quickFriend').value;
        const message = document.getElementById('quickMessage').value.trim();
        if (!friendId || !message) {
            if (window.showToast) window.showToast({ type: 'error', title: 'Belum lengkap', message: 'Pilih teman dan tulis ucapan dulu.' });
            return;
        }
        sendGreeting(friendId, message, 'inapp').then(() => {
            if (window.showToast) window.showToast({ type: 'success', title: 'Terkirim! 🎉', message: 'Ucapan cepatmu tersimpan.' });
            document.getElementById('quickMessage').value = '';
            pollFeed();
        }).catch(() => {
            if (window.showToast) window.showToast({ type: 'error', title: 'Gagal', message: 'Gagal mengirim ucapan cepat.' });
        });
    });
});
</script>
@endpush
