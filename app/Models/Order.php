<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
 
    protected $fillable = [
        
        'order_id' ,
<<<<<<< HEAD
=======
        'user_id' ,
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
        'orderitem_id' ,
        'order_status' ,
        'customer_id' ,
        'user_email' ,
        'checkout_email' ,
        'planname' ,
        'total_price' ,
        'total_formatted' ,
        'product_id' ,
        
    ];
}
