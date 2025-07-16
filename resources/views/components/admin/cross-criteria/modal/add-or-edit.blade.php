<div id="addOrEditModal" data-bs-backdrop="static" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel"
    aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light py-2">
                <h5 class="modal-title" id="myModalLabel">Create a new cross criteria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <form action="{{ route('cross-criteria.store') }}" method="POST" id="addOrEditForm">
                @csrf
                <input type="hidden" name="_method" id="method" value="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label for="name" class="form-label">Title</label>
                            <input type="text" name="name" class="form-control" id="name"
                                placeholder="Enter cross criteria title">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="color" class="form-label">Color Code</label>
                            <input type="color" name="color" class="form-control" id="color">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" cols="30" rows="5" class="form-control"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary" id="addOrEditSubmitBtn">Save</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
