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
          <div class="credit-card-info-wrapper"><img class="d-block mb-4" src={{"/images/cash.jpg"}} alt="">
            <div class="cod-info text-center mb-3">
              <p>Pay when you receive your products.</p>
            </div><button type="submit" id="'#btnsubmit" class="btn btn-primary btn-lg w-100"  value="cash" name="payment_method">Order Now</button>
          </div>
        </div>
      </div>
      </form>
    </div>

@endsection

@section('script')

  <script>
    var $butt = document.querySelector('#btnsubmit');
    $butt.addEventListener('click', function() {
  $('#btnsubmit').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>loading...');
      });   
    </script>
@endsection

