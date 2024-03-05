<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ButtonData extends Model
{
    use HasFactory;

    protected $fillable = ['link_id'];

    public function link ()
    {
        return $this->belongsTo(Link::class);
    }
}
