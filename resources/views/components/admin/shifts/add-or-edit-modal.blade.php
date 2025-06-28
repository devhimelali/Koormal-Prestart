<div class="modal fade" id="addOrEditShiftModal" tabindex="-1" aria-labelledby="addOrEditShiftModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light pb-2">
                <h5 class="modal-title" id="addOrEditShiftModalLabel">Add a new shift</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('shifts.store') }}" id="shiftAddForm" method="POST">
                @csrf
                <input type="hidden" name="_method" value="POST" id="method">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">
                            Name
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Enter shift name">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3 linked-shift-wrapper"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary" id="shiftSubmitBtn">Save</button>
                    <button type="button" class="btn btn-subtle-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
