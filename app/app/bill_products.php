<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bill_products extends Model
{
  protected $table = 'bill_products';
    
    protected $fillable = [
    'id','name', 'slug', 'bill_category_id', 'api_id', 'image', 'status', 'service_id', 'min_amount', 'max_amount', 'commission_type', 'convinience_fee', 'biller_name', 'is_price_editable', 'verify_api_id'
    ];

    public function bill_transaction(){

      return  $this->hasMany('App\bill_transactions');
    }

    public function bill_category(){

      return $this->belongsTo('App\bill_category');
    }

    public function image($fileName, $pro){
      if(request()->hasfile($fileName)){  
          $file = request()->file($fileName);
          $extention = $file->getClientOriginalExtension();
          $time = md5(time());
          $filename=$time.'.'.$extention;
          $file->move('images/products', $filename);
          $pro->image = $filename;
  }
}
}
