<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactFormData extends Model
{
    use HasFactory;

    protected $fillable = [
        'link_id',
        'responses_email',

        'title',
        'description',
        'submission_message',
        'category',
        'portfolio_thumbnail',

        'useEmail',
        'useGoogleSheets',

        'get_name',
        'name_required',

        'get_email',
        'email_required',

        'get_mesaage',
        'message_required',

        'mobile_required',
        'message_required',

        'get_country',
        'country_required',

        'termsandcondition_url', 
    ];

    public function link ()
    {
        return $this->belongsTo(Link::class);
    }
}
