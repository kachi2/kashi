<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\webhook;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function webhook(Request $request){
                
                    $request = file_get_contents('php://input');
                    $req_dump = print_r( $request, true );
                    
                   
                    $fp = file_put_contents( 'request.log', $req_dump );
                    Log::debug('An informational message.');
                http_response_code(200); 
                 dd($request);
            
    }
    
    
    public function initiate_pay(){
            $data = array(
               "bankCode" => "000001",
                "accountNumber" => "8260345467",
                "amount" => 300,
                "senderBankCode" => "000001",
                "senderAccountNumber" => "0000000000",
                "senderAccountName" =>"CONNECT DEMO"
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
            dd($resp);
            return redirect()->route('webhooks_j');
    }
}
