@extends('layouts.app')

@section('navigation')
   <div class="header-area" id="headerArea">
      <div class="container h-100 d-flex align-items-center justify-content-between">
        <!-- Back Button-->
        <div class="back-button"><a href="{{route('home')}}"><i class="lni lni-arrow-left"></i></a></div>
        <!-- Page Title-->
        <div class="page-heading">
          <h6 class="mb-0">My Cart</h6>
        </div>
        <!-- Navbar Toggler-->
        <div class="suha-navbar-toggler d-flex justify-content-between flex-wrap" id="suhaNavbarToggler"><span></span><span></span><span></span></div>
      </div>
    </div>

@endsection
@section('content')
  <div class="page-content-wrapper">
      <div class="container">
        <!-- Cart Wrapper-->
        <div class="cart-wrapper-area py-3">
          <div class="cart-table card mb-3">
            <div class="table-responsive card-body">
              <table class="table mb-0">
                <tbody>
                @if(count($data) > 0)
                @foreach ($data as $items )
                  <tr>
                    <th scope="row">
                     {!!Form::open(['action' => ['cartController@destroy',$items->rowId], 'method'=>'post' ])!!}
                    <button style="border:none" onclick="this.form.submit()"><a class="remove-product"> 
                    <i class="lni lni-close"></i></a></th></button>
                       <input hidden  class="qty-text increments" name="rowId" type="text"  value="{{$items->rowId}}">
                      {{Form::hidden('_method', 'DELETE')}}
                    </form>
                    <td><a href="{{preg_replace('/\s+/', '-', url('items/' .$items->id.'-'.$items->name.'.'.'html'))}}"><img src="{{asset('/images/products/'.$items->model->cover_image)}}" alt="{{$items->name}}"></a></td>
                    <td><a href="{{preg_replace('/\s+/', '-', url('items/' .$items->id.'-'.$items->name.'.'.'html'))}}">{{$items->name}}<span>₦{{number_format($items->sale_price > 0? $items->sale_price: $items->price,2)}} × {{$items->qty}}</span></a></td>
                    <td>
                      <div class="quantity">
                      <form  action="{{route('update_cart')}}" method="get">
                        <input  onchange="this.form.submit()" class="qty-text increment" name="qty" type="number"  value="{{$items->qty}}">
                        <input hidden  class="qty-text increments" name="rowId" type="text"  value="{{$items->rowId}}">
                      </form>
                      </div>
                    </td>
                  </tr>
               @endforeach
            
                </tbody>
              </table>
            </div>
          </div>
          <!-- Coupon Area-->
          <div class="card coupon-card mb-3">
            <div class="card-body">
              <div class="apply-coupon">
                <h6 class="mb-0">Have a coupon?</h6>
                <p class="mb-2">Enter your coupon code here &amp; get awesome discounts!</p>
                <div class="coupon-form">
                  <form action="#">
                    <input class="form-control" type="text" placeholder=" ">
                    <button class="btn btn-primary" type="submit">Apply</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- Cart Amount Area-->
          <div class="card cart-amount-area">
            <div class="card-body d-flex align-items-center justify-content-between">
              <h5 class="total-price mb-0">N<span class="counter">{{number_format(Cart::priceTotalFloat(), 2)}}</span></h5><a class="btn btn-warning" href="{{route('checkout.index')}}">Checkout Now</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  @else 
  <div class="coupon-card mb-3">
          <span> <i class="lni lni-cart"> </i> You dont have any item on cart</span> 
           </div>
 @endif
              