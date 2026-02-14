<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SubCategory extends Model
{
    protected $table = 'sub_categories';

    protected static function booted()
    {
        static::creating(function ($category) {
            $category->slug = Str::slug($category->name, '-');
        });
        static::updating(function ($category) {
            $category->slug = Str::slug($category->name, '-');
        });
    }


    protected $fillable = [
        'name',
        'category_id'
    ];






    public function category()
    {
        return $this->belongsTo(Category::class);
    }


}
