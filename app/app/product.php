<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    protected $fillable = [
    'brand_id', 
    'category_id',
     'sub_category_id', 
     'shop_id', 
     'name', 
     'added_by', 
     'quantity', 
     'available_qty', 
     'weight',
      'color_id', 
      'price', 
      'sale_price', 
      'status', 
      'cover_image', 
      'gallery', 
      'specification',
       'percentage', 
       'description', 
       'is_new'
    ];

  
    public function category(){

        return $this->belongsTo('App\category', 'category_id', 'id');
    }
    public function subcat(){

        return $this->belongsTo('App\sub_category', 'sub_category_id', 'id');
    }

  public function brands(){

        return $this->belongsTo('App\brand', 'brand_id', 'id');
  }
  public function color(){
      return $this->belongsTo('App\color');
  }

  public function shops(){

    return $this->belongsTo('App\shop', 'shop_id', 'id');
  }
}
