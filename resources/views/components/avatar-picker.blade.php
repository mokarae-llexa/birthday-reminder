@props(['currentAvatar' => null, 'defaultName' => 'Teman'])

@php
    $initialAvatar = $currentAvatar ?: 'https://ui-avatars.com/api/?name=' . urlencode($defaultName) . '&background=FFE1DD&color=C55F4E&size=160&bold=true';
@endphp

<div class="avatar-picker-container mb-4">
    <label class="form-label d-block fw-semibold mb-2">Foto / Icon Profil</label>
    
    <div class="d-flex align-items-center gap-3">
        <div class="position-relative">
            <div class="avatar-preview-box" id="avatarPreviewContainer">
                <img id="avatarPreview" src="{{ $initialAvatar }}" alt="Avatar Preview" class="rounded-circle shadow-sm" style="width: 96px; height: 96px; object-fit: cover; border: 3px solid #FFE6E3;">
            </div>
            <button type="button" class="btn btn-sm btn-light rounded-circle position-absolute bottom-0 end-0 shadow-sm border" id="btnTriggerUpload" title="Ubah Foto">
                📷
            </button>
        </div>

        <div class="d-flex flex-column gap-2">
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3" id="btnChoosePhoto">
                    <i class="bi bi-upload"></i> Upload Foto
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-3" id="btnChoosePreset">
                    <i class="bi bi-emoji-smile"></i> Pilih Icon
                </button>
            </div>
            <div class="form-text text-muted" style="font-size: 12px;">
                Format: JPG, PNG, WEBP. Max <strong>2MB</strong>.
            </div>
            <button type="button" class="btn btn-link text-danger text-decoration-none btn-sm p-0 align-self-start {{ $currentAvatar ? '' : 'd-none' }}" id="btnRemoveAvatar">
                Delete Photo
            </button>
        </div>
    </div>

    <input type="file" id="avatarFileInput" name="avatar" accept="image/png, image/jpeg, image/webp, image/gif" class="d-none">
    <input type="hidden" name="avatar_base64" id="avatarBase64Input">
    <input type="hidden" name="avatar_remove" id="avatarRemoveInput" value="0">
</div>

<div class="modal fade" id="presetIconModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Pilih Icon Preset</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3 text-center" id="presetIconsGrid">
                    @php
                        $presetEmojis = ['🎂', '🥳', '🎈', '🎁', '🐱', '🐶', '🦄', '👑', '⭐', '🍕', '🍦', '🚀', '🎭', '🎨', '🎵', '🏆'];
                    @endphp
                    @foreach($presetEmojis as $emoji)
                        <div class="col-3">
                            <button type="button" class="btn btn-outline-light text-dark p-3 fs-2 w-100 rounded-3 preset-emoji-btn border" data-emoji="{{ $emoji }}">
                                {{ $emoji }}
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="avatarCropperModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 bg-dark text-white overflow-hidden shadow-lg">
            <div class="modal-header border-secondary text-white py-3">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-crop me-2"></i>Atur Foto Profil
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 text-center position-relative">
                <div class="cropper-container-wrapper d-flex align-items-center justify-content-center bg-black" style="min-height: 380px; max-height: 480px; overflow: hidden;">
                    <img id="cropperImageSrc" src="" alt="Source Image" style="max-width: 100%; display: block;">
                </div>

                <div id="cropperAlert" class="alert alert-danger mx-3 mt-3 d-none mb-0 text-start"></div>
            </div>

            <div class="modal-footer border-secondary flex-column bg-dark pt-3 pb-3 px-4">
                <div class="w-100 d-flex align-items-center justify-content-center gap-3 mb-3">
                    <button type="button" class="btn btn-outline-light btn-sm rounded-circle p-2" id="btnZoomOut" title="Zoom Out">
                        <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
                        </svg>
                    </button>
                    <input type="range" class="form-range w-50 custom-zoom-slider" id="zoomRange" min="0.1" max="3" step="0.01" value="1">
                    <button type="button" class="btn btn-outline-light btn-sm rounded-circle p-2" id="btnZoomIn" title="Zoom In">
                        <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                        </svg>
                    </button>
                    <div class="vr bg-secondary mx-2"></div>
                    <button type="button" class="btn btn-outline-light btn-sm rounded-circle p-2" id="btnRotateLeft" title="Putar Kiri">
                        <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
                            <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
                        </svg>
                    </button>
                    <button type="button" class="btn btn-outline-light btn-sm rounded-circle p-2" id="btnRotateRight" title="Putar Kanan">
                        <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"/>
                            <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966a.25.25 0 0 1 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"/>
                        </svg>
                    </button>
                    <button type="button" class="btn btn-outline-light btn-sm rounded-circle p-2" id="btnResetCrop" title="Reset">
                        <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"/>
                        </svg>
                    </button>
                </div>

                <div class="w-100 d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="button" class="btn btn-danger rounded-pill px-4" id="btnApplyCrop" style="background-color: #C55F4E; border-color: #C55F4E;">
                        Simpan Foto
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.cropper-view-box,
.cropper-face {
    border-radius: 50% !important;
}
.cropper-view-box {
    outline: 2px solid rgba(255, 255, 255, 0.9) !important;
    outline-color: rgba(255, 255, 255, 0.9) !important;
}
.cropper-line, .cropper-point {
    display: none !important;
}
.preset-emoji-btn:hover {
    background-color: #FFE6E3 !important;
    border-color: #C55F4E !important;
    transform: scale(1.1);
    transition: transform 0.2s ease;
}
.custom-zoom-slider {
    accent-color: #C55F4E;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById('avatarFileInput');
    const btnChoosePhoto = document.getElementById('btnChoosePhoto');
    const btnTriggerUpload = document.getElementById('btnTriggerUpload');
    const btnChoosePreset = document.getElementById('btnChoosePreset');
    const btnRemoveAvatar = document.getElementById('btnRemoveAvatar');
    const avatarPreview = document.getElementById('avatarPreview');
    const avatarBase64Input = document.getElementById('avatarBase64Input');
    const avatarRemoveInput = document.getElementById('avatarRemoveInput');

    const cropperModalElement = document.getElementById('avatarCropperModal');
    let cropperModal = null;
    if (typeof bootstrap !== 'undefined') {
        cropperModal = new bootstrap.Modal(cropperModalElement);
    }

    const presetModalElement = document.getElementById('presetIconModal');
    let presetModal = null;
    if (typeof bootstrap !== 'undefined') {
        presetModal = new bootstrap.Modal(presetModalElement);
    }

    const cropperImageSrc = document.getElementById('cropperImageSrc');
    const cropperAlert = document.getElementById('cropperAlert');
    const zoomRange = document.getElementById('zoomRange');
    let cropper = null;
    let initialZoom = 1;

    [btnChoosePhoto, btnTriggerUpload].forEach(btn => {
        if (btn) {
            btn.addEventListener('click', function () {
                fileInput.value = '';
                fileInput.click();
            });
        }
    });

    if (btnChoosePreset) {
        btnChoosePreset.addEventListener('click', function () {
            if (presetModal) presetModal.show();
        });
    }

    document.querySelectorAll('.preset-emoji-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const emoji = this.dataset.emoji;
            const canvas = document.createElement('canvas');
            canvas.width = 200;
            canvas.height = 200;
            const ctx = canvas.getContext('2d');
            
            ctx.fillStyle = '#FFE6E3';
            ctx.beginPath();
            ctx.arc(100, 100, 100, 0, Math.PI * 2);
            ctx.fill();

            ctx.font = '100px sans-serif';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText(emoji, 100, 110);

            const dataUrl = canvas.toDataURL('image/png');
            avatarPreview.src = dataUrl;
            avatarBase64Input.value = dataUrl;
            avatarRemoveInput.value = "0";
            if (btnRemoveAvatar) btnRemoveAvatar.classList.remove('d-none');

            if (presetModal) presetModal.hide();
        });
    });

    if (btnRemoveAvatar) {
        btnRemoveAvatar.addEventListener('click', function () {
            avatarPreview.src = 'https://ui-avatars.com/api/?name=' + encodeURIComponent('{{ $defaultName }}') + '&background=FFE1DD&color=C55F4E&size=160&bold=true';
            avatarBase64Input.value = '';
            avatarRemoveInput.value = "1";
            fileInput.value = '';
            btnRemoveAvatar.classList.add('d-none');
        });
    }

    function setAvatarDirectly(dataUrl) {
        avatarPreview.src = dataUrl;
        avatarBase64Input.value = dataUrl;
        avatarRemoveInput.value = "0";
        if (btnRemoveAvatar) btnRemoveAvatar.classList.remove('d-none');
    }

    fileInput.addEventListener('change', function (e) {
        const files = e.target.files;
        if (!files || files.length === 0) return;

        const file = files[0];
        if (file.size > 2 * 1024 * 1024) {
            alert('File size exceeds the maximum limit of 2MB! Please choose a smaller file.');
            fileInput.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function (evt) {
            // Fallback: jika Bootstrap Modal / Cropper.js gagal dimuat (mis. offline),
            // langsung pakai gambar asli tanpa crop agar upload tetap berfungsi.
            if (!cropperModal || typeof Cropper === 'undefined') {
                setAvatarDirectly(evt.target.result);
                return;
            }
            cropperImageSrc.src = evt.target.result;
            cropperAlert.classList.add('d-none');
            cropperAlert.innerText = '';
            
            cropperModal.show();
        };
        reader.readAsDataURL(file);
    });

    if (cropperModalElement) {
    cropperModalElement.addEventListener('shown.bs.modal', function () {
        if (typeof Cropper === 'undefined') return;
        if (cropper) {
            cropper.destroy();
        }

        cropper = new Cropper(cropperImageSrc, {
            aspectRatio: 1,
            viewMode: 1,
            dragMode: 'move',
            autoCropArea: 0.8,
            restore: false,
            guides: false,
            center: true,
            highlight: false,
            cropBoxMovable: false,
            cropBoxResizable: false,
            toggleDragModeOnDblclick: false,
            ready: function () {
                zoomRange.value = 1;
                initialZoom = 1;
            },
            zoom: function (e) {
                if (e.detail.ratio) {
                    zoomRange.value = e.detail.ratio;
                }
            }
        });
    });

    cropperModalElement.addEventListener('hidden.bs.modal', function () {
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
        // Jika user menutup modal tanpa menyimpan crop, file mentah di fileInput
        // tetap dikirim sebagai fallback sehingga upload tidak hilang.
    });
    } // end if (cropperModalElement)

    document.getElementById('btnZoomIn').addEventListener('click', function () {
        if (cropper) cropper.zoom(0.1);
    });
    document.getElementById('btnZoomOut').addEventListener('click', function () {
        if (cropper) cropper.zoom(-0.1);
    });
    zoomRange.addEventListener('input', function () {
        if (cropper) {
            const currentRatio = cropper.getImageData().width / cropper.getImageData().naturalWidth;
            const targetRatio = parseFloat(this.value);
            cropper.zoomTo(targetRatio);
        }
    });

    document.getElementById('btnRotateLeft').addEventListener('click', function () {
        if (cropper) cropper.rotate(-90);
    });
    document.getElementById('btnRotateRight').addEventListener('click', function () {
        if (cropper) cropper.rotate(90);
    });
    document.getElementById('btnResetCrop').addEventListener('click', function () {
        if (cropper) cropper.reset();
    });

    document.getElementById('btnApplyCrop').addEventListener('click', function () {
        if (!cropper) return;

        const canvas = cropper.getCroppedCanvas({
            width: 400,
            height: 400,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high',
        });

        if (!canvas) return;

        const croppedBase64 = canvas.toDataURL('image/png');
        
        if (croppedBase64.length > 2.8 * 1024 * 1024) {
            cropperAlert.innerText = 'Hasil potong foto terlalu besar (> 2MB). Silakan persempit area atau kurangi kualitas.';
            cropperAlert.classList.remove('d-none');
            return;
        }

        avatarPreview.src = croppedBase64;
        avatarBase64Input.value = croppedBase64;
        avatarRemoveInput.value = "0";

        if (btnRemoveAvatar) btnRemoveAvatar.classList.remove('d-none');

        if (cropperModal) cropperModal.hide();
    });
});
</script>
