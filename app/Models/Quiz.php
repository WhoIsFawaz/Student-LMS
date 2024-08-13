<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $primaryKey = 'quiz_id';
    protected $table = 'quiz';

    protected $fillable = [
        'module_id', 'quiz_title', 'quiz_description', 'quiz_date', 'duration'
    ];

    public function questions()
    {
        return $this->hasMany(QuizQuestion::class, 'quiz_id', 'quiz_id');
    }

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }
}
?>