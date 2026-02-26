<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{




    public function toArray(Request $request)
    {

        return [
            'category' => [
                'id' => $this->id,
                'slug' => $this->slug,
                'name' => $this->name,
                'description' => $this->description,
                'image' => $this->image_path ? asset('storage/' . $this->image_path) : null,
            ]
        ];
    }
}
