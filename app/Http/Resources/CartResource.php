<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'course' => [
                'id' => $this->course->id,
                'title' => $this->course->title,
                'slug' => $this->course->slug,
                'price' => $this->course->price,
                'is_free' => $this->course->is_free,
                'image_path' => $this->course->image_path ? asset('storage/' . $this->course->image_path) : null,
                'category' => $this->course->category->name,
                'instructor' => [
                    'name' => $this->course->instructor?->name,
                ],
            ],
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
