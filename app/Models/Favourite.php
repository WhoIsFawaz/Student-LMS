<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    use HasFactory;

    protected $primaryKey = 'favourite_id';

    protected $fillable = ['user_id', 'module_id', 'content_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }

    public function content()
    {
        return $this->belongsTo(ModuleContent::class, 'content_id');
    }
}
