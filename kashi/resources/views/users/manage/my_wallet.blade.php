@extends('layouts.app')
@section('navigation')
   <div class="header-area" id="headerArea">
      <div class="container h-100 d-flex align-items-center justify-content-between">
        <!-- Back Button-->
        <div class="back-button"><a href="{{route('home')}}"><i class="lni lni-arrow-left"></i></a></div>
        <!-- Page Title-->
        <div class="page-heading">
          <h6 class="mb-0">My Wallet</h6>
        </div>
        <!-- Navbar Toggler-->
        <div class="suha-navbar-toggler d-flex justify-content-between flex-wrap" id="suhaNavbarToggler"><span></span><span></span><span></span></div>
      </div>
    </div>

@endsection
@section('content')

 <div class="page-content-wrapper">
      <div class="container">
        <!-- Notifications Area-->
        <div class="notification-area pt-3 pb-2">
          <h6 class="pl-1"></h6> 
       
          @include('includes.message')
          <div class="list-group">
                 @if(Session::has('succes'))
          <span class="alert btn-warning"> {{Session::get('succes')}}</span>
          @endif
            <!-- Single Notification-->
          <span> <button class="btn btn-primary float-right top:20px" id="top-up"> Top-Up Wallet </button></span>
            <span class="list-group-item d-flex align-items-center p-5" >
              
               
                <p class="mb-0" style="font-weight:bold">  
                Main Wallet <a href=""> <span style="color:#fff" class="btn-primary p-2">₦{{number_format(auth()->user()->wallet,2)}}</span>
                 </p></a>
                 <div class="p-3"> </div>
                 <p class="mb-0" style="font-weight:bold">
                Commission: <span style="color:#fff" class=" btn-primary p-2">₦{{number_format(auth()->user()->comm_wallet,2)}}</span>
          
                 </p>
              </span>
              <div id="hide">
            {{Form::open(['action' => 'HomeController@transfer_fund', 'method'=>'post'])}}
              <input type="text" class="form-control" id="trans" name="amount" placeholder="Enter Amount" autocomplete="off">  
               <div class="p-1"></div>
              
            <center> <button class="btn btn-primary" type="button" id="transfer"> Transfer commission to main wallet</button>
            <button type="submit" class="btn btn-primary" id="complete">Complete Transfer</button></center> 
                </form>
                </div>
               {{Form::open(['action' =>'HomeController@manual_topUp', 'method'=>'post'])}}
            <script src="https://api.payant.ng/assets/js/inline.min.js"></script>
            <input type="number" class="form-control" id="pays" name="amount" placeholder="Enter Amount" required autocomplete="off">  
            <div class="p-1"></div>
            <center><button type="button"  id="payant" class="btn btn-warning" onclick="payWithPayant()">Fund with Card</button> 
         <button type="submit" id="manual" class="btn btn-success">Fund with Bank Transfer</button></center>
         {{Form::close()}}
         
         <div class="p-3">
         
         </div>
          
        <h6 class="pl-1">Recent Transactions</h6>
             @if(count($transactions)> 0)
             @foreach ($transactions as $tt )
                 <span class="list-group-item d-flex align-items-center" href="">
             <div class="noti-info">
              <p class="mb-0" style="font-weight:bold; font-size:12px">
              {{strtoupper($tt->purpose)}}  &nbsp;  ₦{{number_format($tt->amount,2)}}
              &nbsp; <span> Pre Bal: ₦{{number_format($tt->prev_balance)}}
                    Avail Bal: ₦{{number_format($tt->avail_balance)}}</span>
              <span>Type: @if($tt->type == 'credit') <button class="btn btn-success btn-sm">{{strtoupper($tt->type)}}</button> @else <button class="btn btn-warning btn-sm">{{strtoupper($tt->type)}}</button> @endif &nbsp; {{$tt->created_at}}</span>
                 </p>
             </div> 
                </span>
                    @endforeach
           <div> {{$transactions->links()}}</div>
                @else
                 <span class="list-group-item d-flex align-items-center" href="">
             <div class="noti-info">
              <p class="mb-0" style="font-weight:bold">
              You have not done any Transactions yet
                 </p>
             </div> 
                </span>
                @endif
          </div>
          
        </div>
      </div>
    </div>
@endsection

@section('script')
        <script>
        
        $(window).on('load', function(){
        
        document.getElementById('trans').hidden=true;
        document.getElementById('complete').hidden=true;
        document.getElementById('payant').hidden=true;
        document.getElementById('pays').hidden=true;
        document.getElementById('manual').hidden=true;
        });
        
        $('#transfer').on('click', function(){
        
        document.getElementById('trans').hidden=false;
        document.getElementById('transfer').hidden=true;
        document.getElementById('complete').hidden=false;
        
        });
        
        $('#top-up').on('click', function(){
        
        document.getElementById('transfer').hidden=true;
        document.getElementById('payant').hidden=false;
        document.getElementById('pays').hidden=false;
        document.getElementById('top-up').hidden=true;
        document.getElementById('manual').hidden=false;
        document.getElementById('hide').hidden=true;
        document.getElementById('complete').hidden=true;
        document.getElementById('trans').hidden=true;
        
        });
        
         $('#manual').on('click', function(){
        
          $('#manual').html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>Please wait...'); 
          $('#manual').attr('readOnly', true);
    });  
        
        </script>
        
        
        <script>
          function payWithPayant() {
        
        var token = {!! json_encode(config('app.payantPub_key')) !!};
        var first_name = {!! json_encode(auth()->user()->name) !!};
        var last_name = {!! json_encode(auth()->user()->name) !!};
        var email = {!! json_encode(auth()->user()->email) !!};
        var phone = {!! json_encode(auth()->user()->phone) !!};
            var amount = document.getElementById('pays').value;

    var handler = Payant.invoice({
      "key": token,
      "client": {
            "first_name": first_name,
            "last_name": last_name,
            "email": email,
            "phone": phone
        },
      "due_date": "12/30/2016",
      "fee_bearer": "client",
      "items": [
        {
          "item": ".Com Domain Name Registration",
          "description": "alberthostpital.com",
          "unit_cost": amount,
          "quantity": "1"
        }
      ],
      callback: function(response) {
      const trxref = response.reference_code;

      if (response.reference_cod == "200" || response.reference_cod == "0") {
                    // redirect to a success page
                    window.location = {!! json_encode('https://paym.com.ng/verify/walletpayment/') !!} +trxref; //Add your success page here
                } else {
                    window.location = {!! json_encode('https://paym.com.ng/verify/walletpayment/') !!} +trxref;
                }
      },
      onClose: function() {
        console.log('Window Closed.');
      }
    });

    handler.openIframe();
  }
</script>
@endsection