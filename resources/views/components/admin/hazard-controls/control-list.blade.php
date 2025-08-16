<x-form action="{{ route('store-fatality-control') }}" :hasFile="true" id="assignFatalityControlForm">
    <x-form.input type="hidden" name="_method" id="method" value="POST"/>
    <x-form.input type="hidden" name="fatality_risk_id" id="fatality_risk_id" value="{{ $fatalityRiskId }}"/>
    <x-form.input type="hidden" name="shift_log_id" id="shift_log_id" value="{{ $shiftLogId }}"/>
    @forelse($fatalityControls as $control)
        <div class="form-check mb-2">
            <input type="checkbox"
                   class="form-check-input"
                   id="control_{{ $control->id }}"
                   name="controls[]"
                   value="{{ $control->description }}"
                   @if(in_array($control->description, $savedControls)) checked @endif>
            <label class="form-check-label" for="control_{{ $control->id }}">
                {!! $control->description !!}
            </label>
        </div>
    @empty
    @endforelse
    <x-slot name="buttons">
        <button type="submit" id="assignFatalityControlSubmitBtn" class="btn btn-secondary">Save</button>
        <button type="button" class="btn btn-subtle-danger" data-bs-dismiss="modal">Cancel</button>
    </x-slot>
</x-form>
