<?php

namespace App\DTOs;

use App\Enums\ShiftTypeEnum;
use DateTimeImmutable;

class SiteCommunicationDto
{
    /**
     * Create a new class instance.
     *
     * @param  int  $shift_id  Shift identifier
     * @param  int  $shift_rotation_id  Shift rotation identifier
     * @param  DateTimeImmutable  $start_date  Shift start date
     * @param  DateTimeImmutable  $end_date  Shift end date
     * @param  ShiftTypeEnum  $shift_type  Type of shift (enum)
     * @param  string|null  $note  Note to the question (nullable)
     * @param  DateTimeImmutable|null  $date  Date of the review
     */
    public function __construct(
        public int $shift_id,
        public int $shift_rotation_id,
        public DateTimeImmutable $start_date,
        public DateTimeImmutable $end_date,
        public ShiftTypeEnum $shift_type,
        public ?string $note,
        public ?DateTimeImmutable $date
    ) {
        //
    }


    public static function fromArray(array $data): self
    {
        return new self(
            shift_id: $data['shift_id'],
            shift_rotation_id: $data['shift_rotation_id'],
            start_date: new DateTimeImmutable($data['start_date']),
            end_date: new DateTimeImmutable($data['end_date']),
            shift_type: ShiftTypeEnum::from($data['shift_type']),
            note: $data['note'] ?? null,
            date: $data['date'] ? new DateTimeImmutable($data['date']) : null
        );
    }
}
