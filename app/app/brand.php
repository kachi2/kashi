<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class brand extends Model
{
    
    protected $fillable = [

        'id',
        'name',
        'status'
    ];

    public function products(){

        return $this->hasMany('App\product');
    }
}
