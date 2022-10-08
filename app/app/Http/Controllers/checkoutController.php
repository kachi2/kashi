<?php
namespace App\Http\Controllers;
use App\User;
use App\shipping;
use App\product;
use App\category;
use App\order;
use App\sub_category;
use App\wallet_transaction;
use App\order_item;
use App\shop;
use App\notifications;
use App\settlement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\vendorOrders;
use Illuminate\Database\Eloquent\Relations\Pivot;

class checkoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct(){

        $this->payantToken = "6d97a845397070068c46c802c57e595b2a8c767a3c546de307f16305";
     }
    public function index()
    {  
        $user = user::where('id', auth()->user()->id)->first();
        $address= shipping::where(['user_id'=> $user->id, 'is_default' => 1])->first();
        if(!$address){
            $data['user'] = $user;
        }else{
            $data['user'] = $address;
        }

        $data['price'] = \Cart::priceTotalFloat();
        if($data['price'] > 100  && $data['price'] <= 25000){
            $data['shipping'] = $data['price'] * 0.05;  
        }elseif($data['price'] > 25000  && $data['price'] <= 50000){
            $data['shipping'] = $data['price'] * 0.04;
        }elseif($data['price'] > 50000  && $data['price'] <= 100000){
            $data['shipping'] = $data['price'] * 0.03;
        }elseif($data['price'] > 100000  && $data['price'] <= 150000){
            $data['shipping'] = $data['price'] * 0.02;
        }elseif($data['price'] > 150000){
            $data['shipping'] = $data['price'] * 0.01;
        }
        return view('users.carts.checkout', $data);
    }

    public function shipping_address(){
        return view('users.carts.shipping');
    }

    public function shipping(Request $request){

        $validate = $this->validate($request, [
            'receiver' => 'required',
            'phone' => 'required',
            'email' => 'email|required',
            'address' => 'required',
            'state' => 'required'
        ]);
        if(!$validate){
            return redirect()->back()->withInputErrors();    
        }
            $user = User::where('id', auth()->user()->id)->first();
            $ships = shipping::where(['user_id' => $user->id, 'is_default'=>1])
                              ->update(['is_default' => 0]);      
            $shipping = new shipping;
            $shipping->user_id = auth()->user()->id;
            $shipping->is_default = 1;
            $shipping->address = $request->address;
            $shipping->name = $request->receiver;
            $shipping->phone = $request->phone;
            $shipping->email = $request->email;
            $shipping->state = $request->state; 

            if($shipping->save()){

                return redirect()->route('checkout.index');
            }else{
                return redirect()->back()->withInputErrors(); 
            }
    }

        public function payment_method(Request $request){
            $cart= \Cart::content();
            $orderId = rand(11111,99999).rand(1111,3333);
            foreach($cart as $cat){
                $order_list = new order_item;
                $order_list->id = $orderId;
                $order_list->payable = $request->payable;
                $order_list->shipping_method = $request->selector;
                $order_list->product_id = $cat->model->id;
                $order_list->product_name = $cat->name;
                $order_list->shop_id = $cat->model->shop_id;
                $order_list->qty = $cat->qty;
                if(isset($cat->model->sale_price)){
                    $price = $cat->model->sale_price;
                }else{
                    $price = $cat->model->price;
                }
                $order_list->price = $price;
                $order_list->image = $cat->model->cover_image;
                $order_list->amount = $cat->qty*$order_list->price;
                $order_list->user_id = auth()->user()->id;
                $order_list->save();
            }
            return view('users.carts.payment');
        }
        public function cash_payment(){

            return view('users.carts.cash');
        }

        public function bank_payment(){

            return view('users.carts.bank');
        }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {    
        //dd($request->all());
        
        $validate = $this->validate($request, [
            'payment_method',
            ]);
     
        $orderId= DB::table('order_items')->where(['user_id'=> auth()->user()->id])->orderBy('created_at', 'desc')->first();
        //insert into order list table
      //dd(\Cart::content());
      
      $transaction_ref = 'payM'.rand(11111111,9999999);
      $orderAmount = \Cart::priceTotalFloat();
      
        if(count(\Cart::content()) == null){
            return redirect()->back()->with('error', 'Order Expired');
        }
        $dd = order::where('order_id', $orderId->id)->first();

            if($dd){
                alert()->error('Order Already Exist', 'Failed')->autoclose(5000);
                return redirect()->route('checkout.index');
            }
        
        $order = new order;
        $order->user_id = auth()->user()->id;
        $order->order_id = $orderId->id;
        $order->transaction_ref = $transaction_ref;
        $order->payment_method = $request->payment_method;
        $order->status = 'pending';
        $order->is_delivered = 0;
        $order->amount = $orderAmount;
        $order->payable = $orderId->payable;
        $ship= Shipping::where(['user_id' => auth()->user()->id, 'is_default' => 1])->latest()->first();
        if($ship){
        $order->receiver = $ship->name;
        $order->address = $ship->address;
        $order->phone = $ship->phone;
        $order->email = $ship->email;
        $order->postal_code = $ship->postal_code;
        $order->city = $ship->city;
        $order->state = $ship->state;
        }else{
            $user_address = User::where('id', auth()->user()->id)->first();
            $order->receiver = $user_address->name;
            $order->address = 'no address';
            $order->phone = $user_address->phone;
            $order->email = $user_address->email;
            $order->postal_code = null;
            $order->city = null;
            $order->state = null;
        }

        if($request->payment_method == 'wallet')
        {
            if(auth()->user()->wallet < $order->amount){
                \Session::flash('wallet-check', 'You Balance is too low for this Transaction');
                return redirect()->route('checkout.index');
            }elseif($order->amount < 0){
                \Session::flash('wallet-check', 'Amount Cannot be negative');
                return redirect()->route('checkout.index');  
            }elseif(auth()->user()->is_wallet == 0){
                \Session::flash('wallet-check', 'Your wallet is not activated yet, <br> please got to settings to request activation');
                return redirect()->route('checkout.index');
               }elseif(auth()->user()->is_wallet == 2){
                \Session::flash('wallet-check', 'Your wallet is disabled, please contact admin');
                return redirect()->route('checkout.index'); 
           }
        }
    if($order->save())
    {
        //get shop id to send a notification for success order
        $shopsID= DB::table('order_items')->where(['id'=> $orderId->id])->get();
        $shops = $shopsID->unique('shop_id');
        foreach($shops as $shopId){
        $shops = shop::where('id', $shopId->shop_id)->get();
        $shoID= DB::table('order_items')->where(['shop_id'=> $shopId->shop_id, 'id'=>$orderId->id])->pluck('amount');
       
       $dd = $shoID->sum();
        //var_dump($shops);
        foreach($shops as $shop){   
        $ownerId = $shop->user->id;
        $ownerName = $shop->user->name;
        $notify = new notifications;
        $notify->user_id = $ownerId;
        $notify->topic = 'You have a new Order';
        $notify->message = 'Dear '.$ownerName. ' '.'You have a new Order from '. auth()->user()->name. ', Please check your orders in your shop for more details, thanks';
        if($notify->save()){
            $notifyCount = $shop->user->notifyCount + 1;
            user::where('id', $ownerId)->update(['notifyCount'=>$notifyCount]);
        }
    
        //create a table for settlment for the vendor account
        $settlement = new settlement;
        $settlement->shop_id = $shop->id;
        $settlement->order_id = $orderId->id;
        $settlement->amount = $dd;
        $settlement->is_settled = 0;
        $settlement->is_confirmed = 0;
        $settlement->is_paid = 0;
        $settlement->purpose = 'Settlement for OrderId:'.' '.$orderId->id;
        $settlement->save();

        $v_orders = new vendorOrders;
        $v_orders->shop_id = $shop->id;
        $v_orders->order_id = $orderId->id;
        $v_orders->v_amount = $dd;
        $v_orders->save();
    }
        }
    }
        if($request->payment_method == 'card'){
            //redirect to payment gateway
            $amount = $orderId->payable;
            return view('users.carts.card', compact('amount'));
        }elseif($request->payment_method == 'wallet'){
           //charge user from wallet
            $this->chargeUser($order->amount, $order->order_id);
            \Cart::destroy();
            return view('users.carts.success');
           }elseif($request->payment_method == 'bank')
           {
            $data['cash'] = "cash";
            \Cart::destroy();
            return view('users.carts.bank', $data);
           }else{
               $data['cash'] = "cash";
            \Cart::destroy();
               return view('users.carts.success', $data);
           }
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
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function chargeUser($amount, $order_id){
        $user = User::where(['id' => auth()->user()->id])->first();
        $new_wallet = $user->wallet - $amount;
        $update_wallet = User::where('id', $user->id)->update(['wallet' => $new_wallet]);
        $transactionRef = 'payM-'.rand(1111111, 9999999);
        wallet_transaction::create([
        'user_id' => $user->id,
        'transaction_ref'=>$transactionRef,
        'purpose' => 'Payment for OrderID:'. $order_id,
        'type'=>'debit',
        'amount'=>$amount,
        'is_commission'=>0,
        'prev_balance' =>$user->wallet,
        'avail_balance' => $new_wallet
        ]);
    
        $orders = order::where(['order_id' => $order_id])
            ->update([
                'transaction_ref' => $transactionRef, 
                 'status' => 'success', 
                 'amount'=>$amount
                 ]);
        $settle = settlement::where('order_id', $order_id)
                ->update([
                   'is_paid' =>1 
                ]);
    }

    public function checkout_success(){

        return view('users.carts.success');
    }


    public function verify($trxref){
        $trnx_ref_exists = wallet_transaction::where(['external_ref' => $trxref])->first();
        if ($trnx_ref_exists) {
      ;      return redirect()->route('my_wallet')->with('error', 'Transaction Already Exist');
            exit();
        }

        $cURLConnection = curl_init();
        curl_setopt($cURLConnection, CURLOPT_URL, 'https://api.payant.ng/payments/'.$trxref);
        curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Authorization: Bearer ".$this->payantToken
        ));
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true); 
        $se = curl_exec($cURLConnection);
        curl_close($cURLConnection);  
        $resp = json_decode($se, true);

        //dd($resp);
        if ($resp['status'] == 'error') {
            \Session::flash('flash_message', 'Transaction not found, Please contact support');
            $message = 'Transaction not found, Please contact support';
          
     ;   }
     
        $paymentStatus = $resp['data']['status'];
        $chargeResponsecode = $resp['data']['status'];
        $chargeAmount = $resp['data']['amount'];
        $chargeCurrency = $resp['data']['currency'];
        $custemail = $resp['data']['client']['email'];
        $payment_id = $resp['data']['payment_id'];
        $external_ref = $resp['data']['reference_code'];
        $mm = \Cart::priceTotalFloat();
       

        if (($chargeResponsecode == "success")  && ($chargeCurrency == 'NGN')) {     
            //Give Value and return to Success page
            $transactionRef = 'ONET-'.rand(1111111, 9999999);
            $getUser = User::where('email', $custemail)->first();
            $ownerNewBalance = $getUser->wallet + $chargeAmount;
            $updateOwnerBalance = User::where(['id' => $getUser->id])->update(['wallet' => $ownerNewBalance]);
            Wallet_transaction::create([
                'user_id' => $getUser->id,
                'transaction_ref'=>$transactionRef,
                'external_ref' =>$trxref,
                'purpose' => 'Wallet Top Up',
                'type'=>'credit',
                'external_ref'=>$external_ref,
                'amount'=>$chargeAmount,
                'is_commission'=>0,
                'prev_balance' =>$getUser->wallet_balance,
                'avail_balance' => $ownerNewBalance 
            ]);
            $order = DB::table('orders')->where('user_id', auth()->user()->id)->latest()->first();
            //dd($order_id);
            $orders = order::where(['order_id' => $order->order_id])
            ->update([
                'external_ref'=>$external_ref
                 ]);
                 sleep(5);
            $this->chargeUser($chargeAmount, $order->order_id);
            //alert()->success('success', 'Wallet top Compltete');
            \Cart::destroy();
            return redirect()->route('checkout.success');
        } else {
            alert()->error('error', 'Payment failed, funds reversed');
            return redirect()->route('my_wallet');
        }
    }
}
