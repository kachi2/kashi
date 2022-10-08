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
        <div class="checkout-wrapper-area py-3">
          <div class="credit-card-info-wrapper">
            <div class="bank-ac-info">
              <p>Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won’t be shipped until the funds have cleared in our account.</p>
              <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between align-items-center">Bank Name<span>Stanbic IBTC Bank.</span></li>
                <li class="list-group-item d-flex justify-content-between align-items-center">Account Number<span>0015900824</span></li>
                <li class="list-group-item d-flex justify-content-between align-items-center">Account Name<span>Ozoudeh Michael</span></li>
             </ul>
            </div><button type="submit"  class="btn btn-primary btn-lg w-100"  value="cash" name="payment_method">Order Now</button>
          </div>
        </div>
      </div>
      </form>
    </div>

@endsection

