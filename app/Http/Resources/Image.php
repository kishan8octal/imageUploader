<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Image extends JsonResource
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
            'user_name' => $this->user->name,
            'category_name' => $this->category->name,
            'image_url' => $this->image_url,
            'total_downloads' => $this->total_downloads,
        ];
    }
}
