@extends('layouts.app')
@section('title', 'Shift Rotation Configuration')
@section('content')
    <x-common.breadcrumb :title="'Shift Rotations'" :breadcrumbs="[['label' => 'Dashboard', 'url' => route('redirect')], ['label' => 'Shift Rotations']]" />
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Shift Rotation Configuration</h4>
                    @if ($isActive)
                        <button type="button" id="stopRotationBtn" class="btn btn-danger d-flex align-items-center gap-1">
                            <i class="ph ph-prohibit"></i>
                            Stop
                        </button>
                    @endif
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('shift-rotations.update') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label class="form-label" for="start_date">Start Date:</label>
                                <input type="text" name="start_date" class="form-control flatpickr" id="start_date"
                                    value="{{ old('start_date', optional($rotation)->start_date) }}" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label" for="rotation_days">Rotation Days (e.g. 7):</label>
                                <input type="number" name="rotation_days" class="form-control" id="rotation_days"
                                    min="1" value="{{ old('rotation_days', optional($rotation)->rotation_days) }}"
                                    required>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-secondary">Save Rotation</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        flatpickr("#start_date", {
            dateFormat: "d-m-Y"
        });

        $('#stopRotationBtn').on('click', function() {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, stop it!',
                confirmButtonColor: '#dc3545',
            }).then((result) => {
                if (result.isConfirmed) {
                    stopRotation();
                }
            });
        });

        function stopRotation() {
            $.ajax({
                url: "{{ route('shift-rotations.stop') }}",
                type: 'GET',
                beforeSend: function() {
                    ajaxBeforeSend('#stopRotationBtn', '#stopRotationBtn');
                },
                success: function(response) {
                    notify('success', response.message);
                    setTimeout(function() {
                        window.location.href = "{{ route('shift-rotations.edit') }}";
                    }, 1000);
                },
                error: handleAjaxErrors,
                complete: function() {
                    ajaxComplete('#stopRotationBtn', '<i class="ph ph-prohibit"></i> Stop');
                }
            });
        };
    </script>
@endsection
