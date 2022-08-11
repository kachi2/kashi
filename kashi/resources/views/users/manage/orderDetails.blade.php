@extends('layouts.app')
@section('navigation')
   <div class="header-area" id="headerArea">
      <div class="container h-100 d-flex align-items-center justify-content-between">
        <!-- Back Button-->
        <div class="back-button"><a href="{{route('my-orders')}}"><i class="lni lni-arrow-left"></i></a></div>
        <!-- Page Title-->
        <div class="page-heading">
          <h6 class="mb-0">Order Details</h6>
        </div>
        <!-- Navbar Toggler-->
        <div class="suha-navbar-toggler d-flex justify-content-between flex-wrap" id="suhaNavbarToggler"><span></span><span></span><span></span></div>
      </div>
    </div>

@endsection
@section('content')

 <div class="page-content-wrapper">
      <div class="container">
        <!-- Notifications Area-->
        <div class="notification-area pt-3 pb-2">
          <h6 class="pl-1">Order  Details</h6>
          <div class="list-group">
            <!-- Single Notification-->
          @php

            $shipping = $order_items[0]->payable - $orders->amount;
          @endphp
            <a class="list-group-item d-flex align-items-center" href="">
              <div class="noti-info">
                <p class="mb-0" style="font-weight:bold">
                 <span>Order Id: {{$orders->order_id}}</span>
                 <span>Transaction Ref: {{$orders->transaction_ref}}</span>
                 <span>Total Amount: ₦{{number_format($orders->amount,2)}}</span>
                 <span>Shipping Amount: ₦{{number_format($orders->payable - $orders->amount,2)}}</span>
                 <span>Total Payable: N{{number_format($orders->payable,2)}}</span>
               <span> Payment Status: @if($orders->status != 'success') <button class="btn btn-danger btn-sm">
              {{'Unpaid'}} </button> 
                @else <button class="btn btn-success btn-sm">{{'Paid'}} </button> @endif</span>
               
               <span> Placed On: {{$orders->created_at}}<span>
               </p>
                
              </div></a>
              <span class="list-group-item d-flex align-items-center">
              Items on this Cart
              </span>

                @foreach($order_items as $order_item)
                <div class="col-12 col-md-6">
              <div class="card weekly-product-card mb-3">
                <div class="card-body d-flex align-items-center">
                <div class="product-thumbnail-side"><a class="product-thumbnail d-block" href="single-product.html">
                  <img src={{asset('images/products/'.$order_item->image)}} alt=""></a> 
                  </div>
                  <div class="product-description"><a class="product-title d-block" href="single-product.html">{{$order_item->product_name}}</a>
                    <span> QTY: {{$order_item->qty}} </span><br>
                     <span> Price: N{{number_format($order_item->price,2)}} </span>
                    </div>
                </div>
               
              </div>
            </div>
                @endforeach
            <span class="list-group-item d-flex align-items-center">
              Shipping Information
              </span>
                   <a class="list-group-item d-flex align-items-center" href="">
              <div class="noti-info">
                <p class="mb-0" style="font-weight:bold">
                 <span>Shipping Method: {{$order_items[0]->shipping_method}}</span>
                 <span>Receiver: {{$orders->receiver}}</span>
                 <span>Phone: {{$orders->phone}}</span>
                  <span>Email: {{$orders->email}}</span>
                  <span>Address: {{$orders->address.', '.$orders->state}}</span>
               <span> Placed On: {{$orders->created_at}}<span>
                <span> Delivery Status: @if($orders->is_delivered != 1) <button class="btn-danger btn-sm p-1">
              {{'Undelivered'}} </button> 
                @else <button class="btn btn-success btn-sm p-1">{{'Delivered'}} </button> @endif</span>
                 </p>
                
              </div></a>

              <span class="list-group-item d-flex align-items-center">
              Payment Information
              </span>
                   <a class="list-group-item d-flex align-items-center" href="">
              <div class="noti-info">
                <p class="mb-0" style="font-weight:bold">
                 <span>Payment Method: {{$orders->payment_method}}</span>
             <span> Payment Status: @if($orders->status != 'success') <button class="btn btn-danger btn-sm">
              {{'Unpaid'}} </button> 
                @else <button class="btn btn-success btn-sm">{{'Paid'}} </button> @endif</span> </p>
                
              </div></a>
               <a href="{{route('my-orders')}}" class="btn btn-primary"> Back to Transactions </a> 
          </div>
          
        </div>
      </div>
    </div>
@endsection