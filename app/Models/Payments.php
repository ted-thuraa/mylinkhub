<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;
    protected $fillable = [
        
        'sub_id' ,
        'order_id' ,
        'sub_status' ,
        'customer_id' ,
        'user_email' ,
        'checkout_email' ,
        'planname' ,
     
        
    ];
}
