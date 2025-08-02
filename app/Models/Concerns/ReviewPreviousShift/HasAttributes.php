<?php

namespace App\Models\Concerns\ReviewPreviousShift;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasAttributes
{
    /**
     * Get the start date of the health and safety review in the format 'd-m-Y'
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function startDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d-m-Y'),
        );
    }

    /**
     * Get the end date of the health and safety review in the format 'd-m-Y'
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function endDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d-m-Y'),
        );
    }

    /**
     * Get the date of the health and safety review in the format 'd-m-Y'
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function date(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d-m-Y')
        );
    }
}
