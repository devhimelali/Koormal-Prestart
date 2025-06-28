<label for="linked_shift_id" class="form-label">
    Linked Shift
    <span class="text-muted">(Optional)</span>
</label>
<select class="form-select" id="linked_shift_id" name="linked_shift_id">
    <option value="">Select a linked shift</option>
    @foreach ($shifts as $shift)
        <option value="{{ $shift->id }}">{{ $shift->name }}</option>
    @endforeach
</select>
