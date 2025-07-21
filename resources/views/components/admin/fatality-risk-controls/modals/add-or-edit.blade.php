<x-modal id="addFatalityRiskControlModal" title="Create a new fatality risk control" :staticBackdrop="true" size="modal-lg"
    :scrollable="true">
    <x-form action="{{ route('fatality-risk-controls.store') }}" :hasFile="true" id="addFatalityRiskControlForm">
        <div class="mb-2">
            <x-form.label for="name" text="Name" required="true" />
            <x-form.input name="name" type="text" label="Title" placeholder="Enter fatality risk control title"
                id="name" required />
            <x-form.error :name="'name'" />
        </div>
        <x-form.color-picker name="bg_color" label="Background Color" value="#ffcc00" />

        <x-form.select name="status" label="Status" :options="['active' => 'Active', 'inactive' => 'Inactive']" />

        <div class="mb-2">
            <x-form.label for="description" text="Description" />
            <x-form.text-area name="description"
                placeholder="Write a short description about the fatality risk control..." :useCkeditor="true" />
            <x-form.error :name="'description'" />
        </div>
        <div class="mb-2">
            <x-form.label for="photo" text="Photo" required="true" />
            <x-form.image-dropzone name="photo" />
        </div>
        <x-slot name="buttons">
            <button type="submit" id="addFatalityRiskControlSubmitBtn" class="btn btn-secondary">Save</button>
            <button type="button" class="btn btn-subtle-danger" data-bs-dismiss="modal">Cancel</button>
        </x-slot>
    </x-form>

</x-modal>
