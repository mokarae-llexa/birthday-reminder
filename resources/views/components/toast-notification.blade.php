<div id="toastContainer" class="toast-container-custom">
    @if(session('success'))
        <div class="toast-card toast-success" role="alert">
            <div class="toast-icon">🎉</div>
            <div class="toast-content">
                <div class="toast-title">Berhasil!</div>
                <div class="toast-message">{{ session('success') }}</div>
            </div>
            <button type="button" class="toast-close" onclick="this.parentElement.remove()">&times;</button>
        </div>
    @endif

    @if(session('status'))
        <div class="toast-card toast-success" role="alert">
            <div class="toast-icon">✨</div>
            <div class="toast-content">
                <div class="toast-title">Info</div>
                <div class="toast-message">{{ session('status') }}</div>
            </div>
            <button type="button" class="toast-close" onclick="this.parentElement.remove()">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div class="toast-card toast-error" role="alert">
            <div class="toast-icon">⚠️</div>
            <div class="toast-content">
                <div class="toast-title">Kesalahan</div>
                <div class="toast-message">{{ session('error') }}</div>
            </div>
            <button type="button" class="toast-close" onclick="this.parentElement.remove()">&times;</button>
        </div>
    @endif

    @if($errors->any())
        <div class="toast-card toast-error" role="alert">
            <div class="toast-icon">⚠️</div>
            <div class="toast-content">
                <div class="toast-title">Terjadi Kesalahan</div>
                <div class="toast-message">
                    @if($errors->count() == 1)
                        {{ $errors->first() }}
                    @else
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
            <button type="button" class="toast-close" onclick="this.parentElement.remove()">&times;</button>
        </div>
    @endif
</div>

<style>
.toast-container-custom {
    position: fixed;
    top: 24px;
    right: 24px;
    z-index: 99999;
    display: flex;
    flex-direction: column;
    gap: 12px;
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
    background: #FFFFFF;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(197, 95, 78, 0.15), 0 4px 12px rgba(0, 0, 0, 0.05);
    border: 1.5px solid #FFE6E3;
    animation: toastSlideIn 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.toast-card::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    border-radius: 4px 0 0 4px;
}

.toast-success::before {
    background-color: #C55F4E;
}

.toast-error::before {
    background-color: #E53E3E;
}

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
    background-color: #FFE6E3;
}

.toast-error .toast-icon {
    background-color: #FED7D7;
}

.toast-content {
    flex: 1;
    min-width: 0;
    padding-top: 2px;
}

.toast-title {
    font-size: 13.5px;
    font-weight: 700;
    color: #1F1F1F;
    margin-bottom: 2px;
}

.toast-message {
    font-size: 12.5px;
    color: #4A4A4A;
    line-height: 1.4;
}

.toast-close {
    background: none;
    border: none;
    font-size: 20px;
    color: #A0AEC0;
    cursor: pointer;
    padding: 0 4px;
    line-height: 1;
    transition: color 0.2s ease;
    margin-left: 4px;
}

.toast-close:hover {
    color: #1F1F1F;
}

@keyframes toastSlideIn {
    from {
        opacity: 0;
        transform: translateX(100%) translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateX(0) translateY(0);
    }
}

@keyframes toastFadeOut {
    from {
        opacity: 1;
        transform: scale(1);
    }
    to {
        opacity: 0;
        transform: scale(0.9) translateY(-10px);
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toastContainer = document.getElementById('toastContainer');
    
    const toasts = toastContainer.querySelectorAll('.toast-card');
    toasts.forEach(toast => {
        setTimeout(() => {
            toast.style.animation = 'toastFadeOut 0.3s ease forwards';
            setTimeout(() => toast.remove(), 300);
        }, 4500);
    });

    window.showToast = function ({ type = 'success', title = 'Berhasil!', message = '' }) {
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
