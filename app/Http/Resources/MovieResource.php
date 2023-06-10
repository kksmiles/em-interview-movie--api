<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'slug' => $this->slug,
            'title' => $this->title,
            'description' => $this->description,
            'released_date' => $this->release_date,
            'available_until' => $this->available_until,
            'length_in_seconds' => $this->length_in_seconds,
            'pictures' => MoviePictureResource::collection($this->whenLoaded('pictures')),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'deleted_at' => $this->deleted_at,
        ];
    }
}
