<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden" style="background: var(--white, #FFFFFF);">
            <div class="modal-body text-center p-4">
                <div class="mb-3 d-inline-flex align-items-center justify-content-center rounded-circle shadow-sm"
                    style="width: 64px; height: 64px; background-color: var(--primary-soft, #FCE4E6); color: var(--primary-dark, #B95569);"
                    aria-hidden="true">
                    <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 7h16M10 11v6M14 11v6M6 7l1 12a2 2 0 002 2h6a2 2 0 002-2l1-12M9 7V4h6v3" />
                    </svg>
                </div>
                <h5 class="fw-bold mb-2" id="deleteConfirmModalLabel" style="color: var(--text, #333333);">Delete friend data?</h5>
                <p class="text-muted small mb-4" style="line-height: 1.5;">
                    Are you sure you want to delete <strong id="deleteTargetName" style="color: var(--primary-dark, #B95569);"></strong>?
                    This
                    action can't be undone
                </p>

                <form id="deleteConfirmForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <div class="d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-secondary rounded-pill px-4 fw-semibold"
                            data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn rounded-pill px-4 fw-semibold text-white shadow-sm"
                            style="background-color: var(--primary-dark, #B95569); border-color: var(--primary-dark, #B95569);">
                            Yes, Delete
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openDeleteModal(actionUrl, friendName) {
        const form = document.getElementById('deleteConfirmForm');
        const nameElem = document.getElementById('deleteTargetName');

        if (form && nameElem) {
            form.action = actionUrl;
            nameElem.textContent = friendName;

            const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
            deleteModal.show();
        }
    }
</script>
