<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $primaryKey = 'assignment_id';
    protected $fillable = ['module_id', 'title', 'weightage', 'description', 'due_date', 'file_path'];

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }

    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class, 'assignment_id');
    }
}