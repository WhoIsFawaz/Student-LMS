<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $primaryKey = 'quiz_attempt_id';
    protected $table = 'quiz_attempt';

    protected $fillable = [
        'quiz_id', 'user_id', 'total_marks', 'grade', 'feedback'
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id', 'quiz_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
