<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
<<<<<<< HEAD
=======
use Illuminate\Database\Eloquent\Concerns\HasUuids;
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
<<<<<<< HEAD
    use HasFactory;
=======
    use HasFactory, HasUuids;
    protected $primaryKey = 'id'; // Name of the primary key column
    public $incrementing = false;
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02

    protected $fillable = [
        'user_id',
        'linkname',
<<<<<<< HEAD
=======
        'owner_fullname',
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
        'linkbio',
        'theme_id',
        'bio',
        'bioimage',
        'bg_image',
    ];
    
}
