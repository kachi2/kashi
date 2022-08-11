@extends('layouts.app')
    @section('content')

    <!-- Order/Payment Success-->
    <div class="order-success-wrapper">
      <div class="content"><i class="lni lni-checkmark-circle"></i>
        <h5>Transaction Completed Successfully</h5>
        <p>Feel Free to share your experience, Thanks!</p>
        <a class="btn btn-warning mt-3" href="{{route('home')}}">Back to Home</a>
      </div>
    </div>
    @endsection