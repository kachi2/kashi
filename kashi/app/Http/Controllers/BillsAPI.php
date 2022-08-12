<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\bill_api_attempts;
use App\bill_products;
use App\bill_transactions;
use App\SmeData;
use Symfony\Component\HttpKernel\DataCo2llector\AjaxDataCollector;

class BillsAPI extends Controller
{
    public function __construct()
    {
        $this->vtpassUsername =  'mikkynoble@gmail.com';
        $this->vtpassPassword =  'Mikkynoble@1';
        $this->API_Vend = "b6fd39de1984f92465cd8d9169092ba9";
    }
    
    public function vtpass_wallet(){
          $host = 'https://vtpass.com/api/balance';
        $curl       = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $host,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_USERPWD => $this->vtpassUsername.":" .$this->vtpassPassword,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));
        $vtapssResponse = curl_exec($curl);
        $_response  = json_decode($vtapssResponse,true);
        //dd($_response);
        if (!empty($_response)) {
            if($_response['code'] == '1'){
                //dd($_response);
           $var = $_response['contents'];
          
            }   
    }
    return $var;
        
    }


    public function vtpassData_variations($slug)
    {
       // dd($slug);
        //$host = 'https://sandbox.vtpass.com/api/service-variations?serviceID='.$slug;
          $host = 'https://vtpass.com/api/service-variations?serviceID='.$slug;
        $curl       = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $host,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_USERPWD => $this->vtpassUsername.":" .$this->vtpassPassword,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));
        $vtapssResponse = curl_exec($curl);
        $_response  = json_decode($vtapssResponse,true);
    // dd($_response);
        if (!empty($_response)) {
            if(isset($_response['response_description']) && $_response['response_description'] == '000'){
           $var = $_response['content'];
            }else{
              $var['varations'] = '';
             $var['variation_label'] =''; 
            } 
    }else{
        $var['varations'] = '';
        $var['variation_label'] ='';
    }
    //dd($var);
    return $var;
   
}
        public function vtpassData($transactionId)
        {
           // $host = 'https://sandbox.vtpass.com/api/pay';
            $host = 'https://vtpass.com/api/pay';
            $requestId = 'NNU-EX'.rand(11111,99999).rand(111,333);
            $transaction = bill_transactions::where('transactionId', $transactionId)->first();
            $data = array(
                'serviceID'=> $transaction->bill_product->service_id, //integer
                'amount' =>  $transaction->total_amount, // integer
                'phone' => $transaction->phone, //integer
                'request_id' => $requestId, // unique for every transaction,
                'variation_code' => $transaction->variation,
                'billersCode' => $transaction->biller_code
            );
            $curl  = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $host,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_USERPWD => $this->vtpassUsername.":" .$this->vtpassPassword,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $data,
            ));
            $vtapssResponse = curl_exec($curl);
            $_response  = json_decode($vtapssResponse,true);
            //dd( $_response);
            if (!empty($_response)) {
                if($_response['code'] == '000'){
                    $res['code'] = 'success';
                    if(!empty($_response['purchased_code'])){

                        bill_transactions::where('transactionId', $transaction->transactionId)
                        ->update(['bill_token' => $_response['purchased_code']]);
                    }
                    $resp['response_code'] = $_response['code'];
                    $resp['response_description'] = $_response['response_description'];
                }elseif($_response['code'] == '016'){
                    $res['code'] = 'failed';
                    $resp['response_code'] = $_response['code'];
                    $resp['response_description'] = $_response['response_description'];
                }else{
                    $res['code'] = 'error';
                    $resp['response_code'] = $_response['code'];
                    $resp['response_description'] = $_response['response_description'];
                }
            }
            bill_api_attempts::create([
                'transactionId' => $transaction->transactionId,
                'requestId' => $requestId,
                'response_code' => $_response['code'],
                'description' => $res['code'],
                'api_id' => $transaction->bill_product->api_id
            ]);
        return $res;
        }

        public function vtpassAirtime($transactionId)
        {
            $transaction = bill_transactions::where('transactionId', $transactionId)->firstOrFail();

           // $host = 'https://sandbox.vtpass.com/api/pay';
            $host = 'https://vtpass.com/api/pay';
            $requestId = 'NNU-EX'.rand(111111,9999999).rand(111,333);
            //dd($transaction->bill_product->service_id);
            $data = array(
                
                'serviceID'=> $transaction->bill_product->service_id, //integer
                'amount' =>  $transaction->amount, // integer
                'phone' => $transaction->phone, //integer
                'request_id' => $requestId, // unique for every transaction,
                'billersCode' => $transaction->biller_code
            );
            $curl  = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $host,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_USERPWD => $this->vtpassUsername.":" .$this->vtpassPassword,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $data,
            ));
            $vtapssResponse = curl_exec($curl);
            $_response  = json_decode($vtapssResponse,true);
           // print_r($_response);
           // dd($vtapssResponse);
            
            if (!empty($_response)) {
                if($_response['code'] == '000'){
                    $res['code'] = 'success';
                }elseif($_response['code'] == '016'){
                    $res['code'] = 'failed';
                    $resp['response_code'] = $_response['code'];
                    $resp['response_description'] = $_response['response_description'];
                }else{
                    $res['code'] = 'pending';
                    $resp['response_code'] = $_response['code'];
                    $resp['response_description'] = $_response['response_description'];
                }
            }else{
                $res['code'] = 'error';
                $resp['response_code'] = '';
                $resp['response_description'] = '';
            }
            bill_api_attempts::create([
                'transactionId' => $transactionId,
                'requestId' => $requestId,
                'response_code' => $_response['code'],
                'description' => $res['code'],
                'api_id' => $transaction->bill_product->api_id
            ]);
        return $res;
            
        }

     

        public function VTpassVerify(Request $request){
           /// $host = 'https://sandbox.vtpass.com/api/merchant-verify';
             $host = 'https://vtpass.com/api/merchant-verify';
            $data = array(
                'billersCode' => $request->billerCode,
                'serviceID' =>  $request->serviceId,
                'type'=>$request->type
            );
            $curl  = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $host,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_USERPWD => $this->vtpassUsername.":" .$this->vtpassPassword,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $data,
            ));
            $vtapssResponse = curl_exec($curl);
            //$_response  = json_decode($vtapssResponse,true);

            return response()->json($vtapssResponse);

        }
        
        public function vtpassBills($transactionId)
        {
            $transaction = bill_transactions::where('transactionId', $transactionId)->firstOrFail();

            //$host = 'https://sandbox.vtpass.com/api/pay';
             $host = 'https://vtpass.com/api/pay';
            $requestId = 'payM'.rand(111111,9999999).rand(111,333);
            //dd($transaction->bill_product->service_id);
            $data = array(
                
                'serviceID'=> $transaction->bill_product->service_id, //integer
                'amount' =>  $transaction->amount, // integer
                'phone' => $transaction->phone, //integer
                'request_id' => $requestId, // unique for every transaction,
                'billersCode' => $transaction->biller_code,
                'variation_code'=>$transaction->variation
            );
          //  dd($data);
            $curl  = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $host,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_USERPWD => $this->vtpassUsername.":" .$this->vtpassPassword,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $data,
            ));
            $vtapssResponse = curl_exec($curl);
            $_response  = json_decode($vtapssResponse,true);
          // dd($_response);
           //dd($vtapssResponse);
            
            if (!empty($_response)) {
                if($_response['code'] == '000'){
                    $res['code'] = 'success';
                    if(!empty($_response['purchased_code'])){

                        bill_transactions::where('transactionId', $transaction->transactionId)
                        ->update(['bill_token' => $_response['purchased_code']]);
                    }
                }elseif($_response['code'] == '016'){
                    $res['code'] = 'failed';
                    $resp['response_code'] = $_response['code'];
                    $resp['response_description'] = $_response['response_description'];
                }else{
                    $res['code'] = 'pending';
                    $resp['response_code'] = $_response['code'];
                    $resp['response_description'] = $_response['response_description'];
                }
            }else{
                $res['code'] = 'error';
                $resp['response_code'] = '';
                $resp['response_description'] = '';
            }
            bill_api_attempts::create([
                'transactionId' => $transactionId,
                'requestId' => $requestId,
                'response_code' => $_response['code'],
                'description' => $res['code'],
                'api_id' => $transaction->bill_product->api_id
            ]);
         // dd($res);
            return $res;
        }

        public function zealData_variation($slug){
            $cURL = curl_init();
            curl_setopt($cURL, CURLOPT_URL, 'https://zealvend.com/api/data/bundles?network='.$slug);
            curl_setopt($cURL, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json",
                "Authorization: Bearer".$this->Zeal_Vend
            ));
            curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true); 
            $se = curl_exec($cURL);
            curl_close($cURL);
            $res = json_decode($se, true);
           // dd($res);
            return $res;
            }
            
          public function zeal_balance(){
            $cURL = curl_init();
            curl_setopt($cURL, CURLOPT_URL, 'https://zealvend.com/api/user/profile');
            curl_setopt($cURL, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json",
                "Authorization: Bearer".$this->Zeal_Vend
            ));
            curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true); 
            $se = curl_exec($cURL);
            curl_close($cURL);
            $res = json_decode($se, true);
           // dd($res);
            $response = $res['user'];
            return $response;
            }

            public function Vend_Data($transactionId){
                $transaction = bill_transactions::where('transactionId', $transactionId)->first();
                $requestId = 'payM'.rand(111111,9999999).rand(111,333);
                $dataId = SmeData::where('variation', $transaction->variation)->first();
                // $data = array(
                //     "network" => 01,
                //     "dataplan" => $dataId->code,
                //     "mobileno" => $transaction->phone,
                // );
                // $post = json_encode($data, true); 
            
                $cURL = curl_init();
                    curl_setopt_array($cURL, array(
                    CURLOPT_URL => "https://iSub.com.ng/buydata_api",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_HTTPHEADER => array(
                        "AuthorizationToken: ".$this->API_Vend,
                        "cache-control: no-cache"
                    ),
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => array(
                        'network' => 01,
                        'mobileno' => $transaction->phone,
                        'dataplan' => $dataId->code,
                        ),
                    ));
                    $resp = curl_exec($cURL);
                    curl_close($cURL);
                    $response = json_decode($resp, true);
                    dd($resp);
                return $response;
                }

        public function DataVariation($slug){
            $data = SmeData::where('slug', $slug)->get();
            return $data;
        }
}
