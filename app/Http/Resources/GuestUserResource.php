<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GuestUserResource extends ResourceCollection
{
    
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
       
            return [
                'id' => $this->id,
                'theme_id' => $this->theme_id,
                'linkname' => $this->username,
                'owner_fullname' => $this->fullname,
                'linkbio' => $this->bio,
                'linkbioimage' => $this->image ? url('/') . $this->image : null,
            
            ];
        
    }
}
