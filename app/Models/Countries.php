<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    use HasFactory;
    protected $fillable = ['country_code', 'country_name'];

    public function pageViews()
    {
        return $this->hasMany(Pageviews::class);
    }
}
