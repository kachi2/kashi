@extends('layouts.app')
@section('navigation')
   <div class="header-area" id="headerArea">
      <div class="container h-100 d-flex align-items-center justify-content-between">
        <!-- Back Button-->
        <div class="back-button"><a href="{{route('shops.index')}}"><i class="lni lni-arrow-left"></i></a></div>
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
      <div class="container">
        <!-- Notifications Area-->
        <div class="notification-area pt-3 pb-2">
          <h6 class="pl-1">Your customer Order History</h6>
          <div class="list-group">
            <!-- Single Notification-->
            @if(count($orders )> 0)
            @foreach ($orders as  $trans)
            <a class="list-group-item d-flex align-items-center" href="{{route('vendorsorderDetails',$trans->order_id)}}">
              <div class="noti-info">
                <span> Order Id: {{$trans->order_id}}</span>
                <span> Amount: ₦{{number_format($trans->v_amount,2)}}</span>
                <span> Transaction Ref: {{$trans->transaction_ref}}</span>
                <span> Transaction Date: {{$trans->created_at}}</span>
             <span> Payment Status: @if($trans->status != 'success') <button class="btn btn-danger btn-sm">
              {{'Unpaid'}} </button> 
                @else <button class="btn btn-success btn-sm">{{'Paid'}} </button> @endif</span> 
                
              </div></a>
                   @endforeach
                   <div>{{$orders->links()}} </div>
                   
              @else
              <a class="list-group-item d-flex align-items-center" href="">
              <div class="noti-info">
                <span> No one have ordered your items yet</span> 
              </div></a>
              @endif
          </div>
        </div>
      </div>
    </div>

@endsection

