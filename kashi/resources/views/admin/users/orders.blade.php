@extends('layouts.admin')
@section('content')
<div class="page-body">

            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="page-header-left">
                                <h4>Orders
                                </h4>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <ol class="breadcrumb pull-right">
                                <li class="breadcrumb-item"><a href=""><i data-feather="home"></i></a></li>
                                <li class="breadcrumb-item">Dashbhoard</li>
                                <li class="breadcrumb-item active">Orders</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->

            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                    @include('includes.message')
                        <div class="card">
                            <div class="card-body">
                               
                               <div class="table-responsive">
        <table class="table table-striped table-bordered" id="table2">
                                    <thead>
                                    <tr><th>SN</th>
                                        <th>Order ID</th>
                                        <th>Transaction Ref</th>
                                         <th>External Ref</th>
                                        <th>Payment Method</th>
                                        <th>Amount</th>
                                        <th>Payable</th>
                                        <th>Payment Status</th>
                                        <th>Delivery Status</th>
                                        <th>Transaction Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                   @foreach ($orders as $pro )
                                    <tr>
                                    <td>{{$pro->id}}</td>
                                        <td>{{$pro->order_id}}</td>
                                        <td>{{$pro->transaction_ref != null? $pro->transaction_ref : '-' }}</td>
                                        <td>{{$pro->external_ref != null? $pro->external_ref: '-' }} </td>
                                        <td>{{$pro->payment_method}}</td>
                                        <td>₦{{number_format($pro->amount)}}</td>
                                        <td>₦{{number_format($pro->payable)}}</td>
                                        <td>@if($pro->status == 'success') <span class="btn btn-primary btn-xs">Paid</span>
                                         @else <span class="btn btn-warning btn-xs">Pending</span> @endif</td>
                                        </td>
                                        <td>@if($pro->is_delivered == 1) <span class="btn btn-primary p-1 btn-xs">Delivered</span>
                                         @else <span class="btn btn-warning btn-xs">Pending</span> @endif</td>
                                       <td>{{$pro->created_at}}</td>
                                        <td>
                                          <button class="btn btn-primary btn-xs" data-toggle="modal" data-original-title="test" data-target="#exampleModal{{$pro->id}}">View Details</button>

            <div class="btn-popup pull-right">
        <div class="modal fade" id="exampleModal{{$pro->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title f-w-600" id="exampleModalLabel">Order Details</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                         <table class="table table-striped table-bordered" id="table2">
                                    <thead>
                                    <tr>
                                        <th>Receiver</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                         <th>Address</th>
                                        <th>State</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                     <tbody>
                                    <tr>
                                        <td>{{$pro->receiver}}</td>
                                        <td>{{$pro->email}}</td>
                                        <td>{{$pro->phone}}</td>
                                        <td>{{$pro->address }} </td>
                                        <td>{{$pro->city.','.$pro->state}}</td>
                                            <td>
                                          @if($pro->status != 'success')
                                          {{Form::open(['action'=> ['AdminController@approvePay', $pro->id], 'method'=>'get'])}}
                                  
                                          <button class="btn btn-primary btn-xs">Approve Payment</button></button>
                                          {{Form::close()}}
                                          @endif
                                        @if($pro->is_delivered != 1)
                                         {{Form::open(['action'=> ['AdminController@approveDelivery', $pro->id], 'method'=>'get'])}}
                                        <button class="btn btn-primary btn-xs">Approve Delivery</button></button>
                                          {{Form::close()}}
                                        @endif
                                          </td> 
                                    </tr>
                                  
                                    </tbody>
                                </table>
                        
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close Window</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
                                        <a href="{{route('Admin.orderDetails', $pro->order_id)}}"> <button  class="btn btn-warning btn-xs">View Items</button></a>
                                          </td> 
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                    <div> {{$orders->links()}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
        </div>
              

@endsection
