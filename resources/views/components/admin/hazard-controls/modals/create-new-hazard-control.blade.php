<x-modal id="createHazardControlModal" title="Create a new control" :staticBackdrop="true"
         size="modal-lg"
         :scrollable="true">
    <x-form action="{{ route('hazard-controls.store') }}" :hasFile="true" id="createHazardControlForm">
        <x-form.input type="hidden" name="_method" id="method" value="POST"/>
        <x-form.input type="hidden" name="fatality_risk_id" id="fatality_risk_id"/>
        <x-form.input type="hidden" name="shift_log_id" id="shift_log_id"/>

        <div class="mb-2">
            <x-form.label for="description" text="Description"/>
            <x-form.text-area name="description"
                              placeholder="Write a short description about the fatality control..."
                              :useCkeditor="true"/>
            <x-form.error :name="'description'"/>
        </div>
        <x-slot name="buttons">
            <button type="submit" id="createHazardControlSubmitBtn" class="btn btn-secondary">Save</button>
            <button type="button" class="btn btn-subtle-danger" data-bs-dismiss="modal">Cancel</button>
        </x-slot>
    </x-form>
</x-modal>
