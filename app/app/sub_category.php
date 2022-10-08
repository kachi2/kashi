<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sub_category extends Model
{
    protected $table = "sub_category";


public function image($fileName, $category){
    if(request()->hasfile($fileName)){  
        $file = request()->file($fileName);
        $extention = $file->getClientOriginalExtension();
        $time = md5(time());
        $filename=$time.'.'.$extention;
        $file->move('images/category', $filename);
        $category->image = $filename;
}
}
        public function category(){
            return $this->belongsTo('App\category', 'category_id');
        }
        public function products(){
           return $this->hasMany('App\product');
        }
    //
}
