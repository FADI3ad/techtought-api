<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Lesson extends Model
{
    protected $table = 'lessons';


    protected static function booted()
    {
        static::creating(function ($lesson) {
            $lesson->slug = Str::slug($lesson->name, '-');
        });
        static::updating(function ($lesson) {
            $lesson->slug = Str::slug($lesson->name, '-');
        });
    }

    protected $fillable = [
        'section_id',
        'title'
    ];




    // public function videos()
    // {
    //     return $this->hasMany(Video::class);
    // }

}
