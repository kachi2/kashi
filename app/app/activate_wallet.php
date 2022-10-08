<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class activate_wallet extends Model
{
    
    protected $fillable = [
    'user_id',
    'is_activated',
    'status'
    ];

    public function wallet_users(){

        return $this->belongsTo('App\User', 'user_id','id');
    }
}
