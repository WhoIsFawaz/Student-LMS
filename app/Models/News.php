<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $primaryKey = 'news_id';
    protected $fillable = ['module_id','news_title', 'news_description','created_at','updated_at'];
    public $timestamps = false;
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}