<div id="toastContainer" class="toast-container-custom">
    @if (session('success'))
        <div class="toast-card toast-success" role="alert">
            <div class="toast-icon" aria-hidden="true">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M8 12.5l2.7 2.7L16 9.5"/>
                </svg>
            </div>
            <div class="toast-content">
                <div class="toast-title">Berhasil!</div>
                <div class="toast-message">{{ session('success') }}</div>
            </div>
            <button type="button" class="toast-close" aria-label="Tutup" onclick="this.parentElement.remove()">&times;</button>
        </div>
    @endif

    @if (session('status'))
        <div class="toast-card toast-info" role="alert">
            <div class="toast-icon" aria-hidden="true">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 16v-5M12 8h.01"/>
                </svg>
            </div>
            <div class="toast-content">
                <div class="toast-title">Info</div>
                <div class="toast-message">{{ session('status') }}</div>
            </div>
            <button type="button" class="toast-close" aria-label="Tutup" onclick="this.parentElement.remove()">&times;</button>
        </div>
    @endif

    @if (session('error'))
        <div class="toast-card toast-error" role="alert">
            <div class="toast-icon" aria-hidden="true">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M10.3 3.9L2.4 17.5a2 2 0 001.7 3h15.8a2 2 0 001.7-3L13.7 3.9a2 2 0 00-3.4 0z"/>
                    <path d="M12 9.5v4M12 17h.01"/>
                </svg>
            </div>
            <div class="toast-content">
                <div class="toast-title">Kesalahan</div>
                <div class="toast-message">{{ session('error') }}</div>
            </div>
            <button type="button" class="toast-close" aria-label="Tutup" onclick="this.parentElement.remove()">&times;</button>
        </div>
    @endif

    @if ($errors->any())
        <div class="toast-card toast-error" role="alert">
            <div class="toast-icon" aria-hidden="true">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M10.3 3.9L2.4 17.5a2 2 0 001.7 3h15.8a2 2 0 001.7-3L13.7 3.9a2 2 0 00-3.4 0z"/>
                    <path d="M12 9.5v4M12 17h.01"/>
                </svg>
            </div>
            <div class="toast-content">
                <div class="toast-title">Terjadi Kesalahan</div>
                <div class="toast-message">
                    @if ($errors->count() == 1)
                        {{ $errors->first() }}
                    @else
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
            <button type="button" class="toast-close" aria-label="Tutup" onclick="this.parentElement.remove()">&times;</button>
        </div>
    @endif
</div>

<style>
    :root {
        --slate: #5D688A;
        --slate-dark: #3F4766;
        --pink: #F7A5A5;
        --pink-deep: #E27D7D;
        --cream: #FFF2EF;
        --peach: #FFDBB6;
        --peach-deep: #E8A765;
    }

    .toast-container-custom {
        position: fixed;
        top: 24px;
        right: 24px;
        z-index: 99999;
        display: flex;
        flex-direction: column;
        gap: 14px;
        max-width: 400px;
        width: calc(100% - 48px);
        pointer-events: none;
    }

    .toast-card {
        pointer-events: auto;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 14px 16px;
        background: var(--cream);
        border-radius: 16px;
        border: 2.5px solid var(--slate);
        box-shadow: 4px 4px 0 var(--pink);
        animation: toastSlideIn 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .toast-success { border-color: var(--slate);     box-shadow: 4px 4px 0 var(--pink); }
    .toast-info    { border-color: var(--peach-deep); box-shadow: 4px 4px 0 var(--peach); }
    .toast-error   { border-color: var(--pink-deep);  box-shadow: 4px 4px 0 var(--slate); }

    .toast-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .toast-success .toast-icon {
        background-color: #E4E8F5;
        border: 2px solid var(--slate);
        color: var(--slate);
    }

    .toast-info .toast-icon {
        background-color: var(--peach);
        border: 2px solid var(--peach-deep);
        color: #B8742B;
    }

    .toast-error .toast-icon {
        background-color: var(--pink);
        border: 2px solid var(--pink-deep);
        color: #B83F3F;
    }

    .toast-content {
        flex: 1;
        min-width: 0;
        padding-top: 2px;
    }

    .toast-title {
        font-size: 14.5px;
        font-weight: 800;
        color: var(--slate-dark);
        margin-bottom: 2px;
    }

    .toast-message {
        font-size: 12.5px;
        font-weight: 500;
        color: var(--slate);
        line-height: 1.45;
    }

    .toast-close {
        background: none;
        border: none;
        font-size: 20px;
        color: var(--slate);
        opacity: 0.6;
        cursor: pointer;
        padding: 0 4px;
        line-height: 1;
        transition: all 0.2s ease;
        margin-left: 4px;
    }

    .toast-close:hover {
        color: var(--pink-deep);
        opacity: 1;
    }

    @keyframes toastSlideIn {
        from { opacity: 0; transform: translateX(100%) translateY(-10px); }
        to   { opacity: 1; transform: translateX(0) translateY(0); }
    }

    @keyframes toastFadeOut {
        from { opacity: 1; transform: scale(1); }
        to   { opacity: 0; transform: scale(0.9) translateY(-10px); }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toastContainer = document.getElementById('toastContainer');

        const toasts = toastContainer.querySelectorAll('.toast-card');
        toasts.forEach(toast => {
            setTimeout(() => {
                toast.style.animation = 'toastFadeOut 0.3s ease forwards';
                setTimeout(() => toast.remove(), 300);
            }, 4500);
        });

        window.showToast = function({
            type = 'success',
            title = 'Berhasil!',
            message = ''
        }) {
            const toast = document.createElement('div');
            toast.className = `toast-card toast-${type}`;
            toast.setAttribute('role', 'alert');

            const icon = type === 'success' ? '🎉' : '⚠️';

            toast.innerHTML = `
            <div class="toast-icon">${icon}</div>
            <div class="toast-content">
                <div class="toast-title">${title}</div>
                <div class="toast-message">${message}</div>
            </div>
            <button type="button" class="toast-close">&times;</button>
        `;

            toast.querySelector('.toast-close').addEventListener('click', () => toast.remove());

            toastContainer.appendChild(toast);

            setTimeout(() => {
                toast.style.animation = 'toastFadeOut 0.3s ease forwards';
                setTimeout(() => toast.remove(), 300);
            }, 4500);
        };
    });
</script>
