<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class FormAnalytics extends Model
{
    use HasFactory, HasUuids;
    protected $primaryKey = 'id'; // Name of the primary key column
    public $incrementing = false;

    protected $fillable = [
        'link_id' ,
        'date' ,
        'views' ,
        'uniqueviews' ,
        'clicks' ,
        'responces' ,
        'ctr' ,
        'conversion_rate',
    ];

    public function link ()
    {
        return $this->belongsTo(Link::class);
    }
}
