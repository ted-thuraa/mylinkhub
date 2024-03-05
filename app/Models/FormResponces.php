<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormResponces extends Model
{
    use HasFactory;

    protected $fillable = [
        'link_id',
        'form_type',
        'sent_to',
        'answer_data',
        'ip',
    ];

    public function link ()
    {
        return $this->belongsTo(Link::class);
    }
}
