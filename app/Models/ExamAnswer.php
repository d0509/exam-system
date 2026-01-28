<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ExamResult;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamAnswer extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'exam_result_id',
        'question_id',
        'selected_answer_id',
        'is_correct'
    ];

    public function examResult()
    {
        return $this->belongsTo(ExamResult::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function selectedAnswer()
    {
        return $this->belongsTo(Answer::class, 'selected_answer_id');
    }
}
