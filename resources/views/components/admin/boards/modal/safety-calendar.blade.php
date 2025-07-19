<div id="safetyCalendarModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light py-2">
                <h5 class="modal-title" id="myModalLabel">Safety Calendar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <form action="" method="POST" id="safetyCalendarForm">
                @csrf
                <input type="hidden" name="daily_shift_entry_id" value="{{ $dailyShiftEntryId }}">
                <input type="hidden" name="cell" id="safetyCalendarCell">
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="cross_criteria" class="form-label">Cross Criteria</label>
                        <select name="cross_criteria" id="cross_criteria" class="form-select">
                            <option value="">Select Cross Criteria</option>
                            @foreach ($crossCriteria as $criteria)
                                <option value="{{ $criteria->id }}">{{ $criteria->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary" id="safetyCalendarSubmitBtn">Save</button>
                    <button type="button" class="btn subtle-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
