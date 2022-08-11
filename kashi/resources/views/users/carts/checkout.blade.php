@extends('layouts.app')

@section('navigation')
   <div class="header-area" id="headerArea">
      <div class="container h-100 d-flex align-items-center justify-content-between">
        <!-- Back Button-->
        <div class="back-button"><a href="{{route('carts.index')}}"><i class="lni lni-arrow-left"></i></a></div>
        <!-- Page Title-->
        <div class="page-heading">
          <h6 class="mb-0">Checkout</h6>
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
          <!-- Billing Address-->
        
          <div class="billing-information-card mb-3">
            @include('includes.message')
            @if(Session::has('wallet-check'))
             <p class="alert alert-danger">{!! Session::get('wallet-check') !!}</p> 
            @endif
            <div class="card billing-information-title-card bg-danger">
              <div class="card-body">
              
                <h6 class="text-center mb-0 text-white">Billing Information</h6>
              </div>
            </div>
            <div class="card user-data-card">
              <div class="card-body">                                   
                <div class="single-profile-data d-flex align-items-center justify-content-between">
                  <div class="title d-flex align-items-center"><i class="lni lni-user"></i><span>Receiver</span></div>
                  <div class="data-content">{{$user->name}}</div>
                </div>
                <div class="single-profile-data d-flex align-items-center justify-content-between">
                  <div class="title d-flex align-items-center"><i class="lni lni-envelope"></i><span>Email Address</span></div>
                  <div class="data-content">{{$user->email}}</div>
                </div>
                <div class="single-profile-data d-flex align-items-center justify-content-between">
                  <div class="title d-flex align-items-center"><i class="lni lni-phone"></i><span>Phone</span></div>
                  <div class="data-content">{{$user->phone}}</div>
                </div>
                <div class="single-profile-data d-flex align-items-center justify-content-between">
                  <div class="title d-flex align-items-center"><i class="lni lni-map-marker"></i><span>Shipping Address</span></div>
                  <div class="data-content">@if($user->address){{$user->address .", ". $user->state }}@else No address @endif</div>
                </div>
                <!-- Edit Address--><a class="btn btn-danger w-100" href="{{route('shipping_address')}}">Edit Billing Information</a>
              </div>
            </div>
          </div>
          <!-- Shipping Method Choose-->
          {{Form::open(['action'=> 'checkoutController@payment_method', 'method'=>'post'])}}
          <div class="shipping-method-choose mb-3">
            <div class="card shipping-method-choose-title-card bg-success">
              <div class="card-body">
                <h6 class="text-center mb-0 text-white">Shipping Method</h6>
              </div>
            </div>
            <div class="card shipping-method-choose-card">
              <div class="card-body">
                <div class="shipping-method-choose">
                  <ul>
                    <li>
                      <input id="fastShipping" type="radio"   name="selector" value="home-delivery">
                      <label for="fastShipping">Home Delivery - <span> Your Items will delivered approimately on
                      
                      <script>
                      var m = new Date();
                       var days = [ "monday", "tuesay", "wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
                      var months = ["Jan", "Feb", "March", "April", "May", "June", "July", "Aug", "Sept", "Oct", "Nov", "Dec"];
                      if((m.getDate()+3) > 30){
                          document.writeln((m.getDate()+3)  + ", "+ months[m.getMonth() + 1]);
                      }else{
                          document.writeln((m.getDate()+3)  + ", "+ months[m.getMonth()]);
                      }
                       
                      </script>
                      <span style="color:red">Shipping Fee: ₦{{number_format($shipping,2)}} for Customers within Lagos and Ogun State</span>
                      </span></label>
                      <div class="check"></div>
                    </li>
                    <li>
                      <input id="normalShipping" type="radio"  name="selector" value="pickup" checked>
                      <label for="normalShipping">Pickup<span>You can visit our office addresss to pick Items</span></label>
                      <div class="check"></div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <!-- Cart Amount Area-->
          <div class="card cart-amount-area">
            <div class="card-body d-flex align-items-center justify-content-between">
            <input type="hidden" id="payable" value="{{$price}}" name="payable">
              <h5 class="total-price mb-0">₦<span class="counter" id="hhh"> {{number_format($price,2)}}</span></h5><button type="submit" class="btn btn-warning">Confirm &amp; Pay</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  {{Form::close()}}
@endsection

@section('script')

<script>

$('#fastShipping').on('change', function(){

     var shipping = {!! json_encode($shipping) !!}
       var price = {!! json_encode($price) !!}
    if(document.getElementById('fastShipping').checked = true){

        var dd = price + shipping;
        options = '<span class="counter">'+ dd.toLocaleString() +'</span>';
        $('#hhh').empty(options);
        $('#hhh').append(options);
        $('#payable').attr('value', dd);
    }


});

$('#normalShipping').on('change', function(){

       var price = {!! json_encode($price) !!}
    if(document.getElementById('normalShipping').checked = true){
        options = '<span class="counter">'+ price.toLocaleString() +'</span>';
        $('#hhh').empty(options);
        $('#hhh').append(options);
    }


});

</script>

@endsection