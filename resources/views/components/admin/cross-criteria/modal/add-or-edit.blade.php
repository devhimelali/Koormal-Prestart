<x-modal id="addOrEditModal" title="Create a new cross criteria" :staticBackdrop="true" size="modal-lg">
    <x-form action="{{ route('cross-criteria.store') }}" id="addOrEditForm">
        <x-form.input type="hidden" name="_method" id="method" value="POST" />
        <div class="row">
            <div class="col-md-6 mb-2">
                <x-form.label for="name" text="Title" required="true" />
                <x-form.input type="text" name="name" id="name" placeholder="Enter cross criteria title"
                    :required="true" />
                <x-form.error :name="'name'" />
            </div>
            <div class="col-md-6 mb-2">
                <x-form.label for="color" text="Color Code" required="true" />
                <x-form.color-picker name="color" id="color" :required="true" />
                <x-form.error :name="'color'" />
            </div>
            <div class="col-md-12 mb-2">
                <x-form.label for="description" text="Description" />
                <x-form.text-area name="description" id="description"
                    placeholder="Write a short description about the cross criteria..." :useCkeditor="true" />
                <x-form.error :name="'description'" />
            </div>
        </div>
        <x-slot name="buttons">
            <button type="submit" id="addOrEditSubmitBtn" class="btn btn-secondary">Save</button>
            <button type="button" class="btn btn-subtle-danger" data-bs-dismiss="modal">Cancel</button>
        </x-slot>
    </x-form>
</x-modal>
