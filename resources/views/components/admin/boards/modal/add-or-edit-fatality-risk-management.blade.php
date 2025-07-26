<!-- Fatality Risk Control Modal -->
<div class="modal fade" id="fatalityRiskControlModal" tabindex="-1" aria-labelledby="fatalityRiskControlModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h1 class="modal-title fs-5" id="fatalityRiskControlModalLabel">Fatality Risk Control</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="fatality_risk_control" class="form-label">Fatality Risk Control</label>
                        <select name="fatality_risk_control" id="fatality_risk_control" class="form-select select2">
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
                    <button type="submit" class="btn btn-secondary">Save</button>
                    <button type="button" class="btn btn-subtle-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>

        </div>
    </div>
</div>