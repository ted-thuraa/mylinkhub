<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuestLinkData extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       
            return [
<<<<<<< HEAD
                'page_id' => $this->page_id,
=======
                'user_id' => $this->user_id,
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
                'theme_id' => $this->theme_id,
                'name' => $this->linkname,
                'bio' => $this->linkbio,
                'image' => $this->bioimage ? url('/') . $this->bioimage : null,
            ];    
    }
}
