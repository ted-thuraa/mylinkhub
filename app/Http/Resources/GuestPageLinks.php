<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GuestPageLinks extends ResourceCollection
{
    
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        return $this->collection->map(function ($links) {
            return [
                'id' => $links->id,
<<<<<<< HEAD
                'page_id' => $links->page_id,
                'name' => $links->name,
                'description' => $links->description,
                'url' => $links->url,
                'active' => $links->active,
                'saas_category' => $links->saas_category,
                'saas_status' => $links->saas_status,
                'image' => $links->image ? url('/') . $links->image : null,
=======
                'user_id' => $links->user_id,
                'order' => $links->order,
                'name' => $links->name,
                'category' => $links->category,
                'description' => $links->description,
                'active' => $links->active,
                'clicks' => $links->clicks,
                'url' => $links->url,
                'layout' => $links->layout,
                'faviconurl' => $links->faviconurl,
                'thumbnailurl' => $links->thumbnailurl,
                'image' => $links->icon ? url('/') . $links->icon : null,
                'thumbnailimage' => $links->thumbnailimage ? url('/') . $links->thumbnailimage : null,
                //'thumbnailimage' => $links->thumbnailimage ? $links->thumbnailimage : null,
                'data' => json_decode($links->data),
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
            ];
        });
    }
}
