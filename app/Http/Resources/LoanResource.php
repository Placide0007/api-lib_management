<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoanResource extends JsonResource
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
            'user_id' => $this->user_id,
            'book_id' => $this->book_id,
            'due_date' => $this->due_date ? $this->due_date->format('d-m-Y H:i') : null,
            'borrowed_at' => $this->borrowed_at ? $this->borrowed_at->format('d-m-Y H:i') : null,
            'returned_at' => $this->returned_at ? $this->returned_at->format('d-m-Y H:i') : null,
            'updated_at' => $this->updated_at ? $this->updated_at->format('d-m-Y H:i') : null,
        ];
    }
}
