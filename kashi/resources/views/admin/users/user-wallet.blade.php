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
                                        <tr>
                                        <th>SN</th>
                                        <th>Tnx Ref</th>
                                        <th>External Ref</th>
                                        <th>Purpose</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>commission</th>
                                        <th>Prev Balance</th>
                                        <th>Avail Balance</th>
                                        <th>Tnx Date</th>
                                    </tr>
                                    </thead>
                                     <tbody>
                                     @foreach ($wallet as $pro )  
                                    <tr>
                                        <td>{{$pro->id}}</td>
                                        <td>{{$pro->transaction_ref}}</td>
                                         <td>{{$pro->external_ref != null? $pro->external_ref: '-'}}</td>
                                        <td>{{$pro->purpose}}</td>
                                        <td>{{$pro->type}}</td>
                                        <td>{{number_format($pro->amount)}}</td>
                                        <td>{{$pro->is_commission != 1? 'Nil' : 'Commission'}}</td>
                                        <td>{{number_format($pro->prev_balance)}}</td>
                                         <td>{{number_format($pro->avail_balance)}}</td>
                                          <td>{{$pro->created_at}}</td>
                                       
                                         
                                    </tr>
                                  @endforeach
                                    </tbody>
                                </table>
                                    <div> {{$wallet->links()}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
        </div>
@endsection
