<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayingCustomers extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id' ,
        'lemoncustomer_id' ,
        'customer_name' ,
        'customer_email' ,
        'product_name' ,
        'product_name' ,
        'product_id' , 
    ];
}
