<x-modal id="addFatalityControlModal" title="Create a new fatality control" :staticBackdrop="true"
         size="modal-lg"
         :scrollable="true">
    <x-form action="{{ route('fatality-controls.store') }}" :hasFile="true" id="addFatalityControlForm">
        <x-form.input type="hidden" name="_method" id="method" value="POST"/>
        <div class="mb-2">
            <x-form.label for="name" text="Name" required="true"/>
            <x-form.select name="fatality_risk_id" id="fatality_risk_id" options="{{}}" placeholder="Select a fatality risk"/>
            <x-form.input name="name" type="text" label="Title" placeholder="Enter fatality control title"
                          id="name" required/>
            <x-form.error :name="'name'"/>
        </div>

        <div class="mb-2">
            <x-form.label for="description" text="Description"/>
            <x-form.text-area name="description"
                              placeholder="Write a short description about the fatality control..."
                              :useCkeditor="true"/>
            <x-form.error :name="'description'"/>
        </div>
        <x-slot name="buttons">
            <button type="submit" id="addFatalityControlSubmitBtn" class="btn btn-secondary">Save</button>
            <button type="button" class="btn btn-subtle-danger" data-bs-dismiss="modal">Cancel</button>
        </x-slot>
    </x-form>

</x-modal>
