<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormClicks extends Model
{
    use HasFactory;

    protected $fillable = [
        'link_id' ,
        'ip' ,
    ];

    public function link ()
    {
        return $this->belongsTo(Link::class);
    }
}
