<?php

namespace App\DTOs;

use App\Enums\ShiftTypeEnum;
use DateTimeImmutable;

class HealthSafetyReviewCrossCriteriaDto
{
    /**
     * Create a new class instance.
     *
     * @param  int  $cross_criteria_id  Cross criteria identifier
     * @param  int  $shift_id  Shift identifier
     * @param  int  $shift_rotation_id  Shift rotation identifier
     * @param  DateTimeImmutable  $start_date  Shift start date
     * @param  DateTimeImmutable  $end_date  Shift end date
     * @param  ShiftTypeEnum  $shift_type  Type of shift (enum)
     * @param  string  $cell_number  Cell number
     */
    public function __construct(
        public int $cross_criteria_id,
        public int $shift_id,
        public int $shift_rotation_id,
        public DateTimeImmutable $start_date,
        public DateTimeImmutable $end_date,
        public ShiftTypeEnum $shift_type,
        public string $cell_number
    ) {
        //
    }

    public static function fromArray(array $data): self
    {
        return new self(
            cross_criteria_id: $data['cross_criteria_id'],
            shift_id: $data['shift_id'],
            shift_rotation_id: $data['shift_rotation_id'],
            start_date: new DateTimeImmutable($data['start_date']),
            end_date: new DateTimeImmutable($data['end_date']),
            shift_type: ShiftTypeEnum::from($data['shift_type']),
            cell_number: $data['cell_number']
        );
    }
}
