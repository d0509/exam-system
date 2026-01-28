<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'question_id',
        'answer',
        'is_correct',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];
}
