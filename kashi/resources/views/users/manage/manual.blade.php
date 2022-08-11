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
          <div class="credit-card-info-wrapper"><img class="d-block mb-4" src="img/bg-img/12.png" alt="">
            <div class="bank-ac-info">
              <p>Make a payment of <span style="color:blue"> ₦{{number_format($amount,2)}}</span> directly into your wallet with the following details.</p>
              <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between align-items-center">Bank Name<span>Sterling Bank</span></li>
                <li class="list-group-item d-flex justify-content-between align-items-center">Account Number<span>{{auth()->user()->accountNumber}}</span></li>
                <li class="list-group-item d-flex justify-content-between align-items-center">Account Name<span>payM- {{substr(auth()->user()->name, 0, 20)}}</span></li>
              </ul>
              {{Form::open(['action' =>'HomeController@topUp', 'method'=>'get'])}}
               <input type="hidden" class="form-control" name="note" value="payment made" required>
                
                <input type="hidden" value="{{$amount}}" name="amount">
            </div><button type="submit"  class="btn btn-primary w-100">Complete</button>
          </div>
          {{Form::close()}}
        </div>
      </div>
      </form>
    </div>

@endsection

