<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\shop;
use App\brand;
use App\color;
use App\category;
use App\order;
use App\sub_category;
use App\settlement;
use Illuminate\Support\Facades\Session;
use App\product;
use App\notifications;
use UxWeb\SweetAlert\SweetAlert;
use Image;
Use Alert;
use DB;

class vendorsController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function shopsIndex(){

        $shop = shop::where('user_id', auth()->user()->id)->first();
    return view('users.manage.shops', compact('shop'));


    }

    public function store_shops(Request $request){


       $validator =  $this->validate($request, [
            'name' => ['required', 'unique:shops'],
            'email' => 'required',
            'phone' => ['required', 'max:11'],
            'location' => 'required',
            'image'=>'required'
        ]);

        if($validator){
            $shop = new shop;
            $shop->name = $request->name;
            $shop->email = $request->email;
            $shop->user_id = auth()->user()->id;
            $shop->image('image', $shop);
            $shop->phone = $request->phone;

            $shop->location = $request->location;
         if($shop->save()){

            alert()->success('Done Successfully', 'Added')->autoclose(5000);
            return redirect()->route('shops.index')->with('msg');

        }else{
            return redirect()->back()->withInputErrors($request->all());;
        }

    }else{

        return redirect()->back()->withInputErrors();
    }
}

    public function add_shops(){

        return view('users.manage.add_shop');

    }

    public function shop_sell(){
        $data['shops'] = shop::where('user_id', auth()->user()->id)->first();
        $data['category'] = category::all();
        $data['colors'] = color::all();
        $data['brands'] = brand::all();

        return view('users.manage.sell', $data);
    }
    
    public function edit_shop(){
        
        $shop = shop::where('user_id', auth()->user()->id)->first();
        return view('users.manage.shopEdit', compact('shop'));
    }
    
    
    public function update_shops(Request $request){
  
            $shop = shop::where('user_id', auth()->user()->id)->first();
            $shop->name = $request->name;
            $shop->email = $request->email;
            $shop->image('image', $shop);
            $shop->phone = $request->phone;
            $shop->location = $request->location;
         if($shop->save()){

            alert()->success('Completed Successfully', 'Updated')->autoclose(5000);
            return redirect()->route('shops.index')->with('msg');

        }else{
            return redirect()->back()->withInputErrors($request->all());;
        }
        
}
    

    public function getSub_cat(Request $request){
        
        $response = sub_category::where('category_id', $request->cat)->get();

        return response()->json($response);
    }

    public function products_store(Request $request){
        
       $validator =  $this->validate($request, [
            'name'=>'required',
            'description'=>'required',
            'image'=>'required',
            'price'=>'Numeric|required',
            'sub_category'=>'Numeric'
        ]);
        if(!$validator){
            return redirect()->back()->withInput('errors');
        }
        $shop_id = shop::where('user_id', auth()->user()->id)->first();
       //dd($request->all());
        if($request->name){
        $products =  new product;
        $products->name= $request->name;
        $products->category_id= $request->category;
        $products->sub_category_id= $request->sub_category;
        $products->description = $request->description;
        $products->added_by = auth()->user()->name;
        $products->quantity = $request->qty;
        $products->available_qty = 1;
        $products->is_new = $request->condtn;
        $products->shop_id = $shop_id->id;
        $products->price = $request->price;
        if(isset($request->colorNew)){
            $color = new color;
            $color->name = $request->colorNew;
            $color->save();
            $colors = color::orderBy('created_at', 'Desc')->first();
            $products->color_id = $colors->id;
        }else{
            $products->color_id = $request->color;
        }
        if($request->sale_price){
        $products->sale_price = $request->sale_price;
        $xx = $request->price - $request->sale_price;
        $cc = ($xx/$request->price);
        $mm = $cc*100;
        $products->percentage = $mm ;
        }else{
            $products->sale_price = 0; 
            $products->percentage = 0;
        }
            if($request->file('image')){

                $file = $request->file('image');
                $name = $file->getClientOriginalName();
                $FileName = \pathinfo($name, PATHINFO_FILENAME);
                $ext = $file->getClientOriginalExtension();
                $time = md5(time().$FileName);
                $fileName = $time.'.'.$ext;
                $ff = Image::make($request->file('image'))->resize(190, 200)->save('images/products/'.$fileName);
                //$products->cover_image = $ff;
                //$file->move('images/products/', $fileName);
                $products->cover_image = $fileName;
            }
            
            if($request->file('images')){
                $file = $request->file('images');
                foreach($file  as $image){
                $name = $image->getClientOriginalName();
                $FileName = \pathinfo($name, PATHINFO_FILENAME);
                $ext = $image->getClientOriginalExtension();
                $time = md5(time().$FileName);
                $fileName =$time.'.'.$ext;
                $image->move('images/products/', $fileName);
                $images[] = $fileName;
            }
            $products->gallery= json_encode($images); 
        }
            if($products->save()){
                $user = User::where('id', auth()->user()->id)->first();
               
                if($user->is_notify == 1){
                $notify = new notifications;
                $notify->user_id = $user->id;
                $notify->topic = 'New Product Added';
                $notify->message = 'Dear '.$user->name. ' '.'You have successfully added new product to your shop, Kindly Review.. Thanks!';
                if($notify->save()){
                    $notifyCount = $user->notifyCount + 1;
                    user::where('id', $user->id)->update(['notifyCount'=>$notifyCount]);
                }
            }
                alert()->success('Completed Successfully', 'Done!')->autoclose(5000);
                return redirect()->route('my-products');
            }else{
                return redirect()->back()->withInputErrors();
            }
            
        }


    }


    public function products_update(Request $request, $id){
        
       
       $validator =  $this->validate($request, [
            'name'=>'required',
            'description'=>'required',
            'price'=>'Numeric|required',
            'sub_category'=>'Numeric'
        ]);
        if(!$validator){
            return redirect()->back()->withInput('errors');
        }
         $shop_id = shop::where('user_id', auth()->user()->id)->first();
        //dd($request->all());
         $products =  product::where('id', $id)->first();
         $products->name= $request->name;
         $products->category_id= $request->category;
         $products->sub_category_id= $request->sub_category;
         $products->description = $request->description;
         $products->added_by = auth()->user()->name;
         $products->quantity = $request->qty;
         $products->available_qty = 1;
         $products->is_new = $request->condtn;
         $products->shop_id = $shop_id->id;
         $products->price = $request->price;

         if(isset($request->colorNew)){
             $color = new color;
             $color->name = $request->colorNew;
             $color->save();
             $colors = color::orderBy('created_at', 'Desc')->first();
             $products->color_id = $colors->id;
         }else{
             $products->color_id = $request->color;
         }
         if($request->sale_price){
         $products->sale_price = $request->sale_price;
         $xx = $request->price - $request->sale_price;
         $cc = ($xx/$request->price);
         $mm = $cc*100;
         $products->percentage = $mm ;
         }else{
             $products->sale_price = 0; 
             $products->percentage = 0;
         }
         if(!empty(request()->file('image'))){
            $products->gallery= null;
             }
             $products->save(); 
             if($request->file('image')){
                 $file = $request->file('image');
                 $name = $file->getClientOriginalName();
                 $FileName = \pathinfo($name, PATHINFO_FILENAME);
                 $ext = $file->getClientOriginalExtension();
                 $time = md5(time().$FileName);
                 $fileName = $time.'.'.$ext;
                 $ff = Image::make($request->file('image'))->resize(150, 170)->save('images/products/'.$fileName);
                // $file->move('images/products/', $fileName);
                 $products->cover_image = $fileName;
             }
             
             if($request->file('images')){
                 $file = $request->file('images');
                 foreach($file  as $image){
                 $name = $image->getClientOriginalName();
                 $FileName = \pathinfo($name, PATHINFO_FILENAME);
                 $ext = $image->getClientOriginalExtension();
                 $time = md5(time().$FileName);
                 $fileName =$time.'.'.$ext;
                 $image->move('images/products/', $fileName);
                 $images[] = $fileName;
             }
             $products->gallery= json_encode($images); 
         }
             if($products->save()){
                alert()->success('Completed Successfully', 'Updated')->autoclose(5000);
                 return redirect()->route('my-products')->with('alert', 'Profile updated!');
             }else{
                 return redirect()->back()->with('Errors');
             }
 
     }

    public function my_products(){

        $shops = shop::where('user_id', auth()->user()->id)->first();
        $products = product::where(['shop_id' => $shops->id, 'status'=>1])->latest()->paginate(5);
        return view('users.manage.my-products', compact('products'));
    }

    public function archiveProducts(){

        $shops = shop::where('user_id', auth()->user()->id)->first();
        $products = product::where(['shop_id' => $shops->id, 'status'=>2])->latest()->paginate(5);
        return view('users.manage.deletedProducts', compact('products'));
    }

    public function my_productsEdit($id){

        $data['shops'] = shop::where('user_id', auth()->user()->id)->first();
        $data['category'] = category::all();
        $data['colors'] = color::all();
        $data['brands'] = brand::all();
        $data['products'] = product::where('id', $id)->first();

        return view('users.manage.my-productEdit', $data);

    }

    public function my_productsDelete($id){
        
        $data = product::where('id', $id)
                ->update(['status' => 2]);
        alert()->error('Completed Successfully', 'Deleted')->autoclose(5000);
        return redirect()->back();
    }

    public function my_productsRestore($id){  
        $data = product::where('id', $id)
                ->update(['status' => 1]);
        alert()->success('Completed Successfully', 'Restored')->autoclose(5000);
        return redirect()->back();
    }

    public function accountSwitch($id){
         //vendor account is user level 2
         $users = User::where('id', $id)->first();
         if($users->level == 1){
        $user = User::where('id', $id)
                ->update(
                    [
                        'level' => '2',
                    ]);
            alert()->success('Request Completed Successfully', 'Success');
                    }else{
                        $user = User::where('id', $id)
                        ->update(
                            [
                                'level' => '1',
                            ]);
                    alert()->success('Request Completed Successfully', 'Success');

                    }
            return redirect()->back();
    }

    public function notifySwitch($id){
        $users = User::where('id', $id)->first();
           if($users->is_notify == 1){
               $user = User::where('id', $id)
               ->update(
                   [
                       'is_notify' => '0',
                   ]);
           alert()->success('Request Completed Successfully', 'Success');
                   }else{
                       $user = User::where('id', $id)
                       ->update(
                           [
                               'is_notify' => '1',
                           ]);
                   alert()->success('Request Completed Successfully', 'Success');

                   }
           return redirect()->back(); 

}

    public function vendorOrders(){
        $shop = shop::where('user_id', auth()->user()->id)->first();
        $orders  = DB::table('vendor_orders')
        ->join('orders', 'vendor_orders.order_id', '=' ,'orders.order_id')
        ->where('vendor_orders.shop_id', $shop->id)
        ->latest('vendor_orders.created_at')
        ->simplePaginate(10);
        //dd($orders);

        return view('users.manage.vendorOrders', compact('orders'));
    }

    public function VendorsorderDetails($id){
        $user = User::where('id', auth()->user()->id)->first();
        $shop = shop::where('user_id', $user->id)->first();
        $order_items= DB::table('order_items')->where(['id'=> $id, 'shop_id'=>$shop->id])->orderBy('created_at','desc')->get();
        $orders = DB::table('orders')->where(['order_id' => $id])->first();
       ; return view('users.manage.vendorOrderDetails', compact('order_items', 'orders'));

    }
        public function payment_settlement(){
            $user = User::where('id', auth()->user()->id)->first();
            $shop = shop::where('user_id', $user->id)->first();
            $settlement = settlement::where('shop_id', $shop->id)->latest()->simplePaginate(20);
           // dd($settlement);
            return view('users.manage.settlements', compact('settlement'));

        }
    
        public function settlementDetails($Id){

            $settlement = settlement::where('id', $Id)->first();
            return view('users.manage.settlementDetails', compact('settlement'));
        }

        public function confirm_settlement($id){
            $settle = settlement::where('id', $id)
                    ->update([
                        
                        'is_confirmed' => 1
                        ]);
                alert()->success('payment confirmed ', 'Success')->autoClose(10000);
                return redirect()->back();
        }
    }
