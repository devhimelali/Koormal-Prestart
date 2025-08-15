<?php

namespace App\Models\Concerns\SiteCommunication;

use App\Enums\QuestionTypeEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait HasQueryScopes
{
    public function scopeFilterCommunication(Builder $query, Request $request): Builder
    {
        return $query->where('shift_type', $request->shift_type)
            ->where('shift_id', $request->shift_id)
            ->where('start_date', Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d'))
            ->where('end_date', Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d'))
            ->where('date', Carbon::now()->format('Y-m-d'));
    }
}
