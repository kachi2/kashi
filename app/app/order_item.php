<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class order_item extends Model
{
    protected $table = 'order_items';
    protected $fillable = [
'id',
'user_id',
'shop_id',
'product_id',
'product_name',
'qty',
'price',
'amount',
'payable',
'image',
'shipping_method'
    ];
}
