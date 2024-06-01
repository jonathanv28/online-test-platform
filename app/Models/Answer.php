<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = [
        'question_id',
        'option_text',
        'is_correct',
        'start_time',
        'end_time',
    ];

    public function questions()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
