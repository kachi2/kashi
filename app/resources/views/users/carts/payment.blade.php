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
      {{Form::open(['action'=>'checkoutController@store', 'method'=>'post'])}}
        <!-- Checkout Wrapper-->
        <div class="checkout-wrapper-area pt-3">
          <!-- Choose Payment Method-->
           
          <div class="choose-payment-method">
            <h6 class="mb-3 text-center">Choose Payment Method</h6>
            <div class="row justify-content-center">
              <!-- Single Payment Method-->
             
              <div class="col-6 col-md-5">
                <div class="single-payment-method"><a class="credit-card" ><button type="submit"  style="border:none; color:blue; background:none" value="card" name="payment_method"><i class="lni lni-credit-cards"></i></button>
                    <h6>Credit Card</h6></a></div>
              </div>
              <!-- Single Payment Method-->
              <div class="col-6 col-md-5">
                <div class="single-payment-method"><a class="bank" href="{{route('bank_payment')}}" ><i class="lni lni-restaurant"></i></button>
                    <h6>Bank</h6>
                    </a></div>
              </div>
              <!-- Single Payment Method-->
              <div class="col-6 col-md-5">
                <div class="single-payment-method"><a class="paypal"><button type="submit"  value="wallet" style="border:none; color:blue; background:none" name="payment_method"><i class="lni lni-wallet"></i></button><br>
                    <span>Wallet: </span>
                    <span class="btn btn-primary p-1">N{{number_format(auth()->user()->wallet)}}</span>
                    </a>
                    
                    </div>
                    
              </div>
              <!-- Single Payment Method-->
              <div class="col-6 col-md-5">
                <div class="single-payment-method"><a class="cash" href="{{route('cash_payment')}}" ><i class="lni lni-revenue"></i></button>
                    <h6>Cash</h6></a></div>
              </div>
             
            </div>
          </div>
        </div>
         {{Form::close()}}
      </div>
    </div>
@endsection

