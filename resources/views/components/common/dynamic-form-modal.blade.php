<div class="modal fade" id="{{ $id ?? 'dynamicModal' }}" tabindex="-1"
     aria-labelledby="{{ $id ?? 'dynamicModal' }}Label"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light py-2">
                <h5 class="modal-title" id="{{ $id ?? 'dynamicModal' }}Label">{{ $title ?? 'Form Title' }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="{{ $formId ?? 'dynamicForm' }}" method="POST">
                @csrf
                <input type="hidden" name="_method" value="POST" id="method">
                <div class="modal-body" id="formFieldsContainer">
                    {{-- Dynamic input fields will be appended here by JS --}}
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary"
                            id="formSubmitBtn">{{ $submitText ?? 'Save' }}</button>
                    <button type="button" class="btn btn-subtle-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
