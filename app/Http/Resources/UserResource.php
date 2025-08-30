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
            'name' => ucfirst($this->name),
            'email' => ucfirst($this->email),
            'posts' => PostResource::collection($this->whenLoaded('posts')),
            'loans' => LoanResource::collection($this->whenLoaded('loans')),
            'reservations' => ReservationResource::collection($this->whenLoaded('reservations')),
            'first_name' => ucwords($this->first_name),
            'role' => $this->role,
            'created_at' => $this->created_at->format('d-m-Y H:i'),
            'updated_at' => $this->updated_at->format('d-m-Y H:i')
        ];
    }
}
