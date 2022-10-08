<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class fund_request extends Model
{
    protected $table = 'fund_requests';
    
    protected $fillable = [


        'user_id',
        'amount',
        'note'
    ];

    public function fund_users(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
