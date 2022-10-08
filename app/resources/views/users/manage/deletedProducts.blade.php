    @extends('layouts.app')
    @section('content')

@section('navigation')
   <div class="header-area" id="headerArea">
      <div class="container h-100 d-flex align-items-center justify-content-between">
        <!-- Back Button-->
        <div class="back-button"><a href="{{route('shops.index')}}"><i class="lni lni-arrow-left"></i></a></div>
        <!-- Page Title-->
        <div class="page-heading">
          <h6 class="mb-0">Trashed Products</h6>
        </div>
        <!-- Navbar Toggler-->
        <div class="suha-navbar-toggler d-flex justify-content-between flex-wrap" id="suhaNavbarToggler"><span></span><span></span><span></span></div>
      </div>
    </div>

@endsection

      <div class="page-content-wrapper">
      <!-- Top Products-->
      <div class="top-products-area pt-3">
        <div class="container">
          <div class="section-heading d-flex align-items-center justify-content-between">
            <h6 class="ml-1">My Products</h6>
          </div>
          <div class="row">
            <!-- Single Weekly Product Card-->
          @include('sweet::alert')
          @if(count($products)>0)
            @foreach ($products as $pro )
            <div class="col-12 col-md-6">
              <div class="card weekly-product-card mb-3">
                <div class="card-body d-flex align-items-center">
                  <div class="product-thumbnail-side"><a class="product-thumbnail d-block" href="single-product.html">
                  <img src={{asset('images/products/'.$pro->cover_image)}} alt=""></a> 
                  <div class="">
                   <a class="product-thumbnail d-block" href="single-product.html">
                  @php

                  $gallery = json_decode($pro->gallery);

                  @endphp
                  @if($gallery != null )
                  @foreach ($gallery as $gal)
                  <img src="{{asset('images/products/'.$gal)}}" width="39px" height="20px" alt="">
                  @endforeach
                  @endif
                  </a>
                  </div>
                  </div>
                  <div class="product-description"><a class="product-title d-block" href="single-product.html">{{$pro->name}}</a>
                     <p class="sale-price"><i class="lni lni-naira">₦</i>{{number_format($pro->sale_price > 0?$pro->sale_price:$pro->sale_price)}}<span>₦{{number_format($pro->sale_price > 0?$pro->price:'0.00')}}</span></p>
                   <div class="" style="font-size:13px">Deleted {{$pro->updated_at->diffForHumans()}}</div>
                    <a class="btn btn-primary btn-sm" href="{{route('my-productRestore',$pro->id)}}"><i class="mr-1 lni lni-cart"></i>Restore</a>
                  </div>
                </div>
              </div>
            </div>  
           @endforeach
          </div>
         {{$products->links()}}
         @else
<div class="card weekly-product-card mb-3">
                <div class="card-body d-flex align-items-center">
          You currently do not have  deleted  products yet. 
  </div>
  </div>
         @endif
        </div>
        
      </div>
    </div>


    @endsection