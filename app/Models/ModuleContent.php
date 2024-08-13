<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ModuleContent extends Model
{
    use HasFactory;

    protected $primaryKey = 'content_id';
    protected $fillable = ['module_folder_id', 'title', 'description', 'file_path'];

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id', 'module_id');
    }

    public function folder()
    {
        return $this->belongsTo(ModuleFolder::class, 'module_folder_id', 'module_folder_id');
    }

    public function favourites()
    {
        return $this->hasMany(Favourite::class, 'content_id', 'content_id');
    }

    public function getIsFavouritedAttribute()
    {
        return $this->favourites()->where('user_id', Auth::id())->exists();
    }
}
