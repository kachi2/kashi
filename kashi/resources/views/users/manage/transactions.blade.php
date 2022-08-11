@extends('layouts.app')
@section('navigation')
   <div class="header-area" id="headerArea">
      <div class="container h-100 d-flex align-items-center justify-content-between">
        <!-- Back Button-->
        <div class="back-button"><a href="{{route('home')}}"><i class="lni lni-arrow-left"></i></a></div>
        <!-- Page Title-->
        <div class="page-heading">
          <h6 class="mb-0">Transactions</h6>
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
          <h6 class="pl-1">Transaction History</h6>
          <div class="list-group">
            <!-- Single Notification-->
            @if(count($transactions )> 0)
            @foreach ($transactions as  $trans)
            <a class="list-group-item d-flex align-items-center" href="{{route('trans_details',$trans->transactionId)}}">
            <img  width="40px" height="40px" src="{{asset('/images/products/'.$trans->bill_product->image)}}" alt="">
              <div class="noti-info">
                <p class="mb-0" style="font-weight:bold">Purchased {{$trans->variation? strtoupper($trans->variation): $trans->bill_product->name }} 
                &nbsp; ₦{{number_format($trans->total_amount)}} </p> <span> {{$trans->bill_product->biller_name? strtoupper($trans->bill_product->biller_name): $trans->bill_product->slug }}: 
                {{$trans->biller_code? $trans->biller_code: $trans->phone }}
                </span><span> @if($trans->status == 'Failed') <button class="btn btn-danger btn-sm">{{$trans->status}} </button> 
                @else <button class="btn btn-success btn-sm">{{$trans->status}} </button> @endif {{$trans->created_at}}</span>
              </div></a>
                   @endforeach
                   <div> {{$transactions->links()}} </div>
              @else
              <a class="list-group-item d-flex align-items-center" href="">
              <div class="noti-info">
                You have not performed any transactions yet
              </div></a>
              @endif
          </div>
        </div>
      </div>
    </div>
@endsection