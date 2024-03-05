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
            'uuid' => $this->uuid,
            'theme_id' => $this->theme_id,
            'isAdmin' => $this->isAdmin,
            'username' => $this->username,
<<<<<<< HEAD
=======
            'fullname' => $this->fullname,
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
            'currentplan' => $this->currentplan,
            'creator_category' => $this->creator_category,
            'email' => $this->email,
            'bio' => $this->bio,
<<<<<<< HEAD
            
=======
            'bioimage' => $this->image,
            'creator_category' => $this->creator_category,
            'location' => $this->location,
            'page_font' => $this->page_font,
            'page_layout' => $this->page_layout,
            'theme_id' => $this->theme_id,
            'isGooglesheetsAuthorized' => $this->isGooglesheetsAuthorized,
            'isMailchimpAuthorized' => $this->isMailchimpAuthorized,
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
            'image' => url('/') . $this->image,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
