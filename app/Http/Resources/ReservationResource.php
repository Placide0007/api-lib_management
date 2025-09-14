<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
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
            'status' => $this->status,
            'reserved_at' => $this->reserved_at ? $this->reserved_at->toDateTimeString() : null,
            'created_at' => $this->created_at->format('d-m-Y H:i'),
            'updated_at' => $this->updated_at->format('d-m-Y H:i'),
            'book' => $this->book ? [
                'id' => $this->book->id,
                'title' => $this->book->title,
                'author' => $this->book->author,
            ] : null,
        ];
    }
}
