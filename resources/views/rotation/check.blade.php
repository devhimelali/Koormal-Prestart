@extends('layouts.app')

@section('content')
    <h2>Check Shift on a Date</h2>
    <form method="POST" action="{{ route('rotation.check.result') }}">
        @csrf
        <label>Date:</label>
        <input type="date" name="date" value="{{ old('date') }}" required>

        <label>Type:</label>
        <select name="type" required>
            <option value="day">Day</option>
            <option value="night">Night</option>
        </select>

        <button type="submit">Check</button>
    </form>

    @if (isset($result))
        <h3>Result</h3>
        <p>Date: {{ $date }}</p>
        <p>Shift Type: {{ ucfirst($type) }}</p>
        <p>Shift: {{ $result?->name ?? 'N/A' }}</p>
    @endif
@endsection
