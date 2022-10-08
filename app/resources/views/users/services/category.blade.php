@extends('layouts.app')

@section('navigation')
   <div class="header-area" id="headerArea">
      <div class="container h-100 d-flex align-items-center justify-content-between">
        <!-- Back Button-->
        <div class="back-button"><a href="{{route('home')}}"><i class="lni lni-arrow-left"></i></a></div>
        <!-- Page Title-->
        <div class="page-heading">
          <h6 class="mb-0">Category</h6>
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
      <div class="catagory-single-img" style="background-image: url({{asset('/images/jj.jpeg')}})"></div>
      <!-- Product Catagories-->
      <div class="product-catagories-wrapper mt-3">
        <div class="container">
          <div class="section-heading">
          
            <h6 class="ml-1">{{$products[0]->bill_category->name}}   </h6>
          </div>
          <div class="product-catagory-wrap">
            <div class="row">
              <!-- Single Catagory Card-->
              @foreach ($products as $product )
              <div class="col-4">
                <div class="card mb-3 catagory-card">
                  <div class="card-body"><a href="{{url('buy/'.$product->slug)}}"><img  object-fit="cover" width="80px" height="80px" src="{{asset('/images/products/'.$product->image)}}"><span></span></a></div>
                </div>
              </div>
                @endforeach
            </div>
          </div>
        </div>
      </div>
      <!-- Top Products-->
      <hr>
      @if(count($top_products)>0)
      <div class="top-products-area">
           <div class="top-products-area clearfix">
        <div class="container">
          <div class="section-heading d-flex align-items-center justify-content-between">
            <h6 class="ml-1">Top Products</h6>
          </div>
          <div class="row">
            <!-- Single Top Product Card-->
                  @foreach ($top_products as  $top)
                 <div class="col-6 col-sm-4 col-lg-3">
              <div class="card top-product-card mb-3">
                <div class="card-body"><span class="badge badge-danger">{{number_format($top->percentage)}}% off</span>
                <a class="product-thumbnail d-block" href="{{preg_replace('/\s+/', '-', url('items/' .$top->id.'-'.$top->name.'.'.'html'))}}">
                <img class="mb-2" width="50px" height="20px"  src="{{asset('/images/products/'.$top->cover_image)}}"  alt="{{$top->name}}"></a>
                 <a class="product-title"  style="font-size:12px" href="{{preg_replace('/\s+/', '-', url('items/' .$top->id.'-'.$top->name.'.'.'html'))}}"> @if(strlen($top->name) > 20) {{substr($top->name,0,19). '...'}} @else {{substr($top->name,0,19)}} @endif</a> <p class="sale-price"   style="font-size:12px; font-style:Times" >₦{{$top->sale_price != null?number_format($top->sale_price)  : number_format($top->price) }}<span style="font-size:12px">₦{{$top->sale_price != null?number_format($top->price)  : '' }}</span></p>
                  
                  <div class="" style="font-size:10px"><i class="lni lni-money-location"></i> {{substr($top->shops->name, 0,18)}}</div>
                </div>
               
              </div>
            </div>
             @endforeach

          </div>
        </div>
      </div>
      </div>
      @endif
    </div>



    @endsection