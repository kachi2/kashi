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
                                        <th>User Email</th>
                                        <th>Amount</th>
                                        <th>Note</th>
                                        <th>status</th>
                                         <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                   @foreach ($funds as $fund )
                                    <tr>
                                    <td>{{$fund->id}}</td>
                                    <td>{{$fund->fund_users->email}}</td>
                                     <td>N{{number_format($fund->amount,2)}}</td>
                                    <td>{{$fund->note}}</td>
                                    <td>@if($fund->status == 0)
                                    <span class="btn btn-primary btn-xs"> Pending</span>
                                    @elseif($fund->status == 1)
                                    <span class="btn btn-success btn-xs">Approved</span>
                                    @else
                                    <span class="btn btn-warning btn-xs">Cancelled</span>
                                    @endif
                                    </td>
                                     <td>{{$fund->created_at}}</td>
                                     <td> 
                                     @if($fund->status == 0) 
                                     {{Form::open(['action'=>['AdminController@approve_request', $fund->id], 'method'=>'post'])}}
                                    <button type="submit" name="approve" onclick="return confirm('Are you Sure')" value="yes" class="btn btn-primary btn-xs"> Approve</button>
                                     <button type="submit" name="approve" onclick="return confirm('Are you Sure')" value="no" class="btn btn-danger btn-xs">Cancel</button>
                                     {{Form::close()}}
                                    
                                     @else
                                    <button type="submit" class="btn btn-primary btn-xs">No Action</button>
                                     @endif
                                     <td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                    <div> {{$funds->links()}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
        </div>
@endsection
