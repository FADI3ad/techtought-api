<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Review extends Model
{
        protected $fillable = [
'content',
'course_id'];

    protected $table = 'reviews';

    protected static function booted()
    {
        static::creating(function ($review) {
            $review->slug = Str::slug($review->content, '-');
        });

        static::updating(function ($review) {
            $review->slug = Str::slug($review->content, '-');
        });
    }
 
}
