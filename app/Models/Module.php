<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $primaryKey = 'module_id';
    protected $fillable = ['module_name', 'module_code', 'description', 'credits', 'logo'];

    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'module_id');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class, 'module_id');
    }

    public function moduleContents()
    {
        return $this->hasMany(ModuleContent::class, 'module_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'module_id');
    }
    
    public function teaches()
    {
        return $this->hasMany(Teaches::class, 'module_id');
    }

}