@extends('layouts.app')
@section('navigation')
   <div class="header-area" id="headerArea">
      <div class="container h-100 d-flex align-items-center justify-content-between">
        <!-- Back Button-->
        <div class="back-button"><a href="{{route('home')}}"><i class="lni lni-arrow-left"></i></a></div>
        <!-- Page Title-->
        <div class="page-heading">
          <h6 class="mb-0">My Orders</h6>
        </div>
        <!-- Navbar Toggler-->
        <div class="suha-navbar-toggler d-flex justify-content-between flex-wrap" id="suhaNavbarToggler"><span></span><span></span><span></span></div>
      </div>
    </div>

@endsection
@section('content')

<div class="page-content-wrapper">
      <!-- Top Products-->
      <div class="top-products-area pt-3">
        <div class="container">
          <div class="section-heading d-flex align-items-center justify-content-between">
            <h6 class="ml-1">My Orders</h6>
          </div>
          <div class="row">
            <!-- Single Weekly Product Card-->
          @include('sweet::alert')
          @if(count($orders) > 0)
            @foreach ($orders as $pro )
            <div class="col-12 col-md-6">
              <div class="card weekly-product-card mb-3">
                <div class="card-body d-flex align-items-center">
                
                  <div class="product-thumbnail-side"><a class="product-thumbnail d-block" href="">
                  <img src={{asset('images/products/'.$pro->image)}} alt=""></a> 
                  </div>
                  <div class="product-description"><a class="product-title d-block" href="">Order Id: {{$pro->order_id}}</a>
                    <p class="sale-price"><i class="lni lni-naira">N</i>{{number_format($pro->payable,2)}}</p>
                    <div class="product-rating">{{$pro->created_at}}</div>
                  <a  href="{{route('orderDetails', $pro->id)}}" style="color:#fff" ><button type="submit" class="btn btn-primary btn-sm" ><i class="mr-1 lni lni-card"></i>View Details</button></a>
                  </div>
                </div>
               
              </div>
            </div>  
           @endforeach
         <div class="p-2">{{$orders->links()}}</div>
         @else  
         <div class="card weekly-product-card mb-3">
                <div class="card-body d-flex align-items-center"> 
               <span> You dont have any order yet.</span>
        </div>
        </div>
         @endif
          </div>
                  
        </div>
        
      </div>
    </div>

@endsection

