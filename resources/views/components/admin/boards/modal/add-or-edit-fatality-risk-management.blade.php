<!-- Fatality Risk Control Modal -->
<div class="modal fade" id="fatalityRiskControlModal" tabindex="-1" aria-labelledby="fatalityRiskControlModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light py-2">
                <h1 class="modal-title fs-5" id="fatalityRiskControlModalLabel">Fatality Risk Control</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('fatality-risk-controls.assign')}}" method="post" id="fatalityRiskControlForm">
                @csrf
                <input type="hidden" name="shift_log_id" id="shift_log_id">
                <input type="hidden" name="type" id="inputType" value="add">
                <div class="modal-body">
                    <div class="mb-2 log-details"></div>
                    <div class="mb-2">
                        <label for="fatality_risk_control" class="form-label">Fatality Risk Control</label>
                        <select name="fatality_risk_control[]" id="fatality_risk_control" class="form-select select2"
                                multiple>
                            <option value="">Select Fatality Risk Control</option>
                            @foreach ($fatalityRisks as $fatalityRiskControl)
                                <option value="{{ $fatalityRiskControl->id }}"
                                        data-image="{{ asset('storage/' . $fatalityRiskControl->image) }}">
                                    {{ $fatalityRiskControl->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary" id="fatalityRiskControlSubmitBtn">Save</button>
                    <button type="button" class="btn btn-subtle-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>

        </div>
    </div>
</div>
