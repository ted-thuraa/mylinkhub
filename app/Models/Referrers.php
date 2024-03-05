<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referrers extends Model
{
    use HasFactory;
    protected $fillable = ['referrer'];

    public function pageViews()
    {
        return $this->hasMany(Pageviews::class);
    }
}


