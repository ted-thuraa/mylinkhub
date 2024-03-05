<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
<<<<<<< HEAD
=======
use Illuminate\Database\Eloquent\Concerns\HasUuids;
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
<<<<<<< HEAD
    use HasFactory;
    protected $fillable = [
        'page_id' ,
        'name' ,
        'description' ,
        'url' ,
        'category' ,
        'active' ,
        'clicks' ,
        'image' ,  
        'layout' ,  
    ];

    //create relations
    public function PortfolioData()
    {
        return $this->hasOne(PortfolioData::class);
    }
    public function SaasData()
    {
        return $this->hasOne(SaasData::class);
    }
    public function EcomData()
    {
        return $this->hasOne(EcomData::class);
    }
    public function ContactFormData()
    {
        return $this->hasOne(ContactFormData::class);
    }
    public function ButtonData()
    {
        return $this->hasOne(ButtonData::class);
    }
=======
    use HasFactory, HasUuids;
    protected $primaryKey = 'id'; // Name of the primary key column
    public $incrementing = false;

    const TYPE_PORTFOLIO = 'portfolio';
    const TYPE_TEXT = 'text';
    const TYPE_MINIBLOG = 'miniblog';
    const TYPE_IMAGE = 'image';
    const TYPE_SAAS = 'saas';
    const TYPE_VIDEO = 'video';
    const TYPE_LINK = 'link';
    const TYPE_STORE = 'store';
    const TYPE_FORM = 'form';
    const TYPE_HEADER = 'header';
    const TYPE_MAP = 'map';


    protected $fillable = [
        'user_id',
        'order',
        'url' ,
        'faviconurl' ,
        'thumbnailurl' ,
        'category' ,
        'name' ,
        'redirect_link' ,
        'description' ,
        'active' ,
        'clicks' ,
        'icon' ,
        'thumbnailimage',
        'layout',
        'data',
        'google_sheets_url',
        'google_sheets_submissions',
        'mailchimplistid',
        'responces_email',
        'responces_storage',
        'bg_color',
        'text_color',
        'btn_color',
    ];

    protected static function boot()
    {
        parent::boot();

        // Attach an event listener for the 'created' event
        static::created(function ($model) {
            // Get the maximum 'order' value from the table
            $maxOrder = static::max('order');

            // Set the 'order' value for the newly created model
            $model->update(['order' => $maxOrder + 1]);
        });
    }

    //create relations
    public function answers()
    {
        return $this->hasMany(FormResponces::class);
    }

    public function clicks()
    {
        return $this->hasMany(FormClicks::class);
    }
    public function formanalytics()
    {
        return $this->hasMany(FormAnalytics::class);
    }
    
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
}
