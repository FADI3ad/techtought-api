<?php

namespace App\Models;
//use App\Models\Lesson;


use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
    'title',
    'lesson_id',
    'duration',
    'current_time'
];

}
//public function lesson()
//{
 //  return $this->belongsTo(Lesson::class);
//}
