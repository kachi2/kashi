<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class review extends Model
{
    protected $table = 'reviews';
    protected $fillable = [

        'user_id','message','product_id','rating'
    ];

    public function user(){
        return $this->belongsTo('App\user');
    }
}
