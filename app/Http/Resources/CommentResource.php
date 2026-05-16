<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->user?->name,
            'image' => $this->user?->image ? asset('storage/' . $this->user->image) : null,
            'comment' => $this->comment,
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
