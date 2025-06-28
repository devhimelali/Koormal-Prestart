<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;"
    aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Shift</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="close-modal"></button>
            </div>

            <form class="tablelist-form" action="" method="POST" id="deleteForm">
                @csrf
                <input type="hidden" name="_method" value="DELETE">
                <div class="modal-body p-4">
                    <p id="deleteMessage">Are you sure you want to delete this shift?</p>
                </div>
                <div class="modal-footer" style="display: block;">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-ghost-danger" data-bs-dismiss="modal"><i
                                class="bi bi-x-lg align-baseline me-1"></i> Close
                        </button>
                        <button type="submit" class="btn btn-danger" id="deleteBtn">Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
