<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $primaryKey = 'enrollment_id';
    protected $fillable = ['user_id', 'module_id', 'enrollment_date'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }
}