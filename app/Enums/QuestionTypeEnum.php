<?php

namespace App\Enums;

enum QuestionTypeEnum: string
{
    case QUESTION_ONE = 'question_one';
    case QUESTION_TWO = 'question_two';

    public function label(): string
    {
        return match ($this) {
            self::QUESTION_ONE => 'Question One',
            self::QUESTION_TWO => 'Question Two',
        };
    }
}
