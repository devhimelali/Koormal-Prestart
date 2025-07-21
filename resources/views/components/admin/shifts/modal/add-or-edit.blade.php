<x-modal id="addOrEditShiftModal" title="Create a new shift" :staticBackdrop="true">
    <x-form action="{{ route('shifts.store') }}" id="shiftAddForm">
        <x-form.input type="hidden" name="_method" id="method" value="POST" />

        <div class="mb-2">
            <x-form.label for="name" text="Name" required="true" />
            <x-form.input type="text" name="name" id="name" placeholder="Enter shift name"
                :required="true" />
            <x-form.error :name="'name'" />
        </div>
        <div class="mb-2">
            <x-form.label for="linked_shift_id" text="Linked Shift" />
            <x-form.select name="linked_shift_id" id="linked_shift_id" placeholder="Select a linked shift" />
            <x-form.error :name="'linked_shift_id'" />
        </div>

        <x-slot name="buttons">
            <button type="submit" id="addOrEditSubmitBtn" class="btn btn-secondary">Save</button>
            <button type="button" class="btn btn-subtle-danger" data-bs-dismiss="modal">Cancel</button>
        </x-slot>
    </x-form>
</x-modal>
