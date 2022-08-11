@extends('layouts.app')

@section('navigation')
   <div class="header-area" id="headerArea">
      <div class="container h-100 d-flex align-items-center justify-content-between">
        <!-- Back Button-->
        <div class="back-button"><a href="{{route('home')}}"><i class="lni lni-arrow-left"></i></a></div>
        <!-- Page Title-->
        <div class="page-heading">
          <h6 class="mb-0">Product Details </h6>
        </div>
        <!-- Navbar Toggler-->
        <div class="suha-navbar-toggler d-flex justify-content-between flex-wrap" id="suhaNavbarToggler"><span></span><span></span><span></span></div>
      </div>
    </div>

@endsection
@section('content')

  <div class="page-content-wrapper">
      <!-- Product Slides-->
      <div class="product-slides owl-carousel">
        <!-- Single Hero Slide-->
        @php
      $cart = json_decode($item->gallery);
        @endphp

    @if($cart )
      @foreach ($cart as $carts )
        <div class="single-product-slide" style="background-image: url('{{asset('/images/products/'. $carts)}}')"></div>
        @endforeach
        @else
          <div class="single-product-slide" style="background-image: url('{{asset('/images/products/'.$item->cover_image)}}')"></div>
       
       @endif

      </div>
      <div class="product-description pb-3">
        <!-- Product Title & Meta Data-->
        <div class="product-title-meta-data bg-white mb-3 py-3">
          <div class="container d-flex justify-content-between">
            <div class="p-title-price">
              <h6 class="mb-1">{{$item->name}}</h6>
              <p class="sale-price mb-0">₦{{$item->sale_price != 0? number_format($item->sale_price,2) : $item->sale_price }}<span>₦{{$item->sale_price != 0? number_format($item->price,2) : '0.00' }}</span></p>
            </div>
          </div>
          <!-- Ratings-->
          <div class="product-ratings">
            <div class="container d-flex align-items-center justify-content-between">
              <div class="ratings">
             
              @php 
              $mm = 0;
              if(count($reviews)>0){
              $kk = count($reviewsCount);
              foreach($reviewsCount as $rr){
                $mm += $rr->rating; 
              }
             $cc = $mm/$kk;
              }
              @endphp

              @if(count($reviews)>0)
             @if($cc >= 0.0 && $cc < 1)
                    <i class="lni lni-star"></i>
                     <i class="lni lni-star"></i>
                      <i class="lni lni-star"></i>
                       <i class="lni lni-star"></i>
                        <i class="lni lni-star"></i>
                     @elseif($cc >= 1.0 && $cc <= 2.0)
                    <i class="lni lni-star-filled"></i>
                     <i class="lni lni-star"></i>
                      <i class="lni lni-star"></i>
                       <i class="lni lni-star"></i>
                        <i class="lni lni-star"></i>
                    @elseif($cc >= 2.0 && $cc <= 2.9)
                    <i class="lni lni-star-filled"></i>
                    <i class="lni lni-star-filled"></i>
                     <i class="lni lni-star"></i>
                      <i class="lni lni-star"></i>
                       <i class="lni lni-star"></i>
                    @elseif($cc >= 3.0 && $cc <= 3.9)
                    <i class="lni lni-star-filled"></i>
                    <i class="lni lni-star-filled"></i>
                    <i class="lni lni-star-filled"></i>
                     <i class="lni lni-star"></i>
                      <i class="lni lni-star"></i>
                    @elseif($cc >= 4.0 && $cc < 4.9)
                    <i class="lni lni-star-filled"></i>
                    <i class="lni lni-star-filled"></i>
                    <i class="lni lni-star-filled"></i>
                    <i class="lni lni-star-filled"></i>
                     <i class="lni lni-star"></i>
                    @elseif($cc >= 4.9 && $cc < 9)
                    <i class="lni lni-star-filled"></i>
                    <i class="lni lni-star-filled"></i>
                    <i class="lni lni-star-filled"> </i>
                   <i class="lni lni-star-filled"></i>
                   <i class="lni lni-star-filled"></i> 
                   <i class="lni lni-star-filled"></i>
                    @endif
              
                 {{count($reviewsCount)}} Reviews
              @else
              <i class="lni lni-star"></i>
                     <i class="lni lni-star"></i>
                      <i class="lni lni-star"></i>
                       <i class="lni lni-star"></i>
                        <i class="lni lni-star"></i> (0)Reviews
              @endif
           
              </div>
              <div class="total-result-of-ratings"><span>@if(count($reviews)>0){{$cc!=null? number_format($cc,1):'0.0'}}@else 0.00 @endif</span>
              <span>
              @if(count($reviews)>0)
              @if($cc > 0.0 && $cc < 1.5) Bad  @elseif($cc >= 1.5 && $cc < 2.5 ) Fair  @elseif($cc >= 2.5 && $cc < 3.0 )Good 
              @elseif($cc >= 3.0 && $cc < 4.5 ) Very Good @elseif($cc >= 4.5 && $cc < 10.0 ) Excellent @else  @endif
              @endif
              </span></div>
            </div>
          </div>
        </div>
        <!-- Selection Panel-->
        <div class="selection-panel bg-white mb-3 py-3">
          <div class="container d-flex align-items-center justify-content-between">
            <!-- Choose Color-->
            <div class="choose-color-wrapper">
              <p class="mb-0">Shop Owner</p>
              <div class="choose-color-radio d-flex align-items-center">
                
                <div class="user-profile mr-3"><img src="{{asset('images/shops/'.$item->shops->image)}}" width="30px" height="40px" style="border-radius:30%" alt=""><span> {{$item->shops->name}} </span></div>
              
                
              </div>
            </div>
            <!-- Choose Size-->
           
          </div>
        </div>
        <div class="selection-panel bg-white mb-3 py-3">
          <div class="container d-flex align-items-center justify-content-between">
            <!-- Choose Color-->
            
            @php
            
            if($item->color->name){
            
            $item_name = $item->color->name;
            
            }else{
            $item_name = 'black';
            }
            @endphp
            <div class="choose-color-wrapper">
              <p class="mb-0">Color</p>
              <div class="choose-color-radio d-flex align-items-center">
                <div class="custom-control custom-radio mr-1">
                  <input class="custom-control-input" type="radio" id="customRadio1" name="customRadio" checked>
                  <label class="custom-control-label {{strtolower($item_name)}}" for="customRadio1">{{$item->color_id?$item->color->name:'Multi-Color'}}</label>
                </div>
              </div>
            </div>
            <!-- Choose Size-->
            <div class="choose-size-wrapper text-right">
              <p class="mb-0">Condition</p>
              <ul class="mb-0 choose-size-radio d-flex align-items-center">
              <span> @if($item->is_new == 1)<button class="btn-success btn-sm">New</button>@else <button class="btn-secondary btn-sm">Used</button> @endif </span>
              </ul>
            </div>
          </div>
        </div>
      
        <!-- Add To Cart-->
         @include('includes.message')
        <div class="cart-form-wrapper bg-white mb-3 py-3">
          <div class="container cart-form" >   
              <input class="form-control" type="text" id="qty2" step="1" min="1" max="12" name="qty" value="1" autocomplete="off">
              <a href="{{route('carts.buy_now', $item->id)}}" class="btn btn-danger mr-2">Buy Now</a>         
              <button class="btn btn-warning  btn-sm add2cart-notify" type="submit">Add to cart</button>
          </div>
        </div>
        <!-- Product Specification-->
        <div class="p-specification bg-white mb-3 py-3">
          <div class="container">
            <h6>Description</h6>
            <p>{!! $item->description!!}</p>
            <ul>
              <li style="color:green">7 days returns policy</li>
              <li style="color:green">Warranty not aplicable if User damaged items</li>
              
            </ul>
          </div>
        </div>
        <!-- Rating & Review Wrapper-->
        <div class="rating-and-review-wrapper bg-white py-3 mb-3">
          <div class="container">
            <h6>Ratings &amp; Reviews</h6>
            <div class="rating-review-content">
              <ul>
              @if(count($reviews)>0)
              @foreach($reviews as $review)
                <li class="single-user-review d-flex">
                  <div class="user-thumbnail"></div>
                  <div class="rating-comment">
                    <div class="rating">
                    @if($review->rating == 0 )
                    <i class="lni lni-star"></i>
                     <i class="lni lni-star"></i>
                      <i class="lni lni-star"></i>
                       <i class="lni lni-star"></i>
                        <i class="lni lni-star"></i>
                     @elseif($review->rating == 1)
                    <i class="lni lni-star-filled"></i>
                     <i class="lni lni-star"></i>
                      <i class="lni lni-star"></i>
                       <i class="lni lni-star"></i>
                        <i class="lni lni-star"></i>
                    @elseif($review->rating == 2)
                    <i class="lni lni-star-filled"></i>
                    <i class="lni lni-star-filled"></i>
                     <i class="lni lni-star"></i>
                      <i class="lni lni-star"></i>
                       <i class="lni lni-star"></i>
                    @elseif($review->rating == 3)
                    <i class="lni lni-star-filled"></i>
                    <i class="lni lni-star-filled">
                    </i><i class="lni lni-star-filled"></i>
                     <i class="lni lni-star"></i>
                      <i class="lni lni-star"></i>
                    @elseif($review->rating == 4)
                    <i class="lni lni-star-filled"></i>
                    <i class="lni lni-star-filled"></i>
                    <i class="lni lni-star-filled">
                    </i><i class="lni lni-star-filled"></i>
                     <i class="lni lni-star"></i>
                    @else
                    <i class="lni lni-star-filled"></i>
                    <i class="lni lni-star-filled"></i>
                    <i class="lni lni-star-filled">
                    </i><i class="lni lni-star-filled"></i>
                    </i><i class="lni lni-star-filled"></i>
                    @endif
                    </div>
                    <p class="comment mb-0">{{$review->message}}</p><span class="name-date">{{$review->user->name}} {{$review->created_at->diffForHumans()}}</span>
                  </div>
                </li>
                @endforeach
                  {{$reviews->links()}}
              @else
              <li class="single-user-review d-flex">
              There is no review yet for this product
              </li>
              @endif
              
              </ul>
            </div>
          </div>
        </div>
        <!-- Ratings Submit Form-->
        <div class="ratings-submit-form bg-white py-3">
          <div class="container">
            <h6>Submit A Review</h6>
            @include('includes.message')
          {{Form::open(['action'=>['HomeController@addReview', $item->id], 'method'=>'post'])}}
              <div class="form-group">
                <div class="stars">
                  <input class="star-1" type="radio" value="1" name="rating" id="star1">
                  <label class="star-1" for="star1"></label>
                  <input class="star-2" type="radio" value="2" name="rating" id="star2">
                  <label class="star-2" for="star2"></label>
                  <input class="star-3" type="radio" value="3" name="rating" id="star3">
                  <label class="star-3" for="star3"></label>
                  <input class="star-4" type="radio" value="4" name="rating" id="star4">
                  <label class="star-4" for="star4"></label>
                  <input class="star-5" type="radio" value="5" name="rating" id="star5">
                  <label class="star-5" for="star5"></label><span></span>
                </div>
              </div>
              <div class="form-group">
                <textarea class="form-control" id="comments" name="message" cols="30" rows="10" data-max-length="200"></textarea>
              </div>
              <button class="btn btn-sm btn-primary" type="submit">Save Review</button>
            </form>
          </div>
        </div>
      </div>
    </div>



@endsection



    @section('script')

  <script>
  $('.add2cart-notify').on('click', function(){
    cartId = {!! json_encode($item->id) !!}
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

        //console.log(response);

        if(response){
           $('.cartReload').html(response.qty);
           
         }

      }

    });


  });
  
  
  </script>


    @endsection