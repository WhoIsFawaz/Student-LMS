<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $primaryKey = 'quiz_questions_id';
    protected $table = 'quiz_questions';

    protected $fillable = [
        'quiz_id', 'question', 'option_a', 'option_b', 'option_c', 'option_d', 'correct_option', 'marks'
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id', 'quiz_id');
    }
}

