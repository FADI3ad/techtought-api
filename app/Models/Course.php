<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable=['id','title','description','images','requirements','price','rate','language','is_free','instructor_id','category_id'];
}
