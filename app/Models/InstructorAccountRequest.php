<?php

namespace App\Models;

use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class InstructorAccountRequest extends  Authenticatable
{
    use HasApiTokens;

    protected $table = 'instructor_account_requests';

    protected static function booted()
    {
        static::creating(function ($instructor_request) {
            $instructor_request->slug = Str::slug($instructor_request->name, '-') .'-'. Str::random(6);
        });
    }


    protected $guarded = [
        'id',
        'slug',
        'created_at',
        'updated_at',
    ];

}
