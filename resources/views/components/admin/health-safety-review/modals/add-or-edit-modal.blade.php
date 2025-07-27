<!-- right offcanvas -->
<div class="offcanvas offcanvas-end" data-bs-scroll="true" data-bs-backdrop="true" tabindex="-1" id="addOrEditOffCanvas"
     aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Review of Health & Safety</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form action="{{ route('health-safety-review.store') }}" method="POST" id="addOrEditForm">
            @csrf
            <input type="hidden" name="shift_id" id="shift_id" value="{{ $shift_id }}">
            <input type="hidden" name="rotation_id" id="rotation_id" value="{{ $rotation_id }}">
            <input type="hidden" name="shift_type" id="shift_type" value="{{ $shift_type }}">
            <div class="mb-2">
                <label for="date" class="form-label">Date</label>
                <input type="text" name="date" id="date" class="form-control">
            </div>
            <div class="mb-2">
                <label for="supervisor_name" class="form-label">Supervisor Name</label>
                <input type="text" name="supervisor_name" id="supervisor_name" class="form-control">
            </div>
            <div class="mb-2">
                <div>
                    <label for="question-one" class="form-label">Question 1 - What did we do to work more safely or
                        improve
                        our health on our last shift?
                        <span class="play-icon"
                              data-audio="{{ asset('assets/audios/our-health-safety/question-one.mp3') }}">
                            <i class="ph ph-play-circle"></i>
                        </span>
                    </label>
                </div>
                <textarea name="question_one" id="question-one" cols="30" rows="5" class="form-control"></textarea>
            </div>
            <div class="mb-2">
                <div>
                    <label for="question-two" class="form-label">Question 1 - What did we do to work more safely or
                        improve
                        our health on our last shift?
                        <span class="play-icon"
                              data-audio="{{ asset('assets/audios/our-health-safety/question-two.mp3') }}">
                            <i class="ph ph-play-circle"></i>
                        </span>
                    </label>
                </div>
                <textarea name="question_two" id="question-two" cols="30" rows="5" class="form-control"></textarea>
            </div>
            <div class="d-flex justify-content-between align-items-center gap-2 mt-2">
                <button type="submit" class="btn btn-secondary w-50" id="formSubmitBtn">Save</button>
                <button type="button" class="btn btn-danger w-50" data-bs-dismiss="offcanvas">Close</button>
            </div>
        </form>
    </div>
</div>
