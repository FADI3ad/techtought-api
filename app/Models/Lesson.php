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
            $lesson->slug = Str::slug($lesson->title, '-');
        });
        static::updating(function ($lesson) {
            $lesson->slug = Str::slug($lesson->title, '-');
        });
    }

    protected $fillable = [
        'section_id',
        'title',
        'video_path'
    ];



    public function section()
    {
        return $this->belongsTo(Section::class);
    }

}
