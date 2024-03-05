<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialAppsLinks extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'linkname',
        'linkbio',
        'bioimage',
        'theme_id',
        'bg_image',
    ];
}
