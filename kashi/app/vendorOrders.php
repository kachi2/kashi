<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class vendorOrders extends Model
{
    protected $fillable = [
        'shop_id',
        'order_id'
    ];

    public function orders(){
        return $this->hasOne('App\order', 'order_id', 'order_id');
    }
}
