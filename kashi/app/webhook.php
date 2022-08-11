<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class webhook extends Model
{
    
    
    protected $table = 'webhooks';
    
    protected $fillable = [
        
        'name',
        'errors',
        'user'
        
        ];
}
