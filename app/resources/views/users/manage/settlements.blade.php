@extends('layouts.app')
@section('navigation')
   <div class="header-area" id="headerArea">
      <div class="container h-100 d-flex align-items-center justify-content-between">
        <!-- Back Button-->
        <div class="back-button"><a href="{{route('shops.index')}}"><i class="lni lni-arrow-left"></i></a></div>
        <!-- Page Title-->
        <div class="page-heading">
          <h6 class="mb-0">Settlements</h6>
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
          <h6 class="pl-1">Settlements History</h6>
          <div class="list-group">
            <!-- Single Notification-->
            @if(count($settlement )> 0)
            @foreach ($settlement as  $trans)
            <a class="list-group-item d-flex align-items-center" href="{{route('settlement-details', $trans->id)}}">
              <div class="noti-info">
                <p class="mb-0" style="font-weight:bold">{{$trans->purpose}} </p>
                </span><span>Payable Amount: N{{number_format($trans->amount)}}</span> 
                <span> Status: @if($trans->is_settled == '0') <button class="btn btn-danger btn-sm">Pending</button> 
                @else <button class="btn btn-success btn-sm">Settled</button> @endif </span>
                 <span>Date: {{$trans->created_at}}</span>
                
              </div></a>
                   @endforeach
                   <div> {{$settlement->links()}} </div>
              @else
              <a class="list-group-item d-flex align-items-center" href="">
              <div class="noti-info">
               No customer has Purchased your products yet
              </div></a>
              @endif
          </div>
        </div>
      </div>
    </div>
@endsection