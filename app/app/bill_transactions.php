<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bill_transactions extends Model
{
    protected $table = 'bill_transactions';
    protected $fillable = [

        'amount',
        'total_amount', 
        'fee',
        'transactionId',
        'bill_products_id',
        'status',
        'user_id',
        'email',
        'phone',
        'variation',
        'commission',
        'biller_code',
        'service_verification'
    ];

    public function bill_product(){
       return $this->belongsTo('App\bill_products', 'bill_products_id', 'id');
    }
    public function wallet_trans(){
        return $this->hasOne('App\wallet_transaction', 'transaction_ref', 'transactionId');
    }
}
