@extends('layouts.app')
@section('navigation')
   <div class="header-area" id="headerArea">
      <div class="container h-100 d-flex align-items-center justify-content-between">
        <!-- Back Button-->
        <div class="back-button"><a href="{{route('transactions')}}"><i class="lni lni-arrow-left"></i></a></div>
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
          <h6 class="pl-1">Transaction Details</h6>
          <div class="list-group">
            <!-- Single Notification-->
          
            <span class="list-group-item d-flex align-items-center" >
              <div class="noti-info">
                <p class="mb-0" style="font-weight:bold">
                <span>Service: {{strtoupper($transactions->bill_product->name)}}</span>
                @if($transactions->variation) <span>Variation: {{strtoupper($transactions->variation)}}</span>@endif
                 <span>Transaction Id: {{$transactions->transactionId}}</span>
                 <span>Phone Number: {{$transactions->phone}}</span>
                @if($transactions->biller_name) <span>{{$transactions->biller_name == 'smartcard'? 'Smartcard' : 'Meter Number'}}: {{$transactions->biller_code}}</span>@endif
                 @if($transactions->service_verification) <span>Account Name: {{$transactions->service_verification}}</span>@endif
                 @if($transactions->bill_token) <span>{{$transactions->bill_token}}</span>@endif
                 <span>Amount: ₦{{number_format($transactions->total_amount,2)}}</span>
                 <span>Commission: ₦{{number_format($transactions->commission,2)}}</span>
                 <span>Prev Balance: ₦{{number_format($transactions->wallet_trans->prev_balance,2)}}</span>
                 <span>Avail Balance:  ₦{{number_format($transactions->wallet_trans->avail_balance,2)}}</span>
               <span> Status: @if($transactions->status == 'Failed') <button class="btn btn-danger btn-sm">
              {{$transactions->status}} </button> 
                @else <button class="btn btn-success btn-sm">{{$transactions->status}} </button> @endif</span>
               <span> Date: {{$transactions->created_at}}<span>
                 </p>
              </div></span>
               <a href="{{route('transactions')}}" class="btn btn-primary"> Back to Transactions </a> 
          </div>
          
        </div>
      </div>
    </div>
@endsection