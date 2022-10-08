
    @extends('layouts.app')
    @section('navigation')
  <div class="header-area" id="headerArea">
      <div class="container h-100 d-flex align-items-center justify-content-between">
        <!-- Logo Wrapper-->
        <div class="logo-wrapper"><a href="{{route('home')}}"> <img src="{{asset('/images/icons/logoo.png')}}" width="60px" height="60px" alt="payM logo"></a></div>
        <!-- Search Form-->
        <div class="top-search-form">
          <form action="{{route('search-results')}}" method="get">
            <input class="form-control" name="search" type="search" placeholder="Search products, brands..">
            <button type="submit"><i class="fa fa-search"></i></button>
          </form>
        </div>
        <!-- Navbar Toggler-->
        <div class="suha-navbar-toggler d-flex flex-wrap" id="suhaNavbarToggler"><span></span><span></span><span></span></div>
      </div>
    </div>
@endsection
    @section('content')
    <div class="page-content-wrapper">
      <!-- Hero Slides-->
      <div class="hero-slides owl-carousel">
        <!-- Single Hero Slide-->
        
        <div class="single-hero-slide" style="background-image: url('{{asset('/images/jjh.jpg')}}')">
          <div class="slide-content h-100 d-flex align-items-center">
            <div class="container">
              <h4 class=" mb-0" style="color:blue" data-animation="fadeInUp" data-delay="100ms" data-wow-duration="1000ms"></h4>
              <p  style="color:blue; font-weight:bold" data-animation="fadeInUp" data-delay="400ms" data-wow-duration="1000ms"></p>
            </div>
          </div>
        </div>
        
          <div class="single-hero-slide" style="background-image: url('{{asset('/images/cc.jpeg')}}')">
          <div class="slide-content h-100 d-flex align-items-center">
            <div class="container">
              <h4 class=" mb-0" style="color:blue" data-animation="fadeInUp" data-delay="100ms" data-wow-duration="1000ms"></h4>
              <p  style="color:blue; font-weight:bold" data-animation="fadeInUp" data-delay="400ms" data-wow-duration="1000ms"></p>
            </div>
          </div>
        </div>
        
        <!-- Single Hero Slide-->
       
      </div>
      <!-- Product Catagories-->
      <div class="product-catagories-wrapper pt-3">
        <div class="container">
          <div class="section-heading">
            <h6 class="ml-1">Bills Catagory</h6>
          </div>
          <div class="product-catagory-wrap">
            <div class="row">
              <!-- Single Catagory Card-->
              @foreach ($bill_category as $bill_cat )
              <div class="col-4">
                <div class="card mb-3 catagory-card" >
                  <div class="card-body"><a style="padding:0px" href="{{url('category/'.md5('this is the bill').'_'.$bill_cat->id.'_'.$bill_cat->name.'_'.'3874983')}}"><img   style="width:20px; height:20px" object-fit="cover" src="{{asset('/images/category/'.$bill_cat->image)}}"><span>{{$bill_cat->name}}</span></a></div>
                </div>
              </div>
              @endforeach
              <!-- Single Catagory Card--> 
            </div>
          </div>
        </div>
      </div>
      <!-- Flash Sale Slide-->
      <div class="flash-sale-wrapper pb-3">
        <div class="container">
          <div class="section-heading d-flex align-items-center justify-content-between">
            <h6 class="ml-1">Top Products</h6>
          </div>
          <!-- Flash Sale Slide-->
          <div class="flash-sale-slide owl-carousel">
            <!-- Single Flash Sale Card-->
            @foreach ($recent as  $top)
            <div class="card flash-sale-card">
              <div class="card-body"><a href="{{preg_replace('/\s+/', '-', url('items/' .$top->id.'-'.$top->name.'.'.'html'))}}"><img src="{{asset('/images/products/'.$top->cover_image)}}" alt="{{$top->name}}"><span class="product-title">{{$top->name}}</span>
                  <p class="sale-price">₦{{$top->sale_price != null? number_format($top->sale_price)  : number_format($top->price) }}<span></p> <span class="progress-title"></span>
                
                  <!-- Progress Bar-->
                 </a></div>
            </div>
            @endforeach
            <!-- Single Flash Sale Card-->
        
         
          </div>
        </div>
      </div>
      <!-- Top Products-->
      <div class="top-products-area clearfix">
        <div class="container">
          <div class="section-heading d-flex align-items-center justify-content-between">
            <h6 class="ml-1">Recent Products</h6>
          </div>
          <div class="row">
            <!-- Single Top Product Card-->
                  @foreach ($top_products as  $top)
                 <div class="col-6 col-sm-4 col-lg-3">
              <div class="card top-product-card mb-3">
                <div class="card-body">@if($top->percentage > 1)<span class="badge badge-danger">{{number_format($top->percentage)}}% off</span>@endif
                <a class="product-thumbnail d-block" href="{{preg_replace('/\s+/', '-', url('items/' .$top->id.'-'.$top->name.'.'.'html'))}}">
                <img class="mb-2" width="50px" height="20px"  src="{{asset('/images/products/'.$top->cover_image)}}"  alt=""></a>
                 <a class="product-title"  style="font-size:12px" href="{{preg_replace('/\s+/', '-', url('items/' .$top->id.'-'.$top->name.'.'.'html'))}}"> @if(strlen($top->name) > 20) {{substr($top->name,0,17). '...'}} @else {{substr($top->name,0,19)}} @endif</a>
                  <p class="sale-price"   style="font-size:12px; font-style:Times" >₦{{$top->sale_price != null?number_format($top->sale_price)  : number_format($top->price) }} @if($top->sale_price > 0)<span style="font-size:12px"> ₦{{number_format($top->price)}}</span>@endif</p>
                  
                  <div class="" style="font-size:10px"><i class="lni lni-money-location"></i> {{substr($top->shops->name, 0,18)}}</div>
                </div>
                
                
               
              </div>
            </div>
             @endforeach

          </div>
        </div>
      </div>
      <!-- Cool Facts Area-->
      <div class="cta-area">
        <div class="container">
          <div class="cta-text p-4 p-lg-5" style="background-image: url({{asset('frontend/img/bg-img/24.jpg')}})">
              
            <h4>You Sell Products?</h4>
            <p>@guest Register and  activate your reseller account, very simple and easy</p><a class="btn btn-danger" href="{{route('register')}}">Get Started</a> @else 
            @if(auth()->user()->level ==1)
            Go to settings and activate reseller account to get started  </p><a class="btn btn-danger" href="{{route('settings')}}">Get Started</a>
            @else
            Click on Sell on the menu and post your products
            @endif
            @endguest
          </div>
        </div>
      </div>
      <!-- Weekly Best Sellers-->
         <div class="product-catagories-wrapper pt-3">
        <div class="container">
          <div class="section-heading">
            <h6 class="ml-1">Top Category</h6>
          </div>
          <div class="product-catagory-wrap">
            <div class="row">
              <!-- Single Catagory Card-->
              @foreach ($category as $catagories)
              <div class="col-4">
                <div class="card mb-3 catagory-card">
                  <div class="card-body">
                  <a class="product-thumbnail d-block" href="{{route('products.categories',$catagories->id )}}">
                <img class="mb-2" width="50px" height="20px"  src="{{asset('/images/category/'.$catagories->image)}}"  alt=""></a>
                  <span>{{$catagories->name}}</span><span></div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
      <!-- Discount Coupon Card-->
      <div class="container">
        <div class="card discount-coupon-card border-0">
          <div class="card-body">
            <div class="coupon-text-wrap d-flex align-items-center p-3">
             @guest <h5 class="text-white pr-3 mb-0">Get 2% <br> discount</h5>
               <p class="text-white pl-3 mb-0"> Do you know you can get up to 2%<strong class="px-1">Commission </strong>on every Bill transactions?.</p>@else
              
              @if(auth()->user()->level == 1) 
               <h5 class="text-white pr-3 mb-0">Get 2% <br> discount</h5>
              <p class="text-white pl-3 mb-0"> Enjoy up to 2% commission on every bill transaction when you activate your reseller account </p>
              @else   
                 <h5 class="text-white pr-3 mb-0">Get 4% <br> Commissions</h5>
                <p class="text-white pl-3 mb-0">Enjoy up to 4% commission when you resell our bill products, don't be left out!</p>@endif
              @endguest
            </div>
          </div>
        </div>
      </div>
    
      <div class="p-2"></div>
      <!-- Featured Products Wrapper-->
      @if(count($products) > 0) 
      <div class="top-products-area clearfix">
        <div class="container">
          <div class="section-heading d-flex align-items-center justify-content-between">
            <h6 class="ml-1">Top Reviews</h6>
          </div>
          <div class="row">
            <!-- Single Top Product Card-->
                      @foreach ($products as  $top)
                 <div class="col-6 col-sm-4 col-lg-3">
              <div class="card top-product-card mb-3">
                <div class="card-body">@if($top->percentage > 1)<span class="badge badge-danger">{{number_format($top->percentage)}}% off</span>@endif
                <a class="product-thumbnail d-block" href="{{preg_replace('/\s+/', '-', url('items/' .$top->id.'-'.$top->name.'.'.'html'))}}">
                <img class="mb-2" width="50px" height="20px"  src="{{asset('/images/products/'.$top->cover_image)}}"  alt=""></a>
                 <a class="product-title"  style="font-size:12px" href="{{preg_replace('/\s+/', '-', url('items/' .$top->id.'-'.$top->name.'.'.'html'))}}"> @if(strlen($top->name) > 20) {{substr($top->name,0,17). '...'}} @else {{substr($top->name,0,19)}} @endif</a>
                  <p class="sale-price"   style="font-size:12px; font-style:Times" >₦{{$top->sale_price != null?number_format($top->sale_price)  : number_format($top->price) }} @if($top->sale_price > 0)<span style="font-size:12px"> ₦{{number_format($top->price)}}</span>@endif</p>
                  
                  <div class="" style="font-size:10px"><i class="lni lni-money-location"></i> {{substr($top->shops->name, 0,18)}}</div>
                </div>
                
                
               
              </div>
            </div>
             @endforeach

          </div>
        </div>
      </div>
      @endif
      
    </div>
    @endsection

      @section('script')

  <script>
  $('.add2cart-notify').on('click', function(){
    cartId = $('.addId').attr('value');
    qty = $('#qty2').val();
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
            });

    $.ajax({
      url: "/cart/"+cartId,
      type: "get",
      data:{ 
        qty:qty
      },
       dataType: "json",

      success:function(response){

       // console.log(response);

        if(response){
           $('.cartReload').html(response.qty);
           
         }

      }



    });


  });
  
  
  </script>


    @endsection