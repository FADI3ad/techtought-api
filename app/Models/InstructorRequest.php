<?php

namespace App\Models;

use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class InstructorRequest extends  Authenticatable
{
    use HasApiTokens;

    protected $table = 'instructor_requests';

    protected static function booted()
    {
        static::creating(function ($instructor_request) {
            $instructor_request->slug = Str::slug($instructor_request->full_name, '-') . Str::random(6);
        });
        static::updating(function ($instructor_request) {
            $instructor_request->slug = Str::slug($instructor_request->full_name, '-') . Str::random(6);
        });
    }


    protected $guarded = [
        'id',
        'slug',
        'created_at',
        'updated_at',
    ];

}
