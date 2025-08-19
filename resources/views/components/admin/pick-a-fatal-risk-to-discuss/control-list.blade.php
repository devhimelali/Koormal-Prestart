<x-form action="{{ route('store-fatality-control') }}" :hasFile="false" id="controlListForm">
    <x-form.input type="hidden" name="fatality_risk_id" id="fatality_risk_id" value="{{ $fatalityRisk->id }}"/>

    <div class="mb-2">
        <x-form.label text="Control" for="control"/>
        <select name="control" id="control" class="form-select">
            <option value="">Select Control</option>
            @forelse($controls as $control)
                <option value="{{$control->description}}">{{$control->description}}</option>
            @empty
            @endforelse
        </select>
    </div>
    <div class="mb-2 d-none" id="discussNoteDiv">
        <x-form.label text="Discuss Note" for="discuss_note"/>
        <textarea name="discuss_note" id="discuss_note" class="form-control" rows="6"></textarea>
    </div>

    <x-slot name="buttons">
        <button type="submit" id="controlListSubmitBtn" class="btn btn-secondary">Save</button>
        <button type="button" class="btn btn-subtle-danger" data-bs-dismiss="modal">Cancel</button>
    </x-slot>
</x-form>
