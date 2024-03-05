<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mainlinkanalytics extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id' ,
        'name' ,
        'date' ,
        'views' ,
        'clicks' ,
        'ctr' ,
        'uniquevisitors' ,
        'ip_address' ,
    ];
}
