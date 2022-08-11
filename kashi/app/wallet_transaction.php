<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class wallet_transaction extends Model
{
   
    protected $fillable = [
    'user_id',
    'transaction_ref',
    'external_ref',
    'purpose',
    'type',
    'amount',
    'commission',
    'prev_balance',
    'avail_balance'
    ];

    public function trans(){
        return $this->hasOne('App\bill_transactions', 'transactionId', 'transaction_ref');
    }
}
