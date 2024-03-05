<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class Formanalytics extends ResourceCollection
{
    
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        $formattedDate = Carbon::parse($this->date)->format('F d');
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'views' => $this->views,
            'clicks' => $this->clicks,
            'uniquevisitors' => $this->uniquevisitors,
            'ctr' => $this->ctr,
            'date' => $formattedDate,
        ];
       
    }
}
