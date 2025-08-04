<div class="board">
    <!-- Header with Logos and Title -->
    <div class="row align-items-center board-header mb-3">
        <div class="col-2 col-md-2 text-start text-md-center mb-2 mb-md-0">
            <img src="{{ asset('assets/logos/4emus-logo.png') }}" class="img-fluid header-logo float-start">
        </div>
        <div class="col-8 col-md-8 text-center">
            <h5 class="board-title mb-0">Review of Health & Safety</h5>
        </div>
        <div class="col-2 col-md-2 text-end text-md-center">
            <img src="{{ asset('assets/logos/koormal-logo.png') }}" class="img-fluid header-logo float-end">
        </div>
    </div>
    <div class="row my-4">
        <!-- Question 1 -->
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-2">
                <h6>Question 2 - What wasn’t as healthy or safe as it should have been on our last
                    shift?<span class="play-icon"
                                data-audio="{{ asset('assets/audios/our-health-safety/question-two.mp3') }}">
                        <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-1phnduy" focusable="false"
                             aria-hidden="true" viewBox="0 0 24 24">
                            <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2M9.5 16.5v-9l7 4.5z">
                            </path>
                        </svg>
                    </span>
                </h6>
                @if(!$disabled)
                    <button type="button" class="btn btn-sm btn-success d-flex align-items-center gap-1"
                            id="addQuestionTwoBtn">
                        <i class="ph ph-plus"></i>
                    </button>
                @endif
            </div>

            <div class="table-responsive">
                <table class="table table-bordered text-nowrap">
                    <tbody>
                    @forelse ($healthSafetyReview as $review)
                        @php
                            $today = \Carbon\Carbon::now()->format('d-m-Y');
                            $isNotEditable = $review->date !== $today;
                        @endphp
                        <tr class="align-middle">
                            <td class="bg-light td-date">
                                {{ $review->date }}
                                ({{ \Carbon\Carbon::parse($review->date)->format('l') }})
                            </td>
                            <td class="p-1 align-top w-auto">
                                <div contenteditable="{{($disabled || $isNotEditable) ? 'false' : 'true'}}"
                                     class="{{($disabled || $isNotEditable) ? '': 'question-two'}}"
                                     data-date="{{ $review->date }}"
                                     style="border: 1px solid #ccc; padding: 6px 8px; min-height: 25px; width: 100%; box-sizing: border-box; word-break: break-word; overflow-wrap: break-word; white-space: normal; background-color: #fff; border-radius: 4px;">
                                    {{ $review->answer }}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No data found</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="d-flex align-items-center justify-content-between">
        <button type="button" class="btn btn-sm btn-danger d-flex align-items-center gap-1" id="previousStepBtn">
            <i class="bi bi-caret-left-fill"></i>
            Previous
        </button>
        <button type="button" class="btn btn-sm btn-secondary d-flex align-items-center gap-1" id="nextStepBtn">
            Next
            <i class="bi bi-caret-right-fill"></i>
        </button>
    </div>
</div>

<script>
    $('.play-icon').on('click', function () {
        let $iconWrapper = $(this);
        let $icon = $iconWrapper.find('i');
        let audioSrc = $iconWrapper.data('audio');

        // Stop current audio if playing something else
        if (currentAudio && currentAudio.src !== audioSrc) {
            currentAudio.pause();
            currentAudio.currentTime = 0;

            if (currentIcon) {
                currentIcon.removeClass('ph-pause-circle').addClass('ph-play-circle');
            }
            if (currentWrapper) {
                currentWrapper.removeClass('active');
            }
        }

        if (!currentAudio || currentAudio.src !== audioSrc) {
            currentAudio = new Audio(audioSrc);
            currentIcon = $icon;
            currentWrapper = $iconWrapper;

            currentAudio.play();
            $icon.removeClass('ph-play-circle').addClass('ph-pause-circle');
            $iconWrapper.addClass('active');
        } else if (!currentAudio.paused) {
            currentAudio.pause();
            $icon.removeClass('ph-pause-circle').addClass('ph-play-circle');
            $iconWrapper.removeClass('active');
        } else {
            currentAudio.play();
            $icon.removeClass('ph-play-circle').addClass('ph-pause-circle');
            $iconWrapper.addClass('active');
        }

        currentAudio.onended = function () {
            $icon.removeClass('ph-pause-circle').addClass('ph-play-circle');
            $iconWrapper.removeClass('active');
            currentAudio = null;
            currentIcon = null;
            currentWrapper = null;
        };
    });

    $('#previousStepBtn').on('click', function () {
        currentStep = 1;
        updateBoard(currentStep);
    })

    $('#nextStepBtn').on('click', function () {
        currentStep = 3;
        updateBoard(currentStep);
    })
</script>
