@extends('layouts.admin')
@section('content')
<div class="page-body">

            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="page-header-left">
                                <h4>Users
                                </h4>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <ol class="breadcrumb pull-right">
                                <li class="breadcrumb-item"><a href=""><i data-feather="home"></i></a></li>
                                <li class="breadcrumb-item">Dashbhoard</li>
                                <li class="breadcrumb-item active">User</li>
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
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>status</th>
                                        <th>User Level</th>
                                        <th>Wallet</th>
                                        <th>Commission</th>
                                          <th>Wallet Status</th>
                                        <th>Date Joined</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                   @foreach ($users as $user )
                                    <tr>
                                    <td>{{$user->id}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                     <td>{{$user->phone}}</td>
                                        <td>@if($user->status == 1) <span class="btn btn-primary btn-xs">Active</span>
                                         @else <span class="btn btn-danger btn-xs">Blocked</span> @endif</td>
                                        </td>
                                        <td>{{$user->level}}</td>
                                        <td>N{{number_format($user->wallet)}}</td>
                                         <td>N{{number_format($user->comm_wallet)}}</td>
                                         <td>@if($user->is_wallet == 1) <span class="btn btn-primary btn-xs">Active</span>
                                         @elseif($user->is_wallet == 0) <span class="btn btn-warning btn-xs">In-Active</span>@else<span class="btn btn-danger btn-xs">Blocked</span> @endif</td>
                                        </td>
                                <td>{{$user->created_at}}</td>
                                        <td>
                                          {{Form::open(['action'=> ['AdminController@viewTrans' , $user->id], 'method'=>'post'])}}
                                          <button class="btn btn-primary btn-xs" >Wallet Transactions</button>
                                            {{Form::close()}}
                                             {{Form::open(['action'=> ['AdminController@bill_transaction', $user->id], 'method'=>'post'])}}
                                          <button class="btn btn-primary btn-xs" >Bills Transactions</button>
                                            {{Form::close()}}
                                             {{Form::open(['action'=> ['AdminController@viewOrders', $user->id], 'method'=>'get'])}}    
                                        <button  class="btn btn-warning btn-xs">View Orders</button>
                                        {{Form::close()}}
                            
                                          @if($user->status == 2)
                                             {{Form::open(['action'=> ['AdminController@blockUser', $user->id], 'method'=>'post'])}}
                                          <button class="btn btn-success btn-xs p-1" >UnBlock User</button>
                                            {{Form::close()}}
                                            @else
                                             {{Form::open(['action'=> ['AdminController@blockUser', $user->id], 'method'=>'post'])}}
                                          <button class="btn btn-danger btn-xs" >Block User</button>
                                          &nbsp;
                                            @endif
                                          </td> 
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                    <div> {{$users->links()}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
        </div>
@endsection
