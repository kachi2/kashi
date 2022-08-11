<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class shop extends Model
{
    

protected $fillable = [
    'name',
    'email',
    'phone',
    'location',
    'user_id'
];

    function image($image, $shop){

    if(request()->hasfile($image)){

        $file = request()->file($image);
        $ext = $file->getClientOriginalExtension();
        $time = md5(time());
        $filename = $time.'.'.$ext;
        $file->move('images/shops', $filename);
        $shop->image = $filename;
    }

    }

    public function products(){

        return $this->hasMany('App\product');
    }

    public function user(){

        return $this->belongsTo('App\User');
    }

    public function settlment(){

        return $this->hasMany('App\settlment');
    }
}


