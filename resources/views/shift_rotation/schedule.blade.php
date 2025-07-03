@extends('layouts.app')
@section('title', 'Schedule')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Schedule</h4>
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
