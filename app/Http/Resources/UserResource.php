<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone_no' => $this->phone_no,
            'theme_settings' => $this->theme_settings,
            'favourite_tags' => TagResource::collection($this->whenLoaded('favourite_tags')),
            'favourite_categories' => CategoryResource::collection($this->whenLoaded('favourite_categories')),
            'favourite_movies' => MovieResource::collection($this->whenLoaded('favourite_movies')),
            'deleted_at' => $this->deleted_at,
        ];
    }
}
