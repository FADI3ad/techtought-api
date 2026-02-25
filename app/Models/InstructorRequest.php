<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class InstructorRequest extends Model
{
    protected $table = 'instructor_requests';

   protected static function booted()
{
    static::creating(function ($model) {
        $model->slug = Str::slug($model->fullname);
    });
}
    protected $fillable = [
    'full_name',
    'slug',
    'email',
    'country',
    'subject',
    'age',
    'phone',
    'experience_years',
    'cv_link',
    'national_id_front',
    'national_id_back',
    'status'
];
}
