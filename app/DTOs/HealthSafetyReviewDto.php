<?php

namespace App\DTOs;

use App\Enums\QuestionTypeEnum;
use App\Enums\ShiftTypeEnum;
use DateTimeImmutable;

class HealthSafetyReviewDto
{
    /**
     * Create a new class instance.
     *
     * @param int $shift_id Shift identifier
     * @param int $daily_shift_entry_id Daily shift entry identifier
     * @param DateTimeImmutable $start_date Shift start date
     * @param DateTimeImmutable $end_date Shift end date
     * @param DateTimeImmutable $date Review date
     * @param ShiftTypeEnum $shift_type Type of shift (enum)
     * @param QuestionTypeEnum $question_number Question identifier (enum)
     * @param string|null $answer Answer to the question (nullable)
     */
    public function __construct(
        public int $shift_id,
        public int $daily_shift_entry_id,
        public DateTimeImmutable $start_date,
        public DateTimeImmutable $end_date,
        public DateTimeImmutable $date,
        public ShiftTypeEnum $shift_type,
        public QuestionTypeEnum $question_number,
        public ?string $answer = null
    ) {
        //
    }

    public static function fromArray(array $data): self
    {
        return new self(
            shift_id: $data['shift_id'],
            daily_shift_entry_id: $data['daily_shift_entry_id'],
            start_date: new DateTimeImmutable($data['start_date']),
            end_date: new DateTimeImmutable($data['end_date']),
            date: new DateTimeImmutable($data['date']),
            shift_type: ShiftTypeEnum::from($data['shift_type']),
            question_number: QuestionTypeEnum::from($data['question_number']),
            answer: $data['answer'] ?? null
        );
    }
}
