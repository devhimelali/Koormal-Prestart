<div id="safetyCalendarModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
     style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light py-2">
                <h5 class="modal-title" id="myModalLabel">Safety Calendar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('boards.store.health-safety-cross-criteria') }}" method="POST"
                  id="safetyCalendarForm">
                @csrf
                <input type="hidden" name="cell_number" id="safetyCalendarCell">
                <input type="hidden" name="cross_criteria_id" id="safetyCalendarCriteriaId">
                <input type="hidden" name="start_date" id="safetyCalendarStartDate">
                <input type="hidden" name="end_date" id="safetyCalendarEndDate">
                <input type="hidden" name="shift_id" id="safetyCalendarShiftId">
                <input type="hidden" name="shift_rotation_id" id="safetyCalendarRotationId">
                <input type="hidden" name="shift_type" id="safetyCalendarShiftType">
                <div class="modal-body">
                    <div class="row">
                        @foreach ($crossCriteria as $criteria)
                            <div class="col-3 criteria-option" data-id="{{ $criteria->id }}"
                                 data-color="{{ $criteria->color }}" data-bg="{{ $criteria->bg_color }}">
                                <div class="option"
                                     style="border: {{ $criteria->color }} 2px solid; background-color: {{ $criteria->bg_color }};">
                                    {{ $criteria->name }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary" id="safetyCalendarSubmitBtn">Save</button>
                    <button type="button" class="btn btn-subtle-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<style>
    .criteria-option {
        cursor: pointer;
        padding: 4px;
    }

    .option {
        text-align: center;
        border: 1px solid #ccc;
        border-radius: 4px;
        width: auto;
        height: 120px;
        padding: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .option.selected {
        border: 2px solid #000 !important;
        background-color: #f0f0f0 !important;
    }
</style>

<script>
    // ✅ Reset everything when modal is closed
    $('#safetyCalendarModal').on('hidden.bs.modal', function () {
        $('.criteria-option').each(function () {
            let $item = $(this);
            let color = $item.data('color');
            let bg = $item.data('bg');

            // Restore original styles
            $item.find('.option')
                .removeClass('selected')
                .css({
                    border: `${color} 2px solid`,
                    backgroundColor: bg
                });
        });

        // Clear hidden input
        $('#safetyCalendarModal #safetyCalendarCriteriaId').val('');
    });
</script>
