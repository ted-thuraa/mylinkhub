<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class SocialmediaLinks extends Model
{
    use HasFactory, HasUuids;
    protected $primaryKey = 'id'; // Name of the primary key column
    public $incrementing = false;
    protected $fillable = [
        'user_id',
        'url' ,
        'name' ,
        'username' ,
        'active' ,
        'clicks' ,
        
    ];
}
