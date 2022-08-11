<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class notifications extends Model
{
    protected $table = 'notifications';
    protected $fillable = [

        'user_id','topic', 'message'
    ];
}
