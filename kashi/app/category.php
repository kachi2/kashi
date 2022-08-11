<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    protected $table = "category";
    protected $fillable = [
        'name',
        'status',
        'image'
    ];

    public function image($image, $category){
        if(request()->hasfile($image)){  
            $file = request()->file($image);
            $extention = $file->getClientOriginalExtension();
            $time = md5(time());
            $filename=$time.'.'.$extention;
            $file->move('images/category', $filename);
            $category->image = $filename;
    }
  }
        public function subcat(){
            return $this->hasMany('App\sub_category');
        }

        public function products() {
            return $this->hasManyThrough('App\product', 'App\sub_category', 'category_id', 'sub_category_id', 'id', 'id');
        }
}
