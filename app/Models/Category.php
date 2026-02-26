<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

class Category extends Model
{

    protected $table = 'categories';

    protected static function booted()
    {
        static::creating(function ($category) {
            $category->slug = Str::slug($category->name, '-');
        });
        static::updating(function ($category) {
            $category->slug = Str::slug($category->name, '-');
        });

    }



    protected $guarded = [
        'id',
        'slug',
        'created_at',
        'updated_at'
    ];


    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function courses()
    {
        return $this->hasmany(Course::class);
    }
}
