<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'author',
        'read_time',
        'excerpt',
        'content',
        'level_id',
    ];

    public function getLevelNameAttribute()
    {
        return match($this->level_id) {
            1 => 'Beginner',
            2 => 'Intermediate',
            3 => 'Advanced',
            4 => 'Expert',
            default => 'Intermediate',
        };
    }

    public function getLevelColorAttribute()
    {
        return match($this->level_id) {
            1 => 'text-green-400 border-green-400',
            2 => 'text-yellow-400 border-yellow-400',
            3 => 'text-orange-500 border-orange-500',
            4 => 'text-red-500 border-red-500 shadow-[0_0_10px_rgba(255,0,0,0.8)]',
            default => 'text-yellow-400 border-yellow-400',
        };
    }
}
