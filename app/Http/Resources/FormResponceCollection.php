<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FormResponceCollection extends ResourceCollection
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
                'responces' => $link->responces,
                'starts' => $link->clicks,
                //'form' => json_decode($link->data),
                //'submissions' => ResponceResource::collection($link->answers),
               
            ];
        });
    }
}
