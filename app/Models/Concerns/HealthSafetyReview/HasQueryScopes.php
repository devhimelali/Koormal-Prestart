<?php

namespace App\Models\Concerns\HealthSafetyReview;

use App\Enums\QuestionTypeEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait HasQueryScopes
{
    /**
     * Scope a query to only include question one for the given request.
     *
     * @param  Builder  $query
     * @param  Request  $request
     * @return Builder
     */
    public function scopeQuestionOne(Builder $query, Request $request): Builder
    {
        return $query->where('question_number', QuestionTypeEnum::QUESTION_ONE)
            ->where('shift_type', $request->shift_type)
            ->where('shift_id', $request->shift_id)
            ->where('start_date', Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d'))
            ->where('end_date', Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d'));
    }


    /**
     * Scope a query to only include question two for the given request.
     *
     * @param  Builder  $query  The query builder instance.
     * @param  Request  $request  The request containing filtering parameters.
     * @return Builder
     */
    public function scopeQuestionTwo(Builder $query, Request $request): Builder
    {
        return $query->where('question_number', QuestionTypeEnum::QUESTION_TWO)
            ->where('shift_type', $request->shift_type)
            ->where('shift_id', $request->shift_id)
            ->where('start_date', Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d'))
            ->where('end_date', Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d'));
    }
}
