<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Course extends Model
{



    protected $table = 'courses';


    protected $guarded = [
        'id',
        'slug',
        'created_at',
        'updated_at'
    ];


    protected static function booted()
    {
        static::creating(function ($course) {
            $course->slug = Str::slug($course->title, '-');
        });
        static::updating(function ($course) {
            $course->slug = Str::slug($course->title, '-');
        });
    }



    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

}
