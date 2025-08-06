<!-- Default Modals -->
<div id="addSiteCommunication" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
     style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light py-2">
                <h5 class="modal-title" id="myModalLabel">Create Site Communication</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('site-communications.store')}}" method="POST" enctype="multipart/form-data"
                  id="addSiteCommunicationForm">
                @csrf
                <input type="hidden" name="shift_type" id="shift_type" value="{{ request()->query('shift_type') }}">
                <input type="hidden" name="_method" id="method" value="POST">
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Title">
                    </div>
                    <div class="mb-2">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="5"
                                  placeholder="Description"></textarea>
                    </div>
                    <div class="mb-2">
                        <label for="dates" class="form-label">Date/Dates</label>
                        <input type="text" class="form-control" id="dates" name="dates" placeholder="Date/Dates">
                    </div>
                    <div class="mb-2">
                        <label for="pdf" class="form-label">Attachment File</label>
                        <input type="file" class="form-control" id="pdf" name="pdf" placeholder="Attachment File">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary" id="addSiteCommunicationSubmitBtn">Save</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
