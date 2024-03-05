<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaasDataResource extends JsonResource
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
            'description' => $this->description,
            'category' => $this->category,
            'active' => $this->active,
            'mrr' => $this->mrr,
            'saas_thumbnail' => $this->saas_thumbnail,
            'saas_category' => $this->saas_category,
            'saas_status' => $this->saas_status,
        ];
    }
}
