<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => [
                'id' => $this->user_id,
                'name' => $this->user?->name,
                'image' => $this->user?->image ? asset('storage/' . $this->user->image) : null,
            ],
            'course_id' => $this->course_id,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
