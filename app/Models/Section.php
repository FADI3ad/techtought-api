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
            $section->slug = Str::slug($section->name, '-');
        });
        static::updating(function ($section) {
            $section->slug = Str::slug($section->name, '-');
        });
    }


    public function course()
    {
        return $this->belongsTo(Course::class);
    }



}
