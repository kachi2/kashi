<?php

namespace App\Http\Controllers;
use App\User;
use App\Shipping_address;
use Illuminate\Support\Facades\DB;
use App\order_item;
use App\product;
use App\order;
use App\shipping;
use App\wallet_transaction;
use App\notifications;
use App\fund_request;
use App\shop;
use App\activate_wallet;
use App\bill_transactions;
use Illuminate\Http\Request;
use App\settlement;

class AdminController extends Controller
{
  /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title= 'Dashboard';
        $products = product::all();
        $users = User::all();
        $orders = order::all();
        $vendors = User::where('level',2)->get();
        $wallet = User::get()->sum('wallet');
        $vtpass = App('App\Http\Controllers\BillsAPI')->vtpass_wallet();
        $zeal_vend =App('App\Http\Controllers\BillsAPI')->zeal_balance(); 
       // dd($zeal_vend);
        $shops = shop::all();
        $comm = User::get()->sum('comm_wallet');        
    
        return view('admin.index', compact('title', 'products', 'users', 'orders', 'wallet', 'vendors', 'comm', 'shops', 'vtpass', 'zeal_vend'));
    }
        public function transaction(){
            $transaction = wallet_transaction::paginate(20);
            return view('admin.users.transactions', compact('transaction'));
        }

    public function users(){
        $users = DB::table('users')
                ->paginate(20);
        return view('admin.users.users', compact('users'));
    }

    public function orders(){
        $title="All Orders";
        
        $orders= DB::table('orders')
                ->latest()
                ->paginate(30);
        return view('admin.users.orders', compact('orders', 'title'));
    }

    public function orderDetails($id){
        $orders= DB::table('order_items')
                ->where('id', $id)
                ->get();
        return view('admin.users.orderDetails', compact('orders'));
    }

    public function approveDelivery($id){

        $order = order::findorfail($id);
        $update =  order::where('id', $order->$id)
                ->update(
                    [
                    'is_delivered' => 1
                    ]
                    );
        if($order){
        return redirect()->back()->with('success', 'Delivery Successfully approved');
        }else{
            return redirect()->back()->with('error', 'Request Failed, Try Again');   
        }
    }
    public function approvePay($id){
        $order = order::findorfail($id);
        $update =  order::where('id', $order->id)
                ->update(
                    [
                    'status' => 'success'
                    ]
                    );
        $settle = settlement::where('order_id',$order->order_id)
                    ->update([
                    'is_paid'=> 1
                    ]);
        if($order){
        return redirect()->back()->with('success', 'Payment Successfully approved');
        }else{
            return redirect()->back()->with('error', 'Request Failed, Try Again');   
        }
    }

    public function viewTrans($id){

        $wallet = wallet_transaction::where('user_id', $id)->paginate(20);
        return view('admin.users.user-wallet', compact('wallet'));
    }

    public function viewOrders($id){

        $orders = order::where('user_id', $id)->paginate(20);
        return view('admin.users.user-orders', compact('orders'));
    }

    public function notify(){

        return view('admin.users.notify');
    }

    public function push_notify(Request $request){

        $validate = $this->validate($request, [

            'name' => 'required',
            'message'=>'required'
        ]);

        if($validate){

            $users = User::all();
            foreach($users as $user){
            $notify = new notifications;
            $notify->user_id = $user->id;
            $notify->topic = $request->name;
            $notify->message = 'Dear '.$user->name. ' '.$request->message;
            if($notify->save()){
               
                $notifyCount = $user->notifyCount + 1;
                user::where('id', $user->id)->update(['notifyCount'=>$notifyCount]);
            }
            }

            return back()->with('success', 'notification sent');
        }else{
            return back()->withInputErrors();
        }

    }

    public function fund_request(){

        $funds = fund_request::latest()->simplePaginate(20);
        return view('admin.users.fund-request', compact('funds'));
    }

    public function approve_request(Request $request, $id){

        $fund = fund_request::where('id', $id)->first();
        if($request->approve == 'yes'){
            
            $user_wallet = $fund->fund_users->wallet;
            $new_wallet = $user_wallet + $fund->amount;
            $transactionRef = 'payM'.rand(111111111,9999999);
            $updateUserWallet = User::where('id', $fund->fund_users->id)
                                ->update([
                                    'wallet' =>$new_wallet,
                                ]);
                wallet_transaction::create([
                    'user_id' => $fund->fund_users->id,
                    'transaction_ref'=>$transactionRef,
                    'external_ref' =>null,
                    'purpose' => 'Wallet Top Up',
                    'type'=>'credit',
                    'amount'=>$fund->amount,
                    'is_commission'=>0,
                    'prev_balance' =>$user_wallet,
                    'avail_balance' => $new_wallet 
                ]);
            $updateFundTable = fund_request::where('id', $id)
                                ->update([
                                    'status' => 1
                                ]);
                    $notify = new notifications;
                    $notify->user_id = $fund->fund_users->id;
                    $notify->topic = 'Approved Fund Request';
                    $notify->message = 'Dear '.$fund->fund_users->name. ' '.'Your request to fund '.'N'.number_format($fund->amount,2) .' into your wallet was approved successfully, check wallet history for confirmation';
                    if($notify->save()){
                        $notifyCount = $fund->fund_users->notifyCount + 1;
                        user::where('id', $fund->fund_users->id)->update(['notifyCount'=>$notifyCount]);
                    }
            
                    return redirect()->back()->with('success', 'Approved Successfully');
        }elseif($request->approve == 'no'){

            $updateFundTable = fund_request::where('id', $id)
                                ->update([
                                    'status' => 2
                                ]);

                $notify = new notifications;
                $notify->user_id = $fund->fund_users->id;
                $notify->topic = 'Cancelled Fund Request';
                $notify->message = 'Dear '.$fund->fund_users->name. ' '.'Your request to fund '.'N'.number_format($fund->amount,2) .' into your wallet was cancelled, if you have paid for this request, kindly contact Admin';
                if($notify->save()){
                    $notifyCount = $fund->fund_users->notifyCount + 1;
                    user::where('id', $fund->fund_users->id)->update(['notifyCount'=>$notifyCount]);
                }
        
                return redirect()->back()->with('success', 'Cancelled Successfully');
         }else{

            return redirect()->back()->with('error', 'Request Failed');
         }


    }
    public function activation_request(){
        $funds = activate_wallet::latest()->simplePaginate(20);
       //dd($funds[0]->wallet_users->email);
        return view('admin.users.wallet-activate', compact('funds'));
    }


    public function wallet_activation(Request $request, $id){

        $wallet = activate_wallet::where('id', $id)->first();
        if($request->approve == 'yes'){
            $updateFundTable = activate_wallet::where('id', $id)
                                ->update([
                                    'status' => "Approved",
                                    'is_activated' => 1
                                ]);
            $updateUser = User::where('id',$wallet->wallet_users->id)
                                ->update([
                                'is_wallet' => 1
                                ]);
                    $notify = new notifications;
                    $notify->user_id = $wallet->wallet_users->id;
                    $notify->topic = 'Wallet Activated';
                    $notify->message = 'Dear '.$wallet->wallet_users->name. ' '.'Your request to activate your wallet was successfully, Happy trading with us';
                    if($notify->save()){
                        $notifyCount = $wallet->wallet_users->notifyCount + 1;
                        user::where('id', $wallet->wallet_users->id)->update(['notifyCount'=>$notifyCount]);
                    }
                    return redirect()->back()->with('success', 'Approved Successfully');
        }elseif($request->approve == 'no'){

            $updateFundTable = activate_wallet::where('id', $id)
                                ->update([
                                    'status' => "Cancelled",
                                    'is_activated' => 2
                                ]);

                $notify = new notifications;
                $notify->user_id = $wallet->wallet_users->id;
                $notify->topic = 'Cancelled Wallet Activation';
                $notify->message = 'Dear '.$wallet->wallet_users->name. ' '.'Your request to activate your wallet was cancelled, please contact admin for more information';
                if($notify->save()){
                    $notifyCount = $wallet->wallet_users->notifyCount + 1;
                    user::where('id', $wallet->wallet_users->id)->update(['notifyCount'=>$notifyCount]);
                }
        
                return redirect()->back()->with('success', 'Cancelled Successfully');
         }else{

            return redirect()->back()->with('error', 'Request Failed');
         }


    }

    public function blockUser($id){
        $users = User::where('id', $id)->first();
        if($users->status == 1){
        $updateUser = User::where('id', $users->id)
                    ->update([
                    'is_wallet' => 2,
                    'status' => 2
                    ]);
            
            $notify = new notifications;
            $notify->user_id = $users->id;
            $notify->topic = 'Account Blocked!';
            $notify->message = 'Dear '.$users->name. ' '.'Your account has been blocked by the admin, this might be due to fraud action, please contact our support for more information';
            if($notify->save()){
                $notifyCount = $users->notifyCount + 1;
                user::where('id', $users->id)->update(['notifyCount'=>$notifyCount]);
            }   
        }else{
            $updateUser = User::where('id', $users->id)
            ->update([
            'is_wallet' => 1,
            'status' => 1
            ]);
    
    $notify = new notifications;
    $notify->user_id = $users->id;
    $notify->topic = 'Account Unlocked!';
    $notify->message = 'Dear '.$users->name. ' '.'Congratulations Your account has been unblocked by the admin';
    if($notify->save()){
        $notifyCount = $users->notifyCount + 1;
        user::where('id', $users->id)->update(['notifyCount'=>$notifyCount]);
    } 

        }
                    return redirect()->back()->with('success', 'Completed Successfully');
    }

    public function bill_transactions(){

        $transaction = bill_transactions::latest()->simplePaginate(30);
        return view('admin.users.bill_transactions', compact('transaction'));
    }

    public function bill_transaction($id){

        $transaction = bill_transactions::where('user_id', $id)->latest()->simplePaginate(20);
        return view('admin.users.bill_transactions', compact('transaction'));
    }

    public function users_settlement(){

        $settlements = settlement::latest()->simplePaginate(30);
        return view('admin.users.settlements', compact('settlements'));
    }

    public function confirm_settle($id){
        $dd = settlement::where('id', $id)->first();
        $shop = shop::where('id', $dd->shop_id)->first();
        $settle = settlement::find($id)->update([
            'is_settled' => 1
        ]);
        $notify = new notifications;
        $notify->user_id = $shop->user->id;
        $notify->topic = 'New Confirmed Settlement!';
        $notify->message = 'Dear '.$shop->user->name. ' '.'An Admin just confirmed the settlement for Order ID'.' '.$dd->order_id.' Please go to your shop and confirm if you received payment';
        if($notify->save()){
            $notifyCount = $shop->user->notifyCount + 1;
            user::where('id', $shop->user->id)->update(['notifyCount'=>$notifyCount]);
        } 
        if($settle){
            return redirect()->back()->with('success', 'Settlment confirmed successfully');
        }

    }
}
