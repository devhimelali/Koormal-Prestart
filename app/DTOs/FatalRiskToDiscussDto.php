<?php

namespace App\DTOs;

use App\Enums\ShiftTypeEnum;
use DateTimeImmutable;

class FatalRiskToDiscussDto
{
    /**
     * Create a new class instance.
     *
     * @param  int  $fatality_risk_id  fatality risk identifier
     * @param  int  $shift_id  Shift identifier
     * @param  int  $shift_rotation_id  Shift rotation identifier
     * @param  DateTimeImmutable  $start_date  Shift start date
     * @param  DateTimeImmutable  $end_date  Shift end date
     * @param  ShiftTypeEnum  $shift_type  Type of shift (enum)
     * @param  ?string  $discuss_note  Discuss note
     * @param  array  $controls  Controls
     */
    public function __construct(
        public int $fatality_risk_id,
        public int $shift_id,
        public int $shift_rotation_id,
        public DateTimeImmutable $start_date,
        public DateTimeImmutable $end_date,
        public ShiftTypeEnum $shift_type,
        public ?string $discuss_note = null,
        public array $controls
    ) {
        //
    }

    public static function fromArray(array $data): self
    {
        return new self(
            fatality_risk_id: $data['fatality_risk_id'],
            shift_id: $data['shift_id'],
            shift_rotation_id: $data['shift_rotation_id'],
            start_date: new DateTimeImmutable($data['start_date']),
            end_date: new DateTimeImmutable($data['end_date']),
            shift_type: ShiftTypeEnum::from($data['shift_type']),
            discuss_note: $data['discuss_note'],
            controls: $data['controls']
        );
    }
}
