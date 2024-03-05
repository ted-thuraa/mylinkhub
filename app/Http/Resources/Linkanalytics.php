<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class Linkanalytics extends ResourceCollection
{
    
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        return $this->collection->map(function ($link) {
            return [
                
                'name' => $link->name,
                'clicks' => $link->total_clicks,
                'click_percentage' => $link->click_percentage,   
            ];
        });
    }
}
