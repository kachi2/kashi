<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class settlement extends Model
{
    protected $table = 'settlements';

    protected $fillable = [

        'user_id',
        'shop_id',
        'is_settled',
        'is_confirmed',
        'is_paid',
        'purpose'
    ];

    public function shops(){

        return $this->belongsTo('App\shop', 'shop_id', 'id');
    }
}
