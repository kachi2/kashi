<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'user_id',
        'order_id',
        'external_ref',
        'payment_method',
        'amount',
        'status',
        'is_delivered',
        'receiver',
        'address',
        'phone',
        'postal_code',
        'email',
        'city',
        'state'
            ];
    public function order_items()
    {
        return $this->hasMany('App\order_item', 'id', 'order_id');
   }

   public function users(){
       return $this->belongTo('App\User', 'user_id', 'id');
   }
   
}
