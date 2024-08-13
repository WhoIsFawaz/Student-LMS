<?php

namespace App\Models;

use Filament\Panel;
use App\Models\Module;
use App\Models\Teaches;
use App\Models\Enrollment;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';
    protected $fillable = ['first_name', 'last_name', 'email', 'date_of_birth', 'password', 'user_type', 'profile_picture'];

    protected $hidden = ['password', 'remember_token'];
    protected $appends = ['name'];

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->email === 'admin@eduhub.com';
    }
    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public static function getUsersByType($type)
    {
        return self::where('user_type', $type)->get()->pluck('name', 'user_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'user_id');
    }
    
    public function teaches()
    {
        return $this->hasMany(Teaches::class, 'user_id');
    }

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'enrollments', 'user_id', 'module_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'enrollments', 'module_id', 'user_id');
    }

    public function isAdmin()
    {
        return $this->user_type === 'admin';
    }

    public function isProfessor()
    {
        return $this->user_type === 'professor';
    }

    public function isStudent()
    {
        return $this->user_type === 'student';
    }
}