@props([
    'name',
    'id' => $name,
    'placeholder' => '',
    'value' => old($name),
    'required' => false,
    'rows' => 5,
    'useCkeditor' => false,
])

<textarea name="{{ $name }}" id="{{ $id }}"
          class="form-control @error($name) is-invalid @enderror {{ $useCkeditor ? 'ckeditor' : '' }}"
          rows="{{ $rows }}" placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }}>{{ $value }}</textarea>

@if ($useCkeditor)
    @once
        @push('scripts')
            <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
        @endpush
    @endonce

    @push('scripts')
        <script>
            class LaravelUploadAdapter {
                constructor(loader) {
                    this.loader = loader;
                }

                upload() {
                    return this.loader.file
                        .then(file => new Promise((resolve, reject) => {
                            const data = new FormData();
                            data.append('upload', file);
                            data.append('_token', '{{ csrf_token() }}');

                            fetch('{{ route('ckeditor.upload') }}', {
                                method: 'POST',
                                body: data,
                            })
                                .then(response => response.json())
                                .then(result => {
                                    if (result.url) {
                                        resolve({
                                            default: result.url
                                        });
                                    } else {
                                        reject(result.message || 'Upload failed');
                                    }
                                })
                                .catch(reject);
                        }));
                }

                abort() {
                    // Not implemented
                }
            }

            function LaravelUploadAdapterPlugin(editor) {
                editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                    return new LaravelUploadAdapter(loader);
                };
            }

            document.addEventListener('DOMContentLoaded', function () {
                ClassicEditor
                    .create(document.querySelector('#{{ $id }}'), {
                        extraPlugins: [LaravelUploadAdapterPlugin],
                    })
                    .then(editor => {
                        window.editors = window.editors || {};
                        window.editors['{{ $id }}'] = editor;
                    })
                    .catch(error => console.error(error));
            });
        </script>
    @endpush
@endif
