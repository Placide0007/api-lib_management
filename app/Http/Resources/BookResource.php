<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => ucfirst($this->title),
            'author' => ucfirst($this->author),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'isbn' => $this->isbn,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'cover_image' => $this->cover_image ? asset('storage/' . $this->cover_image, true) : null,
            'created_at' => $this->created_at->format('d-m-Y H:i'),
            'updated_at' => $this->updated_at->format('d-m-Y H:i'),
        ];
    }
}
