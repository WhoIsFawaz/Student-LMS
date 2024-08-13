<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $primaryKey = 'grade_id';
    protected $fillable = ['user_id', 'assignment_id', 'grade', 'score', 'feedback'];

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assignment()
    {
        return $this->belongsTo(Assignment::class, 'assignment_id');
    }
}