<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcomData extends Model
{
    use HasFactory;

    protected $fillable = [
        'link_id',
        'item1_name',
        'item1_desc',
        'item1_price',
        'item1_image',
        'item2_name',
        'item2_desc',
        'item2_price',
        'item2_image',
        'item3_name',
        'item3_desc',
        'item3_price',
        'item3_image',
        'item4_name',
        'item4_desc',
        'item4_price',
        'item4_image',
        'item5_name',
        'item5_desc',
        'item5_price',
        'item5_image',
        'item6_name',
        'item6_desc',
        'item6_price',
        'item6_image',
    ];

    public function link ()
    {
        return $this->belongsTo(Link::class);
    }
}
