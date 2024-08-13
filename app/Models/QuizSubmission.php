<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizSubmission extends Model
{
    use HasFactory;

    protected $primaryKey = 'quiz_submission_id';
    protected $table = 'quiz_submissions';

    protected $fillable = [
        'quiz_questions_id', 'user_id', 'submission_answer'
    ];

    public function question()
    {
        return $this->belongsTo(QuizQuestion::class, 'quiz_questions_id', 'quiz_questions_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
