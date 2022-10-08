
@extends('layouts.app')

@section('navigation')
   <div class="header-area" id="headerArea">
      <div class="container h-100 d-flex align-items-center justify-content-between">
        <!-- Back Button-->
        <div class="back-button"><a href="{{route('checkout.index')}}"><i class="lni lni-arrow-left"></i></a></div>
        <!-- Page Title-->
        <div class="page-heading">
          <h6 class="mb-0">Payment</h6>
        </div>
        <!-- Navbar Toggler-->
        <div class="suha-navbar-toggler d-flex justify-content-between flex-wrap" id="suhaNavbarToggler"><span></span><span></span><span></span></div>
      </div>
    </div>

@endsection

@section('content')
 <div class="page-content-wrapper">
      <div class="container">
        <!-- Checkout Wrapper-->
        <div class="checkout-wrapper-area py-3">
          <!-- Credit Card Info-->
          <div class="credit-card-info-wrapper"><img class="d-block mb-4" src="img/bg-img/12.png" alt="">
            <div class="pay-credit-card-form">
                <div class="form-group">
                  <label for="cardNumber">Total Amount to pay</label>
                  <input class="form-control" style="background: #fff" type="text" placeholder="" value="N{{number_format($amount,2)}}" readonly><small class="ml-1"><i class="fa fa-lock mr-1"></i>Your payment info is stored securely
                </div>
                </div>
                <form>
                  <script src="https://api.payant.ng/assets/js/inline.min.js"></script>
                       <button class="btn btn-primary btn-lg w-100" onclick="payWithPayant()" type="button">Pay Now</button>
               </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    @endsection
    @section('script')
<script>

var amount = {!! json_encode($amount) !!}
  function payWithPayant() {
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
                    window.location = {!! json_encode('https://paym.com.ng/verify/orderpayment/') !!} +trxref; //Add your success page here
                } else {
                    window.location = {!! json_encode('https://paym.com.ng/verify/orderpayment/') !!} +trxref;
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