<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
<<<<<<< HEAD
=======
use Illuminate\Database\Eloquent\Concerns\HasUuids;
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
use Illuminate\Database\Eloquent\Model;

class Pageanalytics extends Model
{
<<<<<<< HEAD
    use HasFactory;

    protected $fillable = [
        'page_id' ,
=======
    use HasFactory, HasUuids;
    protected $primaryKey = 'id'; // Name of the primary key column
    public $incrementing = false;

    protected $fillable = [
        'user_id' ,
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
        'name' ,
        'date' ,
        'views' ,
        'clicks' ,
        'ctr' ,
<<<<<<< HEAD
        'uniquevisitors' ,
        
=======
        'uniquevisitors',
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
    ];
}
