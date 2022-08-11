<?php
namespace App\Http\Controllers;

use App\bill_products;
use App\bill_category;
use App\bill_transactions;
use App\wallet_transaction;
use App\User;
use Symfony\Component\HttpFoundation\Session\Session;
use App\bills_products;
use App\product;
use DB;
use Illuminate\Http\Request;

class BillsController extends Controller
{
    public function __construct()
    {
        $this->payantToken = "6d97a845397070068c46c802c57e595b2a8c767a3c546de307f16305";
        $this->middleware('auth');
        
    }

    public function bill_category($id){
        $ff = explode('_', $id);
        $category = bill_category::findorfail($ff[1]);
        $products = bill_products::where('bill_category_id', $ff[1])->get();
        $top_products = product::where('views','>', '10')->inRandomOrder()->take(10)->get();
        return view('users.services.category', compact('products', 'top_products'));
    }
    
    public function get_variation($slug){
        $data['slug'] = bill_products::where('slug', $slug)->first();
        //dd($data['slug'] );
        if($data['slug']->bill_category_id == 2 || $data['slug']->bill_category_id == 3 || $data['slug']->bill_category_id == 5){
            $apiResult = app('App\Http\Controllers\BillsAPI')->vtpassData_variations($data['slug']->slug); 
          //dd($apiResult); 
          if($apiResult['varations']){      
            foreach ($apiResult['varations'] as $key => $value) {
                $da['v_code'] = $value['variation_code'];
                $da['price'] = $value['variation_amount'];
                $da['name'] = $value['name'];
                $vars[] = $da;
                $xda[$value['variation_code']] = $value['name'];
                $vars_x = $xda;
            }
            $data['serviceName'] = $apiResult['ServiceName'];
            $data['serviceID'] = $apiResult['serviceID'];
            $data['varations'] = $vars;
            $data['varation_labels'] = $vars_x;  
        }else{
            $data['varations'] = '';
            $data['varation_labels'] = '';
        }

    } else if($data['slug']->bill_category_id == 6){
                $apiResult = app('App\Http\Controllers\BillsAPI')->zealData_variation($data['slug']->slug); 
              // dd($apiResult['data'] );
                if($apiResult['data']){     
                foreach ($apiResult['data'] as $key => $value) {
                   // dd($value);
                    $da['v_code'] = $value['bundle'];
                    $da['price'] = $value['price'] + $value['price']*0.02;
                    $da['name'] = $value['network'];
                    $da['period'] = $value['validity'];
                    $vars[] = $da;
                    $xda[$value['bundle']] = $value['bundle'].' '.'N'.number_format($value['price'] + $value['price']*0.02,2).' '.$value['validity'];
                    $vars_x = $xda;
                }
                $data['varations'] = $vars;
                $data['varation_labels'] = $vars_x; 
            }else{ 
                $data['varations'] = '';
               $data['varation_labels'] = ''; 
                }
               // dd($data);
        }else{ 
            $data['varations'] = '';
            $data['varation_labels'] = ''; 
            }
      
        return view ('users.services.buy', $data);
}

    public function initiateTransaction(Request $request, $slug){
      // dd($request->all());
       $validator=  $this->validate($request, [
            'amount'=>['required', 'min:1'],
            'phone' => ['required', 'min:9','regex:/(070|080|081|090)[0-9]/'],
            'variation',
            'billercode'=>'Numeric',
            'billerName',
            'phone'=>'Numeric'
        ]);  
       // dd($validator);
        if(!$validator){
            return back();
        }else{
            $api_product = bill_products::where('slug', $slug)->first();
        $user = User::where('id', auth()->user()->id)->first();
        if($user->is_wallet == 0){
            \Session::flash('wallet', 'Your Wallet is not activated yet, <br> kindly Goto Settings to request activation');
            return redirect()->back();
        }
        if($user->is_wallet == 2){
            \Session::flash('wallet', 'Your Wallet is disabled, kindly contact Admin');
            return redirect()->back();
        }
        if($user->wallet < $request->amount){
            return redirect()->back()->withErrors('Your wallet is balance low for this transction');
        } 
        
        if(!empty($request->variation)){
            $varies = $this->get_variation($slug);
        }
        //commission calculator
        if ($api_product->commission_type == 'flat' && auth()->user()->level == 2) {
            $commission =  $api_product->commission;
        }elseif($api_product->commission_type == 'percentage' && auth()->user()->level == 2 ){
            $commission = (($api_product->commission / 100) * $request->amount);
        }else{
            $commission = '0.00';
        }
        if($api_product->min_amount > $request->amount){
            
            \Session::flash('wallet', 'You cannot pay less than N'.$api_product->min_amount .'.00 for this service');
            return redirect()->back();
        }
         if($api_product->max_amount < $request->amount){
            \Session::flash('wallet', 'You cannot pay above than N'.$api_product->max_amount .'.00 for this service');
            return redirect()->back();
        }
        if ($api_product->convinience_fee) {
            $fee =  $api_product->convinience_fee;
        }else{
            $fee = '0.00';
        }
        $amount_charged = $request->amount;
        $total_amount = $amount_charged + $fee;
        $transactionId = rand(11111,99999).time();
        //initiate Transaction
        $createTransaction = bill_transactions::create([
           'amount' => $request->amount,
           'fee' => $fee, 
           'total_amount' => $total_amount,
           'transactionId' => $transactionId,
           'bill_products_id' => $api_product->id,
           'status' => 'proccessing',
           'user_id' => $user->id,
           'email' => $user->email,
           'phone' => $request->phone,
           'variation' => $request->variation,
           'commission' => $commission,
           'biller_code' => $request->billercode,
           'service_verification' => $request->billerName,
        ]);
        //charge User 
        $this->chargeUser($transactionId);
        //completed transaction
        if($api_product->bill_category_id == 1){
             //airtime
            $apiResult = app('App\Http\Controllers\BillsAPI')->vtpassAirtime($transactionId);
        }elseif($api_product->bill_category_id == 2){
               //data
            $apiResult = app('App\Http\Controllers\BillsAPI')->vtpassData($transactionId); 
        }elseif($api_product->bill_category_id == 3 || $api_product->bill_category_id == 4 || $api_product->bill_category_id ==5){
                //pay bills
            $apiResult = app('App\Http\Controllers\BillsAPI')->vtpassBills($transactionId);
        }else if($api_product->bill_category_id == 6){
            $zealVend = app('App\Http\Controllers\BillsAPI')->zealVend_Data($transactionId);
        }else{
            return back();
        }
       //dd($apiResult['code']);
        if(isset($apiResult)){
        if($apiResult['code'] == 'success'){
            $newUpdate = bill_transactions::where('transactionId', $transactionId)->update([
                'status' => 'Successful'
            ]);
            
         $referral = User::where('id', auth()->user()->referral_id)->first();
        if($referral){
             
        $tt = explode(" ", auth()->user()->name);
        $name = $tt[0];
            $ref_com = ((0.2/ 100)* $request->amount);
            $newWallet = $referral->wallet + $ref_com;
            $update = User::where('id', $referral->id)
                    ->update(['wallet' => $newWallet]);
                $wallet = wallet_transaction::create([
                'user_id' => $referral->id,
                'transaction_ref' => $transactionId,
                'external_ref'=>null,
                'purpose' => 'Referral Commission from'.' '.$name,
                'type' => 'credit',
                'amount'=> $ref_com,
                'commission' => $ref_com,
                'prev_balance'=>$referral->wallet,
                'avail_balance' => $newWallet
            ]);
            
            }
            return view('users.services.successpay');


        }else if($apiResult['code'] == 'failed'){
            $newUpdate = bill_transactions::where('transactionId', $transactionId)->update([
                'status' => 'Failed'
            ]);
            sleep(5);
            $user_w = User::where('id', auth()->user()->id)->first();
            $newWallet = $user_w->wallet + $total_amount;
            $newCom = $user_w->comm_wallet - $commission;
            $updateUser = user::where('id', $user->id)->update([
                'wallet'=>$newWallet,
                'comm_wallet'=> $newCom,
            ]);
            $wallet = wallet_transaction::create([
                'user_id' => $user->id,
                'transaction_ref' => $transactionId,
                'external_ref'=>null,
                'purpose' => 'Reversal for'.' '.$api_product->slug,
                'type' => 'credit',
                'amount'=> $total_amount,
                'commission' => $commission,
                'prev_balance'=>$user_w->wallet,
                'avail_balance' => $newWallet
            ]);
            //dd($wallet);
            \Session::flash('msg', 'Transaction Failed, Please try Again'); 
            return back();

        }else if($apiResult['code'] == 'pending'){
            $newUpdate = bill_transactions::where('transactionId', $transactionId)->update([
                'status' => 'Failed'
            ]);
            sleep(5);
            $user_w = User::where('id', auth()->user()->id)->first();
            $newWallet = $user_w->wallet + $total_amount;
            $newCom = $user_w->comm_wallet - $commission;
            $updateUser = user::where('id', $user->id)->update([
                'wallet'=>$newWallet,
                'comm_wallet'=> $newCom,
            ]);
            $wallet = wallet_transaction::create([
                'user_id' => $user->id,
                'transaction_ref' => $transactionId,
                'external_ref'=>null,
                'purpose' => 'Reversal for'.' '.$api_product->slug,
                'type' => 'credit',
                'amount'=> $total_amount,
                'commission' => $commission,
                'prev_balance'=>$user_w->wallet,
                'avail_balance' => $newWallet
            ]);
            \Session::flash('msg', 'Transaction Failed, Please try Again');
            \Session::flash('alert-class', 'alert-danger');
                return back();
            }
            else if($apiResult['code'] == 'error'){
            $newUpdate = bill_transactions::where('transactionId', $transactionId)->update([
                'status' => 'Failed'
            ]);
            sleep(5);
            $user_w = User::where('id', auth()->user()->id)->first();
            $newWallet = $user_w->wallet + $total_amount;
            $newCom = $user_w->comm_wallet - $commission;
            $updateUser = user::where('id', $user->id)->update([
                'wallet'=>$newWallet,
                'comm_wallet'=> $newCom,
            ]);
            $wallet = wallet_transaction::create([
                'user_id' => $user->id,
                'transaction_ref' => $transactionId,
                'external_ref'=>null,
                'purpose' => 'Reversal for'.' '.$api_product->slug,
                'type' => 'credit',
                'amount'=> $total_amount,
                'commission' => $commission,
                'prev_balance'=>$user_w->wallet,
                'avail_balance' => $newWallet
            ]);
            \Session::flash('msg', 'Transaction Failed, Please try Again');
            \Session::flash('alert-class', 'alert-danger');
            return back();
            }else{
                \Session::flash('msg', 'Something went wrong');
            \Session::flash('alert-class', 'alert-danger');
            return back();
            }
    
        }elseif(isset($zealVend)){
          //dd($zealVend);
          
           if($zealVend['status'] == 'success'){
            $newUpdate = bill_transactions::where('transactionId', $transactionId)->update([
                'status' => 'Successfull'
            ]);
            return view('users.services.successpay');
               
           }elseif($zealVend['status'] == 'failed'){
            $newUpdate = bill_transactions::where('transactionId', $transactionId)->update([
                'status' => 'Failed'
            ]);
            sleep(5);
            $user_w = User::where('id', auth()->user()->id)->first();
            $newWallet = $user_w->wallet + $total_amount;
            $newCom = $user_w->comm_wallet - $commission;
            $updateUser = user::where('id', $user->id)->update([
                'wallet'=>$newWallet,
                'comm_wallet'=> $newCom,
            ]);
            $wallet = wallet_transaction::create([
                'user_id' => $user->id,
                'transaction_ref' => $transactionId,
                'external_ref'=>null,
                'purpose' => 'Reversal for'.' '.$api_product->slug,
                'type' => 'credit',
                'amount'=> $total_amount,
                'commission' => $commission,
                'prev_balance'=>$user_w->wallet,
                'avail_balance' => $newWallet
            ]);
            \Session::flash('msg', 'Transaction Failed, Please try Again');
            \Session::flash('alert-class', 'alert-danger');
                return back();
            
        }else{
            $newUpdate = bill_transactions::where('transactionId', $transactionId)->update([
                'status' => 'Failed'
            ]);
            sleep(5);
            $user_w = User::where('id', auth()->user()->id)->first();
            $newWallet = $user_w->wallet + $total_amount;
            $newCom = $user_w->comm_wallet - $commission;
            $updateUser = user::where('id', $user->id)->update([
                'wallet'=>$newWallet,
                'comm_wallet'=> $newCom,
            ]);
            $wallet = wallet_transaction::create([
                'user_id' => $user->id,
                'transaction_ref' => $transactionId,
                'external_ref'=>null,
                'purpose' => 'Reversal for'.' '.$api_product->slug,
                'type' => 'credit',
                'amount'=> $total_amount,
                'commission' => $commission,
                'prev_balance'=>$user_w->wallet,
                'avail_balance' => $newWallet
            ]);
            \Session::flash('msg', 'Transaction Failed, Please try Again');
            \Session::flash('alert-class', 'alert-danger');
            return back();
        }
        }else{
           \Session::flash('msg', 'Transaction Failed, Please try Again');
            \Session::flash('alert-class', 'alert-danger');
            return back(); 
        }
    }
}

    public function chargeUser($transactionId){
        $transaction = bill_transactions::where('transactionId', $transactionId)->first();
        $user = user::where('id', auth()->user()->id)->first();
        
        $userOldWallet = $user->wallet;
        $userNewWallet = $user->wallet - $transaction->total_amount;
        $userComm = $user->comm_wallet + $transaction->commission;
        $updateUser = user::where('id', $user->id)->update([
            'wallet'=>$userNewWallet,
            'comm_wallet' =>$userComm 
        ]);
        $wallet = wallet_transaction::create([
            'user_id' => $user->id,
            'transaction_ref' => $transaction->transactionId,
            'external_ref'=>null,
            'purpose' => 'Purchased'.' '.$transaction->bill_product->name,
            'type' => 'debit',
            'amount'=> $transaction->total_amount,
            'commission' => $transaction->commission,
            'prev_balance'=>$userOldWallet,
            'avail_balance' => $userNewWallet
        ]);
        //dd($wallet);

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
             }
     
        $paymentStatus = $resp['data']['status'];
        $chargeResponsecode = $resp['data']['status'];
        $chargeAmount = $resp['data']['amount'];
        $chargeCurrency = $resp['data']['currency'];
        $custemail = $resp['data']['client']['email'];
        $payment_id = $resp['data']['payment_id'];
        $external_ref = $resp['data']['reference_code'];

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
            //dd($paymentStatus);
       return response()->json($se);
          
        } else {
            alert()->error('error', 'Payment Failed');
            return redirect()->route('my_wallet');
        }
    }
}
