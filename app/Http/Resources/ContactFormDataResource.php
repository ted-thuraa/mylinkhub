<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactFormDataResource extends JsonResource
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
            'responses_email' => $this->responses_email,

            'title' => $this->title,
            'description' => $this->description,
            'submission_message' => $this->submission_message,
            'category' => $this->category,
            'portfolio_thumbnail' => $this->portfolio_thumbnail,

            'useEmail' => $this->useEmail,
            'useGoogleSheets' => $this->useGoogleSheets,

            'get_name' => $this->get_name,
            'name_required' => $this->name_required,

            'get_email' => $this->get_email,
            'email_required' => $this->email_required,

            'get_mesaage' => $this->get_mesaage,
            'message_required' => $this->message_required,

            'mobile_required' => $this->mobile_required,
            'message_required' => $this->message_required,

            'get_country' => $this->get_country,
            'country_required' => $this->country_required,

            'termsandcondition_url' => $this->termsandcondition_url,
        ];
    }
}
