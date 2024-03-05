<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagevisitorlocationdata extends Model
{
    use HasFactory;
    protected $fillable = [
<<<<<<< HEAD
        'page_id',
=======
        'user_id',
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
        'ip',
        'country',
        'countryCode',
        'cityName',
        'areaCode',
        'regionName',
        'regionCode',
    ];
}
