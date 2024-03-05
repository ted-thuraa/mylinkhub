<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortfolioData extends Model
{
    use HasFactory;

    protected $fillable = [
        'link_id',
        'title',
        'description',
        'category',
        'portfolio_thumbnail',
    ];

    public function link ()
    {
        return $this->belongsTo(Link::class);
    }
}
