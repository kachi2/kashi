<?php

namespace App\Http\Controllers;
use App\bill_category;
use App\bill_products;
use Illuminate\Http\Request;
use App\User;
use App\shop;
use App\brand;
use App\product;
use App\order;
use App\category;
use App\review;
use App\activate_wallet;
use App\sub_category;
use App\color;
use App\wallet_transaction;
use App\bill_transactions;
use App\notifications;
use App\webhook_calls;
use App\fund_request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Session\Session;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth')->except('index');
        $this->payantToken = "6d97a845397070068c46c802c57e595b2a8c767a3c546de307f16305";
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() 
    {
        $bill_category = bill_category::All();
        // $top_products = product::whereHas('category', fn($q) => $q->where('status', '1'))->get();
        // $top_products = product::with(['category' => fn($q) => 
        // $q->where('name', '')])->get();

        // $top_products = product::get()->load('subcat');
        // dd($top_products);
        $recent = product::where('status', '1')->take(10)->inRandomOrder()->get();
        $products = product::where(['status' => '1', ])->where('views','>','5')->inRandomOrder()->take(10)->get();
        $category = category::all();

        return view('users.index', compact('bill_category', 'top_products', 'category', 'products', 'recent'));
    }

    public function productCategory($id){
        $cat = category::where('id', $id)->first();
        $subcat = $cat->products()->where('status', 1)->get();
        return view('users.shops', compact('subcat'));

    }
    public function user_settings(){

        return view('users.manage.settings');

    }
    
    public function profile(){
        return view('users.manage.profile');
    }

    public function transactions(){

        $transactions = bill_transactions::where('user_id', auth()->user()->id)->latest()->simplePaginate(10);   
        return view('users.manage.transactions', compact('transactions'));
    }
    public function product_details($id){

        $data['item'] = product::where('id', $id)->first();
        $viewsCount = $data['item']->views + 1;
        $views = product::where('id', $id)->update(['views' => $viewsCount]);
        $data['reviews'] = review::where('product_id', $id)->latest()->simplePaginate(3);
        $data['reviewsCount'] = review::where('product_id', $id)->get();
        return view('users.carts.products', $data);
    }
    public function my_wallet(){ 
        // $user = User::where('id', auth()->user()->id)->first();
        // if($user->accountNumber !== null){
        //        $transactions = wallet_transaction::where('user_id', auth()->user()->id)->latest()->simplePaginate(5); 
        //     return view('users.manage.my_wallet', compact('transactions')); 
        // }else{
        //  $data = array(
        //     "customer" => array(
        //         "name" => auth()->user()->name,
        //         "email" => auth()->user()->email,
        //         "phoneNumber" => auth()->user()->phone,
        //         "sendNotifications" => true
        //     ),
        // "type" => "RESERVED",
        // "accountName" => auth()->user()->name,
        // "bankCode" => "000001",
        // "currency" =>  "NGN",
        // "country" => "NG"
        //     );
        // $auth = 'TWlra3lub2JsZUBnbWFpbC5jb206TWlra3lub2JsZUAx' ;
        // $post = json_encode($data, true); 
        // $cURL = curl_init();
        //     curl_setopt_array($cURL, array(
        //     CURLOPT_URL => "https://connect-api.payant.ng/accounts",
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => "",
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_HTTPHEADER => array(
        //         "Content-Type: application/json",
        //         "Authorization: Basic ".$auth,
        //         "OrganizationID: 5f691331a526c91d7399aea2"
        //     ),
        //     CURLOPT_TIMEOUT => 0,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => "POST",
        //     CURLOPT_POSTFIELDS => $post,
        //     ));
        //     $resp = curl_exec($cURL);
        //     curl_close($cURL);
        //     $response = json_decode($resp, true);
        //     if($response['statusCode'] == 200){
        //         $account = $response['data']['accountNumber'];
        //         $cc = User::where('id', $user->id)->update(['accountNumber'=> $account]);
        //      //dd($response['data']['accountNumber']);   
        //     }else{
        //         return redirect()->route('my_wallet');
        //     }
             $transactions = wallet_transaction::where('user_id', auth()->user()->id)->latest()->simplePaginate(5); 
            return view('users.manage.my_wallet', compact('transactions')); 
      //  }
        
        

    }
    public function trans_details($id){

        $transactions = bill_transactions::where('transactionId', $id)->first();
     //   dd($transactions->wallet_trans());
        return view('users.manage.trans_details', compact('transactions'));
    }
    public function transfer_fund(Request $request){

        $validate = $this->validate($request, [
            'amount'=>['min:1', 'Numeric', 'max:5000']
        ]);

//        dd($validate);
        $user = User::where('id', auth()->user()->id)->first();
        if($validate){
            if($request->amount > $user->comm_wallet){
                return back()->withErrors('Amount is more than commission balance');
                exit();
            }
            if($request->amount < 0){

                return back()->withErrors('you cannot transfer negative amount');
                exit();
            }
            $old_wallet = $user->wallet;
            $old_com = $user->comm_wallet;
            $new_wallet = $old_wallet + $request->amount;
            $new_com = $old_com - $request->amount;
            $transactionId = rand(11111111,9999999);
        $update = User::where('id', $user->id)
                        ->update([
                            'wallet' => $new_wallet,
                            'comm_wallet' => $new_com
                        ]);
               if($update){
            $update_wallet = wallet_transaction::create([
                'user_id' => $user->id,
                'transaction_ref' => $transactionId,
                'external_ref'=>null,
                'purpose' => 'Commission Transfer',
                'type' => 'credit',
                'amount'=> $request->amount,
                'commission' => $new_com,
                'prev_balance'=>$old_wallet,
                'avail_balance' => $new_wallet
                ]);
                return back()->withSuccess('transfer was done successfully');
               }else{
                   return back()->withErrors('Request Failed');
               }        

        }

    }


    public function myOrders(){
        $orders = DB::table('orders')
                ->join('order_items', 'orders.order_id', '=' ,'order_items.id')
                ->where('orders.user_id', auth()->user()->id)
                ->latest('orders.created_at')
                ->paginate(8);

        //dd($orders);
        return view('users.manage.my-orders', compact('orders'));
    }

    public function orderDetails($id){
        $order_items= DB::table('order_items')->where(['id'=> $id])->orderBy('created_at','desc')->get();
        $orders = DB::table('orders')->where(['order_id' => $id])->first();
       ; return view('users.manage.orderDetails', compact('order_items', 'orders'));

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
                'prev_balance' =>$getUser->wallet,
                'avail_balance' => $ownerNewBalance 
            ]);
            alert()->success('success', 'Wallet top Completed');
            return redirect()->route('my_wallet');
        } else {
            alert()->error('error', 'Transaction Failed');
            return redirect()->route('my_wallet');
        }
    }

    public function notifications(){
        $notifications = notifications::where('user_id', auth()->user()->id)->latest()->simplePaginate(7);
        return view('users.manage.notifications', compact('notifications'));
    }

    public function notifications_details($id){
        $notifications = notifications::where('id',$id)->first();
        $noti = notifications::where(['user_id'=>auth()->user()->id, 'is_read'=>0])->get();
        $notify = notifications::where('id',$id)->update(['is_read' => 1]);
        if(count($noti) > 0){
            $nofifyCount = count($noti) - 1;
        }else{
            $nofifyCount = 0;
        }
        $user = User::where('id', auth()->user()->id)->update(['notifyCount' => $nofifyCount]);
        return view('users.manage.notifyDetails', compact('notifications'));
    }

    public function notificationDel($id){
        $del = notifications::where('id', $id)->first();
        $del->delete();
        return redirect()->route('notifications')->with('success', 'Deleted Successfully');
    }


    public function addReview(Request $request, $id){

       $val =  $this->validate($request, [
            'rating' => 'required',
            'message' => 'required'
        ]);
    
        if($val){
        $proid = product::findorfail($id);
        $review = new review;
        $review->product_id = $proid->id;
        $review->user_id = auth()->user()->id;
        $review->rating = $request->rating;
        $review->message = $request->message;
        
        if($review->save()){
            return redirect()->back()->with('success', 'Review Added Successfully');
            
        }
            
        } 

}


public function search(Request $request)
{
    if(isset($request->search)){
    $product['prod'] = product::take(5)->orderBy('created_at','desc')->get();
    $search = $request->get('search');
     $product['products'] = product::where(['status' => 1])->where( 'name', 'LIKE', "%$search%" )->orwhere( 'description', 'LIKE', "%$search%")->get();
     $product['shops'] = shop::where('name', 'LIKE', "%$search%")->get();
    }else{
      $product['title'] = 'Cannot search for empty keyword'; 
      $product['products'] = [];
    }
    return view ( 'users.manage.search-results',$product);
    }

    public function manual_topUp(Request $request){
        
        $req = $this->validate($request, [
            
                'amount'=>'required|min:500|Numeric'
            ]);
            
        if(!$req){
            return back()->withInputErrors();
        }
       
             $amount = $request->amount;
        
       
         return view('users.manage.manual', compact('amount'));
    }

    public function topUp(Request $request){
        
        $valid = $this->validate($request, [
            
            'amount' => 'required',
            ]);
        if(!$valid){
            return back();
        }
        
        if(auth()->user()->level == 2 && auth()->user()->id != 25){
            
            $amount = $request->amount - 30;
        }else{
            
            $amount = $request->amount;
        }
       // dd($request->all());
        $user = User::where('id', auth()->user()->id)->first();
        $fund = new fund_request;
        $fund->user_id = $user->id;
        $fund->amount = $amount;
        $fund->note = $request->note;
        $fund->save();
        
        \Session::Flash('succes', 'We are receiving your payment, your wallet will be credited once transfer is successful');
        return redirect()->route('my_wallet');
    }


    public function activate_wallet(){
        if(auth()->user()->is_wallet == 0){
        $wallet = new activate_wallet;
        $wallet->user_id = auth()->user()->id;
        $wallet->is_activated = 0;
        $wallet->status = 'pending';
        $wallet->save();
        alert()->success('Your request is sent successfuly, you wil get notifications in fews minutes')->autoclose(5000);
    }else{
        alert()->error('Request Rejected')->autoclose(5000);

    }
        return redirect()->back();
    }

    public function changepass(){
        return view('users.manage.changepass');
    }

    public function changePassword(Request $request){
     $pass = $this->validate($request, [
           'oldPassword' => 'required',
           'password' => 'required|min:5|confirmed',
           'password_confirmation'=>'required'
           ]);

          $hashedPassword = auth()->user()->password;
          $pass =  bcrypt($request->oldPassword);
          
         //dd($pass.' '.$hashedPassword);
       //  $dd =  \Hash::check($request->oldPassword , $hashedPassword);
               // dd($dd);
           if (\Hash::check($request->oldPassword , $hashedPassword)) {
          //  dd($hashedPassword);
           if (!\Hash::check($request->password , $hashedPassword)) {
               
                 $users_password = bcrypt($request->password);

                 user::where( 'id' , auth()->user()->id)->update( array( 'password' =>  $users_password));
                 \Session::flash('alert', 'alert-success');
                 \Session::flash('pass','Password Updated Successfully');
                 return redirect()->back();
               }
               else{
                \Session::flash('alert', 'alert-danger');
                \Session::flash('pass','Old / New Password Cannot be the Same');
                return redirect()->back();
                } 
           } else{
          //  dd($hashedPassword);
            \Session::flash('alert', 'alert-danger');
            \Session::flash('pass','Old Password is Incorrect');
               return redirect()->back();
           }
       }
       
        public function payant(Request $request){
            $data = array(
                "bankCode" => "000001",
                "accountNumber" => "8261658605",
                "amount" => 30000,
                "senderBankCode" => "000001",
                "senderAccountNumber" => "8261658605",
                "senderAccountName" => "CONNECT DEMO"
                );
            $auth = 'TWlra3lub2JsZUBnbWFpbC5jb206TWlra3lub2JsZUAx' ;
            $post = json_encode($data, true); 
            $cURL = curl_init();

                curl_setopt_array($cURL, array(
                CURLOPT_URL => "https://connect-sandbox.herokuapp.com/accounts/simulator/transfer",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "Authorization: Basic ".$auth,
                    "OrganizationID: 5f5e89e430115900179edf52"
                ),
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $post,
                ));
                $resp = curl_exec($cURL);
                curl_close($cURL);
                $response = json_decode($resp, true);
                dd($response);
          return back();
            }
            
            
        public function webhook(){
                  // Retrieve the request's body and parse it as JSON
                $input = file_get_contents("php://input");
                $event = json_decode($input);
                
                $ff = new webhook_calls;
                $ff->name = 'name';
                $ff->save();
                // Do something with $event
                print_r('we ar here');
                print_r($event);
                http_response_code(200); // PHP 5.4 or greater
              
            }
            
        public function referrals(){
           $user = User::where('referral_id', auth()->user()->id)->latest()->get();
            return view('users.manage.referrals', compact('user'));
            
        }
}
