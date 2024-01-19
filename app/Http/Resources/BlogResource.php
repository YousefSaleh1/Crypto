<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user_id = $this->user_id;
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'body'          => $this->body,
            'updated_at'    => $this->created_at->format('Y-m-d'),
            'photo'         => asset('photos/' . $this->photo),
            'tags'          => TagResource::collection($this->whenLoaded('tags')),
        ];
    }
}
