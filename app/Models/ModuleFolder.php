<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleFolder extends Model
{
    protected $table = 'module_folders';
    protected $primaryKey = 'module_folder_id';
    protected $fillable = ['folder_name', 'module_id'];

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }

    public function contents()
    {
        return $this->hasMany(ModuleContent::class, 'module_folder_id');
    }
}
