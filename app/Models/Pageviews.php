<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pageviews extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'ip_address', 'referrer', 'country_code'];

    public function referrer()
    {
        return $this->belongsTo(Referrers::class);
    }
    public function country()
    {
        return $this->belongsTo(Countries::class);
    }
}
