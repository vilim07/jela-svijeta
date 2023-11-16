<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TagResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $locale = $request->query('lang');

        $translations = [
            'title' => $this->translate($locale)->title,
        ];

        return [
            'id' => $this->id,
            'slug' => $this->slug,
            ...$translations
        ];
    }
}
