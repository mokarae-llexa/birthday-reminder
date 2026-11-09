@props([
    'mode' => 'autofill',
    'modalId' => 'databasePickerModal',
    'searchUrl' => null,
])

@php
    $searchUrl = $searchUrl ?: route('friends.search-database');
@endphp

<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <div>
                    <h5 class="modal-title fw-bold mb-1" id="{{ $modalId }}Label">Select Online Friend</h5>
                    <p class="text-muted small mb-0">Search registered users or saved friends, then pick one to
                        auto-fill the form.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex gap-2 flex-wrap mb-3">
                    <div class="flex-grow-1 position-relative" style="min-width: 220px;">
                        <input type="text" class="form-control rounded-pill ps-4" id="{{ $modalId }}Search"
                            placeholder="Search name or email..." autocomplete="off">
                    </div>
                    <div class="btn-group" role="group" aria-label="Source filter">
                        <input type="radio" class="btn-check" name="{{ $modalId }}Source"
                            id="{{ $modalId }}SrcAll" value="all" checked>
                        <label class="btn btn-outline-secondary btn-sm rounded-pill px-3"
                            for="{{ $modalId }}SrcAll">All</label>
                        <input type="radio" class="btn-check" name="{{ $modalId }}Source"
                            id="{{ $modalId }}SrcUsers" value="users">
                        <label class="btn btn-outline-secondary btn-sm rounded-pill px-3"
                            for="{{ $modalId }}SrcUsers">Users</label>
                        <input type="radio" class="btn-check" name="{{ $modalId }}Source"
                            id="{{ $modalId }}SrcFriends" value="friends">
                        <label class="btn btn-outline-secondary btn-sm rounded-pill px-3"
                            for="{{ $modalId }}SrcFriends">Friends</label>
                    </div>
                </div>

                <div id="{{ $modalId }}Loading" class="text-center py-4 d-none">
                    <div class="spinner-border text-secondary" role="status" style="color: var(--primary, #E88F9B) !important;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="text-muted small mt-2 mb-0">Searching...</p>
                </div>

                <div id="{{ $modalId }}Empty" class="text-center py-4 d-none">
                    <div class="d-flex justify-content-center mb-2" style="color: var(--primary, #E88F9B);" aria-hidden="true">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="7" />
                            <path d="M21 21l-4.3-4.3" />
                            <path d="M8.5 11h5" />
                        </svg>
                    </div>
                    <p class="fw-semibold mb-1">No data found</p>
                    <p class="text-muted small mb-0">Try another keyword or a different source filter.</p>
                </div>

                <div id="{{ $modalId }}List" class="list-group list-group-flush"
                    style="max-height: 380px; overflow-y: auto;"></div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-secondary rounded-pill px-4"
                    data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        (function() {
            const modalId = @json($modalId);
            const searchUrl = @json($searchUrl);
            const mode = @json($mode);

            function el(id) {
                return document.getElementById(id);
            }

            function escapeHtml(str) {
                return String(str ?? '').replace(/[&<>"']/g, function(c) {
                    return {
                        '&': '&amp;',
                        '<': '&lt;',
                        '>': '&gt;',
                        '"': '&quot;',
                        "'": '&#039;'
                    } [c];
                });
            }

            function icon(paths, size) {
                return '<svg width="' + size + '" height="' + size +
                    '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="flex-shrink:0;vertical-align:-2px;color:var(--secondary, #5D688A);">' +
                    paths + '</svg>';
            }

            const ICON = {
                check: function(s) {
                    return icon('<path d="M5 12.5l4.5 4.5L19 7.5"/>', s);
                },
                link: function(s) {
                    return icon(
                        '<path d="M10 14a4 4 0 005.7 0l3-3a4 4 0 00-5.7-5.7l-1 1M14 10a4 4 0 00-5.7 0l-3 3a4 4 0 005.7 5.7l1-1"/>',
                        s);
                },
                cake: function(s) {
                    return '<svg width="' + s + '" height="' + s +
                        '" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="flex-shrink:0;vertical-align:-3px;">' +
                        '<path d="M12 2.6c.8.7 1 1.4.5 2a1 1 0 01-1.7-.1c-.2-.6 0-1.2 1.2-1.9z" style="fill:var(--primary, #E88F9B);stroke:var(--primary, #E88F9B);stroke-width:1"/>' +
                        '<path d="M12 7v3.5" style="stroke:var(--secondary, #5D688A)"/>' +
                        '<rect x="4" y="10.5" width="16" height="9" rx="2" style="stroke:var(--secondary, #5D688A)"/>' +
                        '<path d="M4 14.5c1.3 1.4 2.7 1.4 4 0s2.7-1.4 4 0 2.7 1.4 4 0 2.7-1.4 4 0" style="stroke:var(--primary, #E88F9B)"/>' +
                        '<path d="M2.5 21.5h19" style="stroke:var(--secondary, #5D688A)"/></svg>';
                }
            };

            function currentSource() {
                const checked = document.querySelector('input[name="' + modalId + 'Source"]:checked');
                return checked ? checked.value : 'all';
            }

            let debounceTimer = null;

            async function loadResults() {
                const listEl = el(modalId + 'List');
                const loadingEl = el(modalId + 'Loading');
                const emptyEl = el(modalId + 'Empty');
                const searchEl = el(modalId + 'Search');
                if (!listEl) return;

                loadingEl.classList.remove('d-none');
                emptyEl.classList.add('d-none');
                listEl.innerHTML = '';

                try {
                    const params = new URLSearchParams({
                        q: searchEl ? searchEl.value : '',
                        source: currentSource(),
                        limit: '10',
                    });
                    const res = await fetch(searchUrl + '?' + params.toString(), {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                    });
                    if (!res.ok) throw new Error('HTTP ' + res.status);
                    const json = await res.json();
                    const items = json.data || [];

                    if (items.length === 0) {
                        emptyEl.classList.remove('d-none');
                        return;
                    }

                    items.forEach(function(item) {
                        const row = document.createElement('div');
                        row.className = 'list-group-item d-flex align-items-center gap-3 py-3';
                        const badgeColor = item.source === 'user' ?
                            'background:var(--secondary-soft, #E9ECF4);color:var(--secondary-dark, #3F4766);border:1px solid var(--secondary, #5D688A);' :
                            'background:var(--primary-soft, #FCE4E6);color:var(--primary-dark, #B95569);border:1px solid var(--border, #F0C9C9);';
                        const extraBadges =
                            (item.is_self ?
                                '<span class="badge rounded-pill" style="font-size:10px;background:var(--secondary-soft, #E9ECF4);color:var(--secondary-dark, #3F4766);border:1px solid var(--secondary, #5D688A);">It\'s you</span>' :
                                '') +
                            (item.is_added ?
                                '<span class="badge rounded-pill d-inline-flex align-items-center gap-1" style="font-size:10px;background:var(--primary-soft, #FCE4E6);color:var(--primary-dark, #B95569);border:1px solid var(--border, #F0C9C9);">' +
                                ICON.check(11) + 'Already added</span>' :
                                '');
                        const pickBtn = item.is_added ?
                            '<button type="button" class="btn btn-sm rounded-pill px-3 d-inline-flex align-items-center gap-1" disabled title="Already in the friends list">Added ' +
                            ICON.check(13) + '</button>' :
                            '<button type="button" class="btn btn-sm rounded-pill px-3 text-white pick-btn" style="background-color:var(--primary, #E88F9B);border-color:var(--primary, #E88F9B);">Select</button>';
                        row.innerHTML =
                            '<img src="' + escapeHtml(item.avatar || '') +
                            '" alt="" class="rounded-circle border" style="width:48px;height:48px;object-fit:cover;border-color:var(--border, #F0C9C9) !important;" onerror="this.src=\'https://ui-avatars.com/api/?name=' +
                            encodeURIComponent(item.name || '?') +
                            '&background=FCE4E6&color=B95569&bold=true\';">' +
                            '<div class="flex-grow-1" style="min-width:0;">' +
                            '<div class="d-flex align-items-center gap-2 flex-wrap">' +
                            '<span class="fw-bold" style="color:var(--text, #333333);">' + escapeHtml(item.name || '-') + '</span>' +
                            '<span class="badge rounded-pill" style="font-size:10px;' + badgeColor + '">' +
                            escapeHtml(item.source_label || item.source) + '</span>' +
                            extraBadges +
                            '</div>' +
                            '<div class="text-muted small text-truncate">' + escapeHtml(item.email ||
                                'No email yet') + (item.birth_date ? ' &bull; ' + ICON.cake(14) + ' ' +
                                escapeHtml(item.birth_date) : '') + '</div>' +
                            (item.source === 'user' ? '<div class="small" style="color:var(--secondary, #5D688A);"></div>' :
                                '') +
                            '</div>' +
                            pickBtn;

                        const btn = row.querySelector('.pick-btn');
                        if (btn) {
                            btn.addEventListener('click', function() {
                                handlePick(item);
                            });
                        }
                        listEl.appendChild(row);
                    });
                } catch (e) {
                    emptyEl.classList.remove('d-none');
                    emptyEl.querySelector('p.fw-semibold').textContent = 'Failed to load data';
                } finally {
                    loadingEl.classList.add('d-none');
                }
            }

            function handlePick(item) {
                if (mode === 'redirect') {
                    window.location.href = item.prefill_url;
                    return;
                }
                fillFriendForm(item);
                const modalEl = el(modalId);
                if (modalEl && typeof bootstrap !== 'undefined') {
                    const instance = bootstrap.Modal.getInstance(modalEl);
                    if (instance) instance.hide();
                }
            }

            function setVal(id, value) {
                const input = document.getElementById(id);
                if (input && value !== null && value !== undefined) {
                    input.value = value;
                    input.dispatchEvent(new Event('input', {
                        bubbles: true
                    }));
                    input.dispatchEvent(new Event('change', {
                        bubbles: true
                    }));
                }
            }

            function fillFriendForm(item) {
                const isUserLink = item.source === 'user';

                setVal('name', item.name || '');
                setVal('email', item.email || '');
                setVal('phone', item.phone || '');
                setVal('birth_date', item.birth_date || '');
                setVal('notes', item.notes || '');

                const linkInput = document.getElementById('linkedUserIdInput');
                if (linkInput) linkInput.value = isUserLink ? item.id : '';

                ['name', 'email', 'birth_date'].forEach(function(id) {
                    const input = document.getElementById(id);
                    if (input) input.readOnly = isUserLink;
                });

                const birthInput = document.getElementById('birth_date');
                if (birthInput) birthInput.required = !isUserLink;

                const birthHint = document.getElementById('birthDateSyncHint');
                if (birthHint) {
                    birthHint.classList.toggle('d-none', !(isUserLink && !item.birth_date));
                }

                if (item.avatar) {
                    const preview = document.getElementById('avatarPreview');
                    if (preview) preview.src = item.avatar;
                    const base64Input = document.getElementById('avatarBase64Input');
                    if (base64Input) base64Input.value = '';
                    let urlInput = document.getElementById('avatarUrlInput');
                    if (urlInput) {
                        urlInput.value = item.avatar;
                        if (urlInput.value.includes('ui-avatars.com')) urlInput.value = '';
                    }
                    const removeInput = document.getElementById('avatarRemoveInput');
                    if (removeInput) removeInput.value = '0';
                    const btnRemove = document.getElementById('btnRemoveAvatar');
                    if (btnRemove) btnRemove.classList.remove('d-none');
                }

                const notice = document.getElementById('prefillNotice');
                if (notice) {
                    notice.classList.remove('d-none');
                    const label = document.getElementById('prefillNoticeLabel');
                    if (label) label.textContent = (item.source_label || 'Database') + ': ' + (item.name || '');
                    const title = document.getElementById('prefillNoticeTitle');
                    if (title) title.innerHTML = isUserLink ? ICON.link(15) + 'Linked to user account' :
                        'Auto-filled data';
                    const hint = document.getElementById('prefillNoticeHint');
                    if (hint) hint.textContent = isUserLink ?
                        'Name, Email & Birth Date sync automatically from their profile. Just complete Phone & Notes.' :
                        'Please complete the remaining fields before saving.';
                }

                const nameInput = document.getElementById('name');
                if (nameInput) nameInput.focus();
            }

            window[modalId + '_fillFriendForm'] = fillFriendForm;

            document.addEventListener('DOMContentLoaded', function() {
                const searchEl = el(modalId + 'Search');
                if (searchEl) {
                    searchEl.addEventListener('input', function() {
                        clearTimeout(debounceTimer);
                        debounceTimer = setTimeout(loadResults, 300);
                    });
                }
                document.querySelectorAll('input[name="' + modalId + 'Source"]').forEach(function(radio) {
                    radio.addEventListener('change', loadResults);
                });
                const modalEl = el(modalId);
                if (modalEl) {
                    modalEl.addEventListener('shown.bs.modal', loadResults);
                }
            });
        })();
    </script>
@endpush