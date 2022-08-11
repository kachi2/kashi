<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\product;
use App\category;
use Illuminate\Support\Facades\DB;
class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request, $id ){ 

        if(!isset($request->qty)){

            $qty = 1;

        }else{

            $valid = $this->validate($request, [
            
                'qty'=>'integer|required|min:0|max:10'
                
                ]);
                
                if(!$valid){
                    
                    return back()->withInputErrors('Only Numbers are required');
                }
                $qty = $request->qty;
        }
      
        $product=product::find($id);
        $products=DB::table('products')->where('id', $id)->get();
        $res = \Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->sale_price,
            'qty' =>$qty,
            'weight'=>1, 
        ])->associate('App\product');
        
       if($res){
        return response()->json($res);
       }
      
    }
    public function carts_buy(Request $request, $id ){ 

        if(empty($request->qty)){

            $qty = 1;

        }else{

            $valid = $this->validate($request, [
            
                'qty'=>'integer|required|min:0|max:10'
                
                ]);
                
                if(!$valid){
                    
                    return back()->withInputErrors('Only Numbers are required');
                }
                $qty = $request->qty;
        }
      
        $product=product::find($id);
        $products=DB::table('products')->where('id', $id)->get();
        \Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->sale_price,
            'qty' => $qty,
            'weight'=>1, 
        ])->associate('App\product');
       // dd( $products);
       $carts['data'] = \Cart::content();
        return redirect()->route('carts.index', $carts);
    }

    public function index()
    {
        $carts['data'] = \Cart::content();
      
      return view('users.carts.index', $carts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function remove()
    {
        \Cart::destroy();
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
          $valid = $this->validate($request, [
            
            'qty'=>'integer'
            
            ]);
            
            if(!$valid){
                
                return back()->withInputErrors('Only Numbers are required');
            }
          
           $cart =  \Cart::update(request()->rowId, request()->qty);
            return response()->json($cart);
    }

    public function update_cart(Request $request)
    {
           //dd($request->all());
             $valid = $this->validate($request, [
            
            'qty'=>'integer'
            
            ]);
            
            if(!$valid){
                
                return back()->withInputErrors('Only Numbers are required');
            }
           $response = \Cart::update(request()->rowId, request()->qty);
            return back();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        \Cart::remove(request()->rowId);
        return back();
    }
}
