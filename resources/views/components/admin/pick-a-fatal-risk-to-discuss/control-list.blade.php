<x-form action="{{ route('boards.store.fatal-risk-to-discuss') }}" :hasFile="false" id="controlListForm">
    <x-form.input type="hidden" name="fatality_risk_id" id="fatality_risk_id" value="{{ $fatalityRisk->id }}"/>
    <x-form.input type="hidden" name="shift_id" id="shift_id" value="{{ $shiftId }}"/>
    <x-form.input type="hidden" name="shift_rotation_id" id="shift_rotation_id" value="{{ $ShiftRotationId }}"/>
    <x-form.input type="hidden" name="start_date" id="start_date" value="{{ $startDate }}"/>
    <x-form.input type="hidden" name="end_date" id="end_date" value="{{ $endDate }}"/>
    <x-form.input type="hidden" name="shift_type" id="shift_type" value="{{ $shiftType }}"/>

    <div class="mb-2">
        <x-form.label text="Control" for="control"/>
        <select name="controls[]" id="control" class="form-select" multiple placeholder="Select or add control">
            @forelse($controls as $control)
                <option
                    {{ in_array($control->description, $selectedControls) ? 'selected' : '' }} value="{{$control->description}}">{{$control->description}}</option>
            @empty
            @endforelse
        </select>
    </div>
    <div id="discussNoteDiv" class="mb-2 @empty($discussNote) d-none @endempty">
        <x-form.label text="Discuss Note" for="discuss_note"/>
        <textarea name="discuss_note" id="discuss_note" class="form-control" rows="6">{{ $discussNote }}</textarea>
    </div>

    <x-slot name="buttons">
        <button type="submit" id="controlListSubmitBtn" class="btn btn-secondary">Save</button>
        <button type="button" class="btn btn-subtle-danger" data-bs-dismiss="modal">Cancel</button>
    </x-slot>
</x-form>
