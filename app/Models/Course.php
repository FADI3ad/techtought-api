<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use Illuminate\Support\Str;

class Course extends Model
{



    protected $table = 'courses';

    protected $with = ['instructor'];

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



    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
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

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments', 'course_id', 'user_id')->withTimestamps();
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorite_courses', 'course_id', 'user_id')->withTimestamps();
    }

    public function getAvgRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?: 0;
    }

    public function getIsEnrolledAttribute()
    {
        if (!auth('sanctum')->check()) {
            return false;
        }

        return $this->students()->where('user_id', auth('sanctum')->id())->exists();
    }

    public function getIsFavoriteAttribute()
    {
        if (!auth('sanctum')->check()) {
            return false;
        }

        return $this->favoritedBy()->where('user_id', auth('sanctum')->id())->exists();
    }

    public function lessons()
    {
        return $this->hasManyThrough(Lesson::class, Section::class);
    }

    public function getLessonsCountAttribute()
    {
        return $this->lessons()->count();
    }

    protected $appends = ['avg_rating', 'is_enrolled', 'is_favorite', 'lessons_count'];

}
