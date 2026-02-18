<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Section extends Model
{


    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected static function booted()
    {
        static::creating(function ($section) {
            $section->slug = Str::slug($section->title, '-');
        });
        static::updating(function ($section) {
            $section->slug = Str::slug($section->title, '-');
        });
    }


    public function course()
    {
        return $this->belongsTo(Course::class);
    }



}
