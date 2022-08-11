<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bill_category extends Model
{
    

    public function bill_products(){
        return $this->hasMany('App\bill_products');
    }

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
}
