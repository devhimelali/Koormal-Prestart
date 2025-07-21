@props(['name', 'multiple' => false, 'preview' => true, 'value' => []])

@php
    $inputId = Str::uuid();
@endphp

<div class="dropzone border border-secondary rounded p-3 text-center bg-light" id="dropzone-{{ $inputId }}"
    data-input-id="{{ $inputId }}">
    <p class="text-muted mb-0 drop-zone-title">Drag & drop or click to upload {{ $multiple ? 'images' : 'an image' }}</p>
    <input type="file" name="{{ $multiple ? $name . '[]' : $name }}" id="file-input-{{ $inputId }}" class="d-none"
        accept="image/*" {{ $multiple ? 'multiple' : '' }}>
</div>

<div id="preview-{{ $inputId }}" class="d-flex flex-wrap gap-2 mt-2">
    @foreach ($value as $img)
        <div class="position-relative">
            <img src="{{ $img }}" alt="Uploaded" class="img-thumbnail" style="width: 100px; height: 100px;">
            <button type="button"
                class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-preview">&times;</button>
        </div>
    @endforeach
</div>

<style>
    .dropzone {
        min-height: 170px;
        cursor: pointer;
    }

    .dropzone.border-primary {
        border-color: #0d6efd !important;
        background-color: #e7f1ff;
    }

    .remove-preview {
        border-radius: 50% !important;
        padding: 0px 5px !important;
    }

    .drop-zone-title {
        transform: translate(0, 55px);
    }
</style>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropzone = document.getElementById('dropzone-{{ $inputId }}');
            const input = document.getElementById('file-input-{{ $inputId }}');
            const preview = document.getElementById('preview-{{ $inputId }}');
            const allowPreview = {{ $preview ? 'true' : 'false' }};
            const allowMultiple = {{ $multiple ? 'true' : 'false' }};

            dropzone.addEventListener('click', () => input.click());

            dropzone.addEventListener('dragover', e => {
                e.preventDefault();
                dropzone.classList.add('border-primary');
            });

            dropzone.addEventListener('dragleave', () => {
                dropzone.classList.remove('border-primary');
            });

            dropzone.addEventListener('drop', e => {
                e.preventDefault();
                dropzone.classList.remove('border-primary');
                const files = Array.from(e.dataTransfer.files);
                input.files = e.dataTransfer.files;
                if (allowPreview) {
                    showPreviews(files);
                }
            });

            input.addEventListener('change', () => {
                const files = Array.from(input.files);
                if (allowPreview) {
                    showPreviews(files);
                    $('#old-image-preview').html('');
                }
            });

            function showPreviews(files) {
                preview.innerHTML = '';
                files.forEach(file => {
                    if (!file.type.startsWith('image/')) return;

                    const reader = new FileReader();
                    reader.onload = e => {
                        const wrapper = document.createElement('div');
                        wrapper.className = 'position-relative';

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'img-thumbnail';
                        img.style.width = '100px';
                        img.style.height = '100px';

                        const removeBtn = document.createElement('button');
                        removeBtn.className =
                            'btn btn-sm btn-danger position-absolute top-0 end-0 remove-preview';
                        removeBtn.type = 'button';
                        removeBtn.innerHTML = '&times;';
                        removeBtn.onclick = () => {
                            wrapper.remove();
                            // Also clear file input when removing preview if single file mode
                            if (!allowMultiple) input.value = null;
                        };

                        wrapper.appendChild(img);
                        wrapper.appendChild(removeBtn);
                        preview.appendChild(wrapper);
                    };
                    reader.readAsDataURL(file);
                });
            }

            // Remove button handler for initial value previews
            preview.querySelectorAll('.remove-preview').forEach(button => {
                button.addEventListener('click', function() {
                    this.parentElement.remove();
                });
            });
        });
    </script>
@endpush
