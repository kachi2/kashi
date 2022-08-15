<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentProcessor extends Controller
{
    //


    public function __construct()
    {
        
    }

#=========== user reserve account ============

public function RequestAccount(){

    $baseUrl = 'https://sandbox.monnify.com/api/v1/auth/';
    $requestId = 'payM'.rand(111111,9999999).rand(111,333);
    //dd($transaction->bill_product->service_id);
    $data = array(
 
    );
  //  dd($data);
    $curl  = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => $baseUrl,
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
}

}
