@extends('layouts.app')

    @section('navigation')
  <div class="header-area" id="headerArea">
      <div class="container h-100 d-flex align-items-center justify-content-between">
        <!-- Logo Wrapper-->
        <div class="logo-wrapper"><a href="{{route('home')}}"> <img src="{{asset('/images/icons/lolj.png')}}" width="55px" height="54px" alt="payM logo"></a></div>
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
      <!-- Top Products-->
      <div class="top-products-area pt-3">
        <div class="container">
          <div class="section-heading d-flex align-items-center justify-content-between">
            <h6 class="ml-1">Search Results</h6>
            <!-- Layout Options-->
            
             @if(count($products)> 0)
                    {{count($products)}} Products found
                @endif
                
         </div>
          <div class="row">
            <!-- Single Top Product Card-->
        
        
            <!-- Single Top Product Card-->
            
               
            @if(count($products)> 0)
               @foreach ($products as  $top)
                 <div class="col-6 col-sm-4 col-lg-3">
              <div class="card top-product-card mb-3">
                <div class="card-body">@if($top->percentage > 1)<span class="badge badge-danger">{{number_format($top->percentage)}}% off</span>@endif
                <a class="product-thumbnail d-block" href="{{preg_replace('/\s+/', '-', url('items/' .$top->id.'-'.$top->name.'.'.'html'))}}">
                <img class="mb-2" width="50px" height="20px"  src="{{asset('/images/products/'.$top->cover_image)}}"  alt="{{$top->name}}"></a>
                 <a class="product-title"  style="font-size:12px" href="{{preg_replace('/\s+/', '-', url('items/' .$top->id.'-'.$top->name.'.'.'html'))}}"> @if(strlen($top->name) > 20) {{substr($top->name,0,19). '...'}} @else {{substr($top->name,0,19)}} @endif</a>
                  <p class="sale-price"   style="font-size:12px; font-style:Times" >???{{$top->sale_price != null?number_format($top->sale_price)  : number_format($top->price) }} @if($top->sale_price > 0)<span style="font-size:12px"> ???{{number_format($top->price)}}</span>@endif</p>
                  
                  <div class="" style="font-size:10px"><i class="lni lni-money-location"></i> {{substr($top->shops->name, 0,18)}}</div>
                </div>
                
                
               
              </div>
            </div>
             @endforeach
            @elseif(isset($title))
            <div class="col-12 ">
               <center>
                   <span class="card top-product-card mb-6">
            
                {{$title}}
                
              </span>
               </center>
              </div>
            @else
             <div class="col-12 ">
               <center>
                   <span class="card top-product-card mb-6">
            
                No product found for this search, try again!
                
              </span>
               </center>
              </div>
            @endif
            <!-- Single Top Product Card-->
            
            </div>
          </div>
        </div>
      </div>
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

        console.log(response);

        if(response){
           $('#cartReload').html(response.qty);
           
         }

      }



    });


  });
  
  
  </script>


    @endsection