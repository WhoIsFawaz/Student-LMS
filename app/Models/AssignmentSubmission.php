<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentSubmission extends Model
{
    use HasFactory;

    protected $primaryKey = 'assignment_submission_id';
    protected $fillable = [
        'assignment_id',
        'user_id',
        'submission_description',
        'submission_files',
        'submission_date',
        'grade',
        'feedback'
    ];

    protected $casts = [
        'submission_files' => 'array',
    ];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class, 'assignment_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}