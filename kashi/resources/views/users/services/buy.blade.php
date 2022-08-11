@extends('layouts.app')
@section('navigation')
   <div class="header-area" id="headerArea">
      <div class="container h-100 d-flex align-items-center justify-content-between">
        <!-- Back Button-->
        <div class="back-button"><a href="{{route('home')}}"><i class="lni lni-arrow-left"></i></a></div>
        <!-- Page Title-->
        <div class="page-heading">
          <h6 class="mb-0">Buy</h6>
        </div>
        <!-- Navbar Toggler-->
        <div class="suha-navbar-toggler d-flex justify-content-between flex-wrap" id="suhaNavbarToggler"><span></span><span></span><span></span></div>
      </div>
    </div>

@endsection
@section('content')
    @section('content')
 <div class="page-content-wrapper">
      <!-- Catagory Single Image-->
      <div class="p-3"></div>
      <!-- Product Catagories-->
      <div class="product-catagories-wrapper mt-3">
        <div class="container">
          <div class="section-heading">
            <h6 class="ml-1">Buy {{strtoupper($slug->slug)}}</h6>
          </div>
         <div class="card user-data-card">
            <div class="card-body">
                    @if(Session::has('msg'))
            <p class="alert {{Session::get('alert-class', 'alert-danger')}}">{{ Session::get('msg') }}</p>
              @endif
                @if(Session::has('wallet'))
            <p class="alert {{Session::get('alert-class', 'alert-danger')}}">{!! Session::get('wallet') !!}</p>
              @endif
           {{Form::open(['action'=>['BillsController@initiateTransaction',$slug->slug], 'method'=>'post', 'id'=>'form1'])}}  
           @csrf

             @if($slug->biller_name == 'meterNumber')
                <div class="form-group">
                  <div class="title mb-2"><i class="lni lni-scroll-down"></i><span>Select Variation</span></div>                           
               <select name="variation" id="varType" class="form-control" required>
               <option value="postpaid">Postpaid</option>
               <option value="prepaid">Prepaid</option>
               </select>
               </div>
                 @endif

         @if(!empty($slug->biller_name))
           <div class="form-group">
                  <div class="title mb-2">
                  
                  <i class="lni lni-layout"></i><span>{{$slug->biller_name == 'smartcard'? 'Smartcard': 'Meter Numer'}}</span></div>
                  <input class="form-control @error('billercode') is-invalid @enderror" id="verify" maxlength="18" type="number" value="{{old('billercode')}}" name="billercode" placeholder="000000000" autocomplete="off" required>
                @error('billercode')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                </div>
                 <div class="form-group">
                  <div class="title mb-2">
                  
                  <i class="lni lni-user"></i><span>Customer Name</span>
                  </div>
                <div class="input-group mb-2">
                <input type="text" name="billerName" class="form-control text-justify" id="verifyName" readonly>
                <div class="input-group-append">
                  <span class="input-group-text" id="load"></span>
                </div>
              </div>
             </div>
                @endif
               
                <div class="form-group">
                  <div class="title mb-2">
                  <i class="lni lni-phone"></i><span>Phone Number</span></div>
                  <input class="form-control @error('phone') is-invalid @enderror" id="phone" minlength="9" maxlength="13" type="number" value="{{old('phone')}}" name="phone" placeholder="0803000000" autocomplete="off">
                @error('phone')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                </div>
            
                @if(!empty($varation_labels)) 
                <div class="form-group">
                  <div class="title mb-2"><i class="lni lni-scroll-down"></i><span>Select Variation</span></div>                           
                {!!Form::select('variation',$varation_labels,'',['class' => 'form-control','placeholder' => 'Select Variation', 'id'=>'vary','required'])!!}
                </div>
                 @endif

                <div class="form-group">
                  <div class="title mb-2"><i class="lni lni-money-location"></i><span>Amount</span></div>
                  <input class="form-control @error('amount') is-invalid @enderror"   id="myInput1"  onchange="myChangeFunction(this)" type="number"  
                  name="amount" placeholder="0.00" autocomplete="off">
                   @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                     @enderror
                </div>
                 @if($slug->biller_name == 'smartcard')
                <span class="float-right" style="font-size:12px; font-weight:bold"> Edit Price?<input type="checkbox" id="edit_price"> </span>
                @endif
                <input type="hidden"  id="myInput2">
                  @php 
                  $wallet = auth()->user()->wallet;
                  @endphp
                <input type="checkbox" onchange="mybox(this)" id="mycheck" disabled>
                 eWallet:<button class="btn btn-primary btn-sm p-1" disabled> ₦{{number_format($wallet,2)}}</button>
                 <p style="color:#000; font-weight:bold; font-size:11px" id="notif" hidden>Wallet is low for this amount</p>
                 <div style="margin:20px"></div>
                  <button class="btn btn-primary btn-lg w-100" id="btnsubmit" type="submit" >Pay</button>
                  </form>
                 
                  <form>
                  <script src="https://api.payant.ng/assets/js/inline.min.js"></script>
                <button type="button" id="btnsubmit2" class="btn btn-primary btn-lg w-100" onclick="payWithPayant()" hidden>Pay with Card</button>
               </form>
               
          </div>
        </div>
      </div>
      <!-- Top Products-->
      <hr>
    </div>
    
@endsection

   @section('script')
   
 
   <script>
   
     $(window).on('load',function(){
   
     document.getElementById("load").hidden = true;
   
   });


          $('#verify').on('change', function(){
               meter = $('#varType').val();
               //alert(meter);
            //alert(meter);
            document.getElementById("load").hidden = false;
              $('#load').html('<span class="spinner-grow text-success spinner-grow-sm" role="status" aria-hidden="true"></span> <span class="text-success" style="font-size:12px"> fetching Name... </span>');
            var serviceId = {!! json_encode($slug->service_id) !!}
            var billerCode = verify.value;
            $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
            });
     //var form_data = $(this);
        $.ajax({
          url: "/verify-account",
          type:"post",
          data:{
            serviceId: serviceId,
            billerCode: billerCode,
            type:meter
          },
           cache:false,
          dataType: "json",
          success:function(response){
         // console.log(response);
         // alert(response.code);
         document.getElementById("load").hidden = true;
          var data = $.parseJSON(response);
          if(data.content.error){
            var wrong = 'Wrong Account, Retry!';
            $('#verifyName').attr('placeholder',wrong);
            //$('#verifyName').attr('style','font-weight:bolder');
             document.getElementById('btnsubmit').disabled = true;
            document.getElementById('btnsubmit2').disabled = true;
           //console.log(response);
            
          }else if(data.content.Customer_Name){
           var success = data.content.Customer_Name;
            $('#verifyName').attr('value',success);
            document.getElementById('btnsubmit').disabled = false;
            document.getElementById('btnsubmit2').disabled = false;
            //console.log(response);
          }else{
             var err = 'Something went wrong';
            $('#verifyName').attr('placeholder', err);
          // $('#verifyName').attr('style','color:red');

            //console.log(response);
          }
          }
         });
   });

   </script>
<script>

      $(document).ready(function(){
        $( window ).on( "load", function() {
      var p_amount_edit = {!! json_encode($slug->is_price_editable) !!}
        if (p_amount_edit ==  0) {
          $('#myInput1').attr('readonly','readonly');
        }
      });

      });


 $('#edit_price').on('change',function(params){
   if(document.getElementById("edit_price").checked == true){
    $('#myInput1').attr('readonly',false);
   }else{

  location.reload();

   }
  
 // alert('am here');
  //document.getElementById('myInput1').disabled = false;

 });

   $('#vary').on('change',function(params) {
         var input2 = document.getElementById('vary');
         var wallet = {!! json_encode($wallet) !!}
         // alert(input2.value)     
        var variations = {!! json_encode($varations) !!}
        $.each(variations, function(key, value){
            if(value.v_code == input2.value)
            {
             // alert(value.v_code)
                var p_amount_edit = {!! json_encode($slug->is_price_editable) !!}
                if ((value.price > 1) && (p_amount_edit ==  0) ) { 
                  if(value.price <= wallet){                
                    document.getElementById("mycheck").checked = true;
                    document.getElementById('btnsubmit').hidden = false;
                     var $butt = document.querySelector('#btnsubmit');
                     document.getElementById('notif').hidden = true;
                        $butt.addEventListener('click', function() {
                      $('#btnsubmit').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Please Wait...');
                          });
                    document.getElementById('btnsubmit2').hidden = true;
                    document.getElementById("mycheck").disabled = false;
                  }else{
                     document.getElementById("mycheck").checked = false;
                    document.getElementById("mycheck").disabled = true;
                    document.getElementById('btnsubmit').hidden = true;
                    document.getElementById('notif').hidden = false;
                    document.getElementById('btnsubmit2').hidden = false;
                   
                  }
                      $('#myInput1').attr('readonly','readonly');
                }
                // alert(value.price);
                
                $('#myInput1').attr('value',value.price);
            }
        });
        
        
        
    });
</script>

 <script>
        function myChangeFunction(input1) {
          var input2 = document.getElementById('myInput2');
          input2.value = input1.value;
          var amount = input2.value;
          var wallet = {!! json_encode($wallet) !!}
        if(wallet >= amount){
            document.getElementById("mycheck").checked = true;
            document.getElementById('btnsubmit').hidden = false;
            document.getElementById('btnsubmit2').hidden = true;
            document.getElementById("mycheck").disabled = false;
            document.getElementById('notif').hidden = true;
            
                       var $butt = document.querySelector('#btnsubmit');
                        $butt.addEventListener('click', function() {
                      $('#btnsubmit').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Please Wait...');
                          });
        }else{
          document.getElementById("mycheck").checked = false;
          document.getElementById("mycheck").disabled = true;
          document.getElementById('notif').hidden = false;
          document.getElementById('btnsubmit').hidden = true;
          document.getElementById('btnsubmit2').hidden = false;
        } 
        }
</script>
<script>
        function mybox() {   
            if(document.getElementById("mycheck").checked == true){
            document.getElementById('btnsubmit2').hidden = true;
            document.getElementById('btnsubmit').hidden = false;
            
            }else{
              document.getElementById('btnsubmit2').hidden = false;
                document.getElementById('btnsubmit').hidden = true;
            } 
        }
</script>


<script>
     
  function payWithPayant() {
    var amount = document.getElementById('myInput1').value;
    var token = {!! json_encode(config('app.payantPub_key')) !!};
    var first_name = {!! json_encode(auth()->user()->name) !!};
    var last_name = {!! json_encode(auth()->user()->name) !!};
    var email = {!! json_encode(auth()->user()->email) !!};
    var phone = {!! json_encode(auth()->user()->phone) !!};
  
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
          "item": "Airtime",
          "description": "Airtime Payment",
          "unit_cost": amount,
          "quantity": "1",
        }
      ],
 
      callback: function(response) {
         
        const trxref = response.reference_code;
          $.ajax({
              url: 'https://paym.com.ng/verify/billpayment/'+ trxref,
              method: 'get',
              success: function (response) {
                // the transaction status is in response.data.status
                var data = $.parseJSON(response);
                var iamount = parseFloat(data.data.amount);
                //console.log(response.content);
                if(data.status == 'success' ){
                  if(iamount == amount){
                $('#form1').submit();
                  }
                }
                
              }
            });
      },
      onClose: function() {
        console.log('Window Closed.');
      }
    });

    handler.openIframe();
  }
</script>
  @endsection
  

   