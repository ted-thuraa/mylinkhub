<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
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
            'theme_id' => $this->theme_id,
<<<<<<< HEAD
            'linkname' => $this->linkname,
            'linkbio' => $this->linkbio,
          
            'linkbioimage' => $this->bioimage ? url('/') . $this->bioimage : null,

=======
            'linkname' => $this->username,
            'owner_fullname' => $this->fullname,
            'linkbio' => $this->bio,
            'creator_category' => $this->creator_category,
            'location' => $this->location,
            'font' => $this->page_font,
            'linkbioimage' => $this->image ? url('/') . $this->image : null,
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
