@extends('layouts.app')
@section('title', 'Shift Rotation Configuration')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Shift Rotation Configuration</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('shift-rotations.update') }}">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label" for="start_date">Start Date:</label>
                                <input type="text" name="start_date" class="form-control flatpickr" id="start_date"
                                    value="{{ old('start_date', optional($rotation)->start_date) }}" required>
                            </div>
                            <div class="col-6">
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
    <script>
        flatpickr("#start_date", {
            dateFormat: "d-m-Y"
        });
    </script>
@endsection
