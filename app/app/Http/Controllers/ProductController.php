<?php

namespace App\Http\Controllers;

use App\bill_products;
use App\product;
use Illuminate\Http\Request;
use App\sub_category;
use App\bill_category;
use App\category;
use App\brand;
use App\bill_api;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = product::paginate(30);
        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = category::All();
        $brands = brand::All();
        return view('admin.product.create', compact('category', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [

            'name'=>'required',
            'status'=>'required',
            'price'=>'required',
            'sale_price' =>'required',
            'qty' =>'required',
            'category'=>'required',
            'description'=>'required',
            'image'=>'required',
            'images'=>'required'
        ]);
        if(!$validate){
            
            return redirect()->back();
        }

        if($request->name){

        $products =  new product;
        $products->name= $request->name;
        $products->sub_category_id= $request->category;
        $products->description = $request->description;
        $products->specification = $request->specification;
        $products->added_by = auth('admin')->user()->first_name;
        $products->quantity = $request->qty;
        $products->weight = $request->weight;
        $products->is_new = $request->condtn;
        $products->shop_id = $request->shop_id;
        $products->price = $request->price;
        $products->status = $request->status;
        if(isset($request->brandNew)){
            $brand = new brand;
            $brand->name = $request->brandNew;
            $brand->save();
            $brands = brand::orderBy('created_at', 'Desc')->first();
            $products->brands_id = $brands->id;
        }else{
            $products->brands_id = $request->brand;
        }
        
        $products->available_qty =  $request->qty + $products->quantity;
        $products->sale_price = $request->sale_price;

        $xx = $request->price - $request->sale_price;
        $cc = ($xx/$request->price);
        $mm = $cc*100;
        $products->percentage = $mm ;

            if($request->file('image')){

                $file = $request->file('image');
                $name = $file->getClientOriginalName();
                $FileName = \pathinfo($name, PATHINFO_FILENAME);
                $ext = $file->getClientOriginalExtension();
                $time = md5(time().$FileName);
                $fileName = $time.'.'.$ext;
                $file->move('images/products/', $fileName);
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
                return redirect()->route('products.index')->with('success', 'Product added successfully');
            }
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = category::All();
        $product = product::where(['id' =>$id])->first();
        $brands = brand::All();
        $title ='Edit Product';
        return view('admin.product.edit', compact('category', 'product', 'title', 'brands')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
           $this->validate($request, [

            'name',
            'status',
            'price',
            'sale_price',
            'qty',
            'category',
            'description',
            'image',
            'images'
        ]);
        if(!$validate){
            
            return redirect()->back();
        }
        $products = product::find($id);
        $qty = DB::table('products')->where('id', $id)->pluck('id', 'available_qty');
        $products->name= $request->name;
        $products->sub_category_id= $request->category;
        $products->description = $request->description;
        $products->description = $request->specification;
        $products->quantity = $request->qty;
        $products->weight = $request->weight;
        if(isset($request->brandNew)){
            $brand = new brand;
            $brand->name = $request->brandNew;
            $brand->save();
            $brands = brand::orderBy('created_at', 'Desc')->first();
            $products->brands_id = $brands->id;
        }else{
            $products->brands_id = $request->brand;
        }
        $products->is_new = $request->condtn;
        $products->status = $request->status;
        $products->price = $request->price;
        foreach($qty as $key => $value){
        $product =  $request->quantity + $key ;
        }
        $products->available_qty = $product;
        $products->sale_price = $request->sale_price;
        $xx = $request->price - $request->sale_price;
        $cc = ($xx/$request->price);
        $mm = $cc*100;
        $products->percentage = $mm ;
        if(!empty(request()->file('image'))){
       $products->gallery= null;
        }
       $products->save(); 
        if($file1 = request()->file('image')){
            $name1 = $file1->getClientOriginalName();
            $fileName1 = pathinfo($name1, PATHINFO_FILENAME);
            $ext1 = $file1->getClientOriginalExtension();
            $time1 = time();
            $fileName1 = md5($time1.$fileName1);
            $filename1 = $fileName1.'.'.$ext1;
            $file1->move('images/products', $filename1);
            }else{ $filename1=$products->cover_image; } 
           if($file = request()->file('images')){
            foreach($file  as $image){
            $name = $image->getClientOriginalName();
            $fileName = pathinfo($name, PATHINFO_FILENAME);
            $ext = $image->getClientOriginalExtension();
            $time = time();
            $fileName = md5($fileName.$time);
            $filename=$fileName.'.'.$ext;
            $image->move('images/products', $filename);
            $data[] = $filename;
        }
    }
        $data[] = $products->gallery;
        $products->cover_image=$filename1;
        $products->gallery= json_encode($data); 
        if($products->save()){

            return redirect()->route('products.index')->with('success', 'Product Updated successfully');
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=product::findorfail($id);
        $product->delete();
        return redirect()->back()->with('error', 'Product deleted Successfully');
    }

    public function bill_products(){

        $bill_category = bill_category::all();
        $bill_api = bill_api::all();

        return view('admin.product.bill_products', compact('bill_category', 'bill_api'));
    }

    public function bills_products_index(){

        $products = bill_products::all();

        return view('admin.product.bill_productIndex', compact('products'));
    }


    public function create_Bills(Request $request){

        $validator = $this->validate($request, [
            'name' => 'required',
             'slug' => 'required', 
             'bill_category' => 'required',
              'image' => 'required',
              'status' => 'required',
              'image'=>'required',
              'min_amount' => 'required',
              'max_amount' => 'required',
              'commission_type'=> 'required',  
              'price_editable' => 'required', 
        ]);

        if(!$validator){
            return redirect()->back()->withInputErrors();
        }
        $pro = new bill_products;
        $pro->name = $request->name;
        $pro->slug = $request->slug;
        $pro->bill_category_id = $request->bill_category;
        $pro->api_id = $request->bill_api;
        $pro->status = $request->status;
        $pro->image('image', $pro);
        $pro->commission = $request->commission;
        $pro->service_id = $request->service_id;
        $pro->min_amount = $request->min_amount;
        $pro->max_amount = $request->max_amount;
        $pro->convinience_fee = $request->convinience_fee;
        $pro->commission_type = $request->commission_type;
        $pro->biller_name = $request->biller_name;
        $pro->is_price_editable = $request->price_editable;
        if($pro->save()){
            return redirect()->route('bills_products')->with('success', 'Bill product added successfully');
        }
    }

    public function bills_edit($id){
        $bill_api = bill_api::all();
        $bill_category = bill_category::all();
        $products = bill_products::where('id', $id)->first();
        return view('admin.product.edit_bills', compact('products','bill_category', 'bill_api'));

    }

    public function bills_update(Request $request, $id){


     $validator = $this->validate($request, [
            'name',
             'slug', 
             'bill_category',
              'image',
              'status',
              'image',
              'min_amount',
              'max_amount',
              'commission_type',  
              'price_editable', 
        ]);

        if(!$validator){
            return redirect()->back()->withInputErrors();
        }
        
        $pro = bill_products::where('id', $id)->first();
        $pro->name = $request->name;
        $pro->slug = $request->slug;
        $pro->bill_category_id = $request->bill_category;
        $pro->status = $request->status;
        if(!empty($request->image)){
        $pro->image('image', $pro);
        }
        $pro->commission = $request->commission;
        $pro->service_id = $request->service_id;
        $pro->min_amount = $request->min_amount;
        $pro->max_amount = $request->max_amount;
        $pro->convinience_fee = $request->convinience_fee;
        $pro->commission_type = $request->commission_type;
        $pro->biller_name = $request->biller_name;
        $pro->is_price_editable = $request->price_editable;
        if($pro->save()){
            return redirect()->route('bills.products.index')->with('success', 'Bill product update successfully');
        }
    }

    public function bills_delete($id){
        $bill = bill_products::where('id', $id)->first();
        $bill->delete();
        return back()->with('success', 'deleted successfully');
    }

}
