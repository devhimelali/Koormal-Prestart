@extends('layouts.app')
@section('title', 'Boards History')
@section('content')
    <x-common.breadcrumb :title="'Boards History'"
                         :breadcrumbs="[['label' => 'Dashboard', 'url' => route('redirect')], ['label' => 'Boards History']]"/>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div>
                                <label for="date-range" class="form-label">Select Date Range</label>
                                <input type="text" name="date_range" class="form-control" id="date-range">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div>
                                <label for="crew" class="form-label">Crew</label>
                                <select name="crew" id="crew" class="form-select">
                                    <option value="">Select Crew</option>
                                    @forelse($crews as $crew)
                                        <option value="{{ $crew->name }}">{{ $crew->name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div>
                                <label for="shift" class="form-label">Shift</label>
                                <select name="shift" id="shift" class="form-select">
                                    <option value="">Select Shift</option>
                                    <option value="day">Day Shift</option>
                                    <option value="night">Night Shift</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button
                                class="btn btn-secondary d-flex align-items-center justify-content-center gap-2 w-100 mt-md-4">
                                <i class="ph ph-magnifying-glass"></i>
                                Search Board
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
