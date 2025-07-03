@extends('layouts.app')
@section('title', 'Roster List')
@section('content')
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
                    <div class="table-responsive">
                        <table class="table table-centered align-middle mb-0 table-hover" id="scheduleTable">
                            <thead class="table-active">
                                <tr>
                                    <th scope="col">Date</th>
                                    <th scope="col">Shift</th>
                                    <th scope="col">Crew</th>
                                    <th scope="col">Shift</th>
                                    <th scope="col">Crew</th>
                                    <th scope="col" style="min-width: 260px; width: 260px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody style="vertical-align: middle">
                                @foreach ($dailySchedule as $day)
                                    <tr>
                                        <td>{{ $day['date'] }}</td>
                                        <td>Day</td>
                                        <td>{{ $day['day_shift'] }}</td>
                                        <td>Night</td>
                                        <td>{{ $day['night_shift'] }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="#" class="btn btn-sm btn-primary">View Day Board</a>
                                                <a href="#" class="btn btn-sm btn-secondary">View Night Board</a>
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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

                    response.forEach(function(day) {
                        tbody.append(`
                            <tr>
                                <td>${day.date}</td>
                                <td>Day</td>
                                <td>${day.day_shift}</td>
                                <td>Night</td>
                                <td>${day.night_shift}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="#" class="btn btn-sm btn-primary">View Day Board</a>
                                        <a href="#" class="btn btn-sm btn-secondary">View Night Board</a>
                                    </div>
                                </td>
                            </tr>
                        `);
                    });
                },
                error: function(xhr) {
                    alert("Failed to load schedule.");
                }
            });
        }
    </script>
@endsection
