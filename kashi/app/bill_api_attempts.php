<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bill_api_attempts extends Model
{
    
    protected $fillable = [

        'transactionId' ,
                'requestId',
                'response_code',
                'description',
                'api_id'
    ];
}
