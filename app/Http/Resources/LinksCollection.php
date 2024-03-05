<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class LinksCollection extends ResourceCollection
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
                'id' => $link->id,
<<<<<<< HEAD
                'page_id' => $link->page_id,
                'name' => $link->name,
                'description' => $link->description,
                'active' => $link->active,
                'clicks' => $link->clicks,
                'url' => $link->url,
                'image' => $link->image ? url('/') . $link->image : null,
                'saas_data' => new SaasDataResource($link->SaasData),
                'contactform_data' => new ContactFormDataResource($link->ContactFormData),
                'portfolio_data' => new ContactFormDataResource($link->PortfolioData),
=======
                'user_id' => $link->user_id,
                'order' => $link->order,
                'name' => $link->name,
                'category' => $link->category,
                'description' => $link->description,
                'google_sheets_url' => $link->google_sheets_url,
                'mailchimplistid' => $link->mailchimplistid,
                'responces_email' => $link->responces_email,
                'responces_storage' => $link->responces_storage,
                'active' => $link->active,
                'clicks' => $link->clicks,
                'url' => $link->url,
                'layout' => $link->layout,
                'faviconurl' => $link->faviconurl,
                'thumbnailurl' => $link->thumbnailurl,
                'image' => $link->icon ? url('/') . $link->icon : null,
                //'thumbnailimage' => $link->thumbnailimage ? url('/') . $link->thumbnailimage : null,
                'thumbnailimage' => $link->thumbnailimage ? url('/') . $link->thumbnailimage : null,
                'data' => json_decode($link->data),
                // 'saas_data' => new SaasDataResource($link->SaasData),
                // 'ecom_data' => new EcomDataResource($link->EcomData),
                // //'contactform_data' => new ContactFormDataResource($link->ContactFormData),
                // 'portfolio_data' => new PortfolioDataResource($link->PortfolioData),
                // 'quote_data' => new QuoteDataResource($link->TextData),
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
            ];
        });
    }
}
