@extends('layouts.app')
    @section('content')

    <!-- Order/Payment Success-->
    <div class="order-success-wrapper">
      <div class="content"><i class="lni lni-checkmark-circle"></i>

      @if(isset($cash))  
      <h5>Order Placed Successfully</h5>
      @else
        <h5>Transaction Completed Successfully</h5>
        @endif
         <p>Feel Free to share your experience, Thanks!</p>
        <a class="btn btn-warning mt-3" href="{{route('home')}}">Return Back</a>
      </div>
    </div>


    @endsection