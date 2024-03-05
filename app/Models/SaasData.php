<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaasData extends Model
{
    use HasFactory;

    protected $fillable = [
        'link_id',
        'description',
        'category',
        'active',
        'mrr',
        'saas_thumbnail',
        'saas_category',
        'saas_status',
    ];
    

    public function link ()
    {
        return $this->belongsTo(Link::class);
    }
}
