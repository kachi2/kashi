@extends('layouts.admin')
@section('content')
<div class="page-body">

            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="page-header-left">
                                <h4>Transactions
                                </h4>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <ol class="breadcrumb pull-right">
                                <li class="breadcrumb-item"><a href=""><i data-feather="home"></i></a></li>
                                <li class="breadcrumb-item">Dashbhoard</li>
                                <li class="breadcrumb-item active">Transactions</li>
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
                                        <th>Transaction Id</th>
                                        <th>Total Amount</th>
                                        <th>Commission</th>
                                        <th>Status</th>
                                        <th>User Email</th>
                                        <th>Phone</th>
                                        <th>Bill Product</th>
                                        <th>Token</th>
                                        <th>Biller Code</th>
                                        <th>Service verifications</th>
                                        <th>Variations</th>
                                        <th>created_at</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                   @foreach ($transaction as $pro )  
                           
                                    <tr>
                                        <td>{{$pro->transactionId}}</td>
                                        <td>N{{number_format($pro->total_amount)}}</td>
                                        <td>{{$pro->commission}}</td>
                                         <td>{{$pro->status}}</td>
                                        <td>{{$pro->email}}</td>
                                        <td>{{$pro->phone}}</td>
                                        <td>{{$pro->bill_product->name}}</td>
                                        <td>{{$pro->bill_token}}</td>
                                        <td>{{$pro->biller_code}}</td>
                                        <td>{{$pro->service_verification}}</td>
                                        <td>{{$pro->variations}}</td>
                                          <td>{{$pro->created_at}}</td>
                                       
                                       
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                    <div> {{$transaction->links()}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
        </div>


@endsection
