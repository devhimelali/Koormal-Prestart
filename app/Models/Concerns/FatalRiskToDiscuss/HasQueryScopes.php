<?php

namespace App\Models\Concerns\FatalRiskToDiscuss;

use App\Enums\QuestionTypeEnum;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait HasQueryScopes
{
    public function scopeFilterFatalRiskToDiscuss(Builder $query, Request $request): Builder
    {
        return $query->where('shift_type', $request->shift_type)
            ->where('shift_id', $request->shift_id)
            ->where('start_date', Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d'))
            ->where('end_date', Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d'))
            ->where('fatality_risk_id', $request->fatality_risk_id)
            ->where('date', Carbon::now()->format('Y-m-d'));
    }
}
