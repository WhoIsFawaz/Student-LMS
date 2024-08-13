<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teaches extends Model
{
    use HasFactory;

    protected $primaryKey = 'teaches_id';
    protected $fillable = ['user_id', 'module_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }
}