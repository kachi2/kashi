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
            
            
            <span class="list-group-item d-flex align-items-center" href="">
              <div class="noti-info">
                <p class="mb-0" style="font-weight:bold">{{$settlement->purpose}} </p>
                </span><span>Payable Amount: N{{number_format($settlement->amount)}}</span> 
                <span> Settlement Status: @if($settlement->is_settled == '0') <button class="btn btn-danger btn-sm">Pending</button> 
                @else <button class="btn btn-success btn-sm">Settled</button> @endif </span>
                 <div class="p-1"></div>
                      <span> payment Status: @if($settlement->is_paid == '0') <button class="btn btn-danger btn-sm">Pending</button> 
                @else <button class="btn btn-success btn-sm">Paid</button> @endif </span>
                   <div class="p-1"></div>
                    <span> Settlement Confirmation: @if($settlement->is_confirmed == '0') <button class="btn btn-danger btn-sm">Pending</button> 
                @else <button class="btn btn-success btn-sm">Payment Received</button> @endif </span>
                 <span>Order placed On: {{$settlement->created_at}}</span>
                 <div class="p-1"></div>
                 @if($settlement->is_confirmed == '0')
                 {{Form::open(['action'=>['vendorsController@confirm_settlement',$settlement->id], 'method'=>'post', 'id'=>'form1'])}}
                 <span> <span id="confirm_settlement" style="color:#fff" class="btn btn-primary btn-sm">Confirm Receive of Payment</span></span>
                 {{Form::close()}}
                 @endif
              </div></span>
                 
                   
          </div>
        </div>
      </div>
    </div>
@endsection

@section('script')

    <script>

        $('#confirm_settlement').on('click', function(){
            swal({ 
            title: 'Are you sure',
            text: 'You are about to confirm you received payment for this Order',
            icon: 'warning',
            closeModal: false,
            buttons: {
                cancel : true,
                confirm: 'Yes, I received Payment',    
            },
             }).then(function(isConfirm) {
          if (isConfirm) {
            $('#form1').submit();
            }else{
                swal("Cancelled", "Request rejected", "error");
            }
            });

        });

    </script>

@endsection