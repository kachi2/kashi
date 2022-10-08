@extends('layouts.admin')
@section('content')
<div class="page-body">

            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="page-header-left">
                                <h4>Settlments
                                </h4>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <ol class="breadcrumb pull-right">
                                <li class="breadcrumb-item"><a href=""><i data-feather="home"></i></a></li>
                                <li class="breadcrumb-item">Dashbhoard</li>
                                <li class="breadcrumb-item active">Settlments</li>
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
                                        <th>Admin Confirm</th>
                                        <th>Is Paid</th>
                                        <th>User confirmed</th>
                                         <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                   @foreach ($settlements as $fund )
                                    <tr>
                                    <td>{{$fund->id}}</td>
                                    <td>{{$fund->shops->name}}</td>
                                     <td>N{{number_format($fund->amount,2)}}</td>
                                    <td>{{$fund->purpose}}</td>
                                    <td>@if($fund->is_settled == 0)
                                    <span class="btn btn-primary btn-xs"> Pending</span>
                                    @else
                                    <span class="btn btn-success btn-xs">Settled</span>
                                    @endif
                                    </td>
                                    <td>@if($fund->is_paid == 0)
                                    <span class="btn btn-primary btn-xs"> Pending</span>
                                    @else
                                    <span class="btn btn-success btn-xs">Paid</span>
                                    @endif
                                    </td>
                                     <td>@if($fund->is_confirmed == 0)
                                    <span class="btn btn-primary btn-xs"> Pending</span>
                                    @else
                                    <span class="btn btn-success btn-xs">confirmed</span>
                                    @endif
                                    </td>
                                     <td>{{$fund->created_at}}</td>
                                     <td> 
                                     @if($fund->is_settled == 0) 
                                     {{Form::open(['action'=>['AdminController@confirm_settle', $fund->id], 'method'=>'post'])}}
                                    <button type="submit" name="approve" onclick="return confirm('Are you Sure')" value="yes" class="btn btn-primary btn-xs">Confirm</button>
                                     {{Form::close()}}
                                    
                                     @else
                                    <button type="submit" class="btn btn-success btn-xs">No Action</button>
                                     @endif
                                     <td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                    <div> {{$settlements->links()}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
        </div>
@endsection
