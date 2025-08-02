<?php

namespace App\Models\Concerns\HealthSafetyCrossCriteria;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait HasQueryScopes
{
    /**
     * Scope a query to only include records for the given shift type and
     * shift ID, and between the given start and end dates.
     *
     * @param  Builder  $query
     * @param  Request  $request
     * @return Builder
     */
    public function scopeFilterSafetyCalendar(Builder $query, Request $request): Builder
    {
        return $query->where('shift_type', $request->shift_type)
            ->where('shift_id', $request->shift_id)
            ->where('start_date', Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d'))
            ->where('end_date', Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d'));
    }
}
