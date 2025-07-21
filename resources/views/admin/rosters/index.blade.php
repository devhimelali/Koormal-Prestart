@extends('layouts.app')
@section('title', 'Roster List')
@section('content')
    <x-common.breadcrumb :title="'Roster List'" :breadcrumbs="[['label' => 'Dashboard', 'url' => route('redirect')], ['label' => 'Roster List']]" />
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Roster List</h4>
                    <div class="d-flex align-items-center gap-2">
                        <label for="date-range" class="form-label" style="width: 110px;">Date Range:</label>
                        <input type="text" name="date_range" class="form-control" id="date-range">
                    </div>
                </div>
                <div class="card-body">
                    <x-table id="scheduleTable" :thead="[
                        [
                            'label' => '#',
                            'class' => 'th-sn',
                        ],
                        [
                            'label' => 'Start Date - End Date',
                            'class' => 'th-range',
                        ],
                        [
                            'label' => 'Shift',
                        ],
                        [
                            'label' => 'Crew',
                        ],
                        [
                            'label' => 'Actions',
                            'class' => 'th-actions',
                        ],
                    ]">
                        @foreach ($blocks as $day)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ $day['start_date'] }} - {{ $day['end_date'] }}</td>
                                <td>Day</td>
                                <td>{{ $day['day_shift'] }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-secondary viewBoard"
                                        data-start_date="{{ $day['start_date'] }}" data-end_date="{{ $day['end_date'] }}"
                                        data-crew="{{ $day['day_shift'] }}" data-shift="day">View Board</a>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ $day['start_date'] }} - {{ $day['end_date'] }}</td>
                                <td>Night</td>
                                <td>{{ $day['night_shift'] }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-secondary viewBoard"
                                        data-start_date="{{ $day['start_date'] }}" data-end_date="{{ $day['end_date'] }}"
                                        data-crew="{{ $day['night_shift'] }}" data-shift="night">View
                                        Board</a>
                                </td>
                            </tr>
                        @endforeach
                    </x-table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script>
        flatpickr("#date-range", {
            mode: "range",
            dateFormat: "d-m-Y",
            onClose: function(selectedDates, dateStr, instance) {
                if (selectedDates.length === 2) {
                    let startDate = flatpickr.formatDate(selectedDates[0], "Y-m-d");
                    let endDate = flatpickr.formatDate(selectedDates[1], "Y-m-d");

                    fetchSchedule(startDate, endDate);
                }
            }
        });
        // health-safety-review.index
        $(document).on('click', '.viewBoard', function(e) {
            let start_date = $(this).data('start_date');
            let end_date = $(this).data('end_date');
            let crew = $(this).data('crew');
            let shift = $(this).data('shift');
            window.location.href = "{{ route('boards.index') }}?start_date=" + start_date +
                "&end_date=" + end_date +
                "&crew=" + crew + "&shift=" + shift;
        });

        function fetchSchedule(startDate, endDate) {
            $.ajax({
                url: "{{ route('roster.fetch') }}", // Define this route
                method: 'GET',
                data: {
                    start_date: startDate,
                    end_date: endDate
                },
                success: function(response) {
                    let tbody = $("#scheduleTable tbody");
                    tbody.empty();
                    let sn = 1;

                    response.forEach(function(day) {
                        tbody.append(`
                            <tr>
                                <td>${sn}</td>
                                <td>${day.start_date} - ${day.end_date}</td>
                                <td>Day</td>
                                <td>${day.day_shift}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-secondary viewBoard">View Board</a>
                                </td>
                            </tr>
                            <tr>
                                <td>${sn}</td>
                                <td>${day.start_date} - ${day.end_date}</td>
                                <td>Night</td>
                                <td>${day.night_shift}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-secondary viewBoard">View Board</a>
                                </td>
                            </tr>
                        `);
                        sn++;
                    });
                },
                error: function(xhr) {
                    alert("Failed to load schedule.");
                }
            });
        }
    </script>
@endsection
@section('page-css')
    <style>
        .th-actions {
            min-width: 120px;
            width: 120px;
        }

        @media only screen and (max-width: 480px) {
            .card-header {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 10px;
            }

            .th-range {
                min-width: 200px;
            }
        }
    </style>
@endsection
